@extends('admin.layout')

@section('admin.part')
<div class="container">
    <div class="d-flex justify-content-end mt-4">
        <a class="btn btn-outline-primary" href="{{ route('admin.member.register') }}">追加</a>
    </div>

    <div class="mt-5">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="w-2">アカウント</th>
                    <th class="w-4">氏名</th>
                    <th class="w-2">権限</th>
                    <th class="w-2">申請</th>
                </tr>
            </thead>
            <tbody>
                @foreach($member_list as $member)
                <tr class="member-info" data-member-id="{{ $member->id }}">
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->last_name }} {{ $member->first_name }}</td>
                    <td>{{ $users::USER_TYPE_LIST[$member->type] }}</td>
                    <td>
                        @if($member->status == $user_requests::REQUEST_STATUS_ACTIVE)
                            <span class="text-danger">変更申請中</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script type="module">
    $(function(){
        $('.member-info').on('click', function(){
            let member_id = $(this).data('member-id');
            location.href = "{{ route('admin.member.detail', ['member_id' => '*']) }}".replace('*', member_id);
        });
    });
</script>
@endsection