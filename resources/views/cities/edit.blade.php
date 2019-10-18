@extends('adminlte::page')

@section('title', 'ویرایش شهر')

@section('content_header')
    <h1>ویرایش شهر</h1>
@stop

@section('content')
{!! Form::model($city) !!}
<div class="col-md-6 col-md-offset-3">
    <div class="box box-primary">
        <div class="box-body">
            <div class="form-group {{$errors->first('name', 'has-error')}}">
                <label>نام شهر</label>
                {!! Form::text('name', null, ['class' => 'form-control', 'v-focus']) !!}
                {!! $errors->first('name', '<div class="help-block">:message</div>') !!}
            </div>
        </div>
    </div>
    
    <div class="col-md-10 col-md-offset-1">
        <button class="btn btn-primary btn-block" type="submit">ویرایش شهر</button>
    </div>
</div>
{!! Form::close() !!}
@stop