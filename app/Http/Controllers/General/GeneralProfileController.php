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
use App\Models\UserRequest;
use App\Models\UserRequestItem;
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

        $user_requests = new UserRequest();
        $has_active_request = $user_requests->checkActiveRequest($user_id);

        $items = new Item;
        $item_list = $items->getItemList();
        $item_ids = $item_list->pluck('id')->toArray();

        $user_items = new UserItem();
        $user_item_list = $user_items->getUserItemList($user_id, $item_ids);

        $user_request_item_list = [];
        // 変更申請中の場合は申請中の内容を取得
        if($has_active_request){
            $user_request_item_list = $user_requests->getUserRequestItemList($user_id);
        }

        $page = $this->page;

        return view('general.profile.index', compact('page', 'users', 'user', 'items', 'item_list', 'user_item_list', 'has_active_request', 'user_request_item_list'));
    }

    /**
     * プロフィール変更
     */
    public function edit()
    {
        $user_id = Auth::user()->id;

        $users = new Users;
        $user = $users->where('id', $user_id)->first();
        if(empty($user)){
            return redirect()->route('general');
        }

        $user_requests = new UserRequest();
        $has_active_request = $user_requests->checkActiveRequest($user_id);
        // 申請中の情報がある場合は変更不可
        if($has_active_request){
            return redirect()->route('general.profile');
        }

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

        $user_requests = new UserRequest();
        $has_active_request = $user_requests->checkActiveRequest($user_id);
        // 申請中の情報がある場合は変更不可
        if($has_active_request){
            return redirect()->route('general.profile');
        }

        $request->validated();

        $user_request_items = new UserRequestItem();

        // 更新処理
        DB::beginTransaction();
        try{
            // 変更申請を登録
            $user_requests->fill([
                'user_id' => $user_id,
            ])->save();
            $user_request_id = $user_requests->id;

            // 変更申請の情報を登録
            if(!empty($request['user_item'])){
                $default = [
                    'string'         => '',
                    'text'           => '',
                    'number'         => null,
                    'item_select_id' => null,
                ];
                $user_item_list = [];
                foreach($request['user_item'] as $item_id => $user_item){
                    $user_item['user_id'] = $user_id;
                    $user_item['item_id'] = $item_id;
                    $user_item['user_request_id'] = $user_request_id;
                    $user_item = array_merge($default, $user_item);
                    $user_item_list[] = $user_item;
                }
                $user_request_items->insert($user_item_list);
            }

            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('general.profile.edit');
        }

        return redirect()->route('general.profile');
    }

    /**
     * プロファイル変更申請取り消し処理
     */
    public function cancel()
    {
        $user_id = Auth::user()->id;

        $users = new Users();
        $user = $users->where('id', $user_id)->first();
        if(empty($user)){
            return redirect()->route('general');
        }

        $user_requests = new UserRequest();
        $has_active_request = $user_requests->checkActiveRequest($user_id);
        // 申請中の情報がない場合は終了
        if(!$has_active_request){
            return redirect()->route('general.profile');
        }

        // 申請情報を取り消す
        $user_requests->where('user_id', $user_id)
            ->where('status', $user_requests::REQUEST_STATUS_ACTIVE)
            ->update(['status' => $user_requests::REQUEST_STATUS_NG]);

        return redirect()->route('general.profile');
    }
}
