<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Users;
use App\Models\Item;

class CreateMemberRequest extends FormRequest
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
        $users = new Users();
        $type_rule = implode(',', [$users::USER_TYPE_ADMIN, $users::USER_TYPE_GENERAL]);

        $rule = [
            'name'       => 'required|max:10|alpha_num|unique:users',
            'first_name' => 'required|max:10',
            'last_name'  => 'required|max:10',
            'type'       => "required|in:$type_rule",
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
            'name.required'       => ':attribute は必須です。',
            'name.max'            => ':attribute は :max 文字以内です。',
            'name.alpha_num'      => ':attribute は 英数字のみです。',
            'name.unique'         => '入力された :attribute は既に使われています。',
            'last_name.required'  => ':attribute は必須です。',
            'last_name.max'       => ':attribute は :max 文字以内です。',
            'first_name.required' => ':attribute は必須です。',
            'first_name.max'      => ':attribute は :max 文字以内です。',
            'type.required'       => ':attribute は必須です。',
            'type.in'             => ':attribute の値が不正です。',
            'user_item.*'         => ':attribute の入力が間違っています。',
        ];
    }

    public function attributes()
    {
        return [
            'name'         => 'アカウント',
            'last_name'    => '氏名（姓）',
            'first_name'   => '氏名（名）',
            'type'         => '権限',
            'user_item'    => '設定項目',
        ];
    }
}
