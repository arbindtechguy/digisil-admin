<style>
    .thead-dark {
        background: black;
        color: white;
    }

    .m-3 {
        margin: 15px !important;
    }

    .hide {
        display: none !important;
    }

    .d-flex {
        display: flex;
    }

    .j-right {
        justify-content: right;
    }

</style>
@if (session('flash_message'))
<div class="alert alert-success" role="alert">
    {{ session('flash_message') }}
</div>
@endif
@if (session('flash_message_error'))
<div class="alert alert-danger" role="alert">
    {{ session('flash_message_error') }}
</div>
@endif
<div class="container">
    <button type="button" id="add-category" class="btn btn-success m-3"><i class="fa fa-plus"></i> カテゴリを登録する</button>
</div>
<form method="post" action="{{route('admin.addCategory')}}">
    @csrf
    <table class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">カテゴリ名</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody id="category-body">
            @foreach ($categories as $category)
                <tr>
                    <th class="rank" scope="row">{{$category->rank ?? $category->id}}</th>
                    <td><a href="{{route('admin.groupList', ['categoryID' => $category->id ])}}">{{$category->category}}</a></td>
                    <td><a href="{{route('admin.deleteCategory', ['id' => $category->id])}}" class="btn btn-danger delete">削除する</a></td>

                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="container hide" id="form-btns">
        <div class="d-flex j-right">
            <input type="hidden" id="rank" name="rank" value="">
            <div class="col"><button type="submit" id="save" class="btn btn-success m-3">保存する</button></div>
            <div class="col"><button type="button" id="cancel-add" class="btn btn-danger m-3">キャンセル</button></div>
        </div>
    </div>
</form>

<script>
    var rank = $('.rank').length + 1
    $('#rank').val(rank)
    var add = true;
    $('#add-category').click(function () {
        if (add) {
        add = false
        $('#form-btns').removeClass('hide');
        $('#category-body')
            .append($('<tr>').attr('class', 'psudo-tr')
                .append($('<td>').text(rank))
                .append($('<td>')
                    .append($('<input>')
                        .attr('type', 'text').attr('name', "category")
                        .text('')
                    )
                )
            );
        }
    })

    $('#cancel-add').click(function () {
        add = true;
        if (confirm('変更された部分を保存されません、よろしいですか？')) {
            $('#form-btns').addClass('hide');
            $('#category-body .psudo-tr').remove();
        }
    })

</script>
