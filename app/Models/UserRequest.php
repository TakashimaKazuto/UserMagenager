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
}