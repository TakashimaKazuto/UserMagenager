<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Users;

class GeneralController extends Controller
{
    function __construct()
    {
        $users = new Users;
        $user_type = Auth::user()->type;

        // 管理者権限ユーザは管理者のホームにリダイレクト
        if($user_type == $users::USER_TYPE_ADMIN){
            Redirect::to(route('admin'))->send();
        }
    }
}
