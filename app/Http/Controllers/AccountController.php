<?php

namespace App\Http\Controllers;

// use App\Models\Account;
use App\Models\User;
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
}