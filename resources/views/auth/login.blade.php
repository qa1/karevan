@extends('adminlte::master')

@section('body_class', 'login-page')

@section('body')
    <div class="login-box">
        <div class="login-logo">
            {!! config('adminlte.logo') !!}
        </div>

        <div class="login-box-body">
            <p class="login-box-msg">برای شروع بکار لطفا ابتدا وارد شوید</p>
            <form action="{{ url(config('adminlte.login_url', 'login')) }}" method="post">
                {!! csrf_field() !!}

                <div class="form-group has-feedback {{ $errors->has('username') ? 'has-error' : '' }}">
                    <input type="text" name="username" class="form-control" value="{{ old('username') }}" placeholder="نام کاربری" autofocus="">
                    <span class="fa fa-user form-control-feedback"></span>
                    {!! $errors->first('username', '<span class="help-block"><strong>:message</strong></span>') !!}
                </div>
                <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                    <input type="password" name="password" class="form-control" placeholder="رمزعبور">
                    <span class="fa fa-lock form-control-feedback"></span>
                    {!! $errors->first('password', '<span class="help-block"><strong>:message</strong></span>') !!}
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">ورود به سیستم</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop