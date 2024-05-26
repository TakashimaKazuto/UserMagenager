@extends('admin.layout')

@section('admin.part')
<div class="container">
    <div class="d-flex justify-content-between mt-4">
        <div>
            <a class="btn btn-outline-secondary" href="{{ route('admin.member') }}">戻る</a>
        </div>
        <div>
            <a class="btn btn-outline-danger" href="#">削除</a>
            <a class="btn btn-outline-primary ml-3" href="#">編集</a>
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
                <td>{{ $users::USER_TYPE_NAME_LIST[$member->type] }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection