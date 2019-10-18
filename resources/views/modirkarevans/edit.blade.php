@extends('adminlte::page')

@section('title', 'ثبت نام مدیر کاروان')

@section('content_header')
    <h1>ثبت نام مدیر کاروان</h1>
@stop

@section('content')
{!! Form::model($modirkarevan) !!}
<div class="col-md-6 col-md-offset-3">
    <div class="box box-primary">
        <div class="box-body">
            <div class="form-group {{$errors->first('name', 'has-error')}}">
                <label>نام مدیر کاروان</label>
                {!! Form::text('name', null, ['class' => 'form-control', 'v-focus']) !!}
                {!! $errors->first('name', '<div class="help-block">:message</div>') !!}
            </div>
        </div>
    </div>

    <div class="col-md-10 col-md-offset-1">
        <button class="btn btn-primary btn-block" type="submit">ویرایش نام مدیر کاروان</button>
    </div>
</div>
{!! Form::close() !!}
@stop