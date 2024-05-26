@extends('admin.layout')

@section('admin.part')
<div class="container">
    <form method="POST" action="{{ route('admin.member.create') }}">
        @csrf
        <div class="d-flex justify-content-between mt-4">
            <div>
                <a class="btn btn-outline-secondary" href="{{ route('admin.member') }}">戻る</a>
            </div>
            <div>
                <button type="submit" class="btn btn-outline-primary">登録</a>
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
                    <th class="w-2 align-middle required">アカウント</th>
                    <td class="w-8 align-middle">
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                    </td>
                </tr>
                <tr>
                    <th class="align-middle required">氏名</th>
                    <td class="align-middle">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="ml-2">姓：</span>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control">
                            <span class="ml-2">名：</span>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th class="align-middle">パスワード</th>
                    <td class="align-middle">初期パスワードが発行されます。</td>
                </tr>
                <tr>
                    <th class="align-middle required">権限</th>
                    <td class="align-middle">
                        <div class="form-check-inline">
                            <input type="radio" id="procedure-editable" name="type" value="{{ $users::USER_TYPE_ADMIN }}" class="form-check-input ml-2" {{ old('type') == $users::USER_TYPE_ADMIN ? 'checked' : '' }}>
                            <label for="procedure-editable" class="form-check-label">{{ $users::USER_TYPE_LIST[$users::USER_TYPE_ADMIN] }}</label>
                            <input type="radio" id="procedure-readonly" name="type" value="{{ $users::USER_TYPE_GENERAL }}" class="form-check-input ml-3" {{ old('type') == $users::USER_TYPE_GENERAL ? 'checked' : '' }}>
                            <label for="procedure-readonly" class="form-check-label">{{ $users::USER_TYPE_LIST[$users::USER_TYPE_GENERAL] }}</label>
                        </div>
                    </td>
                </tr>
                @foreach($item_list as $item)
                <tr>
                    <th class="align-middle">{{ $item->name }}</th>
                    <td class="align-middle">
                        @if($item->type == $items::ITEM_TYPE_TEXT)
                        <input type="text" name="user_item[{{ $item->id }}][string]" value="{{ old('user_item.'.$item->id.'.string') }}" class="form-control">
                        @elseif($item->type == $items::ITEM_TYPE_TEXTAREA)
                        <textarea name="user_item[{{ $item->id }}][text]" class="form-control">
                            {{ old('user_item.'.$item->id.'.text') }}
                        </textarea>
                        @elseif($item->type == $items::ITEM_TYPE_NUMBER)
                        <input type="number" name="user_item[{{ $item->id }}][number]" value="{{ old('user_item.'.$item->id.'.number') }}" class="form-control">
                        @elseif($item->type == $items::ITEM_TYPE_SELECT)
                        <select name="user_item[{{ $item->id }}][item_select_id]" class="form-select">
                            <option value="">選択してください</option>
                            @foreach($item->selects as $select)
                            <option value="{{ $select['item_select_id'] }}" {{ old('user_item.'.$item->id.'.item_select_id') == $select['item_select_id'] ? 'selected' : '' }}>{{ $select['item_select_name'] }}</option>
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