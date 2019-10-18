@extends('adminlte::page')

@section('title', 'گزارشات خطاها')

@section('content_header')
    <h1>گزارشات خطاها</h1>
@stop

@push('head')
@include('components.charts')
@endpush

@section('content')
<div class="row">
	<div class="col-md-6 col-md-offset-3">
	    <div class="box">
	        <div class="box-body" style="min-height: 400px">
	            {!! $chart->render() !!}
	        </div>
	    </div>
	</div>

	<div class="col-xs-12">
	    <div class="box">
	        <div class="box-body">
	            <table class="table table-bordered table-striped table-hover" id="datatable">
	                <thead>
	                    <tr>
	                        <th>#</th>
	                        <th>نوع</th>
	                        <th>زائر</th>
	                        <th>مدیر کاروان</th>
	                        <th>تاریخ و زمان</th>
	                    </tr>
	                </thead>
	            </table>
	        </div>
	    </div>
	</div>
</div>
@stop

@push("js")
<script>
var table = $('#datatable').DataTable({
    processing  : true,
    serverSide  : true,
	paging      : true,
	lengthChange: true,
	pageLength  : 50,
	searching   : true,
	// ordering    : false,
	info        : true,
	autoWidth   : false,
    ajax	    : "{!! route('report.error.data', request()->all()) !!}",
    language    : {
        "url": "/libs/datatables-fa.json"
    },
    columns: [
        { data: 'id', name: 'id' },
        { data: 'message', name: 'message' },
        { data: 'person.name', name: 'person.name', 'searchable': true },
        { data: 'person.modirkarevan.name', name: 'person.modirkarevan.name' },
        { data: 'created_at', name: 'created_at', 'searchable': false }
    ],
    order: [[0, 'desc']]
});
</script>
@endpush
