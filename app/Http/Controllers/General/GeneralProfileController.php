<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Controllers\General\GeneralController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Users;
use App\Models\Item;
use App\Models\UserItem;

class GeneralProfileController extends GeneralController
{
    public $page = 'profile';

    /**
     * プロフィール閲覧
     */
    public function index()
    {
        $user_id = Auth::user()->id;

        $users = new Users;
        $user = $users->where('id', $user_id)->first();

        $items = new Item;
        $item_list = $items->getItemList();
        $item_ids = $item_list->pluck('id')->toArray();

        $user_items = new UserItem();
        $user_item_list = $user_items->getUserItemList($user_id, $item_ids);

        $page = $this->page;

        return view('general.profile.index', compact('page', 'users', 'user', 'items', 'item_list', 'user_item_list'));
    }

    /**
     * プロフィール変更
     */
    public function edit()
    {
        $user_id = Auth::user()->id;

        $users = new Users;
        $user = $users->where('id', $user_id)->first();

        $items = new Item;
        $item_list = $items->getItemList();
        $item_ids = $item_list->pluck('id')->toArray();

        $user_items = new UserItem();
        $user_item_list = $user_items->getUserItemList($user_id, $item_ids);

        $page = $this->page;

        return view('general.profile.edit', compact('page', 'users', 'user', 'items', 'item_list', 'user_item_list'));
    }

    /**
     * プロファイル変更申請処理
     */
    public function update()
    {}
}
