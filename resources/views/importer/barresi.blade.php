@extends('adminlte::page')

@section('title', 'ورود اطلاعات - بررسی')

@section('content_header')
    <h1>ورود اطلاعات - بررسی</h1>
@stop

@section('content')
<div class="callout callout-info">
    <h4>نتیجه بررسی</h4>
    <p>
        سطرهایی که به عنوان نامعتبر شناخته شده اند در پایگاه داده درج نخواهند شد
    </p>
    <p>
        <strong>تعداد سطر های معتبر: {{$Valid->count()}}</strong>
    </p>
</div>

{{-- <div class="box box-success">

    <div class="box-header with-border">
        <div class="box-title">سطرهای معتبر</div>
    </div>

    <div class="box-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>نام و نام خانوادگی</th>
                    <th>نام پدر</th>
                    <th>کد تردد</th>
                    <th>کد ملی</th>
                    <th>شهر</th>
                    <th>کاروان</th>
                </tr>
            </thead>
            <tbody>
                @forelse($Valid as $Row)
                <tr>
                    <td>{{isset($Row['name']) ? $Row['name'] : '---'}}</td>
                    <td>{{isset($Row['father']) ? $Row['father'] : '---'}}</td>
                    <td>{{isset($Row['city']) ? $Row['city'] : '---'}}</td>
                    <td>{{isset($Row['modir']) ? $Row['modir'] : '---'}}</td>
                    <td>{{isset($Row['code']) ? $Row['code'] : '---'}}</td>
                    <td>{{isset($Row['melli']) ? $Row['melli'] : '---'}}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="100">هیچ سطر معتبری پیدا نشد</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div> --}}

<div class="box box-danger">

    <div class="box-header with-border">
        <div class="box-title">سطرهای نامعتبر</div>
    </div>

    <div class="box-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>نام و نام خانوادگی</th>
                    <th>نام پدر</th>
                    <th>شهر</th>
                    <th>مدیر کاروان</th>
                    <th>کد تردد</th>
                    <th>کد ملی</th>
                    <th>دلیل</th>
                </tr>
            </thead>
            <tbody>
                @forelse($Invalid as $Row)
                <tr>
                    <td>{{isset($Row['name']) ? $Row['name'] : '---'}}</td>
                    <td>{{isset($Row['father']) ? $Row['father'] : '---'}}</td>
                    <td>{{isset($Row['city']) ? $Row['city'] : '---'}}</td>
                    <td>{{isset($Row['modir']) ? $Row['modir'] : '---'}}</td>
                    <td>{{isset($Row['code']) ? $Row['code'] : '---'}}</td>
                    <td>{{isset($Row['melli']) ? $Row['melli'] : '---'}}</td>
                    <td>
                        <span class="label label-danger">{{$Row['dalil']}}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="100">
                        <div class="alert alert-success" style="margin-bottom: 0">
                            هیچ سطر نامعتبری پیدا نشد
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<div class="col-md-8 col-md-offset-2">
    {!! Form::open(['route' => 'importer.import']) !!}
    <button class="btn btn-primary btn-block btn-lg" type="submit">
        <i class="fa fa-database"></i>
        درج در پایگاه داده
    </button>
    {!! Form::close() !!}
</div>
@stop