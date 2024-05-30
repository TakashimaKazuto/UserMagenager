@extends('admin.layout')

@section('admin.part')
<div class="container">
    <div class="d-flex justify-content-between mt-4">
        <div>
            <a class="btn btn-outline-secondary" href="{{ route('admin.member') }}">戻る</a>
        </div>
        <div>
            @if($member->id != $users::MASTER_ADMIN_ID)
                @if(Auth::user()->id != $member->id)
                    <form method="POST" action="{{ route('admin.member.delete') }}" class="d-inline">
                        @csrf
                        <input type="hidden" name="member_id" value="{{ $member->id }}">
                        <button type="submit" class="btn btn-outline-danger mr-3">削除</button>
                    </form>
                @endif

                @if($has_active_request)
                    <form method="POST" action="{{ route('admin.member.proccess') }}" class="d-inline">
                        @csrf
                        <input type="hidden" name="member_id" value="{{ $member->id }}">
                        <button type="submit" name="status" value="{{ $user_requests::REQUEST_STATUS_NG }}" class="btn btn-outline-primary mr-3">変更申請却下</button>
                        <button type="submit" name="status" value="{{ $user_requests::REQUEST_STATUS_OK }}" class="btn btn-outline-primary mr-3">変更申請許可</button>
                    </form>
                @else
                    <a class="btn btn-outline-primary" href="{{ route('admin.member.edit', ['member_id' => $member->id]) }}">編集</a>
                @endif
            @endif
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
                        @php($user_item = isset($user_item_list[$item->id]) ? $user_item_list[$item->id] : null)
                        @if($item->type == $items::ITEM_TYPE_TEXT)
                            @if($has_active_request && isset($user_request_item_list[$item->id]))
                                <span class="text-danger">{{ $user_request_item_list[$item->id]->string }}</span>
                            @elseif(isset($user_item->string))
                                {{ $user_item->string }}
                            @endif
                        @elseif($item->type == $items::ITEM_TYPE_TEXTAREA)
                            @if($has_active_request && isset($user_request_item_list[$item->id]))
                                <span class="text-danger">{!! nl2br(htmlspecialchars($user_request_item_list[$item->id]->text)) !!}</span>
                            @elseif(isset($user_item->text))
                                {!! nl2br(htmlspecialchars($user_item->text)) !!}
                            @endif
                        @elseif($item->type == $items::ITEM_TYPE_NUMBER)
                            @if($has_active_request && isset($user_request_item_list[$item->id]))
                                <span class="text-danger">{!! nl2br(htmlspecialchars($user_request_item_list[$item->id]->number)) !!}</span>
                            @elseif(isset($user_item->number))
                                {{ $user_item->number }}
                            @endif
                        @elseif($item->type == $items::ITEM_TYPE_SELECT)
                            @if($has_active_request && !empty($user_request_item_list[$item->id]))
                                @php($item_select_id = $user_request_item_list[$item->id]->item_select_id)
                                <span class="text-danger">{{ $item->selects[$item_select_id] }}</span>
                            @elseif(isset($user_item->item_select_id))
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