@extends('adminlte::page')

@section('title', 'مدیریت مدیران کاروان ها')

@section('content_header')
    <h1>مدیریت مدیران کاروان ها</h1>
@stop

@section('content')
<div class="box">
    <div class="box-body">
        <table class="table table-bordered table-striped table-hover" id="datatable">
            <thead>
                <tr>
                    <th width="30"></th>
                    <th width="50">#</th>
                    <th>نام کاروان</th>
                    <th>تاریخ ایجاد</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@stop

@push("scripts")
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
    ajax        : "{!! route('modirkarevans.index.data', request()->all()) !!}",
    language    : {
        "url": "/libs/datatables-fa.json"
    },
    columns: [
        { data: 'action', name: 'action', 'searchable': false, 'orderable': false },
        { data: 'id', name: 'id' },
        { data: 'name', name: 'name' },
        { data: 'created_at', name: 'created_at' },
    ],
    order: [[1, 'desc']]
});
</script>
@endpush
