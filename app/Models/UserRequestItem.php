<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRequestItem extends Model
{
    protected $fillable = [
        'user_id',
        'item_id',
        'user_item_id',
        'user_request_id',
        'string',
        'text',
        'number',
        'item_select_id',
    ];
}
