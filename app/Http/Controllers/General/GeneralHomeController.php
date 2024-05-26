<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Controllers\General\GeneralController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeneralHomeController extends GeneralController
{
    public $page = 'page';

    public function home()
    {
        $page = $this->page;

        return view('general.home', compact('page'));
    }
}
