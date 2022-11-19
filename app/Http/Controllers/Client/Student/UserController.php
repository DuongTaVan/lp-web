<?php

namespace App\Http\Controllers\Client\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Student\CloseAccountRequest;
use App\Services\Client\Student\UserService;

class UserController extends Controller
{
    /**
     * 29_Close account.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function closeAccount(CloseAccountRequest $request, UserService $service)
    {
        $service->close($request);

        return redirect()->back();
    }
}
