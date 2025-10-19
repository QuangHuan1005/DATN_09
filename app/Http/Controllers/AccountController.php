<?php

namespace App\Http\Controllers;

use App\Models\Account;
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
        $user = auth()->user();    
        return view('account.profile', compact('user'));
    }

    public function addresses()
    {
        return view('account.addresses');
    }
    public function edit()
    {
        $user = auth()->user();            // hoặc request()->user()
        return view('account.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Account $account)
    {
        //
    }
}
