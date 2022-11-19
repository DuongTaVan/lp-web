<?php

namespace App\Http\Middleware\Client;

use App\Enums\DBConstant;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\ImagePath;
use Illuminate\Support\Facades\Auth;

class CheckStepTeacherRegister
{
    /**
     * Handle an incoming request.
     *
     * @param Request  $request
     * @param Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('client')->check()) {
            return redirect()->route('client.register');
        }
        $user = Auth::guard('client')->user();
        $routeName = \Request::route()->getName() ? \Request::route()->getName() : null;
        // dd($user);
        $imagePathTypeIdentity = ImagePath::where(['type' => DBConstant::IMAGE_TYPE_IDENTITY_VERIFICATION, 'user_id' => $user->user_id])->first();
        // dd($imagePathTypeIdentity);

        switch ($routeName) {
            case 'client.teacher.register.setting-account.identification':
                if (!$user->first_name_kanji) {
                    return redirect()->route('client.teacher.register.setting-account', $user->user_id);
                }
                break;
            case 'client.teacher.register.setting-account.identification-two':
                if ($user->teacher_category_skills !== DBConstant::TEACHER_CATEGORY_SKILLS && $user->teacher_category_consultation !== DBConstant::TEACHER_CATEGORY_CONSULTATION && $user->teacher_category_fortunetelling !== DBConstant::TEACHER_CATEGORY_FORTUNETELLING) {
                    return redirect()->route('client.teacher.register.setting-account.identification', $user->user_id);
                }
                break;
            case 'client.teacher.register.setting-account.payment':
                if (!$imagePathTypeIdentity) {
                    return redirect()->route('client.teacher.register.setting-account.identification-two', $user->user_id);
                }
                break;
            default:
                # code...
                break;
        }
        
        // if ($routeName === "client.teacher.register.setting-account.identification") {
        //     if (!$user->first_name_kanji) {
        //         return redirect()->route('client.teacher.register.setting-account', $user->user_id);
        //     }
        // }
        // if ($routeName === "client.teacher.register.setting-account.identification-two") {
        //     if ($user->teacher_category_skills !== DBConstant::TEACHER_CATEGORY_SKILLS && $user->teacher_category_consultation !== DBConstant::TEACHER_CATEGORY_CONSULTATION && $user->teacher_category_fortunetelling !== DBConstant::TEACHER_CATEGORY_FORTUNETELLING) {
        //         return redirect()->route('client.teacher.register.setting-account.identification', $user->user_id);
        //     }
        // }
        // if ($routeName === "client.teacher.register.setting-account.payment") {
        //     if (!$imagePathTypeIdentity) {
        //         return redirect()->route('client.teacher.register.setting-account.identification-two', $user->user_id);
        //     }
        // }
        // dd(\Request::route()->getName());
        return $next($request);

        throw new ModelNotFoundException();
    }
}
