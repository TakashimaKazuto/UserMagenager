<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Users extends Model
{
    use SoftDeletes;

    const USER_TYPE_ADMIN = 1;
    const USER_TYPE_GENERAL = 2;
    const USER_TYPE_NAME_LIST = [
        self::USER_TYPE_ADMIN => '管理者',
        self::USER_TYPE_GENERAL => '一般',
    ];

    protected $fillable = [
        'name',
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
}
