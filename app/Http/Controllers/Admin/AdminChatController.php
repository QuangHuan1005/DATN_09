<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminChatController extends Controller
{
    public function index(){
        $users = User::where('role_id', '2')->get();
        return view('admin.chat.chat', compact('users'));
    }
}
