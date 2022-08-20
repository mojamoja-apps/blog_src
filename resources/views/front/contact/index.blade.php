@extends('adminlte::page')

@section('title', 'お問い合わせフォーム')

@section('content_header')
    <h1>お問い合わせフォーム</h1>
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
                {{Form::open(['method'=>'post', 'id'=>'edit_form', 'route' => 'front.contact.confirm'])}}
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">お名前 <code>*必須</code></label>
                            <input type="text" class="form-control" name="name" id="name" placeholder=""
                            value="{{ old('name', $input['name'] ?? '') }}"
                            maxlength="50"
                            required
                            >
                            @if ($errors->has('name'))
                            <code>{{ $errors->first('name') }}</code>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="mail">メールアドレス <code>*必須</code></label>
                            <input type="email" class="form-control" name="mail" id="mail" placeholder=""
                            value="{{ old('mail', $input['mail'] ?? '') }}"
                            maxlength="50"
                            required
                            >
                            @if ($errors->has('mail'))
                            <code>{{ $errors->first('mail') }}</code>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="body">お問い合わせ内容 <code>*必須</code></label>
                            <textarea name="body" id="body" class="form-control" placeholder=""
                            rows="8"
                            maxlength="5000"
                            required
                            >{{ old('body', $input['body'] ?? '') }}</textarea>
                            @if ($errors->has('body'))
                            <code>{{ $errors->first('body') }}</code>
                            @endif
                        </div>


                    </div>
                    <div class="card-footer">
                        <button type="submit" id="commit_btn" class="btn btn-primary">送信確認</button>
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


@stop
