<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminHomeController extends AdminController
{
    public $page = 'home';

    public function home()
    {
        $page = $this->page;

        return view('admin.home', compact('page'));
    }
}
