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
            <a class="btn btn-outline-primary" href="#">編集</a>
        </div>
    </div>

    <div class="mt-5">
        <table class="table table-bordered">
            <tr>
                <th class="w-3">アカウント</th>
                <td class="w-7">{{ $member->name }}</td>
            </tr>
            <tr>
                <th>氏名</th>
                <td>{{ $member->last_name }} {{ $member->first_name }}</td>
            </tr>
            <tr>
                <th>権限</th>
                <td>{{ $users::USER_TYPE_LIST[$member->type] }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection