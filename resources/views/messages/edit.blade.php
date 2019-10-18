@extends('adminlte::page')

@section('title', 'ثبت پیام برای زائر')

@section('content_header')
    <h1>ثبت پیام برای زائر</h1>
@stop

@section('content')
{!! Form::model($message) !!}
<div class="box box-primary">
    <div class="box-body">
        <div class="form-group">
            <label>نام و نام خانوادگی زائر</label>
            <input class="form-control" disabled="" type="text" value="{{$message->person->name}}" />
        </div>

        <div class="form-group">
            <label for="person_code">تصویر</label>
            <div class="controls">
                <a href="{{$message->person->imageUrl()}}" target="_blank"><img src="{{$message->person->imageThumb()}}" class="img img-thumbnail"></a>
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
    <button class="btn btn-primary btn-block" type="submit">ویرایش پیام</button>
</div>
{!! Form::close() !!}
@stop