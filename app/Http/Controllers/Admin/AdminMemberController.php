<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Users;
use App\Models\Item;
use App\Models\UserItem;
use App\Models\UserRequest;
use App\Http\Requests\Admin\CreateMemberRequest;
use App\Http\Requests\Admin\UpdateMemberRequest;

class AdminMemberController extends AdminController
{
    public $page = 'member';

    /**
     * メンバー一覧
     */
    public function list()
    {
        $users = new Users();
        $member_list = $users->getMemberList();

        $user_requests = new UserRequest();

        $page = $this->page;

        return view('admin.member.list', compact('page', 'users', 'member_list', 'user_requests'));
    }

    /**
     * メンバー詳細
     */
    public function detail($member_id)
    {
        $users = new Users();
        $member = $users->where('id', $member_id)->first();
        if(empty($member)){
            return redirect()->route('admin.member');
        }

        $items = new Item();
        $item_list = $items->getItemList();
        $item_ids = $item_list->pluck('id')->toArray();


        $user_requests = new UserRequest();
        $has_active_request = $user_requests->checkActiveRequest($member_id);
        $user_request_item_list = [];
        // 変更申請中の場合は申請中の内容を取得
        if($has_active_request){
            $user_request_item_list = $user_requests->getUserRequestItemList($member_id);
        }

        $user_items = new UserItem();
        $user_item_list = $user_items->getUserItemList($member_id, $item_ids);

        $page = $this->page;

        return view('admin.member.detail', compact('page', 'users', 'member', 'items', 'item_list', 'user_item_list', 'user_requests', 'has_active_request', 'user_request_item_list'));
    }

    /**
     * メンバー登録
     */
    public function register()
    {
        $users = new Users();

        $items = new Item();
        $item_list = $items->getItemList();

        $page = $this->page;

        return view('admin.member.register', compact('page', 'users', 'items', 'item_list'));
    }

    /**
     * メンバー登録処理
     */
    public function create(CreateMemberRequest $request)
    {
        // バリデーション
        $request->validated();

        $users = new Users();
        $user_items = new UserItem();
        $user_id = 0;

        // 更新処理
        DB::beginTransaction();
        try{
            // ユーザ基本情報を登録
            $users->fill([
                'name'       => $request['name'],
                'first_name' => $request['first_name'],
                'last_name'  => $request['last_name'],
                'type'       => $request['type'],
            ]);
            $users->save();
            $user_id = $users->id;

            // ユーザ設定項目情報を登録
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
                    $user_item = array_merge($default, $user_item);
                    $user_item_list[] = $user_item;
                }
                $user_items->insert($user_item_list);
            }

            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('admin.member.register');
        }

        return redirect()->route('admin.member.detail', ['member_id' => $user_id]);
    }

    /**
     * メンバー編集
     */
    public function edit($member_id)
    {
        $users = new Users();
        $member = $users->where('id', $member_id)->first();
        if(empty($member)){
            return redirect()->route('admin.member');
        }

        $user_requests = new UserRequest();
        $has_active_request = $user_requests->checkActiveRequest($member_id);
        if($has_active_request){
            return redirect()->route('admin.member.detail', ['member_id' => $member_id]);
        }

        $items = new Item();
        $item_list = $items->getItemList();
        $item_ids = $item_list->pluck('id')->toArray();

        $user_items = new UserItem();
        $user_item_list = $user_items->getUserItemList($member_id, $item_ids);

        $page = $this->page;

        return view('admin.member.edit', compact('page', 'users', 'member', 'items', 'item_list', 'user_item_list'));
    }

    /**
     * メンバー更新処理
     */
    public function update(UpdateMemberRequest $request)
    {
        $users = new Users();
        $member = $users->where('id', $request['member_id'])->first();
        if(empty($member)){
            return redirect()->route('admin.member');
        }

        // バリデーション
        $request->validated();

        $user_items = new UserItem();
        $user_id = $member->id;

        // 更新処理
        DB::beginTransaction();
        try{
            // ユーザ基本情報を更新
            $users->where('id', $member->id)
                ->update([
                    'first_name' => $request['first_name'],
                    'last_name'  => $request['last_name'],
                ]);

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
                    $user_item['user_id'] = $user_id;
                    $user_item['item_id'] = $item_id;
                    $user_item = array_merge($default, $user_item);
                    $user_item_list[] = $user_item;
                }
                $user_items->upsert($user_item_list, ['id'], ['string', 'text', 'number', 'item_select_id']);
            }

            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('admin.member.register');
        }

        return redirect()->route('admin.member.detail', ['member_id' => $user_id]);
    }

    /**
     * メンバー削除処理
     */
    public function delete(Request $request)
    {
        $users = new Users();
        $member = $users->where('id', $request['member_id'])->first();
        if(empty($member)){
            return redirect()->route('admin.member');
        }
        // 自分のアカウントは削除できないように
        if($member->id == Auth::user()->id){
            return redirect()->route('admin.member.edit');
        }

        $member->delete();

        return redirect()->route('admin.member');
    }

    /**
     * 申請手続き
     */
    public function proccess(Request $request)
    {
        $users = new Users();
        $member = $users->where('id', $request['member_id'])->first();
        if(empty($member)){
            return redirect()->route('admin.member');
        }

        $user_requests = new UserRequest();
        $status_rule = implode(',', [$user_requests::REQUEST_STATUS_OK, $user_requests::REQUEST_STATUS_NG]);
        $request->validate(['status' => "required|in:$status_rule"]);

        $request_status = $request['status'];

        // 更新処理
        DB::beginTransaction();
        try{
            $user_request = $user_requests->where('user_id', $member->id)
                ->where('status', $user_requests::REQUEST_STATUS_ACTIVE)
                ->first();
            $user_request_id = $user_request->id;

            $user_items = new UserItem();
            if($request_status == $user_requests::REQUEST_STATUS_OK){
                $user_request_item_list = $user_requests->getUserRequestItemList($member->id);

                foreach($user_request_item_list as $item_id => $request_item){
                    $user_items->where('user_id', $member->id)
                        ->where('item_id', $item_id)
                        ->update([
                            'user_id'        => $member->id,
                            'item_id'        => $item_id,
                            'string'         => $request_item->string,
                            'text'           => $request_item->text,
                            'number'         => $request_item->number,
                            'item_select_id' => $request_item->item_select_id,
                        ]);
                }
            }

            $user_requests->where('id', $user_request_id)
                ->update(['status' => $request_status]);

            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('admin.member.detail', ['member_id' => $member->id]);
        }

        return redirect()->route('admin.member.detail', ['member_id' => $member->id]);
    }
}
