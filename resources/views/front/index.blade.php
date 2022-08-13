@extends('adminlte::page')

@section('title', 'ブログトップページ')

@section('content_header')
    <h1>ブログトップページ</h1>
@stop

@section('content')

<div class="container-fluid">
    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3>ブログ最新5件</h3>
                </div>
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
                </div>
                <div class="card-footer">
                    <a href="{{ route('front.blog.index') }}">記事一覧へ</a>
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
