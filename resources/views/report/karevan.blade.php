@extends('adminlte::page')

@section('title', 'گزارشات کاروان ها')

@section('content_header')
    <h1>گزارشات کاروان ها</h1>
@stop

@push('head')
@include('components.charts')
@endpush

@section('content')
<div class="col-md-4 col-md-offset-4">
	<div class="form-group">
		{!! Form::open(['method' => 'get']) !!}
		{!! Form::select('date', trafficsDates(), $date, ['class' => 'form-control', 'onchange' => '$(this).parent().submit()']) !!}
		{!! Form::close() !!}
	</div>
</div>
<div class="clearfix"></div>
<div class="callout callout-info"><i class="fa fa-exclamation-triangle"></i> آمار کل و مراجعه نشده کاروان ها نشان دهنده آمار فعلیست و اختصاص به روز انتخاب شده ندارد</div>
<div class="box">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>کاروان</th>
                <th>کل</th>
                <th>مراجعه نشده</th>
                <th>داخل</th>
                <th>خارج</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($karevans as $karevan)
            <tr>
                <td>{{$karevan}}</td>
                <td>{{$data['all'][$loop->index]}}</td>
                <td>{{$data['none'][$loop->index]}}</td>
                <td>{{$data['in'][$loop->index]}}</td>
                <td>{{$data['out'][$loop->index]}}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="info">
                <td></td>
                <td>{{collect($data['all'])->sum()}}</td>
                <td>{{collect($data['none'])->sum()}}</td>
                <td>{{collect($data['in'])->sum()}}</td>
                <td>{{collect($data['out'])->sum()}}</td>
            </tr>
        </tfoot>
    </table>
</div>
<div class="clearfix"></div>
<div class="box">
    <div class="box-body text-center" dir="ltr">
        <div class="col-xs-12" style="height: 500px;">
            {!! $chart->render() !!}
        </div>
    </div>
</div>
@stop