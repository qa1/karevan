@extends('adminlte::page')

@section('title', 'گزارشات تردد')

@section('content_header')
    <h1>گزارشات تردد</h1>
@stop

@push('head')
@include('components.charts')
@endpush

@section('content')
<div class="box">
    <div class="box-body text-center" dir="ltr">
        <div class="col-xs-12" style="height: 500px;">
            {!! $chart->render() !!}
        </div>
    </div>
</div>
@stop