<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserRequest;

class Users extends Model
{
    use SoftDeletes;

    const USER_TYPE_ADMIN = 1;
    const USER_TYPE_GENERAL = 2;
    const USER_TYPE_LIST = [
        self::USER_TYPE_ADMIN => '管理者',
        self::USER_TYPE_GENERAL => '一般',
    ];

    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'password',
        'type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getMemberList()
    {
        $select_column = [
            'users.id',
            'users.name',
            'users.first_name',
            'users.last_name',
            'users.type',
            'user_requests.status',
        ];
        $member_list = $this->select($select_column)
            ->orderBy('users.id', 'asc')
            ->leftjoin('user_requests', function($join){
                $user_requests = new UserRequest();
                $join->on('users.id', '=', 'user_requests.user_id')
                    ->where('user_requests.status', '=', $user_requests::REQUEST_STATUS_ACTIVE);
            })->get();

        return $member_list;
    }
}
