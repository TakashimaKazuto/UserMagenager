@extends('admin.layout')

@section('admin.part')
<div class="container">
    <form method="POST" action="{{ route('admin.item.create') }}">
        @csrf
        <div class="d-flex justify-content-between mt-4">
            <div>
                <a class="btn btn-outline-secondary" href="{{ route('admin.item') }}">戻る</a>
            </div>
            <div>
                <button type="submit" class="btn btn-outline-primary">登録</a>
            </div>
        </div>

        <div class="mt-4">
            @if($errors->any())
                @foreach($errors->all() as $error)
                    <div class="bg-red-200">
                        <p class="lead">{{$error}}</p>
                    </div>
                @endforeach
            @endif
            <table class="table table-bordered">
                <tr>
                    <th class="w-3 required align-middle">項目名</th>
                    <td class="w-7">
                        <input type="text" name="item[name]" value="{{ old('item.name') }}" class="form-control">
                    </td>
                </tr>
                <tr>
                    <th class="align-middle">項目説明</th>
                    <td class="align-middle">
                        <textarea name="item[description]" class="form-control">{{ old('item.description') }}</textarea>
                    </td>
                </tr>
                <tr>
                    <th class="required align-middle">項目タイプ</th>
                    <td class="align-middle">
                        <div class="form-check-inline">
                            <input type="radio" id="type-text" name="item[type]" value="{{ $items::ITEM_TYPE_TEXT }}" class="form-check-input ml-2" {{ old('item.type') == $items::ITEM_TYPE_TEXT ? 'checked' : '' }}>
                            <label for="type-text" class="form-check-label">{{ $items::ITEM_TYPE_LIST[$items::ITEM_TYPE_TEXT] }}</label>
                            <input type="radio" id="type-textarea" name="item[type]" value="{{ $items::ITEM_TYPE_TEXTAREA }}" class="form-check-input ml-3" {{ old('item.type') == $items::ITEM_TYPE_TEXTAREA ? 'checked' : '' }}>
                            <label for="type-textarea" class="form-check-label">{{ $items::ITEM_TYPE_LIST[$items::ITEM_TYPE_TEXTAREA] }}</label>
                            <input type="radio" id="type-number" name="item[type]" value="{{ $items::ITEM_TYPE_NUMBER }}" class="form-check-input ml-3" {{ old('item.type') == $items::ITEM_TYPE_NUMBER ? 'checked' : '' }}>
                            <label for="type-number" class="form-check-label">{{ $items::ITEM_TYPE_LIST[$items::ITEM_TYPE_NUMBER] }}</label>
                            <input type="radio" id="type-select" name="item[type]" value="{{ $items::ITEM_TYPE_SELECT }}" class="form-check-input ml-3" {{ old('item.type') == $items::ITEM_TYPE_SELECT ? 'checked' : '' }}>
                            <label for="type-select" class="form-check-label">{{ $items::ITEM_TYPE_LIST[$items::ITEM_TYPE_SELECT] }}</label>
                        </div>
                    </td>
                </tr>
                <tr id="item-select" class="{{ old('item.type') == $items::ITEM_TYPE_SELECT ? '' : 'hidden' }}">
                    <th class="required align-middle">項目選択肢</th>
                    <td class="align-middle">
                        <div id="item-select-list">
                            <input type="text" name="item[select][]" value="{{ old('item.select.0') }}" class="form-control" {{ old('item.type') == $items::ITEM_TYPE_SELECT ? '' : 'disabled' }}>
                            @if(!is_null(old('item.select')) && count(old('item.select')) > 1)
                                @foreach(old('item.select') as $n => $select)
                                    @if($n > 0)
                                    <input type="text" name="item[select][]" value="{{ $select }}" class="form-control mt-2">
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <div class="d-flex justify-content-end mt-2">
                            <button type="button" id="item-select-add" class="btn btn-outline-primary">追加</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th class="required align-middle">一般権限</th>
                    <td class="align-middle">
                        <div class="form-check-inline">
                            <input type="radio" id="procedure-editable" name="item[procedure]" value="{{ $items::ITEM_PROCEDURE_EDITABLE }}" class="form-check-input ml-2" {{ old('item.procedure') == $items::ITEM_PROCEDURE_EDITABLE ? 'checked' : '' }}>
                            <label for="procedure-editable" class="form-check-label">{{ $items::ITEM_PROCEDURE_LIST[$items::ITEM_PROCEDURE_EDITABLE] }}</label>
                            <input type="radio" id="procedure-readonly" name="item[procedure]" value="{{ $items::ITEM_PROCEDURE_READONLY }}" class="form-check-input ml-3" {{ old('item.procedure') == $items::ITEM_PROCEDURE_READONLY ? 'checked' : '' }}>
                            <label for="procedure-readonly" class="form-check-label">{{ $items::ITEM_PROCEDURE_LIST[$items::ITEM_PROCEDURE_READONLY] }}</label>
                            <input type="radio" id="procedure-hidden" name="item[procedure]" value="{{ $items::ITEM_PROCEDURE_HIDDEN }}" class="form-check-input ml-3" {{ old('item.procedure') == $items::ITEM_PROCEDURE_HIDDEN ? 'checked' : '' }}>
                            <label for="procedure-hidden" class="form-check-label">{{ $items::ITEM_PROCEDURE_LIST[$items::ITEM_PROCEDURE_HIDDEN] }}</label>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>

<script type="module">
    $(function(){
        // 項目タイプで「選択肢」がチェックされた場合に項目選択肢を表示
        $('[name="item[type]"]:radio').on('change', function(){
            let checked = $('input[name="item[type]"]:checked').val();
            if(checked === "{{ $items::ITEM_TYPE_SELECT }}"){
                $('#item-select').removeClass('hidden');
                $('#item-select').find('input').prop('disabled', false);
            }else{
                $('#item-select').addClass('hidden');
                $('#item-select').find('input').prop('disabled', true);
            }
        });

        // 項目選択肢を追加
        $('#item-select-add').on('click', function(){
            var clone = $('#item-select-list').find('input').last().clone(true);
            console.log(clone.val());
            clone.val('');
            clone.addClass('mt-2');
            clone.appendTo('#item-select-list');
        });
    });
</script>
@endsection