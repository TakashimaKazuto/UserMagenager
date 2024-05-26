<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\Item;
use App\Models\ItemSelect;
use App\Http\Requests\Admin\ItemRequest;

class AdminItemController extends Controller
{
    public $page = 'item';

    /**
     * 項目一覧
     */
    public function list()
    {
        $items = new Item;
        $item_list = $items->getItemList();

        $page = $this->page;

        return view('admin.item.list', compact('page', 'items', 'item_list'));
    }

    /**
     * 項目新規登録
     */
    public function register(Request $request)
    {
        $items = new Item;

        $page = $this->page;

        return view('admin.item.register', compact('page', 'items'));
    }

    /**
     * 項目登録処理
     */
    public function create(ItemRequest $request)
    {
        // バリデーション
        $request->validated();

        $items = new Item;
        $item_selects = new ItemSelect;

        $post = $request['item'];

        // 更新処理
        DB::beginTransaction();
        try{
            // 項目を登録
            $items->fill([
                'name'         => $post['name'],
                'description'  => !is_null($post['description']) ? $post['description'] : '',
                'type'         => $post['type'],
                'procedure'    => $post['procedure'],
            ]);
            $items->save();
            $item_id = $items->id;

            // 選択肢項目の場合は選択肢を登録
            if($items->type == $items::ITEM_TYPE_SELECT){
                $select_array = [];
                foreach($post['select'] as $select){
                    $select_array[] = [
                        'item_id' => $item_id,
                        'name'    => $select,
                    ];
                }
                $item_selects->insert($select_array);
            }

            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }

        return redirect()->route('admin.item');
    }
}
