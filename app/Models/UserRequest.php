<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class UserRequest extends Model
{
    const REQUEST_STATUS_ACTIVE = 1;
    const REQUEST_STATUS_OK = 2;
    const REQUEST_STATUS_NG = 3;

    protected $fillable = [
        'user_id',
        'status',
    ];

    /**
     * 申請中の変更がないか確認
     */
    public function checkActiveRequest($user_id)
    {
        $exist = DB::table('user_requests')
            ->where('user_id', $user_id)
            ->where('status', self::REQUEST_STATUS_ACTIVE)
            ->exists();

        return $exist;
    }

    /**
     * 申請中の変更内容を取得
     */
    public function getUserRequestItemList($user_id)
    {
        $select_columns = [
            'user_request_items.item_id',
            'user_request_items.string',
            'user_request_items.text',
            'user_request_items.number',
            'user_request_items.item_select_id',
        ];
        $user_request_items = DB::table('user_requests')
            ->select($select_columns)
            ->where('user_requests.user_id', $user_id)
            ->where('user_requests.status', self::REQUEST_STATUS_ACTIVE)
            ->join('user_request_items', 'user_requests.id', '=', 'user_request_items.user_request_id')
            ->get();

        $user_request_item_list = [];
        foreach($user_request_items as $request_item){
            $item_id = $request_item->item_id;
            $user_request_item_list[$item_id] = $request_item;
        }

        return $user_request_item_list;
    }
}