@extends('admin.layout')

@section('admin.part')
<div class="container">
    <div class="d-flex justify-content-end mt-4">
        <a class="btn btn-outline-primary" href="{{ route('admin.item.register') }}">新規追加</a>
    </div>

    <div class="mt-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="w-2">項目名</th>
                    <th class="w-4">説明</th>
                    <th class="w-2">項目タイプ</th>
                    <th class="w-2">一般権限</th>
                </tr>
            </thead>
            <tbody>
                @foreach($item_list as $item)
                <tr>
                    <td  class="align-middle">{{ $item->name }}</td>
                    <td  class="align-middle">{!! nl2br(htmlspecialchars($item->description)) !!}</td>
                    <td  class="align-middle">
                        <span>{{ $items::ITEM_TYPE_LIST[$item->type] }}</span>
                        @if($item->type == $items::ITEM_TYPE_SELECT)
                            @foreach($item->selects as $select)
                                <br><slan>・{{ $select['item_select_name'] }}</slan>
                            @endforeach
                        @endif
                    </td>
                    <td  class="align-middle">{{ $items::ITEM_PROCEDURE_LIST[$item->procedure] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection