@extends('general.layout')

@section('general.part')
<div class="container">
    <form method="POST" action="{{ route('general.profile.update') }}">
        @csrf
        <input type="hidden" name="member_id" value="{{ $user->id }}">
        <div class="d-flex justify-content-between mt-4">
            <div>
                <a class="btn btn-outline-secondary" href="{{ route('general.profile') }}">戻る</a>
            </div>
            <div>
                <button type="submit" class="btn btn-outline-primary">変更申請</a>
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
                    <td class="w-8 align-middle">{{ $user->name }}</td>
                </tr>
                <tr>
                    <th class="align-middle required">氏名</th>
                    <td class="align-middle">
                        <div class="d-flex justify-content-start align-items-center">
                            <span class="ml-2">姓：{{ $user->last_name }}</span>
                            <span class="ml-2">名：{{ $user->first_name }}</span>
                        </div>
                    </td>
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