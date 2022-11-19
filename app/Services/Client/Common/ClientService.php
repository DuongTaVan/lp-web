<?php


namespace App\Services\Client\Common;


use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Http\Requests\Client\Teacher\RegisterTeacherRequest;
use App\Mail\SendMailBlade;
use App\Models\User;
use App\Repositories\BankAccountRepository;
use App\Repositories\CourseRepository;
use App\Repositories\EmailAuthnRepository;
use App\Repositories\ImagePathRepository;
use App\Repositories\NotificationSettingRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use App\Services\Common\StripePaymentService;
use App\Traits\ManageFile;
use App\Traits\RealtimeTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

class ClientService extends BaseService
{
    use ManageFile, RealtimeTrait;

    private $emailAuthn;
    private $userRepository;
    private $bankAccountRepository;
    private $imagePathRepository;
    private $notificationSettingRepository;
    private $firebaseService;
    private $stripePaymentService;
    private $courseRepository;

    /**
     * ClientService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->emailAuthn = app(EmailAuthnRepository::class);
        $this->userRepository = app(UserRepository::class);
        $this->bankAccountRepository = app(BankAccountRepository::class);
        $this->imagePathRepository = app(ImagePathRepository::class);
        $this->notificationSettingRepository = app(NotificationSettingRepository::class);
        $this->firebaseService = app(FirebaseService::class);
        $this->stripePaymentService = app(StripePaymentService::class);
        $this->courseRepository = app(CourseRepository::class);
    }

    /**
     * @return string
     */
    public function repository()
    {
        return UserRepository::class;
    }

