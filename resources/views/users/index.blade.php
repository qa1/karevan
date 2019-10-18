@extends('adminlte::page')

@section('title', 'مدیریت کاربران')

@section('content_header')
    <h1>مدیریت کاربران</h1>
@stop

@section('content')

<div class="box">
	<div class="box-body">
		<table class="table table-bordered table-striped table-hover" id="datatable">
            <thead>
                <tr>
                    <th width="20">#</th>
                    <th>نام و نام خانوادگی</th>
                    <th>نام کاربری</th>
                    <th width="40"></th>
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
	// ordering    : false,
	info        : true,
	autoWidth   : false,
    ajax	    : "{!! route('users.index.data', request()->all()) !!}",
    language    : {
        "url": "/libs/datatables-fa.json"
    },
    columns     : [
        { data: 'id', name: 'id' },
        { data: 'name', name: 'name' },
        { data: 'username', name: 'username' },
        { data: 'action', name: 'action', 'searchable': false, orderable: false },
    ]
});
</script>
@endpush
