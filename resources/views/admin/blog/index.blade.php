@extends('adminlte::page')

@section('title', 'ブログ一覧')

@section('content_header')
    <h1>ブログ一覧</h1>
@stop

@section('content')
<div class="form-group mt-15">
    <button type="button" class="btn btn-primary" onclick="location.href='{{ route('admin.blog.edit') }}'">新規登録</button>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            {{Form::open(['method'=>'post', 'id'=>'search_form'])}}
                <div class="card card-default {{$collapse['CARD_CLASS']}}">
                    <div class="card-header">
                        <h3 class="card-title">検索</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool collapse_close" data-card-widget="collapse" data-animation-speed="300">
                                <i class="fas {{$collapse['BTN_CLASS']}}"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="{{$collapse['BODY_STYLE']}}">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>カテゴリー</label>
                                    <div class="form-inline">
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" name="category" id="category_all" value=""
                                            @if ($search['keyword'] == null) checked
                                            @endif
                                            >
                                            <label for="category_all" class="custom-control-label">全て　</label>
                                        </div>
                                        @foreach (config('const.BLOG_CATEGORY') as $key => $item)
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" name="category" id="category_{{$key}}" value="{{$key}}"
                                            @if ($search['category'] == $key) checked
                                            @endif
                                            >
                                            <label for="category_{{$key}}" class="custom-control-label">{{$item}}　</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>フリーワード検索</label>
                                    <input type="search" class="form-control" placeholder="スペース区切りで複数キーワード" name="keyword" value="{{$search['keyword']}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="button" class="btn btn-secondary float-right ml-1" onclick="clearSearchForm();">クリア</button>
                                    <button type="submit" class="btn btn-primary float-right">検索</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {{ Form::close() }}
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatable1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>状態</th>
                                <th>日付</th>
                                <th>カテゴリー</th>
                                <th>タイトル</th>
                                <th>登録日時</th>
                                <th>更新日時</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($blogs as $blog)
                            <tr>
                                <td>{{ $blog->id }}</td>
                                <td>@if ($blog->is_enabled == 1) <span class="text-primary">公開</span> @else <span class="text-danger">非公開</span> @endif</td>
                                <td>{{ $blog->day->format('Y/m/d') }}</td>
                                <td>{{ config('const.BLOG_CATEGORY.' . $blog->category) }}</td>
                                <td>{{ $blog->title }}</td>
                                <td>{{ $blog->created_at }}</td>
                                <td>{{ $blog->updated_at }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-primary" onclick="location.href='{{route('admin.blog.edit',['id' => $blog->id])}}'">編集</button>
                                    <button type="button" class="btn btn-danger delete_btn" onclick="deleteData('{{ route('admin.blog.destroy',['id' => $blog->id]) }}');">削除</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>


{{-- 検索クリアボタン用フォーム --}}
{{Form::open(['method'=>'post', 'id'=>'search_clear_form'])}}
{{ Form::close() }}


{{-- 削除ボタン用フォーム --}}
{{Form::open(['method'=>'post', 'id'=>'delete_form'])}}
{{ Form::close() }}

@stop




@section('css')
<link rel="stylesheet" href="{{ asset( cacheBusting('css/common.css') ) }}">
@stop

@section('js')
<script src="{{ asset( cacheBusting('js/common.js') ) }}"></script>
<script src="{{ asset( cacheBusting('js/admin/blog.js') ) }}"></script>
<script>


$('#datatable1').DataTable({
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Japanese.json",
    },
    "stateSave": true,
    "paging": true,
    "lengthChange": false,
    "searching": true,
    "ordering": true,
    "order": [ [ 2, "desc" ] ],
    "info": true,
    "autoWidth": false,
    "responsive": true,
    "columnDefs": [
        { responsivePriority: 1, targets: 4 },
        { responsivePriority: 2, targets: -1 },
        { responsivePriority: 3, targets: 2 },
    ],
});
</script>
@stop
