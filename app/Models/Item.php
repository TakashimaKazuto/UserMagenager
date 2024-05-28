<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    const ITEM_TYPE_TEXT = 1;
    const ITEM_TYPE_TEXTAREA = 2;
    const ITEM_TYPE_NUMBER = 3;
    const ITEM_TYPE_SELECT = 4;
    const ITEM_TYPE_LIST = [
        self::ITEM_TYPE_TEXT     => '文字列',
        self::ITEM_TYPE_TEXTAREA => '長文',
        self::ITEM_TYPE_NUMBER   => '数値',
        self::ITEM_TYPE_SELECT   => '選択肢',
    ];

    const ITEM_PROCEDURE_EDITABLE = 1;
    const ITEM_PROCEDURE_READONLY = 2;
    const ITEM_PROCEDURE_HIDDEN = 3;
    const ITEM_PROCEDURE_LIST = [
        self::ITEM_PROCEDURE_EDITABLE => '編集可能',
        self::ITEM_PROCEDURE_READONLY => '閲覧のみ',
        self::ITEM_PROCEDURE_HIDDEN => '非表示',
    ];

    protected $fillable = [
        'name',
        'description',
        'type',
        'procedure',
    ];

    public function getItemList()
    {
        $item_columns = [
            'items.id',
            'items.name',
            'items.description',
            'items.type',
            'items.procedure',
        ];
        $items = $this->select($item_columns)
            ->selectRaw("group_concat(concat(item_selects.id, ':'), item_selects.name order by item_selects.id) selects")
            ->leftjoin('item_selects', 'items.id', '=', 'item_selects.item_id')
            ->orderBy('items.id', 'asc')
            ->groupBy('items.id')
            ->get();

        $item_list = clone $items;
        foreach($item_list as $item){
            if($item->type == self::ITEM_TYPE_SELECT){
                $select_list = [];

                $selects = explode(',', $item->selects);
                foreach($selects as $select){
                    $tmp = explode(':', $select);
                    $select_id = $tmp[0];
                    $select_value = $tmp[1];
                    $select_list[$select_id] = $select_value;
                }

                $item->selects = $select_list;
            }
        }

        return $item_list;
    }
}
