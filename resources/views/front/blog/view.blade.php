@extends('adminlte::page')

@section('title', $blog->title . ' - ブログ詳細ページ')

@section('content_header')
    <h1>{{ $blog->title }} - ブログ詳細ページ</h1>
@stop

@section('content')

<div class="container-fluid">
    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p>{!! $blog->body !!}</p>
                </div>
                <div class="card-footer">
                    @if ($prev !== null)
                    <span>
                        <a href="{{ route('front.blog.view',['id' => $prev->id]) }}">
                            ＜＜ {{ $prev->title }}
                        </a>
                    </span>
                    @endif

                    @if ($next !== null)
                    <span class="float-right">
                        <a href="{{ route('front.blog.view',['id' => $next->id]) }}">
                            {{ $next->title }} ＞＞
                        </a>
                    </span>
                    @endif
                </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">カテゴリ一覧</h3>
                </div>
                <div class="card-body">
                    <ul>
                        @foreach(config('const.BLOG_CATEGORY') as $cate_key => $category)
                            <li>
                                <a href="{{route('front.blog.category_index',['category_id' => $cate_key])}}" >
                                {{ $category }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


@stop

@section('css')
<link rel="stylesheet" href="{{ asset( cacheBusting('css/common.css') ) }}">
@stop

@section('js')
<script src="{{ asset( cacheBusting('js/common.js') ) }}"></script>


@stop
