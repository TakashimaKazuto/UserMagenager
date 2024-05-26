@extends('general.layout')

@section('general.part')
<div class="container">
    <div class="px-3 py-2 mt-4 bg-gray-200">
        <p class="lead">
            ようこそ、{{ Auth::user()->last_name }} {{ Auth::user()->first_name }}さん。<br>
            あなたのアカウントは一般利用者です。<br>
            自身のプロフィールの確認、変更申請ができます。
        </p>
    </div>
</div>
@endsection