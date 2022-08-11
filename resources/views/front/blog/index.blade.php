@extends('front.layout.common')

@section('title', 'インデックスページ')
@section('keywords', 'キーワード1,キーワード2,キーワード3')
@section('description', 'インデックスページの説明文です')
@section('pageCss')
{{-- <link href="/css/star/index.css" rel="stylesheet"> --}}
@endsection

@include('front.layout.header')

@section('content')
<ul>
                        @foreach($blogs as $blog)
                            <li>
                                <a href="{{route('front.blog.view',['id' => $blog->id])}}" >
                                {{ $blog->day !== null ? $blog->day->format('Y/m/d') : '' }}
                                {{ config('const.BLOG_CATEGORY.' . $blog->category) }}
                                {{ $blog->title }}
                                </a>
                            </li>
                        @endforeach
</ul>
@endsection

@include('front.layout.submenu')

@include('front.layout.footer')

