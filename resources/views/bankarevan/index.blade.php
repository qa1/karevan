@extends('adminlte::page')

@section('title', 'مسدود/رفع مسدودیت کاروان')

@section('content_header')
    <h1>مسدود/رفع مسدودیت کاروان</h1>
@stop

@section('content')
<page-bankarevan inline-template type="{{old('type')}}">
{!! Form::open(['class' => 'form-horizontal']) !!}
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="box box-primary">
            <div class="box-body">
                <div class="form-group {{$errors->first('modirkarevan', 'has-error')}}">
                    <label class="control-label col-md-3" for="modirkarevan">کاروان</label>
                    <div class="col-md-9">
                        {!! Form::select('modirkarevan', ['' => ''] + \App\Models\Modirkarevan::get()->pluck('name', 'id')->toArray(), request('modirkarevan'), ['class' => 'form-control', 'v-focus']) !!}
                        {!! $errors->first('modirkarevan', '<div class="help-block">:message</div>') !!}
                    </div>
                </div>
                <div class="form-group {{$errors->first('type', 'has-error')}}">
                    <label class="control-label col-md-3" for="type">عملیات</label>
                    <div class="col-md-9">
                        {!! Form::select('type', ['' => ''] + dropdownArray(['مسدود کردن', 'رفع مسدودی']), null, ['class' => 'form-control', 'v-model' => 'type']) !!}
                        {!! $errors->first('type', '<div class="help-block">:message</div>') !!}
                    </div>
                </div>
                <div class="form-group {{$errors->first('message', 'has-error')}}" v-if="type == 'مسدود کردن'" v-cloak>
                    <label class="control-label col-md-3" for="message">دلیل مسدودیت</label>
                    <div class="col-md-9">
                        {!! Form::textarea('message', null, ['class' => 'form-control']) !!}
                        {!! $errors->first('message', '<div class="help-block">:message</div>') !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-md-offset-2">
            <button class="btn btn-primary btn-block" type="submit">ثبت</button>
        </div>
    </div>
</div>
{!! Form::close() !!}
</page-bankarevan>
@stop