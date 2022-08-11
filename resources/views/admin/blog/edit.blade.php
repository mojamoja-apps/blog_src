@extends('adminlte::page')

@section('title', 'ブログ編集')

@section('content_header')
    <h1>ブログ編集</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-primary">

                @if ($mode == config('const.editmode.create'))
                {{Form::open(['method'=>'post', 'id'=>'edit_form', 'route' => 'admin.blog.update'])}}
                @else
                {{Form::open(['method'=>'post', 'id'=>'edit_form', 'route' => ['admin.blog.update', $blog->id] ])}}
                @endif
                    <input type="hidden" name="mode" id="mode" value="{{ $mode }}">



                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">日付</label>
                            <div class="input-group">
                                <div class="form-inline">
                                    <input type="text" class="form-control" name="day" id="day"
                                    placeholder="2022/12/31"
                                    autocomplete="off"
                                    value="{{ old('day', ($blog->day != null ? $blog->day->format('Y/m/d') : '') ) }}"
                                    style="width:150px;"
                                    >
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-info btn-flat day_today_btn" >今日</button>
                                    </span>
                                </div>
                            </div>
                            @if ($errors->has('day'))
                            <code>{{ $errors->first('day') }}</code>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="belongs">カテゴリー</label>
                            <div class="form-inline">
                                @foreach (config('const.BLOG_CATEGORY') as $key => $item)
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" name="category" id="category_{{$key}}" value="{{$key}}"
                                    @if ((int)old('category') == $key) checked
                                    @elseif ($blog->category == $key) checked
                                    @elseif ($key == 1 && $blog->category == null) checked
                                    @endif
                                    >
                                    <label for="category_{{$key}}" class="custom-control-label">{{$item}}　</label>
                                </div>
                                @endforeach
                            </div>
                            @if ($errors->has('category'))
                            <code>{{ $errors->first('category') }}</code>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="title">タイトル</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="オススメのラーメン屋を発見！" value="{{ old('title', $blog->title) }}">
                            @if ($errors->has('title'))
                            <code>{{ $errors->first('title') }}</code>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="body">本文</label>
                            <textarea name="body" id="body" placeholder="" rows="8">{{ old('body', $blog->body) }}</textarea>
                            @if ($errors->has('body'))
                            <code>{{ $errors->first('body') }}</code>
                            @endif
                        </div>
                    </div>

<input type="hidden" name="dir" id="dir" value="{{ $blog->dir }}">

                    <div class="card-footer">
                        <button type="submit" id="commit_btn" class="btn btn-primary">登録</button>
                        <button type="button" id="" class="btn btn-default back_btn float-right" onclick="location.href='{{ route('admin.blog.index') }}'">戻る</button>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>





@stop

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css">
<link rel="stylesheet" href="{{ asset( cacheBusting('css/common.css') ) }}">
@stop

@section('js')
<script src="{{ asset( cacheBusting('js/common.js') ) }}"></script>
<script src="{{ asset( cacheBusting('js/admin/blog.js') ) }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
@stop
