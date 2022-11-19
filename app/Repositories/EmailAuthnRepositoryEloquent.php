<?php

namespace App\Repositories;

use App\Enums\Constant;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EmailAuthnRepository;
use App\Models\EmailAuthn;

/**
 * Class EmailAuthnRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EmailAuthnRepositoryEloquent extends BaseRepository implements EmailAuthnRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EmailAuthn::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Get account to active
     *
     * @param $request
     * @return mixed
     */
    public function getAccount($request)
    {
        return $this->model->where('token', $request->token)->where('user_type', $request->user_type)->orderBy('id', Constant::ORDER_BY_DESC)->first();
    }

    /**
     * Delete account exists
     *
     * @param $request
     */
    public function deleteAccount($request)
    {
        $this->model->where('email', $request->email)->where('user_type', $request->user_type)->delete();
    }

    /**
     * Get token to check expired
     *
     * @param $request
     * @return mixed
     */
    public function getToken($request)
    {
        return $this->model->where('token', $request->token)
            ->where('created_at', '>=', now()->subMinutes(config('app.verify_token_expired_registration_client')))
            ->where('user_type', $request->user_type)
            ->first();
    }
}
