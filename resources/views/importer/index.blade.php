@extends('adminlte::page')

@section('title', 'ورود اطلاعات')

@section('content_header')
    <h1>ورود اطلاعات</h1>
@stop

@section('content')
{!! Form::open(['files' => 'true', 'route' => 'importer.barresi']) !!}
<div class="row">
    <div class="col-md-6">
        <div class="callout callout-success">
            <h4>نام ستون ها</h4>
            <p>name, father, code, melli, city, modir</p>
            <p><strong>تمامی ستون ها به جز کد ملی ( melli ) و کد تردد ( code ) اجباریست</strong></p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="callout callout-warning">
            <h4>فایل نمونه</h4>
            <p><a href="{{url('files/import.xlsx')}}"><strong>جهت دریافت اینجا کلیک کنید</strong></a></p>
            <br>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="form-group {{$errors->first('file', 'has-error')}}">
                    <label>انتخاب فایل</label>
                    {!! Form::file('file', ['class' => 'form-control', 'v-focus']) !!}
                    <i class="label label-default">فرمت های قابل پذیرش: csv, xlsx</i>
                    {!! $errors->first('file', '<div class="help-block">:message</div>') !!}
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>
                            <input name="vorood" type="checkbox" value="1" />
                            ثبت ورود پس از ورود اطلاعات
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>
                            <input name="reset" type="checkbox" value="1" />
                            <strong class="text-danger">حذف اطلاعات فعلی</strong> زائرین و درج اطلاعات جدید
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-md-offset-2">
            <button class="btn btn-primary btn-block" type="submit">بررسی فایل</button>
        </div>
    </div>
</div>
{!! Form::close() !!}
@stop