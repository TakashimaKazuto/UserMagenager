<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Users;
use App\Models\Item;

class UpdateMemberRequest extends FormRequest
{
    private $item_rules = [];
    private $item_messages = [];
    private $item_attributes = [];

    function __construct()
    {
        $items = new Item();
        $item_list = $items->getItemList();

        $item_rules = [];
        $item_messages = [];
        $item_attributes = [];
        foreach($item_list as $item){
            $target_key = 'user_item.'.$item->id;
            $target_rules = '';
            $target_messages = [];
            switch($item->type){
                case $items::ITEM_TYPE_TEXT:
                    $target_key .= '.string';
                    $target_rules = 'max:10';
                    $target_messages = [
                        $target_key.'.max' => ':attribute は :max 文字以内です。',
                    ];
                    break;
                case $items::ITEM_TYPE_TEXTAREA:
                    $target_key .= '.text';
                    $target_rules = 'max:50';
                    $target_messages = [
                        $target_key.'.max' => ':attribute は :max 文字以内です。',
                    ];
                    break;
                case $items::ITEM_TYPE_NUMBER:
                    $target_key .= '.number';
                    $target_rules = 'nullable|numeric|max_digits:10';
                    $target_messages = [
                        $target_key.'numeric' => ':attribute は数値で入力してください。',
                        $target_key.'.max_digits' => ':attribute は :max 桁以内です。',
                    ];
                    break;
                case $items::ITEM_TYPE_SELECT:
                    $target_key.= '.item_select_id';
                    $selects = $item->selects;
                    $select_ids = implode(',', array_keys($selects));
                    $target_rules = "nullable|in:$select_ids";
                    $target_messages = [
                        $target_key.'.in' => ':attribute の値が不正です。',
                    ];
                    break;
            }

            $item_rules[$target_key] = $target_rules;
            $item_messages = array_merge($item_messages, $target_messages);
            $item_attributes[$target_key] = $item->name;
        }

        $this->item_rules = $item_rules;
        $this->item_messages = $item_messages;
        $this->item_attributes = $item_attributes;
    }

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

        $rule = array_merge($rule, $this->item_rules);

        return $rule;
    }

    public function messages()
    {
        $message = [
            'last_name.required'  => ':attribute は必須です。',
            'last_name.max'       => ':attribute は :max 文字以内です。',
            'first_name.required' => ':attribute は必須です。',
            'first_name.max'      => ':attribute は :max 文字以内です。',
        ];

        $message = array_merge($message, $this->item_messages);

        return $message;
    }

    public function attributes()
    {
        $attribute = [
            'last_name'    => '氏名（姓）',
            'first_name'   => '氏名（名）',
        ];

        $attribute = array_merge($attribute, $this->item_attributes);

        return $attribute;
    }
}
