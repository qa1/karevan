@extends('adminlte::page')

@section('title', 'ویرایش کاربر')

@section('content_header')
    <h1>ویرایش کاربر</h1>
@stop

@section('content')

{!! Form::model($user) !!}
<div class="box">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
            	<div class="form-group {{$errors->first('name', 'has-error')}}">
					{!! Form::label('name', 'نام و نام خانوادگی', ['class' => 'control-label']) !!}
					{!! Form::text('name', null, ['class' => 'form-control', 'autofocus']) !!}
					{!!$errors->first('name', '<span class="help-block">:message</span>')!!}
				</div>
            </div>
            <div class="col-md-6">
                <div class="form-group {{$errors->first('username', 'has-error')}}">
					{!! Form::label('username', 'نام کاربری', ['class' => 'control-label']) !!}
					{!! Form::text('username', null, ['class' => 'form-control']) !!}
					{!!$errors->first('username', '<span class="help-block">:message</span>')!!}
				</div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
            	<div class="form-group {{$errors->first('password', 'has-error')}}">
					{!! Form::label('password', 'رمزعبور', ['class' => 'control-label']) !!}
					{!! Form::password('password', ['class' => 'form-control']) !!}
					{!!$errors->first('password', '<span class="help-block">:message</span>')!!}
				</div>
            </div>
            <div class="col-md-6">
            	<div class="form-group {{$errors->first('password_confirmation', 'has-error')}}">
					{!! Form::label('password_confirmation', 'تکرار رمزعبور', ['class' => 'control-label']) !!}
					{!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
					{!!$errors->first('password_confirmation', '<span class="help-block">:message</span>')!!}
				</div>
            </div>
        </div>
    </div>
</div>

<div class="box">
    <div class="box-body">
        @foreach(\Spatie\Permission\Models\Permission::get() as $item)
            <label class="btn btn-default" style="margin-bottom: 5px;">
                <input type="checkbox" name="permission[]" value="{{$item->id}}" @if(RBAC::hasAnyPerm($item->name, $user)) checked="" @endif>
                {{$item->name}}
            </label>
        @endforeach
        {!!$errors->first('permission', '<span class="help-block">:message</span>')!!}
    </div>
</div>

<div class="col-md-6 col-md-offset-3">
	<button class="btn btn-block btn-primary" type="submit">ثبت اطلاعات</button>
</div>
{!! Form::close() !!}
@stop