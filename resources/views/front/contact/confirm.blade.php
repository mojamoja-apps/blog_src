@extends('adminlte::page')

@section('title', '確認画面 - お問い合わせフォーム')

@section('content_header')
    <h1>確認画面 - お問い合わせフォーム</h1>
@stop

@section('content')

<div class="container-fluid">
    <div class="row">

        <div class="col-12">


 @if (session('message'))
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="">{{ session('message') }}</label>
                    </div>
                </div>
            </div>
@endif


            <div class="card">
                {{Form::open(['method'=>'post', 'id'=>'contact_form', 'route' => 'front.contact.send'])}}
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">お名前</label>
                            <p>{{ $input['name'] }}</p>
                            <input type="hidden" name="name"
                            value="{{ $input['name'] }}"
                            >
                        </div>

                        <div class="form-group">
                            <label for="mail">メールアドレス</label>
                            <p>{{ $input['mail'] }}</p>
                            <input type="hidden" name="mail"
                            value="{{ $input['mail'] }}"
                            >
                        </div>

                        <div class="form-group">
                            <label for="body">お問い合わせ内容</label>
                            <p>{!! nl2br(e($input['body'])) !!}</p>
                            <input type="hidden" name="body"
                            value="{{ $input['body'] }}"
                            >
                        </div>


                    </div>
                    <div class="card-footer">
                        <button type="button" id="back_btn" name="back_btn" class="btn btn-default mr-5"
                        onclick="formBack('{{ route('front.contact.index') }}');"
                        >戻る</button>
                        <button type="submit" id="commit_btn" name="commit_btn" class="btn btn-primary">送信</button>
                    </div>
                {{ Form::close() }}
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
<script src="{{ asset( cacheBusting('js/front/contact.js') ) }}"></script>
@stop
