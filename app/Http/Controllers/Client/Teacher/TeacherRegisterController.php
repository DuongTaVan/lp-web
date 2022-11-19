<?php

namespace App\Http\Controllers\Client\Teacher;

use App\Enums\DBConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Teacher\RegisterTeacherRequest;
use App\Http\Requests\Client\Teacher\SubmitIdentifyRequest;
use App\Http\Requests\Client\Teacher\UpdateBankAccountRequest;
use App\Http\Requests\Client\Teacher\UpdateBusinessCardRequest;
use App\Http\Requests\Client\Teacher\UpdateImageIdentifyRequest;
use App\Http\Requests\Client\Teacher\UpdateSettingAccountRequest;
use App\Services\Client\Common\ClientService;
use App\Services\Client\Teacher\BankMasterService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeacherRegisterController extends Controller
{
    protected $clientService;
    /**
     * @var bankMasterService.
     */
    protected $bankMasterService;

    /**
     * TeacherRegisterController constructor.
     */
    public function __construct(
        ClientService     $clientService,
        BankMasterService $bankMasterService
    )
    {
        $this->clientService = $clientService;
        $this->bankMasterService = $bankMasterService;
    }

    public function register()
    {
        $user = $this->clientService->findTeacherRegister();
        if (!$user) {
            return redirect()->route('client.register');
        }
        if ((int)$user->user_type === DBConstant::USER_TYPE_TEACHER) {
            return redirect()->route('client.home');
        }
        $banks = $this->bankMasterService->listBank();

        return view('client.screen.teacher-register.register', compact('user', 'banks'));
    }

    public function registerUpdate(RegisterTeacherRequest $request)
    {
        if ($request->ajax()) {
            if ((int)$request->step !== 5) {
                return response()->json(['success' => true]);
            }
            $result = $this->clientService->registerTeacher($request);

            return response()->json($result);
        }
    }


    // Teacher Register setting account
    public function settingAccount()
    {
        $userId = auth('client')->id();
        $user = $this->clientService->findTeacherRegisterById($userId);
        if (!$user) {
            return redirect()->route('client.register');
        }

        return view('client.screen.teacher-register.register', compact('userId', 'user'));
    }

    //teacher nda verify
    public function ndaVerify()
    {
        return view('client.screen.teacher-register.nda-verify');
    }

    /**
     * Teacher payment
     *
     * @param $userId
     * @return array|false|Application|Factory|View|mixed
     */
    public function payment($userId)
    {
        $user = $this->clientService->paymentDetail($userId);
        $banks = $this->bankMasterService->listBank();

        return view('client.screen.teacher-register.payment', compact('user', 'banks'));
    }

    /**
     * Bank Auto complete.
     *
     * @param Request $request
     * @return Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|void
     * @throws \Throwable
     */
    public function bankAutocomplete(Request $request)
    {
        if ($request->ajax()) {
//            if (isset($request->text)) {
//                $request->merge([
//                    'text' => $this->fullSizeToHalfSize($request->text)
//                ]);
//            }
            $text = $request->text ?? null;

            $data = $this->bankMasterService->getDataBank($text);

            $html = null;
            if (count($data) > 0) {
                $html = view('client.screen.teacher-register.list-data-bank', compact('data'))->render();
            }
            return response(['html' => $html]);
        }
    }

    /**
     * Full size to hard size.
     *
     * @param $str
     * @return array|string|string[]
     */
    function fullSizeToHalfSize($str)
    {
        $replaceBy = array('ｳﾞ', 'ｶﾞ', 'ｷﾞ', 'ｸﾞ',
            'ｹﾞ', 'ｺﾞ', 'ｻﾞ', 'ｼﾞ',
            'ｽﾞ', 'ｾﾞ', 'ｿﾞ', 'ﾀﾞ',
            'ﾁﾞ', 'ﾂﾞ', 'ﾃﾞ', 'ﾄﾞ',
            'ﾊﾞ', 'ﾋﾞ', 'ﾌﾞ', 'ﾍﾞ',
            'ﾎﾞ', 'ﾊﾟ', 'ﾋﾟ', 'ﾌﾟ', 'ﾍﾟ', 'ﾎﾟ');
        $replaceOf = array('ヴ', 'ガ', 'ギ', 'グ',
            'ゲ', 'ゴ', 'ザ', 'ジ',
            'ズ', 'ゼ', 'ゾ', 'ダ',
            'ヂ', 'ヅ', 'デ', 'ド',
            'バ', 'ビ', 'ブ', 'ベ',
            'ボ', 'パ', 'ピ', 'プ', 'ペ', 'ポ');
        $result = str_replace($replaceOf, $replaceBy, $str);

        $replaceBy = array('ｱ', 'ｲ', 'ｳ', 'ｴ', 'ｵ',
            'ｶ', 'ｷ', 'ｸ', 'ｹ', 'ｺ',
            'ｻ', 'ｼ', 'ｽ', 'ｾ', 'ｿ',
            'ﾀ', 'ﾁ', 'ﾂ', 'ﾃ', 'ﾄ',
            'ﾅ', 'ﾆ', 'ﾇ', 'ﾈ', 'ﾉ',
            'ﾊ', 'ﾋ', 'ﾌ', 'ﾍ', 'ﾎ',
            'ﾏ', 'ﾐ', 'ﾑ', 'ﾒ', 'ﾓ',
            'ﾔ', 'ﾕ', 'ﾖ', 'ﾗ', 'ﾘ',
            'ﾙ', 'ﾚ', 'ﾛ', 'ﾜ', 'ｦ',
            'ﾝ', 'ｧ', 'ｨ', 'ｩ', 'ｪ',
            'ｫ', 'ヵ', 'ヶ', 'ｬ', 'ｭ',
            'ｮ', 'ｯ', '､', '｡', 'ｰ',
            '｢', '｣', 'ﾞ', 'ﾟ');
        $replaceOf = array('ア', 'イ', 'ウ', 'エ', 'オ',
            'カ', 'キ', 'ク', 'ケ', 'コ',
            'サ', 'シ', 'ス', 'セ', 'ソ',
            'タ', 'チ', 'ツ', 'テ', 'ト',
            'ナ', 'ニ', 'ヌ', 'ネ', 'ノ',
            'ハ', 'ヒ', 'フ', 'ヘ', 'ホ',
            'マ', 'ミ', 'ム', 'メ', 'モ',
            'ヤ', 'ユ', 'ヨ', 'ラ', 'リ',
            'ル', 'レ', 'ロ', 'ワ', 'ヲ',
            'ン', 'ァ', 'ィ', 'ゥ', 'ェ',
            'ォ', 'ヶ', 'ヶ', 'ャ', 'ュ',
            'ョ', 'ッ', '、', '。', 'ー',
            '「', '」', '”', '');
        return str_replace($replaceOf, $replaceBy, $result);
    }

    public function branchAutocomplete(Request $request)
    {
        if ($request->ajax()) {
            $bank = $request->bank ?? null;
            $text = $request->text ?? null;
            $data = $this->bankMasterService->getDataBranch($bank, $text);
            $html = null;
            if (count($data) > 0) {
                $html = view('client.screen.teacher-register.list-data-bank', compact('data'))->render();
            }

            return response(['html' => $html]);
        }
    }

    /**
     * Update teacher bank account
     *
     * @param UpdateBankAccountRequest $request
     * @return RedirectResponse
     */
    public function updateBankAccount(UpdateBankAccountRequest $request)
    {
        return $this->clientService->updatePayment($request->all());
    }

    // Teacher identification
    public function identification()
    {
        $userId = auth('client')->id();
        $user = $this->clientService->findTeacherRegisterById($userId, ['imagePathType1', 'imagePathType2']);
        if (!$user) {
            return redirect()->route('client.register');
        }
        return view('client.screen.teacher-register.identification', compact('userId', 'user'));
    }

    // Teacher identification
    public function identificationTwo(Request $request)
    {
        $userId = auth('client')->id();
        $isFortune = $request->session()->get('isFortune', false);
        $user = $this->clientService->findTeacherRegisterById($userId, ['imagePathType1', 'imagePathType2', 'imagePathTypeDisplayOne']);
        if (!$user) {
            return redirect()->route('client.register');
        }
        return view('client.screen.teacher-register.identification-two', compact('userId', 'user', 'isFortune'));
    }

    /**
     * Update image identify
     *
     * @param UpdateImageIdentifyRequest $request
     * @param $userId
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function updateImageIdentify(UpdateImageIdentifyRequest $request, $userId)
    {
        return $this->clientService->updateImageIdentify($request, $userId);
    }

    /**
     * @param SubmitIdentifyRequest $request
     * @param $userId
     * @return RedirectResponse
     */
    public function submitIdentification(SubmitIdentifyRequest $request, $userId)
    {
        $user = $this->clientService->findTeacherRegisterById($userId);
        switch ($request->teacher_category) {
            case 'teacher_category_skills':
                $this->clientService->updateTypeCategorySkills($userId);
                break;
            case 'teacher_category_consultation':
                if (!$user->imagePathType2) {
                    return redirect()->back()->withInput($request->input())->withErrors([
                        'teacher_category_consultation' => true
                    ]);
                }
                break;
            case 'teacher_category_fortunetelling':
                if ($user->nda_status != DBConstant::NDA_STATUS_CONTRACT) {
                    return redirect()->back()->withInput($request->input())->withErrors([
                        'teacher_category_fortunetelling' => true
                    ]);
                }
                break;
        }

        return redirect()->route('client.teacher.register.setting-account.identification-two', $userId);
    }

    /**
     * @param UpdateSettingAccountRequest $request
     * @return RedirectResponse
     */
    public function updateAccount(UpdateSettingAccountRequest $request)
    {
        $userId = auth('client')->id();
        $result = $this->clientService->updateAccountSetting($request, $userId);
        if ($result['success']) {
            return redirect()->route('client.teacher.register.setting-account.identification');
        }
        return redirect()->back()->with(['error' => $result['message']]);
    }

    /**
     * @param UpdateBusinessCardRequest $request
     * @param $userId
     * @return RedirectResponse
     */
    public function verifyNdaOrBusinessCard(UpdateBusinessCardRequest $request)
    {
        $isFortune = false;
        $userId = auth('client')->id();
        if ((int)$request->qualifications === 0) {
            //remove image when qualification  === 1
            $this->clientService->removeImageQualification($userId);
        }
        $request->session()->put('isFortune', $isFortune);
        if ($request->teacher_category === DBConstant::TEXT_TEACHER_CATEGORY_SKILLS) {
            $result = $this->clientService->verifyCategorySkills($userId);
            if ($result['success']) {
                return redirect()->route('client.teacher.register.setting-account.identification-two');
            }
        }
        if ($request->teacher_category === DBConstant::TEXT_TEACHER_CATEGORY_CONSULTATION) {
            $result = $this->clientService->verifyBusinessCard($request, $userId);
            if ($result['success']) {
                return redirect()->route('client.teacher.register.setting-account.identification-two', $userId);
            }
        } else {
            $user = auth()->guard('client')->user();
            $isFortune = true;
            $request->session()->put('isFortune', $isFortune);
            $result = $this->clientService->updateTeacherCategory($userId);
            if ($result['success']) {
                return redirect()->route('client.teacher.register.setting-account.identification-two', $userId)->with(['user' => $user]);
            }

            // return view('client.screen.teacher-register.identification-two', compact('userId', 'user', 'isFortune'));
        }
    }

    /**
     * @param $userId
     */
    public function verifyNda($userId)
    {
        return $this->clientService->verifyNdaStatus($userId);
    }

    /**
     * Remove Image.
     *
     * @param $userId
     * @return mixed
     */
    public function removeImage($userId)
    {
        return $this->clientService->removeImage($userId);
    }
}
