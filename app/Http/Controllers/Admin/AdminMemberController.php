<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Users;

class AdminMemberController extends Controller
{
    public $page = 'member';

    /**
     * メンバー一覧
     */
    public function list()
    {
        $users = new Users();
        $member_list = $users->get();

        $page = $this->page;

        return view('admin.member.list', compact('page', 'member_list'));
    }

    /**
     * メンバー詳細
     */
    public function detail($member_id)
    {
        $users = new Users();
        $member = $users->find($member_id)->first();

        $page = $this->page;

        return view('admin.member.detail', compact('page', 'users', 'member'));
    }
}
