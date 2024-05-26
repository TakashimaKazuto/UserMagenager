<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Users;

class AdminController extends Controller
{
    function __construct()
    {
        $users = new Users;
        $user_type = Auth::user()->type;

        // 管理者権限を持たないユーザは一般ユーザのホームにリダイレクト
        if($user_type != $users::USER_TYPE_ADMIN){
            return redirect()->route('general/home');
        }
    }
}
