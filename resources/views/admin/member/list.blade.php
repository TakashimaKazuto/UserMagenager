@extends('admin.layout')

@section('admin.part')
<div class="container">
    <div class="d-flex justify-content-end mt-4">
        <a class="btn btn-outline-primary" href="#">新規追加</a>
    </div>

    <div class="mt-5">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="w-2">アカウント</th>
                    <th class="w-5">氏名</th>
                    <th class="w-3">申請</th>
                </tr>
            </thead>
            <tbody>
                @foreach($member_list as $member)
                <tr class="member-info" data-member-id="{{ $member->id }}">
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->last_name }} {{ $member->first_name }}</td>
                    <td></td>
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