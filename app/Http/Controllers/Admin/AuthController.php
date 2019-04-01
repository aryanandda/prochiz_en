<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AuthController extends Controller
{
    /**
     * Display admin login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('admin/login');
    }

    /**
     * Process admin login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function doLogin(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->input('remember');

        if (Auth::guard('admin')->attempt(['email' => $email, 'password' => $password], $remember)) {
            return redirect()->action('Admin\DashboardController@index');
        }

        return redirect()->route('admin.login')->with('fail', true);
    }

    /**
     * Logout admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.logout');
    }

}
