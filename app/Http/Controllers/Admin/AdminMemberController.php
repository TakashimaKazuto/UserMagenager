<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\Users;
use App\Models\Item;
use App\Models\UserItem;
use App\Http\Requests\Admin\CreateMemberRequest;
use App\Http\Requests\Admin\UpdateMemberRequest;

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
        $member = $users->where('id', $member_id)->first();
        if(empty($member)){
            return redirect()->route('admin.member');
        }

        $items = new Item();
        $item_list = $items->getItemList();
        $item_ids = $item_list->pluck('id')->toArray();

        $user_items = new UserItem();
        $user_item_list = $user_items->getUserItemList($member_id, $item_ids);

        $page = $this->page;

        return view('admin.member.detail', compact('page', 'users', 'member', 'items', 'item_list', 'user_item_list'));
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
                $user_items->upsert($user_item_list, ['id'], ['string', 'text', 'number', 'item_select_id']);
            }

            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('admin.member.register');
        }

        return redirect()->route('admin.member.detail', ['member_id' => $user_id]);
    }
}
