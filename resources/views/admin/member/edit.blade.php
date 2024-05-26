@extends('admin.layout')

@section('admin.part')
<div class="container">
    <form method="POST" action="{{ route('admin.member.update') }}">
        @csrf
        <input type="hidden" name="member_id" value="{{ $member->id }}">
        <div class="d-flex justify-content-between mt-4">
            <div>
                <a class="btn btn-outline-secondary" href="{{ route('admin.member.detail', ['member_id', $member->id]) }}">戻る</a>
            </div>
            <div>
                <button type="submit" class="btn btn-outline-primary">更新</a>
            </div>
        </div>

        <div class="mt-4">
            @if($errors->any())
                @foreach($errors->all() as $error)
                    <div class="bg-red-200">
                        <p class="lead">{{$error}}</p>
                    </div>
                @endforeach
            @endif
            <table class="table table-bordered">
                <tr>
                    <th class="w-2 align-middle">アカウント</th>
                    <td class="w-8 align-middle">{{ $member->name }}</td>
                </tr>
                <tr>
                    <th class="align-middle required">氏名</th>
                    <td class="align-middle">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="ml-2">姓：</span>
                            <input type="text" name="last_name" value="{{ old('last_name', $member->last_name) }}" class="form-control">
                            <span class="ml-2">名：</span>
                            <input type="text" name="first_name" value="{{ old('first_name', $member->first_name) }}" class="form-control">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th class="align-middle">パスワード</th>
                    <td class="align-middle"></td>
                </tr>
                <tr>
                    <th class="align-middle">権限</th>
                    <td class="align-middle">{{ $users::USER_TYPE_LIST[$member->type] }}</td>
                </tr>
                @foreach($item_list as $item)
                <tr>
                    <th class="align-middle">{{ $item->name }}</th>
                    <td class="align-middle">
                        @php($user_item_id = isset($user_item_list[$item->id]->id) ? $user_item_list[$item->id]->id : null)
                        <input type="hidden" name="user_item[{{ $item->id }}][id]" value="{{ $user_item_id }}">
                        @if($item->type == $items::ITEM_TYPE_TEXT)
                            @php($user_item_value = isset($user_item_list[$item->id]->string) ? $user_item_list[$item->id]->string : null)
                            <input type="text" name="user_item[{{ $item->id }}][string]" value="{{ old('user_item.'.$item->id.'.string', $user_item_value) }}" class="form-control">
                        @elseif($item->type == $items::ITEM_TYPE_TEXTAREA)
                            @php($user_item_value = isset($user_item_list[$item->id]->text) ? $user_item_list[$item->id]->text : null)
                            <textarea name="user_item[{{ $item->id }}][text]" class="form-control">
                                {{ old('user_item.'.$item->id.'.text', $user_item_value) }}
                            </textarea>
                        @elseif($item->type == $items::ITEM_TYPE_NUMBER)
                            @php($user_item_value = isset($user_item_list[$item->id]->number) ? $user_item_list[$item->id]->number : null)
                            <input type="number" name="user_item[{{ $item->id }}][number]" value="{{ old('user_item.'.$item->id.'.number', $user_item_value) }}" class="form-control">
                        @elseif($item->type == $items::ITEM_TYPE_SELECT)
                        <select name="user_item[{{ $item->id }}][item_select_id]" class="form-select">
                            <option value="">選択してください</option>
                            @foreach($item->selects as $select_id => $select)
                                @php($user_item_value = isset($user_item_list[$item->id]->item_select_id) ? $user_item_list[$item->id]->item_select_id : null)
                                <option value="{{ $select_id }}" {{ old('user_item.'.$item->id.'.item_select_id', $user_item_value) == $select_id ? 'selected' : '' }}>{{ $select }}</option>
                            @endforeach
                        </select>
                        @endif
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </form>
</div>
@endsection