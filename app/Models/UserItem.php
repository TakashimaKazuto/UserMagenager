<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserItem extends Model
{
    protected $fillable = [
        'user_id',
        'item_id',
        'string',
        'text',
        'number',
        'item_select_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function getUserItemList($user_id, $item_ids)
    {
        $user_items = $this->where('user_id', $user_id)
            ->whereIn('item_id', $item_ids)
            ->orderBy('user_id', 'asc')
            ->get();

        $user_item_list = [];
        foreach($user_items as $user_item){
            $item_id = $user_item->item_id;
            $user_item_list[$item_id] = $user_item;
        }

        return $user_item_list;
    }
}
