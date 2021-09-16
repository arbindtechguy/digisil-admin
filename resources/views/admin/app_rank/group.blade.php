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
    <button type="button" id="add-group" class="btn btn-success m-3"><i class="fa fa-plus"></i> グループを登録する</button>
</div>
<form method="post">
    @csrf
    <table class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">グループ名</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody id="group-body">
            @if ($groups)
                @foreach ($groups as $group)
                <tr>
                    <th scope="row">{{$group->rank ?? $group->id}}</th>
                    <td><a href="{{route('admin.appsList', 
                        [
                            'groupID' => $group->id,
                            'categoryID' => $categoryID,
                        ]
                    )}}">{{$group->group}}</a></td>
                    <td><a href="{{route('admin.deleteGroup', ['id' => $group->id])}}" class="btn btn-danger delete">削除する</a></td>

                </tr>
                @endforeach
            @endif
            
        </tbody>
    </table>
    <div class="container hide" id="form-btns">
        <div class="d-flex j-right">
            <div class="col"><button type="submit" id="save" class="btn btn-success m-3">保存する</button></div>
            <div class="col"><button type="button" id="cancel-add" class="btn btn-danger m-3">キャンセル</button></div>
        </div>
    </div>
</form>

<script>
    var rank = $('.rank').length + 1
    var add = true;
    $('#add-group').click(function () {
        if (add) {
        add = false
        $('#form-btns').removeClass('hide');
        $('#group-body')
            .append($('<tr>').attr('class', 'psudo-tr')
                .append($('<td>').text(rank))
                .append($('<td>')
                    .append($('<input>')
                        .attr('type', 'text').attr('name', "group")
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
            $('#group-body .psudo-tr').remove();
        }
    })
</script>
