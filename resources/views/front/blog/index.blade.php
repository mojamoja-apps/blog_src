@extends('adminlte::page')

@section('title', 'ブログ記事一覧')

@section('content_header')
    <h1>ブログ記事一覧</h1>
@stop

@section('content')

<div class="container-fluid">
    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <ul>
                        @foreach($blogs as $blog)
                            <li>
                                <a href="{{route('front.blog.view',['id' => $blog->id])}}" >
                                {{ $blog->day !== null ? $blog->day->format('Y/m/d') : '' }}
                                {{ config('const.BLOG_CATEGORY.' . $blog->category) }}
                                {{ $blog->title }}
                                </a>
                                @if ($blog->image)
                                <img src="{{ $blog->image }}" width="100">
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    {!! $blogs->onEachSide(1)->links() !!}

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
<script src="{{ asset( cacheBusting('js/report/report.js') ) }}"></script>

@stop
