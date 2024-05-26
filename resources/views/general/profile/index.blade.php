@extends('general.layout')

@section('general.part')
<div class="container">
    <div class="d-flex justify-content-end mt-4">
        <div>
            <a class="btn btn-outline-primary" href="{{ route('general.profile.edit') }}">変更</a>
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