<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Models\User;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserRepositoryEloquent.
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Get the number of newly registered users.
     *
     * @param $month
     * @param $userType
     * @return mixed
     */
    public function getNewlyUsers($date, $userType)
    {
        return $this->model->where([
            'user_type' => $userType,
            ['created_at', '>=', now()->parse($date['start_date'])],
            ['created_at', '<=', now()->parse($date['end_date'])->endOfDay()],
            'registration_status' => DBConstant::REGISTRATION_STATUS_AUTHENTICATED,
            'is_archived' => DBConstant::NOT_ARCHIVED_FLAG
        ])->get();
    }

    /**
     * Get the accumulated number of registered users.
     *
     * @param $month
     * @param $userType
     * @return mixed
     */
    public function getRegisteredUsers($month, $userType)
    {
        return $this->model->where([
            'user_type' => $userType,
            'registration_status' => DBConstant::REGISTRATION_STATUS_AUTHENTICATED,
            'is_archived' => DBConstant::NOT_ARCHIVED_FLAG
//            ['created_at', '<=', now()->parse($month)->lastOfMonth()->endOfDay()],
        ])->get();
    }

    /**
     * Show User List.
     *
     * @param $request
     * @return mixed
     */
    public function showUserList($request)
    {
        $nickname = $request->nickname;
        $firstNameKanji = $request->first_name_kanji;
        $lastNameKanji = $request->last_name_kanji;
        $email = $request->email;
        $sortColumn = $request->input('sort_column', 'user_id');
        $sortType = $request->input('sort_by', Constant::ORDER_BY_DESC);
        // Fixed condition
        $users = $this->model->where([
            'registration_status' => DBConstant::REGISTRATION_STATUS_AUTHENTICATED,
            'is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
        ]);

        if ($nickname) {
            $users = $users->where('nickname', 'LIKE', $request->nickname . '%');
        }
        if ($firstNameKanji) {
            $users = $users->where('first_name_kanji', 'LIKE', $request->first_name_kanji . '%');
        }
        if ($lastNameKanji) {
            $users = $users->where('last_name_kanji', 'LIKE', $request->last_name_kanji . '%');
        }
        if ($email) {
            $users = $users->where('email', 'LIKE', $request->email . '%');
        }

        // Search terms if any
        if ($request->filled('userId')) {
            $users = $users->where('user_id', $request->userId);
        }

        if ($request->filled('user_type')) {
            $users = $users->where('user_type', $request->user_type);
        }

        if ($request->filled('teacher_category')) {
            $paramTeacherCategory = $request->teacher_category;
            if ((int)$paramTeacherCategory === DBConstant::CATEGORY_TYPE_SKILLS) {
                $users = $users->where('teacher_category_skills', DBConstant::TEACHER_CATEGORY_SKILLS);
            } else if ((int)$paramTeacherCategory === DBConstant::CATEGORY_TYPE_CONSULTATION) {
                $users = $users->where('teacher_category_consultation', DBConstant::TEACHER_CATEGORY_CONSULTATION);
            } else {
                $users = $users->where('teacher_category_fortunetelling', DBConstant::TEACHER_CATEGORY_FORTUNETELLING);
            }
        }

        if ($request->filled('sex')) {
            $users = $users->where('sex', $request->sex);
        }

        if ($request->filled('identity_verification_status')) {
            $users = $users->where('identity_verification_status', $request->identity_verification_status);
        }

        if ($request->filled('business_card_verification_status')) {
            $users = $users->where('business_card_verification_status', $request->business_card_verification_status);
        }

        $users = $users->selectRaw("*, COALESCE(teacher_category_skills, teacher_category_consultation, teacher_category_fortunetelling) as teacher_category");

        return $users->orderBy($sortColumn, $sortType)->paginate($request->per_page ?? Constant::DEFAULT_LIMIT);
    }

    /**
     * Get user detail.
     *
     * @param $userId
     * @return mixed
     */
    public function getUserDetail($userId)
    {
        return $this->model->leftJoin(
            'bank_accounts as ba',
            'users.user_id',
            '=',
            'ba.user_id'
        )->select(
            'users.user_id',
            'users.user_type',
            'users.teacher_category_skills',
            'users.teacher_category_consultation',
            'users.teacher_category_fortunetelling',
            'users.nickname',
            'users.email',
            'users.last_name_kanji',
            'users.first_name_kanji',
            'users.last_name_kana',
            'users.first_name_kana',
            'users.sex',
            'users.login_type',
            'users.profile_image',
            'users.cash_balance',
            'users.points_balance',
            'users.identity_verification_status',
            'users.business_card_verification_status',
            'users.nda_status',
            'users.date_of_birth',
            'users.address',
            'users.catchphrase',
            'users.biography',
            'users.last_login',
            'ba.bank_name',
            'ba.branch_name',
            'ba.account_type',
            'ba.account_number',
            'ba.account_name'
        )->where([
            'users.user_id' => $userId
        ])->first();
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Store all user.
     *
     * @param string[] $columns
     * @return mixed
     */
    public function getAllUser($columns = ['*'])
    {
        return $this->model->where([
            'registration_status' => DBConstant::REGISTRATION_STATUS_AUTHENTICATED,
            'is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
        ])->select($columns)->get();
    }

    /**
     * Store specified users.
     *
     * @param string[] $columns
     * @return mixed
     */
    public function getSpecifiedUsers($columns = ['*'])
    {
        return $this->model->where([
            'user_type' => DBConstant::USER_TYPE_TEACHER,
            'registration_status' => DBConstant::REGISTRATION_STATUS_AUTHENTICATED,
            'is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
        ])->select($columns)->get();

//        return $this->model->get($columns);
    }

    /**
     * Get the user's Stripe customer ID and purchase ID.
     *
     * @param $id
     * @return mixed
     */
    public function getDataBySettlementId($id)
    {
        return $this->model->join('purchases as p', 'users.user_id', '=', 'p.user_id')
            ->join('settlements as s', 'p.purchase_id', '=', 's.purchase_id')
            ->where('s.id', '=', $id)
            ->select('s.str_payment_id', 'p.purchase_id', 'users.user_id', 's.currency')
            ->first();
    }

    /**
     * Get teacher by id.
     *
     * @param $userId
     * @return mixed
     */
    public function getDataTeacher($userId)
    {
        return $this->model
            ->where([
                'user_id' => $userId,
                'user_type' => DBConstant::USER_TYPE_SALES_SUPPORT_USER,
                'is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
            ])->first();
    }

    /**
     * Get Rank Of User.
     *
     * @param $querySale
     * @param $queryReview
     * @param mixed $data
     *
     * @return mixed
     */
    public function getRankOfUser($querySale, $data)
    {
        return $this->model
            ->joinSub($querySale, 'sub_sale', function ($join): void {
                $join->on('users.user_id', '=', 'sub_sale.user_id');
            })
            ->where([
                ['users.user_type', '=', DBConstant::USER_TYPE_TEACHER],
                ['users.is_archived', '=', DBConstant::NOT_ARCHIVED_FLAG],
                ['sub_sale.avg', '<', $data['avg_rating']],
            ]);
    }

    /**
     * Get Rank Of User By Target Date.
     *
     * @param $querySale
     * @param $queryReview
     * @param $data
     *
     * @return mixed
     */
    public function getRankOfUserByTargetDate($querySale, $data)
    {
        return $this->model
            ->joinSub($querySale, 'sub_sale', function ($join) {
                $join->on('users.user_id', '=', 'sub_sale.user_id');
            })
//            ->joinSub($queryReview, 'sub_review', function ($join) {
//                $join->on('users.user_id', '=', 'sub_review.user_id');
//            })
            ->where([
                ['users.user_type', '=', DBConstant::USER_TYPE_TEACHER],
                ['users.is_archived', '=', DBConstant::NOT_ARCHIVED_FLAG],
                ['sub_sale.course_schedule_count', '>=', $data['course_schedule_count']],
                ['sub_sale.avg', '>=', $data['avg_rating']],
//                ['sub_review.avg_rating', '>=', $data['avg_rating']],
            ]);
    }

    /**
     * Get info user
     *
     * @param $userId
     *
     * @return mixed
     */
    public function userAuthor($userId)
    {
        return $this->model->find($userId);
    }

    /**
     * Do active account
     *
     * @param $email
     *
     * @return mixed
     */
    public function activeAccount($email)
    {
        return $this->model->where('email', $email)->update([
            'registration_status' => DBConstant::REGISTRATION_STATUS_AUTHENTICATED
        ]);
    }

    /**
     * Update password
     *
     * @param $email
     * @param $password
     *
     * @return mixed
     */
    public function resetPassword($email, $password)
    {
        return $this->model->where('email', $email)->where('login_type', DBConstant::LOGIN_TYPE_EMAIL)->update([
            'password' => $password
        ]);
    }

    /**
     * Get user by email
     *
     * @param $email
     *
     * @return mixed
     */
    public function getUserByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    /**
     * Get user teacher
     *
     *
     * @return mixed
     */
    public function getUserTeacher($user_id)
    {
        return $this->model
            ->select('users.user_id')
            ->where(['users.user_type' => DBConstant::USER_TYPE_TEACHER,
                    'users.user_id' => $user_id]
            )
            ->first();
    }

    /**
     * Get User Logged in
     *
     * @return mixed
     */
    public function getUserLoggedIn()
    {
        return Auth::guard('client')->user();
    }

    public function getTeacherRanks($userId)
    {
        return $this->model
            ->join('ranks', 'users.rank_id', 'ranks.rank_id')
            ->where('users.user_id', $userId)
            ->select('ranks.commission_rate')
            ->first('commission_rate');
    }

    /**
     * @param $userId
     * @return mixed|void
     */
    public function getUserPrivateChat($userId, $condition = false)
    {
        $user = $this->model
            ->select(['user_id', 'nickname', 'user_type', 'sex', 'date_of_birth', 'first_name_kanji', 'last_name_kanji', 'name_use', 'is_archived'])
            ->where('users.user_id', $userId)
            ->where('is_archived', DBConstant::NOT_ARCHIVED_FLAG);

        if ($condition) {
            $user = $user->where('users.is_archived', DBConstant::NOT_ARCHIVED_FLAG);
        }

        $user = $user->first();
        if ($user) return $user->toArray();
        return [];
    }

    /**
     * Change status.
     *
     * @return array
     */
    public function changeStatus()
    {
        $userStatus = Auth::guard('client')->user()->user_status;
        if ($userStatus === 1) {
            $userStatus = 0;
            return [
                'user' => $this->model->find(Auth::guard('client')->user()->user_id)->update(['user_status' => $userStatus]),
                'message' => 'サービスの休止を解除しました。',
                'status' => 'true'
            ];
        } else {
            $userStatus = 1;
            return [
                'user' => $this->model->find(Auth::guard('client')->user()->user_id)->update(['user_status' => $userStatus]),
                'message' => 'サービスの休止をしました。',
                'status' => 'true'
            ];
        }

    }

    /**
     * @param $userId
     * @param $courseScheduleId
     * @return mixed
     */
    public function userPurchase($userId, $courseScheduleId)
    {
        return $this->model
            ->join('purchases as p', 'users.user_id', 'p.user_id')
            ->where('p.user_id', $userId)
            ->where('p.course_schedule_id', $courseScheduleId)
            ->where('status', DBConstant::PURCHASES_STATUS_NOT_CAPTURED)
            ->first();
    }

    public function getUserNotApprove()
    {
        return $this->model
            ->where(
                [
                    'business_card_verification_status' => DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_APPLIED,
                    'user_status' => DBConstant::USER_STATUS_ACTIVE
                ]
            )->count();
    }
}
