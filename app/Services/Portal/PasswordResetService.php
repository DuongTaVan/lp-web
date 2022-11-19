<?php

namespace App\Services\Portal;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Mail\SendMailResetPassword;
use App\Repositories\ConsoleUserRepository;
use App\Repositories\PasswordResetRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Str;

class PasswordResetService extends BaseService
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    public $consoleUserRepository;

    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    public $userRepository;

    /**
     * PasswordResetService constructor.
     */
    public function __construct()
    {
        // add repository
        parent::__construct();
        $this->consoleUserRepository = app(ConsoleUserRepository::class);
        $this->userRepository = app(UserRepository::class);
    }

    /**
     * User repository class
     *
     * @return string
     */
    public function repository()
    {
        return PasswordResetRepository::class;
    }

    /**
     * Send Reset Link Email
     *
     * @param $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail($request)
    {
        $user = $this->consoleUserRepository->findWhere([
            'email' => $request->email,
            'is_archived' => DBConstant::NOT_ARCHIVED_FLAG
        ])->first();

        //Check if the user exists
        if (!$user) {
            return redirect()->back()->with('accountError', trans('errors.MSG_5023'));
        }

        $token = Str::random(Constant::TOKEN_PASSWORD_RESET);
        // $sendMailStatus = $this->sendEmailResetPassword($request->email, $token);

        // if ($sendMailStatus !== 0) {
        //     return redirect()->back()->with('error', trans('errors.MSG_5022'));
        // }
        $this->sendEmailResetPassword($request->email, $token);

        // create token in database
        $this->repository->updateOrCreate([
            'email' => $request->email,
            'user_type' => DBConstant::USER_TYPE_SALES_SUPPORT_USER
        ], [
            'email' => $request->email,
            'user_type' => DBConstant::USER_TYPE_SALES_SUPPORT_USER,
            'token' => $token,
        ]);

        return redirect()->back()->with('success', __('message.send_mail_after_reset'));
    }

    /**
     * Send Email Reset Password
     *
     * @param mixed $email
     * @param mixed $token
     * @return void
     */
    private function sendEmailResetPassword($email, $token)
    {
        $urlResetPassword = config('app.url') . '/portal/password/reset/' . $token . '?email=' . urlencode($email);

        return Mail::to($email)->queue(new SendMailResetPassword('Reset Password', $urlResetPassword));
    }

    /**
     * Display a form reset password
     *
     * @param $token
     * @return \Illuminate\Http\Response
     */
    public function showResetForm($token)
    {
        $tokenData = $this->repository->findWhere([
            'token' => $token,
            'user_type' => DBConstant::USER_TYPE_SALES_SUPPORT_USER,
            ['updated_at', '>=', now()->subMinute(config('app.verify_token_expired'))]
        ])->first();

        if (!$tokenData) {
            return redirect()->route('portal.password-reset.show-link')->with('error', trans('errors.MSG_5024'));
        }

        return view('portal.auth.reset', [
            'token' => $token
        ]);
    }

    /**
     * Change new password
     *
     * @param $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword($request)
    {
        $request->flash();
        DB::beginTransaction();
        try {
            // Token is invalid.
            $tokenData = $this->repository->findWhere([
                'token' => $request->token_password,
                'user_type' => DBConstant::USER_TYPE_SALES_SUPPORT_USER,
                ['updated_at', '>=', now()->subMinute(config('app.verify_token_expired'))]
            ])->first();

            if (!$tokenData) {
                return redirect()->route('portal.password-reset.show-link')->with('error', trans('errors.MSG_5024'));
            }

            // The email is invalid
            $user = $this->consoleUserRepository->findWhere([
                'email' => $tokenData->email,
                'is_archived' => DBConstant::NOT_ARCHIVED_FLAG
            ])->first();

            if (!$user) {
                return redirect()->route('portal.password-reset.show-link')->with('error', trans('errors.MSG_5025'));
            }

            $userUpdated = $this->consoleUserRepository->update([
                'password' => Hash::make($request->new_password)
            ], $user->console_user_id);

            if (!$userUpdated) {
                return redirect()->back()->with('error', trans('message.reset_password_fail'));
            }

            $this->repository->where([
                'token' => $request->token_password, 'user_type' => DBConstant::USER_TYPE_SALES_SUPPORT_USER
            ])->delete();

            DB::commit();

            return redirect()->route('portal.login')->with('success', trans('message.reset_password_success'));
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Send reset password client
     *
     * @param $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMailResetClient($request)
    {
        $user = $this->userRepository->where([
            'email' => $request->email,
            'login_type' => DBConstant::LOGIN_TYPE_EMAIL,
            'is_archived' => DBConstant::NOT_ARCHIVED_FLAG
        ])->first();

        if (!$user) {
            return redirect()->back()->with('error', trans('errors.MSG_5023'));
        }

        $token = Str::random(Constant::TOKEN_PASSWORD_RESET);

        $sendMailStatus = Mail::to($request->email)->queue(
            new SendMailResetPassword(
                '[Lappi] 至急 - パスワード再設定のご案内（24時間以内に実行してください）',
                config('app.url') . '/password/reset-form/' . $token,
                $user
            )
        );

        $this->repository->updateOrCreate([
            'user_type' => $user->user_type,
            'email' => $user->email,
        ], [
            'user_type' => $user->user_type,
            'email' => $user->email,
            'token' => $token,
        ]);
        if (auth('client')->check()) {
            return redirect()->route('client.home')->with('success', __('message.send_mail_after_reset'));
        } else {
            return redirect()->route('client.login')->with('success', __('message.send_mail_after_reset'));
        }

    }

    /**
     * Handle reset password
     *
     * @param $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPasswordClient($request)
    {
        DB::beginTransaction();
        try {
            $verifyToken = $this->repository->where('token', $request->token)->first();
            if (!$verifyToken) {
                return redirect()->back()->with('error', trans('errors.MSG_4012'));
            }

            $expiredToken = $this->repository
                ->where('token', $request->token)
                ->where('updated_at', '>=', now()->subMinutes(config('app.verify_token_expired_client')))
                ->first();
            if (!$expiredToken) {
                return redirect()->back()->with('error', trans('errors.MSG_4011'));
            }

            $user = $this->userRepository->where(['email' => $verifyToken->email, 'login_type' => DBConstant::LOGIN_TYPE_EMAIL])->first();
            if (Hash::check($request->password, $user->password)) {
                return back()->withErrors(['password' => '※パスワードが既に使われています']);
            }

            $password = Hash::make($request->password);
            $this->userRepository->resetPassword($verifyToken->email, $password);
            $verifyToken->delete();

            DB::commit();

            return view('client.auth.reset-success');
        } catch (\Exception $exception) {
            DB::rollBack();

            return redirect()->back()->with('error', trans('errors.MSG_5000'));
        }
    }

    /**
     * Show form reset client
     *
     * @param $token
     * @return array|false|\Illuminate\Contracts\Foundation\Application
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|mixed
     */
    public function showResetFormClient($token)
    {
        $tokenData = $this->repository->findWhere([
            'token' => $token,
            ['updated_at', '>=', now()->subMinutes(config('app.verify_token_expired_client'))]
        ])->first();

        if (!$tokenData) {
            return redirect()->route('client.password-reset.show-link')->with('error', trans('errors.MSG_5024'));
        }

        $user = $this->userRepository->getUserByEmail($tokenData->email);

        return view('client.auth.reset-password-form')->with([
            'token' => $token,
            'user' => $user
        ]);
    }
}
