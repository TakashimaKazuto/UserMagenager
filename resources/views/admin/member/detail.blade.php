@extends('admin.layout')

@section('admin.part')
<div class="container">
    <div class="d-flex justify-content-between mt-4">
        <div>
            <a class="btn btn-outline-secondary" href="{{ route('admin.member') }}">戻る</a>
        </div>
        <div>
            @if(Auth::user()->id != $member->id)
            <a class="btn btn-outline-danger mr-3" href="#">削除</a>
            @endif
            <a class="btn btn-outline-primary" href="{{ route('admin.member.edit', ['member_id' => $member->id]) }}">編集</a>
        </div>
    </div>

    <div class="mt-5">
        <table class="table table-bordered">
            <tr>
                <th class="w-3 align-middle">アカウント</th>
                <td class="w-7 align-middle">{{ $member->name }}</td>
            </tr>
            <tr>
                <th class="align-middle">氏名</th>
                <td class="align-middle">{{ $member->last_name }} {{ $member->first_name }}</td>
            </tr>
            <tr>
                <th class="align-middle">権限</th>
                <td class="align-middle">{{ $users::USER_TYPE_LIST[$member->type] }}</td>
            </tr>
            @foreach($item_list as $item)
            <tr>
                <th class="align-middle">{{ $item->name }}</th>
                <td class="align-middle">
                    @if(isset($user_item_list[$item->id]))
                        @php($user_item = $user_item_list[$item->id])
                        @if($item->type == $items::ITEM_TYPE_TEXT)
                            {{ $user_item->string }}
                        @elseif($item->type == $items::ITEM_TYPE_TEXTAREA)
                            {!! nl2br(htmlspecialchars($item->text)) !!}
                        @elseif($item->type == $items::ITEM_TYPE_NUMBER)
                            {{ $user_item->number }}
                        @elseif($item->type == $items::ITEM_TYPE_SELECT)
                            @if(isset($item->selects[$user_item->item_select_id]))
                                {{ $item->selects[$user_item->item_select_id] }}
                            @endif
                        @endif
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection