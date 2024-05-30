@extends('general.layout')

@section('general.part')
<div class="container">
    <div class="d-flex justify-content-end mt-4">
        <div>
            @if($has_active_request)
                <form method="POST" action="{{ route('general.profile.cancel') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">変更申請取消</button>
                </form>
            @else
                <a class="btn btn-outline-primary" href="{{ route('general.profile.edit') }}">変更</a>
            @endif
        </div>
    </div>

    <div class="mt-5">
        <table class="table table-bordered">
            <tr>
                <th class="w-3 align-middle">アカウント</th>
                <td class="w-7 align-middle">{{ $user->name }}</td>
            </tr>
            <tr>
                <th class="align-middle">氏名</th>
                <td class="align-middle">{{ $user->last_name }} {{ $user->first_name }}</td>
            </tr>
            @foreach($item_list as $item)
                @if($item->procedure != $items::ITEM_PROCEDURE_HIDDEN)
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
                @endif
            @endforeach
        </table>
    </div>
</div>
@endsection