<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
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
}
