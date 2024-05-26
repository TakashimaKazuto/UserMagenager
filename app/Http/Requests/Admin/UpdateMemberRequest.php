<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Users;
use App\Models\Item;

class UpdateMemberRequest extends FormRequest
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
        $rule = [
            'first_name' => 'required|max:10',
            'last_name'  => 'required|max:10',
        ];

        $items = new Item();
        $item_list = $items->getItemList();

        $base_item_rule_list = [
            $items::ITEM_TYPE_TEXT => [
                'column' => 'string',
                'rule'   => 'max:10',
            ],
            $items::ITEM_TYPE_TEXTAREA => [
                'column' => 'text',
                'rule'   => 'max:50',
            ],
            $items::ITEM_TYPE_NUMBER => [
                'column' => 'number',
                'rule'   => 'nullable|numeric',
            ],
            $items::ITEM_TYPE_SELECT => [
                'column' => 'item_seiect_id',
                'rule'   => ''
            ]
        ];

        foreach($item_list as $item){
            $base_item_rule = $base_item_rule_list[$item->type];
            $column = $base_item_rule['column'];
            $item_rule = $base_item_rule['rule'];
            if($item->type == $items::ITEM_TYPE_SELECT){
                $selects = $item->selects;
                $select_ids = implode(',', array_keys($selects));
                $item_rule = "in:$select_ids";
            }

            $tmp = [
                "user_item.$item->id.$column" => $item_rule,
            ];
            $rule = array_merge($rule, $tmp);
        }

        return $rule;
    }

    public function messages()
    {
        return [
            'last_name.required'  => ':attribute は必須です。',
            'last_name.max'       => ':attribute は :max 文字以内です。',
            'first_name.required' => ':attribute は必須です。',
            'first_name.max'      => ':attribute は :max 文字以内です。',
            'user_item.*'         => ':attribute の入力が間違っています。',
        ];
    }

    public function attributes()
    {
        return [
            'last_name'    => '氏名（姓）',
            'first_name'   => '氏名（名）',
            'user_item'    => '設定項目',
        ];
    }
}
