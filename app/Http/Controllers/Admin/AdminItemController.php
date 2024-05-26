<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $item_columns = [
            'items.id',
            'items.name',
            'items.description',
            'items.type',
            'items.procedure',
        ];
        $item_list = $items
            ->select($item_columns)
            ->selectRaw('group_concat(item_selects.name) selects')
            ->distinct()
            ->leftjoin('item_selects', 'items.id', '=', 'item_selects.item_id')
            ->orderBy('items.id', 'asc')
            ->groupBy('items.id')
            ->get();

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

        $item = new Item;
        $item_select = new ItemSelect;

        $post = $request['item'];

        // 更新処理
        DB::beginTransaction();
        try{
            // 項目を登録
            $item->fill([
                'name'         => $post['name'],
                'description'  => !is_null($post['description']) ? $post['description'] : '',
                'type'         => $post['type'],
                'procedure'    => $post['procedure'],
            ]);
            $item->save();
            $item_id = $item->id;

            // 選択肢項目の場合は選択肢を登録
            if($item->type == $item::ITEM_TYPE_SELECT){
                $select_array = [];
                foreach($post['select'] as $select){
                    $select_array[] = [
                        'item_id' => $item_id,
                        'name'    => $select,
                    ];
                }
                $item_select->insert($select_array);
            }

            DB::commit();
        }catch(\Exception $e){
            dd($e);
            DB::rollback();
        }

        return redirect()->route('admin.item');
    }
}
