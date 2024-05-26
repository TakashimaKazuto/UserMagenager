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

        $items = new Item();
        $item_list = $items->getItemList();

        $page = $this->page;

        return view('admin.member.detail', compact('page', 'users', 'member', 'items', 'item_list'));
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
                $user_item_list = [];
                foreach($request['user_item'] as $item_id => $user_item){
                    $user_item['user_id'] = $user_id;
                    $user_item['item_id'] = $item_id;
                    $user_item_list[] = $user_item;
                }
                $user_items->insert($user_item_list);
            }

            DB::commit();
        }catch(\Exception $e){
            dd($e);
            DB::rollback();
            return redirect()->route('admin.member.register');
        }

        return redirect()->route('admin.member.detail', ['member_id' => $user_id]);
    }
}
