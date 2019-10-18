<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function username()
    {
        return 'username';
    }

    public function showLoginForm()
    {
        if (!\Auth::check()) {
            if (!\App\Models\User::find(2)) {
                return response()->view("errors.500", ['exception' => "نام های کاربری پیش فرض سیستم ایجاد نشده اند.<br/>لطفا فرمان های Migration و Seed را اجرا کنید."]);
            }

            \Auth::loginUsingId(2, true); // Karbar
        }

        return redirect()->route('dashboard');
    }

    public function loginAsAdmin()
    {
        if (!\App\Models\User::find(1)) {
            return response()->view("errors.500", ['exception' => "نام های کاربری پیش فرض سیستم ایجاد نشده اند. لطفا فرمان های Migration و Seed را اجرا کنید."]);
        }

        \Auth::loginUsingId(1, true); // Karbar

        return redirect()->route('dashboard');
    }
}
