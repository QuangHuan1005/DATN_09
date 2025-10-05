<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function dashboard()
    {
        return view('account.dashboard');
    }
    public function profile()
    {
        return view('account.profile');
    }

    public function addresses()
    {
        return view('account.addresses');
    }
}
    