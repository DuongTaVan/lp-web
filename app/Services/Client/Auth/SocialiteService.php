<?php

namespace App\Services\Client\Auth;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class SocialiteService extends BaseService
{
    /**
     * @return string
     */
    public function repository()
    {
        return UserRepository::class;
    }

    /**
     * Get url redirect
     *
     * @param array $data
     * @param $service
     * @return mixed
     */
    public function getUrlRedirect(array $data, $service)
    {
        if (isset($data['url'])) {
            session(['url' => $data['url']]);
        }

        return Socialite::driver($service)
            ->redirect();
    }

    /**
     * Handle callback social
     *
     * @param array $data
     * @param $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleCallBack(array $data, $service)
    {
        try {
            $url = session('url') ?? null;
            $user = Socialite::driver($service)->stateless()->user();
            $socialField = $service . '_id';
            $socialId = $user->getId();

            switch (true) {
                case ($service === Constant::SOCIAL_LOGIN_LINE):
                    $loginType = DBConstant::LOGIN_TYPE_LINE;
                    break;
                case ($service === Constant::SOCIAL_LOGIN_FACEBOOK):
                    $loginType = DBConstant::LOGIN_TYPE_FACEBOOK;
                    break;
                default:
                    $loginType = DBConstant::LOGIN_TYPE_GOOGLE;
            }

            $user->loginType = $loginType;
            $checkSocialExists = $this->checkSocialExists($socialField, $socialId);
            if (!$checkSocialExists) {
                session(['user' => $user]);
                return view('client.auth.register-less-twenty-year-old')
                    ->with('social', true);
            }

            if ($checkSocialExists->is_archived == DBConstant::ARCHIVED_FLAG) {
                session(['user' => $user]);
                return view('client.auth.register-less-twenty-year-old')
                    ->with('social', true);
            }

            if ((int)$checkSocialExists->registration_status === DBConstant::REGISTRATION_STATUS_NOT_AUTHENTICATED) {
                return redirect()->route('client.register-form-user', ['userId' => $checkSocialExists->user_id]);
            }

            if ((int)$checkSocialExists->registration_status === DBConstant::REGISTRATION_STATUS_AUTHENTICATED) {
                auth()->guard('client')->loginUsingId($checkSocialExists->user_id);
                if ($url != null) {
                    return redirect()->to($url);
                }
                return redirect()->route('client.home');
            }

            return redirect()->route('client.login')
                ->with('error', __('errors.MSG_5033', ['field' => strtoupper($service)]));
        } catch (Exception $exception) {
//            Log::error($exception->getMessage());
            return redirect()->back()->with('error', trans('errors.MSG_5000'));
        }
    }

    /**
     * Check social exists
     *
     * @param $socialField
     * @param $socialId
     * @return mixed
     */
    private function checkSocialExists($socialField, $socialId)
    {
        return $this->repository->findByField($socialField, $socialId, ['user_id', 'registration_status', 'is_archived'])->first();
    }
}
