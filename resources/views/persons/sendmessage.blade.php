@extends('adminlte::page')

@section('title', 'ثبت پیام برای زائر')

@section('content_header')
    <h1>ثبت پیام برای زائر</h1>
@stop

@section('content')
{!! Form::open(['files' => true]) !!}

@if($person->messages->count())
<h4>پیام های پیشین زائر ({{$person->messages->count()}}):</h4>
<ul class="list-group">
    @foreach($person->messages as $message)
    <li class="list-group-item {{$message->status == 'خوانده شده' ? 'list-group-item-success' : ''}}">
        {{$message->message}}
        <p style="padding-top: 5px;">
            <span class="label label-primary">{{$message->created_at->diffForHumans()}}</span>
            <span class="label label-{{$message->status == 'خوانده شده' ? 'success' : 'default'}}">{{$message->status}}</span>
        </p>
    </li>
    @endforeach
</ul>
@endif

<div class="box box-primary">
    <div class="box-body">
        <div class="form-group">
            <label>نام و نام خانوادگی زائر</label>
            <input class="form-control" disabled="" type="text" value="{{$person->name}}" />
        </div>

        <div class="form-group">
            <label for="person_code">تصویر</label>
            <div class="controls">
                <a href="{{$person->imageUrl()}}" target="_blank"><img src="{{$person->imageThumb()}}" class="img img-thumbnail"></a>
            </div>
        </div>

        <div class="row">
            <hr>
        </div>

		<div class="form-group {{$errors->first('message', 'has-error')}}">
	        {!! Form::textarea('message', null, ['class' => 'form-control', 'autofocus', 'placeholder' => 'متن پیام...']) !!}
	        {!!$errors->first('message', '<span class="help-block">:message</span>')!!}
        </div>
    </div>
</div>

<div class="col-md-6 col-md-offset-3">
	<button class="btn btn-primary btn-block" type="submit">ارسال پیام</button>
</div>
{!! Form::close() !!}
@stop