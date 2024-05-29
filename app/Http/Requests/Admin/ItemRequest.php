<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Item;

class ItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $item = new Item;
        $type_rule = implode(',', [$item::ITEM_TYPE_TEXT, $item::ITEM_TYPE_TEXTAREA, $item::ITEM_TYPE_NUMBER, $item::ITEM_TYPE_SELECT]);
        $procedure_rule = implode(',', [$item::ITEM_PROCEDURE_EDITABLE, $item::ITEM_PROCEDURE_READONLY, $item::ITEM_PROCEDURE_HIDDEN]);
        $select_required_rule = $item::ITEM_TYPE_SELECT;

        return [
            'item.name'         => 'required|max:20',
            'item.description'  => 'max:200',
            'item.type'         => "required|in:$type_rule",
            'item.select.*'     => "required_if:item.type,$select_required_rule|max:20",
            'item.procedure'    => "required|in:$procedure_rule",
        ];
    }

    public function messages(): array
    {
        return [
            'item.name.required'        => ':attribute は必須です。',
            'item.name.max'             => ':attribute は :max 文字以内です。',
            'item.description.max'      => ':attribute は :max 文字以内です。',
            'item.type.required'        => ':attribute は必須です。',
            'item.select.*.required_if' => ':attribute は必須です。',
            'item.select.*.max'         => ':attribute は :max 文字以内です。',
            'item.procedure.required'   => ':attribute は必須です。',
            'item.procedure.in'         => ':attribute の値が不正です。',
        ];
    }

    public function attributes()
    {
        return [
            'item.name'         => '項目名',
            'item.description'  => '項目説明',
            'item.type'         => '項目タイプ',
            'item.select.*'     => '選択肢',
            'item.procedure'    => '一般権限',
        ];
    }
}