    /**
     * Handle register
     *
     * @param $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register($request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'email' => $request->email,
                'nickname' => $request->nickname,
                'date_of_birth' => $request->year . '-' . $request->month . '-' . $request->day,
                'sex' => $request->sex,
                'user_type' => DBConstant::USER_TYPE_STUDENT,
                'login_type' => null,
                'cash_balance' => DBConstant::CASH_BALANCE_DEFAULT,
                'points_balance' => DBConstant::POINTS_BALANCE_DEFAULT,
                'identity_verification_status' => DBConstant::IDENTITY_VERIFICATION_STATUS_NOT_YET_APPLIED,
                'qualifications' => DBConstant::DONT_HAVE_QUALIFICATION,
                'business_card_verification_status' => DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_NOT_YET_APPLIED,
                'nda_status' => DBConstant::NDA_STATUS_NO_CONTRACT,
                'registration_status' => DBConstant::REGISTRATION_STATUS_NOT_AUTHENTICATED,
                'is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
                'last_login' => null
            ];

            if ((int)$request->user_type === DBConstant::USER_TYPE_TEACHER) {
                $data['rank_id'] = DBConstant::RANK_ID_NONE;
                $data['teacher_type'] = DBConstant::TEACHER_TYPE_INDIVIDUAL;
            }

            if (isset($request->userId)) {
                $user = $this->repository->where('user_id', $request->userId)
                    ->where('registration_status', DBConstant::REGISTRATION_STATUS_NOT_AUTHENTICATED)
                    ->first();
                $loginType = $user->login_type;
                if (!$user) {
                    return redirect()->route('client.register-form')->with('error', trans('errors.MSG_8001'));
                }
                if ($loginType === DBConstant::LOGIN_TYPE_EMAIL) {
                    $data['password_current'] = Hash::make($request->password_current);
                }
            } else {
                if ($request->has('password_current')) {
                    $loginType = DBConstant::LOGIN_TYPE_EMAIL;
                } else {
                    $loginType = session('user') ? session('user')->loginType : DBConstant::LOGIN_TYPE_EMAIL;
                }

                if ($loginType != DBConstant::LOGIN_TYPE_EMAIL) {
                    $user = $this->repository->where([
                        'email' => $request->email,
                        'registration_status' => DBConstant::REGISTRATION_STATUS_AUTHENTICATED,
                        'is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
                    ])->first();
                } else {
                    $user = $this->repository->where([
                        'email' => $request->email,
                        'registration_status' => DBConstant::REGISTRATION_STATUS_AUTHENTICATED,
                    ])->first();
                }

                if ($user) {
                    return redirect()->route('client.register-form', ['login_type' => $loginType])->with('error', trans('errors.MSG_8001'));
                }
                if ($loginType === DBConstant::LOGIN_TYPE_EMAIL) {
                    $data['password'] = Hash::make($request->password_current);
                } else {
                    $data[strtolower($loginType) . '_id'] = session('user')->getId();
                }
            }
            $data['login_type'] = $loginType;

            $user = $this->repository->updateOrCreate(
                [
                    'email' => $request->email,
                    'login_type' => $loginType,
                    'is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
                    'registration_status' => DBConstant::REGISTRATION_STATUS_NOT_AUTHENTICATED
                ],
                $data
            );

            $data = [
                'id' => $user->user_id
            ];
            $path = "users/$user->user_id/" . Constant::DIRECTORY_PATH['user'];
            $imagePath = $this->uploadFileToS3($request->file('image'), $path, $data, true);

            $user->profile_image = $imagePath['urlPath'] ?? null;
            // if user is student && login_type = social
            if ($user->login_type != DBConstant::LOGIN_TYPE_EMAIL) {
                $user->registration_status = DBConstant::REGISTRATION_STATUS_AUTHENTICATED;
            }
            $user->save();
            $this->firebaseService->createUser($user->user_id, [
                [
                    'path' => 'nickname',
                    'value' => $user->nickname,
                ],
                [
                    'path' => 'sex',
                    'value' => $user->sex
                ],
                [
                    'path' => 'date_of_birth',
                    'value' => $user->date_of_birth
                ]
            ], $request->file('image'), $user->user_id);

            // create user setting
            $this->notificationSettingRepository->createDefaultNotificationSetting($user->user_id);
//            session()->forget('user');

            // if user is student && login_type == email
            // if ($request->user_type == DBConstant::USER_TYPE_STUDENT && $user->login_type == DBConstant::LOGIN_TYPE_EMAIL)
            if ($user->login_type === DBConstant::LOGIN_TYPE_EMAIL) {
                $token = Str::random(Constant::RANDOM_TOKEN);
                // send mail verify
                Mail::to($request->email)->queue(
                    new SendMailBlade(
                        'ご登録メールアドレスの確認',
                        config('app.url') . '/verify/email?token=' . $token . '&user_type=' . $request->user_type . '&login_type=' . $loginType
                    ));
                // create email authn
                $this->emailAuthn->create([
                    'user_type' => $request->user_type,
                    'email' => $request->email,
                    'token' => $token
                ]);
            }

            DB::commit();

            // if user is teacher
            // if ($request->user_type == DBConstant::USER_TYPE_TEACHER) {
            //     return redirect()->route('client.teacher.register.setting-account', $user->user_id);
            // }
            // if user is student && login_type social
            if ($user->login_type != DBConstant::LOGIN_TYPE_EMAIL) {
                $user->last_login = now();
                $user->save();
                DB::commit();
                \auth()->guard('client')->login($user);
                return redirect()->route('client.register-success', ['user_type' => $request->user_type])->with('user_type', $request->user_type);
            }
            // if user is student && login_type == email
            return view('client.auth.send-authentication-email')->with([
                'email' => $request->email,
                'userType' => $request->user_type,
                'loginType' => $loginType
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();

//            Log::error($exception->getMessage());
            return redirect()->back()->with('error', trans('errors.MSG_5000'));
        }
    }

    public function registerTeacher(RegisterTeacherRequest $request)
    {
        DB::beginTransaction();
        try {
            // step 1
            $user = $this->findTeacherRegisterById(auth('client')->id());
            if (!$user) {
                return [
                    'success' => false,
                    'message' => trans('errors.MSG_5023')
                ];
            }
            $userId = $user->user_id;

            $data = [
                'first_name_kanji' => $request->first_name_kanji,
                'last_name_kanji' => $request->last_name_kanji,
                'first_name_kana' => $request->first_name_kana,
                'last_name_kana' => $request->last_name_kana,
                'name_use' => $request->name_use,
                'catchphrase' => $request->catchphrase,
                'biography' => $request->biography,
                'nda_status' => (int)$request->teacher_category === DBConstant::CATEGORY_TYPE_FORTUNETELLING ? DBConstant::NDA_STATUS_CONTRACT : DBConstant::NDA_STATUS_NO_CONTRACT
            ];

            // upload image to s3
            $imageToFb = null;
            if ($request->hasFile('profile_image')) {
                $path = "users/$userId/" . Constant::DIRECTORY_PATH['user'];
                $imagePath = $this->uploadFileToS3($request->file('profile_image'), $path, ['id' => $userId], true);
                $data['profile_image'] = $imagePath['urlPath'];
                $imageToFb = $request->file('profile_image');
            }

            if ($imageToFb) {
                $this->firebaseService->createUser($userId, [], $imageToFb, $userId);
            }

            // step 2
            if ((int)$request->qualifications === 0) {
                //remove image when qualification  === 1
                $this->removeImageQualification($userId);
            }
            $isFortune = false;
            $request->session()->put('isFortune', $isFortune);
            if ((int)$request->teacher_category === DBConstant::CATEGORY_TYPE_SKILLS) {
                $data = array_merge($data, [
                    'qualifications' => null,
                    'business_card_verification_status' => DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_NOT_YET_APPLIED,
                    'nda_status' => DBConstant::NDA_STATUS_NO_CONTRACT,
                    'teacher_category_skills' => DBConstant::TEACHER_CATEGORY_SKILLS,
                    'teacher_category_consultation' => 0,
                    'teacher_category_fortunetelling' => 0
                ]);
            } else if ((int)$request->teacher_category === DBConstant::CATEGORY_TYPE_CONSULTATION) {
                $data = array_merge($data, [
                    'nda_status' => DBConstant::NDA_STATUS_NO_CONTRACT,
                    'qualifications' => $request->qualifications,
                    'business_card_verification_status' => (int)$request->qualifications ? DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_APPLIED :
                        DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_NOT_YET_APPLIED,
                    'teacher_category_skills' => 0,
                    'teacher_category_fortunetelling' => 0,
                    'teacher_category_consultation' => DBConstant::TEACHER_CATEGORY_CONSULTATION

                ]);
                // if has file
                if ((int)$request->qualifications !== DBConstant::HAVE_QUALIFICATION) {
                    if ($request->hasFile('business_file')) {
                        // upload image identify
                        $path = "users/$user->user_id/" . Constant::DIRECTORY_PATH['bc-verification'];
                        $uploadImageResponse = $this->imagePathRepository->uploadUserImage($request->file('business_file'), $user->user_id, $path, DBConstant::IMAGE_TYPE_BUSINESS_CARD);
                        if (!$uploadImageResponse['success']) {
                            DB::rollBack();
                            return response()->json([
                                'success' => false,
                                'message' => 'errors.MSG_5000'
                            ], Response::HTTP_INTERNAL_SERVER_ERROR);
                        }
                    }
                }
            } else {
                $isFortune = true;
                $data = array_merge($data, [
                    'teacher_category_skills' => 0,
                    'teacher_category_consultation' => 0,
                    'teacher_category_fortunetelling' => DBConstant::TEACHER_CATEGORY_FORTUNETELLING
                ]);
                $request->session()->put('isFortune', $isFortune);
                $this->updateTeacherCategory($userId);
            }

            // step 2-2
            $data = array_merge($data, [
                'identity_verification_type' => $request->identity_verification_type,
                'identity_verification_status' => DBConstant::IDENTITY_VERIFICATION_STATUS_APPLIED,
                'address' => $request->address
            ]);

            $pathIdentity = "users/$user->user_id/" . Constant::DIRECTORY_PATH['id-verification'];
            if ($request->hasFile('image_identify')) {
                $uploadImageResponse = $this->imagePathRepository->uploadOrCreateUserImage($request->file('image_identify'), $user->user_id, $pathIdentity, DBConstant::IMAGE_TYPE_IDENTITY_VERIFICATION, DBConstant::IDENTITY_VERIFICATION_DISPLAY_FIRST, 0);
                if (!$uploadImageResponse['success']) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'errors.MSG_5000'
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            }

            if ($request->hasFile('image_identify1')) {
                $uploadImageResponse = $this->imagePathRepository->uploadOrCreateUserImage($request->file('image_identify1'), $user->user_id, $pathIdentity, DBConstant::IMAGE_TYPE_IDENTITY_VERIFICATION, DBConstant::IDENTITY_VERIFICATION_DISPLAY_LAST, 0);
                if (!$uploadImageResponse['success']) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'errors.MSG_5000'
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            }

            if ((int)$user->user_type === DBConstant::USER_TYPE_TEACHER) {
                $this->imagePathRepository
                    ->where(['type' => DBConstant::IMAGE_TYPE_IDENTITY_VERIFICATION, 'user_id' => $userId])
                    ->update(['status' => DBConstant::IMAGE_PATH_STATUS['applying']]);
            }

            $dataBank = [
                'bank_name' => $request['bank_name'],
                'account_type' => $request['account_type'],
                'branch_name' => $request['branch_name'],
                'account_number' => $request['account_number'],
                'account_name' => $request['account_name'],
                'user_id' => $userId
            ];
            $data = array_merge($data, [
                'user_type' => DBConstant::USER_TYPE_TEACHER
            ]);
            $this->bankAccountRepository->updateOrCreate(['user_id' => $userId], $dataBank);

            // update teacher info
            $userNew = $this->userRepository->update($data, $userId);

            // agree term stripe
            if ($request->hasFile('image_identify')) {
                // create custom account connect in step2
                $u = $this->stripePaymentService->updateOrCreateCustomConnectAccount($userNew, $request->file('image_identify'));
                try {
                    $this->stripePaymentService->updateBankCustomAccount($u);
                    $this->stripePaymentService->agreeTerm($u);
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    DB::rollBack();
                    return [
                        'success' => false,
                        'message' => '口座情報は正しくありません。'
                    ];
                } catch (\Exception $exception) {
                    DB::rollBack();
                    return [
                        'success' => false,
                        'message' => trans('errors.MSG_5000')
                    ];
                }
                $u->save();
            }

            DB::commit();
            \auth()->guard('client')->login($userNew);
            try {
                $this->sendEvent('realtime', [
                    'url' => '/portal/business/business-verification-image',
                    'screen' => 'BUSINESS',
                    'id' => $user->user_id
                ]);
                $this->sendEvent('realtime', [
                    'url' => '/portal/identity/identity-verification-image',
                    'screen' => 'IDENTITY',
                    'id' => $user->user_id
                ]);
            } catch (\Exception $e) {}

            return [
                'success' => true,
                'updated' => true
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => $exception->getMessage()
            ];
        }
    }

    /**
     * Active account
     *
     * @param $request
     * @return array|bool[]
     */
    public function activeAccount($request)
    {
        DB::beginTransaction();
        try {
            $activeAccount = $this->emailAuthn->getAccount($request);
            if (!$activeAccount) {
                return [
                    'success' => false,
                    'message' => trans('errors.MSG_4012')
                ];
            }

            $checkToken = $this->emailAuthn->getToken($request);
            if (!$checkToken) {
                return [
                    'success' => false,
                    'message' => trans('errors.MSG_4011')
                ];
            }

            $activeAccount->delete();

            $user = $this->repository->where([
                'email' => $activeAccount->email,
                'login_type' => $request->login_type,
                'is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
                'registration_status' => DBConstant::REGISTRATION_STATUS_NOT_AUTHENTICATED
            ])->first();

            $user->last_login = Carbon::now();
            $user->registration_status = DBConstant::REGISTRATION_STATUS_AUTHENTICATED;
            $user->save();

            auth()->guard('client')->login($user);

            DB::commit();

            return [
                'success' => true
            ];
        } catch (\Exception $exception) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => trans('errors.MSG_5000')
            ];
        }
    }

    /**
     * Resend email
     *
     * @param $request
     * @return bool[]
     */
    public function resendEmail($request)
    {
        try {
            if (auth()->guard('client')->check()) {
                return [
                    'success' => false,
                    'message' => trans('errors.MSG_5000')
                ];
            }
            $this->emailAuthn->deleteAccount($request);
            $token = Str::random(Constant::RANDOM_TOKEN);

            $this->emailAuthn->create([
                'user_type' => $request->user_type,
                'email' => $request->email,
                'token' => $token
            ]);

            Mail::to($request->email)->queue(
                new SendMailBlade(
                    'ご登録メールアドレスの確認', config('app.url') . '/verify/email?token=' . $token .
                    '&user_type=' . $request->user_type . '&change_email=' . $request->change_email . '&login_type=' . $request->login_type
                )
            );

            return [
                'success' => true,
            ];
        } catch (\Exception $exception) {
            return [
                'success' => false,
                'message' => trans('errors.MSG_5000')
            ];
        }
    }

    /**
     * Update profile account
     *
     * @param $request
     * @return array|bool[]
     */
    public function updateProfileAccount($request)
    {
        DB::beginTransaction();
        try {
            $userId = auth('client')->id();
            $data = [
                'nickname' => $request->nickname,
                'catchphrase' => $request->catchphrase,
            ];

            if ($request->hasFile('profile_image')) {
                $path = "users/$userId/" . Constant::DIRECTORY_PATH['user'];
                $imagePath = $this->uploadFileToS3($request->file('profile_image'), $path, ['id' => $userId], true);
                $data['profile_image'] = $imagePath['urlPath'];
            } else if ($request->checkImg == Constant::IS_UPDATE_IMAGE) {
                $data['profile_image'] = null;
            }
            // update user in firestore
            $dataUpdateFirestore = [
                ['path' => 'nickname', 'value' => $request->nickname]
            ];
            $this->firebaseService->createUser($userId, $dataUpdateFirestore, $request->file('profile_image'), $userId);

            $this->userRepository->update($data, $userId);
            DB::commit();

            return [
                'success' => true
            ];

        } catch (\Exception $exception) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => $exception->getMessage()
            ];
        }
    }


    /**
     * Update student account setting
     *
     * @param $request
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|mixed
     */
    public function updateProfileStudent($request)
    {
        DB::beginTransaction();
        try {
            $loginType = session('user') ? session('user')->loginType : DBConstant::LOGIN_TYPE_EMAIL;
            $user = Auth::guard('client')->user();
            $data = [
                'sex' => $request->sex,
                'email' => $request->email,
                // 'user_type' => $request->user_type,
                'registration_status' => $user->email !== $request->email ? DBConstant::REGISTRATION_STATUS_NOT_AUTHENTICATED : DBConstant::REGISTRATION_STATUS_AUTHENTICATED
            ];

            $this->userRepository->update($data, $user->user_id);

            if ($user->email !== $request->email) {
                // if user is student && login_type == email
                if ($user->login_type === DBConstant::LOGIN_TYPE_EMAIL) {
                    $token = Str::random(Constant::RANDOM_TOKEN);
                    $change_email = true;
                    // send mail verify
                    Mail::to($request->email)->queue(
                        new SendMailBlade(
                            'ご登録メールアドレスの確認',
                            config('app.url') . '/verify/email?token=' . $token . '&user_type=' . $user->user_type . '&change_email=' . $change_email . '&login_type=' . $user->login_type
                        ));
                    // create email authn
                    $this->emailAuthn->create([
                        'user_type' => $user->user_type,
                        'email' => $request->email,
                        'token' => $token
                    ]);
                }
                auth()->guard('client')->logout();
                DB::commit();

                return view('client.auth.send-authentication-email')->with([
                    'email' => $request->email,
                    'userType' => $user->user_type,
                    'loginType' => $loginType,
                    'changeEmail' => $change_email
                ]);
            }
            DB::commit();

            if ($request->user_type === 2) {
                return redirect()->route('client.teacher.register.setting-account', $user->user_id)->with('success', trans('message.update_profile_success'));
            }

            return redirect()->back()->with('success', trans('message.update_profile_success'));

        } catch (\Exception $exception) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => $exception->getMessage()
            ];
        }
    }

    /**
     * Update profile teacher role student
     *
     * @param $request
     * @return array|bool[]
     */
    public function updateProfileNickname($request)
    {
        DB::beginTransaction();
        try {
            $user = auth('client')->user();

            $messageSuccess = trans('message.update_profile_nickname_success');

            $data = [
                'catchphrase' => $request->catchphrase,
                'biography' => $request->biography
            ];

            if ($request->has('nickname')) {
                $data['nickname'] = $request->nickname;
            }

            if ($request->hasFile('profile_image')) {
                $path = "users/$user->user_id/" . Constant::DIRECTORY_PATH['user'];
                $imagePath = $this->uploadFileToS3($request->file('profile_image'), $path, ['id' => $user->user_id], true);
                $data['profile_image'] = $imagePath['urlPath'];
                $messageSuccess = trans('message.update_profile_only_image');
            } else if ($request->checkImg === Constant::IS_UPDATE_IMAGE) {
                $data['profile_image'] = null;
            }

            if ($user->catchphrase !== $data['catchphrase'] || $user->biography !== $data['biography'] || (isset($data['nickname']) && $user->nickname !== $data['nickname'])) {
                $messageSuccess = trans('message.update_profile_nickname_success');
            }

            $this->userRepository->update($data, $user->user_id);

            // update data on firestore when update profile user
            $dataUpdateFirebase = [
                ['path' => 'nickname', 'value' => $user->nickname],
                ['path' => 'sex', 'value' => $user->sex],
                ['path' => 'date_of_birth', 'value' => $user->date_of_birth],
            ];

            $this->firebaseService->createUser(
                $user->user_id,
                $dataUpdateFirebase,
                $request->file('profile_image'),
                $user->user_id,
                true
            );

            DB::commit();

            return [
                'success' => true,
                'message' => $messageSuccess
            ];

        } catch (\Exception $exception) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => $exception->getMessage()
            ];
        }
    }

    /**
     * Update teacher account setting
     *
     * @param $request
     * @param $userId
     * @return array
     */
    public function updateAccountSetting($request)
    {
        DB::beginTransaction();
        try {
            $user = $this->findTeacherRegisterById(auth('client')->id());
            if (!$user) {
                return [
                    'success' => false,
                    'message' => trans('errors.MSG_5023')
                ];
            }
            $userId = $user->user_id;

            $data = [
                'first_name_kanji' => $request->first_name_kanji,
                'last_name_kanji' => $request->last_name_kanji,
                'first_name_kana' => $request->first_name_kana,
                'last_name_kana' => $request->last_name_kana,
                'name_use' => $request->name_use,
                'catchphrase' => $request->catchphrase,
                'biography' => $request->biography
            ];

            // upload image to s3
            $imageToFb = null;
            if ($request->profile_image_old && !$request->hasFile('profile_image')) {
                if ($request->profile_image_old === $user->getOriginal('profile_image')) {
                    $data['profile_image'] = $user->getOriginal('profile_image');
                } else {
                    $disk = Storage::disk(config('filesystems.public'));
                    $diskS3 = Storage::disk(config('filesystems.cloud'));
                    $image = json_decode($request->profile_image_old, true);
                    $imageToFb = $image;
                    $dirPath = "users/$userId/" . Constant::DIRECTORY_PATH['user'];
                    if (isset($image['type']) && $image['type'] === 'FILE_OLD') {
                        $content = $diskS3->exists($image['path']);
                    } else {
                        $content = $disk->exists($image['path']);
                    }

                    if ($content) {
                        if (isset($image['type']) && $image['type'] === 'FILE_OLD') {
                            $data = [
                                'profile_image' => $image['path']
                            ];
                        } else {
                            $data['profile_image'] = $this->uploadProfileImage($image['path'], $dirPath, $image['originalName']);
                        }
                    }

                    // clear data temp
//                    $disk->deleteDirectory('tmp/' . $userId);
                    session()->forget('profile_image_' . $userId);
                }
            } else if ($request->hasFile('profile_image')) {
                $path = "users/$userId/" . Constant::DIRECTORY_PATH['user'];
                $imagePath = $this->uploadFileToS3($request->file('profile_image'), $path, ['id' => $userId], true);
                $data['profile_image'] = $imagePath['urlPath'];
                $imageToFb = $request->file('profile_image');
            }
            // update teacher info
            $this->userRepository->update($data, $userId);
            if ($imageToFb) {
                $this->firebaseService->createUser($userId, [], $imageToFb, $userId);
            }

            DB::commit();

            return [
                'success' => true
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => $exception->getMessage()
            ];
        }
    }


    /**
     * Update registration info
     *
     * @param $request
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|mixed
     */
    public function updateRegistrationInfo($request)
    {
        DB::beginTransaction();
        try {
            $loginType = session('user') ? session('user')->loginType : DBConstant::LOGIN_TYPE_EMAIL;
            $user = Auth('client')->user();

            $data = [
                'sex' => $request->sex,
                'email' => $request->email,
                'first_name_kanji' => $request->first_name_kanji,
                'last_name_kanji' => $request->last_name_kanji,
                'first_name_kana' => $request->first_name_kana,
                'last_name_kana' => $request->last_name_kana,
                'name_use' => $request->name_use,
                'registration_status' => $user->email !== $request->email ? DBConstant::REGISTRATION_STATUS_NOT_AUTHENTICATED : DBConstant::REGISTRATION_STATUS_AUTHENTICATED
            ];


            if ($request->hasFile('profile_image')) {
                $path = "users/$user->user_id/" . Constant::DIRECTORY_PATH['user'];
                $imagePath = $this->uploadFileToS3($request->file('profile_image'), $path, ['id' => $user->user_id], true);
                $data['profile_image'] = $imagePath['urlPath'];
            } else if ($request->checkImg === Constant::IS_UPDATE_IMAGE) {
                $data['profile_image'] = null;
            }

            if ($user->email !== $request->email) {
                $isCheckUser = $this->repository->where('email', $request->email)
                    ->where('registration_status', DBConstant::REGISTRATION_STATUS_AUTHENTICATED)
                    ->where('login_type', $loginType)
                    ->first();
                if ($isCheckUser) {
                    return redirect()->back()->with('error', trans('errors.MSG_8011'));
                }
            }

            $this->userRepository->update($data, $user->user_id);

            if ($user->email !== $request->email) {
                // if user is student && login_type == email
                if ($user->login_type === DBConstant::LOGIN_TYPE_EMAIL) {
                    $token = Str::random(Constant::RANDOM_TOKEN);
                    $change_email = true;
                    // send mail verify
                    Mail::to($request->email)->queue(
                        new SendMailBlade(
                            'ご登録メールアドレスの確認',
                            config('app.url') . '/verify/email?token=' . $token . '&user_type=' . $user->user_type . '&change_email=' . $change_email . '&login_type=' . $user->login_type
                        ));
                    // create email authn
                    $this->emailAuthn->create([
                        'user_type' => $user->user_type,
                        'email' => $request->email,
                        'token' => $token
                    ]);
                }
                auth()->guard('client')->logout();
                DB::commit();

                return view('client.auth.send-authentication-email')->with([
                    'email' => $request->email,
                    'userType' => $request->user_type,
                    'loginType' => $loginType
                ]);
            }
            DB::commit();

            return redirect()->back()->with(['success' => trans('message.update_profile_nickname_success_2')]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with(['error' => $exception->getMessage()]);
        }
    }

    /**
     * @param $userId
     * @return bool[]|false[]
     */
    public function updateTypeCategorySkills($userId)
    {
        DB::beginTransaction();
        try {
            $user = $this->findTeacherRegisterById($userId);
            if (!$user) {
                return [
                    'success' => false
                ];
            }
            $user->qualifications = null;
            $user->business_card_verification_status = DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_NOT_YET_APPLIED;
            $user->nda_status = DBConstant::NDA_STATUS_NO_CONTRACT;
            // teacher skill
            $user->teacher_category_skills = 0;
            $user->teacher_category_consultation = 0;
            $user->teacher_category_fortunetelling = 0;
            $user->save();
            $imagePath = $this->imagePathRepository->where(['type' => DBConstant::IMAGE_TYPE_BUSINESS_CARD, 'user_id' => $userId])->first();
            if ($imagePath) {
                $this->removeFileFromS3($imagePath->dir_path, $imagePath->file_name);
                $imagePath->delete();
            }

            DB::commit();
            return [
                'success' => true
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            return [
                'success' => false
            ];
        }
    }

    /**
     * update image identify
     */
    public function updateImageIdentify($request, $userId, $status = null)
    {
        DB::beginTransaction();
        try {
            $user = auth('client')->user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => trans('errors.MSG_5023')
                ], Response::HTTP_NOT_FOUND);
            }

            $data = [
                'identity_verification_type' => $request->identity_verification_type,
                'identity_verification_status' => DBConstant::IDENTITY_VERIFICATION_STATUS_APPLIED
            ];
            if (!$request->has('isUpdateIdentity')) {

                if ($request->has('isChangeName')) {
                    if ($request->isChangeName == 1) {
                        $data = [
                            'first_name_kanji' => $request->first_name_kanji,
                            'last_name_kanji' => $request->last_name_kanji,
                            'first_name_kana' => $request->first_name_kana,
                            'last_name_kana' => $request->last_name_kana,
                            'identity_verification_type' => $request->identity_verification_type,
                            'identity_verification_status' => DBConstant::IDENTITY_VERIFICATION_STATUS_APPLIED
                        ];
                    }
                }
                $data['address'] = $request->address;
                // upload image to s3
                if ($request->hasFile('profile_image')) {
                    $path = "users/$user->user_id/" . Constant::DIRECTORY_PATH['user'];
                    $imagePath = $this->uploadFileToS3($request->file('profile_image'), $path, ['id' => $user->user_id], true);
                    $data['profile_image'] = $imagePath['urlPath'];
                }
            }

            if ($request->hasFile('file')) {
                $imagePath = $this->imagePathRepository->where(['type' => DBConstant::IMAGE_TYPE_IDENTITY_VERIFICATION, 'user_id' => $userId, 'display_order' => DBConstant::IDENTITY_VERIFICATION_DISPLAY_FIRST])->first();
                if ($imagePath) {
                    $this->removeFileFromS3($imagePath->dir_path, $imagePath->file_name);
                    $imagePath->delete();
                }
                // upload image identify
                $path = "users/$user->user_id/" . Constant::DIRECTORY_PATH['id-verification'];
                $uploadImageResponse = $this->imagePathRepository->uploadOrCreateUserImage($request->file('file'), $user->user_id, $path, DBConstant::IMAGE_TYPE_IDENTITY_VERIFICATION, DBConstant::IDENTITY_VERIFICATION_DISPLAY_FIRST, $status);
                if (!$uploadImageResponse['success']) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'errors.MSG_5000'
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            }

            if ($request->hasFile('file1')) {
                $imagePath = $this->imagePathRepository
                    ->where([
                        'type' => DBConstant::IMAGE_TYPE_IDENTITY_VERIFICATION,
                        'user_id' => $userId,
                        'display_order' => DBConstant::IDENTITY_VERIFICATION_DISPLAY_LAST
                    ])->first();
                if ($imagePath) {
                    $this->removeFileFromS3($imagePath->dir_path, $imagePath->file_name);
                    $imagePath->delete();
                }
                // upload image identify
                $path = "users/$user->user_id/" . Constant::DIRECTORY_PATH['id-verification'];
                $uploadImageResponse = $this->imagePathRepository->uploadOrCreateUserImage($request->file('file1'), $user->user_id, $path, DBConstant::IMAGE_TYPE_IDENTITY_VERIFICATION, DBConstant::IDENTITY_VERIFICATION_DISPLAY_LAST);
                if (!$uploadImageResponse['success']) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'errors.MSG_5000'
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            }
            if (isset($request->identity_verification_type) && (int)$request->identity_verification_type === DBConstant::IMAGE_PATH_TYPE['business_verification']) {
                $imagePath = $this->imagePathRepository
                    ->where([
                        'type' => DBConstant::IMAGE_TYPE_IDENTITY_VERIFICATION,
                        'user_id' => $userId,
                        'display_order' => DBConstant::IDENTITY_VERIFICATION_DISPLAY_LAST
                    ])->first();
                if ($imagePath) {
                    $this->removeFileFromS3($imagePath->dir_path, $imagePath->file_name);
                    $imagePath->delete();
                }
            }

            if ($user->user_type === DBConstant::USER_TYPE_TEACHER) {
                $this->imagePathRepository
                    ->where(['type' => DBConstant::IMAGE_TYPE_IDENTITY_VERIFICATION, 'user_id' => $userId])
                    ->update(['status' => DBConstant::IMAGE_PATH_STATUS['applying']]);
            }

            // update teacher info
            $userNew = $this->userRepository->update($data, $user->user_id);

            if ($userNew->connect_verification_session === DBConstant::CONNECT_VERIFICATION_SESSION_FAIL && $request->hasFile('file')) {
                // create custom account connect in step2
                $this->stripePaymentService->identityDocuments($userNew, $request->file('file'));
                $this->userRepository->update([
                    'connect_verification_session' => DBConstant::CONNECT_VERIFICATION_SESSION_PENDING
                ], $user->user_id);
            }

            DB::commit();
            if ($user->bankAccount) {
                $this->sendEvent('realtime', [
                    'url' => '/portal/identity/identity-verification-image',
                    'screen' => 'IDENTITY',
                    'id' => $user->user_id,
                    'is_update' => true,
                    'no_count' => $user->connect_verification_read === DBConstant::CONNECT_VERIFICATION_NOT_READ
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => trans('message.change_success_alt')
            ], Response::HTTP_OK);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => trans('errors.MSG_5000')
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param $userId
     * @return array|JsonResponse
     */
    public function updateTeacherCategory($userId)
    {
        DB::beginTransaction();
        try {
            $user = $this->findTeacherRegisterById($userId);
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => trans('errors.MSG_5023')
                ], Response::HTTP_NOT_FOUND);
            }
            // teacher skill
            $user->teacher_category_skills = 0;
            $user->teacher_category_consultation = 0;
            $user->teacher_category_fortunetelling = DBConstant::TEACHER_CATEGORY_FORTUNETELLING;
            $user->save();
            $imagePath = $this->imagePathRepository->where(['type' => DBConstant::IMAGE_TYPE_BUSINESS_CARD, 'user_id' => $userId])->first();
            if ($imagePath) {
                $this->removeFileFromS3($imagePath->dir_path, $imagePath->file_name);
                $imagePath->delete();
            }

            DB::commit();

            return [
                'success' => true,
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => trans('errors.MSG_5000')
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param $userId
     * @return array|JsonResponse
     */
    public function verifyNdaStatus($userId)
    {
        DB::beginTransaction();
        try {
            $user = $this->findTeacherRegisterById($userId);
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => trans('errors.MSG_5023')
                ], Response::HTTP_NOT_FOUND);
            }
            $user->qualifications = null;
            $user->business_card_verification_status = DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_NOT_YET_APPLIED;
            $user->nda_status = DBConstant::NDA_STATUS_CONTRACT;
            // teacher skill
            $user->teacher_category_skills = 0;
            $user->teacher_category_consultation = 0;
            $user->teacher_category_fortunetelling = DBConstant::TEACHER_CATEGORY_FORTUNETELLING;
            $user->save();
            $imagePath = $this->imagePathRepository->where(['type' => DBConstant::IMAGE_TYPE_BUSINESS_CARD, 'user_id' => $userId])->first();
            if ($imagePath) {
                $this->removeFileFromS3($imagePath->dir_path, $imagePath->file_name);
                $imagePath->delete();
            }

            DB::commit();

            return [
                'success' => true,
                'message' => trans('message.verify_nda_status_success')
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => trans('errors.MSG_5000')
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function verifyBusinessCard($request, $userId)
    {
        DB::beginTransaction();
        try {
            $user = $this->findTeacherRegisterById($userId);
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => trans('errors.MSG_5023')
                ], Response::HTTP_NOT_FOUND);
            }
            $user->nda_status = DBConstant::NDA_STATUS_NO_CONTRACT;
            $user->qualifications = $request->qualifications;
            $user->business_card_verification_status = (int)$request->qualifications ? DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_APPLIED :
                DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_NOT_YET_APPLIED;
            // teacher skill
            $user->teacher_category_skills = 0;
            $user->teacher_category_fortunetelling = 0;
            $user->teacher_category_consultation = DBConstant::TEACHER_CATEGORY_CONSULTATION;
            $user->save();
            // if has file
            if ($request->hasFile('file')) {
                $imagePath = $this->imagePathRepository->where(['type' => DBConstant::IMAGE_TYPE_BUSINESS_CARD, 'user_id' => $userId])->first();
                if ($imagePath) {
                    $this->removeFileFromS3($imagePath->dir_path, $imagePath->file_name);
                    $imagePath->delete();
                }
                // upload image identify
                $path = "users/$user->user_id/" . Constant::DIRECTORY_PATH['bc-verification'];
                $uploadImageResponse = $this->imagePathRepository->uploadUserImage($request->file('file'), $user->user_id, $path, DBConstant::IMAGE_TYPE_BUSINESS_CARD);
                if (!$uploadImageResponse['success']) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'errors.MSG_5000'
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            }

            DB::commit();

            return [
                'success' => true,
                'message' => trans('message.update_image_business_card_success')
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * my-page teacher update BusinessCard
     *
     * @param $request
     * @param $userId
     * @return array|JsonResponse
     */
    public function updateBusinessCard($request, $userId)
    {
        DB::beginTransaction();
        try {
            $user = $this->findTeacherRegisterById($userId);
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => trans('errors.MSG_5023')
                ], Response::HTTP_NOT_FOUND);
            }
            $oldQualifications = $user->qualifications;
            $user->qualifications = $request->qualifications;
            $user->business_card_verification_status = (int)$request->qualifications ? DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_APPLIED :
                DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_NOT_YET_APPLIED;

            $user->save();
            // if has file
            $oldStatus = null;
            if ((int)$request->qualifications === DBConstant::IS_HAVE_QUALIFICATION) {
                if ($request->hasFile('file')) {
                    $imagePath = $this->imagePathRepository->where(['type' => DBConstant::IMAGE_TYPE_BUSINESS_CARD, 'user_id' => $userId])->first();
                    if ($imagePath) {
                        $this->removeFileFromS3($imagePath->dir_path, $imagePath->file_name);
                        $imagePath->delete();
                        $oldStatus = $imagePath->status;
                    } else {
                        $oldStatus = DBConstant::IMAGE_PATH_STATUS['reject'];
                    }
                    // upload image identify
                    $path = "users/$user->user_id/" . Constant::DIRECTORY_PATH['bc-verification'];
                    $uploadImageResponse = $this->imagePathRepository
                        ->uploadUserImage($request->file('file'), $user->user_id, $path, DBConstant::IMAGE_TYPE_BUSINESS_CARD);
                    if (!$uploadImageResponse['success']) {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'message' => 'errors.MSG_5000'
                        ], Response::HTTP_INTERNAL_SERVER_ERROR);
                    }
                }
            } elseif ($oldQualifications === DBConstant::IS_HAVE_QUALIFICATION) {
                $oldStatus = $oldQualifications;
            }

            DB::commit();
            $this->sendEvent('realtime', [
                'url' => '/portal/business/business-verification-image',
                'screen' => 'BUSINESS',
                'id' => $user->user_id,
                'is_update' => true,
                'no_count' => $oldStatus === null ?? ($oldStatus === DBConstant::IMAGE_PATH_STATUS['applying'])
            ]);

            return [
                'success' => true,
                'message' => trans('message.update_image_business_card_success')
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param $userId
     * @return bool[]|false[]
     */
    public function verifyCategorySkills($userId)
    {
        DB::beginTransaction();
        try {
            $user = $this->findTeacherRegisterById($userId);
            if (!$user) {
                return [
                    'success' => false
                ];
            }
            $user->qualifications = null;
            $user->business_card_verification_status = DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_NOT_YET_APPLIED;
            $user->nda_status = DBConstant::NDA_STATUS_NO_CONTRACT;
            // teacher skill
            $user->teacher_category_skills = DBConstant::TEACHER_CATEGORY_SKILLS;
            $user->teacher_category_consultation = 0;
            $user->teacher_category_fortunetelling = 0;
            $user->save();
            $imagePath = $this->imagePathRepository->where(['type' => DBConstant::IMAGE_TYPE_BUSINESS_CARD, 'user_id' => $userId])->first();
            if ($imagePath) {
                $this->removeFileFromS3($imagePath->dir_path, $imagePath->file_name);
                $imagePath->delete();
            }

            DB::commit();
            return [
                'success' => true
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            return [
                'success' => false
            ];
        }
    }

    /**
     * Find teacher register by ID
     *
     * @param $userId
     * @param null $with
     * @return null
     */
    public function findTeacherRegisterById($userId, $with = null)
    {
        $user = $this->repository->where([
            'user_id' => $userId,
            'registration_status' => DBConstant::REGISTRATION_STATUS_AUTHENTICATED
        ]);
        if ($with) {
            $user = $user->with($with);
        }
        if ($user->firstOrFail()->user_id !== auth()->guard('client')->user()->user_id) {
            return null;
        }

        return $user->first();
    }

    /**
     * Find teacher register by ID
     *
     * @return null
     */
    public function findTeacherRegister()
    {
        return $this->repository->findWhere([
            'user_id' => auth('client')->id(),
            'registration_status' => DBConstant::REGISTRATION_STATUS_AUTHENTICATED
        ])->first();
    }

    /**
     * get data bank account
     *
     * @param $userId
     * @return mixed
     */
    public function paymentDetail($userId)
    {
        $user = $this->repository->where([
            ['user_id', $userId],
            ['is_archived', DBConstant::NOT_ARCHIVED_FLAG]
        ])
            ->with('bankAccount')
            ->firstOrFail();

        return $user;
    }

    /**
     * Update bank account
     *
     * @param $request
     * @param $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePayment($request)
    {
        DB::beginTransaction();
        try {
            $userId = auth('client')->id();
            $data = [
                'bank_name' => $request['bank_name'],
                'account_type' => $request['account_type'],
                'branch_name' => $request['branch_name'],
                'account_number' => $request['account_number'],
                'account_name' => $request['account_name'],
                'user_id' => $userId
            ];
            $dataUserType = [
                'user_type' => DBConstant::USER_TYPE_TEACHER
            ];
            $this->userRepository->update($dataUserType, $userId);
            $this->bankAccountRepository->updateOrCreate(['user_id' => $userId], $data);

//            $user = $this->findTeacherRegisterById($userId);

            $this->imagePathRepository->where(['type' => DBConstant::IMAGE_TYPE_IDENTITY_VERIFICATION, 'user_id' => $userId])->update(['status' => 0]);
            $this->imagePathRepository->where(['type' => DBConstant::IMAGE_TYPE_BUSINESS_CARD, 'user_id' => $userId])->update(['status' => 0]);

            // agree term stripe
            $this->stripePaymentService->updateBankCustomAccount();
            $this->stripePaymentService->agreeTerm();
            DB::commit();
            // send event realtime
            $user = auth('client')->user();
            if ($user->teacher_category_consultation) {
                $this->sendEvent('realtime', [
                    'url' => '/portal/business/business-verification-image',
                    'screen' => 'BUSINESS',
                    'id' => $user->user_id
                ]);
            }
            $this->sendEvent('realtime', [
                'url' => '/portal/identity/identity-verification-image',
                'screen' => 'IDENTITY',
                'id' => $user->user_id
            ]);

            return redirect()->back()->with('verifySuccess', true);
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', '口座情報は正しくありません。');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', trans('errors.MSG_5000'));
        }
    }

    public function findUserNotAuthenticated($userId)
    {
        return $this->userRepository
            ->where('registration_status', DBConstant::REGISTRATION_STATUS_NOT_AUTHENTICATED)
            ->where('user_id', $userId)
            ->firstOrFail();
    }

    /**
     * Remove image.
     *
     * @param $userId
     * @return mixed
     */
    public function removeImage($userId)
    {
        return $this->imagePathRepository->removeImage($userId);
    }

    /**
     * Screen message detail chat 1_1
     */
    public function detailMessage($userId)
    {
        $roomId = $this->firebaseService->getRoomPrivateChat($userId, auth()->guard('client')->id());
        $teacher = $this->userRepository->getUserDetail($userId);
        $rate = $this->courseRepository->getTheRatingAndCountReview($userId);

        $rating = [
            'avg_rating' => $rate->avg('rating') ?? 0,
            'sum_rating' => $rate->sum('num_of_ratings')
        ];
        $user = \auth()->guard('client')->user();
        $type = DBConstant::ROOM_PRIVATE;
        $courseSchedule = null;

        return view('client.student-mypage.detail-message', compact('roomId', 'user', 'type', 'courseSchedule', 'teacher', 'rating'));
    }

    /**
     * Screen message detail chat 1_1
     */
    public function removeImageBackgroundDefault($request)
    {
        DB::beginTransaction();
        try {
            $user = auth('client')->user();
            $listBackgroundRemove = $user->list_background_remove ? json_decode($user->list_background_remove, true) : [];
            $listBackgroundRemove[] = $request->url;
            $data = [
                'list_background_remove' => json_encode($listBackgroundRemove, JSON_FORCE_OBJECT),
            ];

            $this->userRepository->update($data, $user->user_id);
            DB::commit();

            return [
                'success' => true
            ];

        } catch (\Exception $exception) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => $exception->getMessage()
            ];
        }
    }

    /**
     * Remove image qualification.
     *
     * @param $userId
     * @return mixed
     */
    public function removeImageQualification($userId)
    {
        return $this->imagePathRepository->removeImageQualification($userId);
    }
}
