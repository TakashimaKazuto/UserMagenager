@extends('admin.layout')

@section('admin.part')
    <div class="container">
        <div class="px-3 py-2 mt-4 bg-gray-200">
            <p class="lead">
                {{ Auth::user()->name }} は管理者権限を持つアカウントです。<br>
                メンバーの登録や編集、項目の設定が可能です。
            </p>
        </div>
    </div>
@endsection