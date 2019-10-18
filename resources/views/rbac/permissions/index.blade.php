@extends('adminlte::page')

@section('title', 'مدیریت مجوز ها')

@section('content_header')
    <h1>مدیریت مجوز ها</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<table class="table table-bordered table-striped table-hover" id="datatable">
			<thead>
				<tr>
					<th width="50">#</th>
					<th>نام</th>
					<th>تاریخ ایجاد</th>
					<th width="50"></th>
				</tr>
			</thead>
		</table>
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
	ordering    : false,
	info        : true,
	autoWidth   : false,
    ajax	    : "{!! route('rbac.permissions.datatable', request()->all()) !!}",
    language    : {
        "url": "/libs/datatables-fa.json"
    },
    columns: [
        { data: 'id', name: 'id' },
        { data: 'name', name: 'name' },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', searchable: false, orderable: false },
    ],
    order: [[0, 'desc']]
});
</script>
@endpush