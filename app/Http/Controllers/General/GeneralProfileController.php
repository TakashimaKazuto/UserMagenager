<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Controllers\General\GeneralController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Users;
use App\Models\Item;
use App\Models\UserItem;
use App\Http\Requests\General\ProfileChangeRequestRequest;

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
    public function request(ProfileChangeRequestRequest $request)
    {
        $user_id = Auth::user()->id;

        $users = new Users();
        $user = $users->where('id', $user_id)->first();
        if(empty($user)){
            return redirect()->route('general');
        }

        $request->validated();

        // 更新処理
        DB::beginTransaction();
        try{
            // ユーザ設定項目情報を更新
            if(!empty($request['user_item'])){
                $default = [
                    'string'         => '',
                    'text'           => '',
                    'number'         => null,
                    'item_select_id' => null,
                ];
                $user_item_list = [];
                foreach($request['user_item'] as $item_id => $user_item){
                    $user_item['id'] = $user_item['id'];
                    $user_item['user_id'] = $user_id;
                    $user_item['item_id'] = $item_id;
                    $user_item = array_merge($default, $user_item);
                    $user_item_list[] = $user_item;
                }
            }

            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('general.profile.edit');
        }

        return redirect()->route('general.profile');
    }
}
