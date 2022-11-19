<?php


namespace App\Http\Controllers\Portal\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Portal\Auth\ChangePasswordRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController
{
    /**
     * display
     *
     * @return void
     */
    public function display()
    {
        return view('portal.auth.change-password');
    }

    /**
     * changePassword
     *
     * @param  mixed $request
     * @return void
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $request->flash();
        $user = Auth::guard('portal')->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', trans('errors.MSG_5025'));
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        $request->flush();
        return redirect()->back()->with('success',  trans('message.change_password_success'));
    }
}
