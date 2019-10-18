@extends('adminlte::page')

@section('title', 'پیام ها')

@section('content_header')
    <h1>پیام ها</h1>
@stop

@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{App\Models\Message::where('status', 'خوانده شده')->count()}}</sup></h3>
                <p>خوانده شده</p>
            </div>
            <div class="icon">
                <i class="fa fa-envelope-open-o"></i>
            </div>
            <a href="{{route('messages.index', ['filter' => 'خوانده شده'])}}" class="small-box-footer">
              مشاهده <i class="fa fa-arrow-circle-left"></i>
            </a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="small-box bg-blue">
            <div class="inner">
                <h3>{{App\Models\Message::where('status', 'خوانده نشده')->count()}}</sup></h3>
                <p>خوانده نشده</p>
            </div>
            <div class="icon">
                <i class="fa fa-envelope-o"></i>
            </div>
            <a href="{{route('messages.index', ['filter' => 'خوانده نشده'])}}" class="small-box-footer">
              مشاهده <i class="fa fa-arrow-circle-left"></i>
            </a>
        </div>
    </div>
</div>

<div class="box">
    <div class="table-responsive">
    	<table class="table table-bordered table-striped table-hover" id="datatable">
            <thead>
                <tr>
                    <th width="30"></th>
                    <th width="50">#</th>
                    <th>نام زائر</th>
                    <th>پیام</th>
                    <th width="100">وضعیت</th>
                    <th width="100">زمان ارسال</th>
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
	// searching   : true,
	// ordering    : false,
	info        : true,
	autoWidth   : false,
    ajax	    : "{!! route('messages.index.data', request()->all()) !!}",
    language    : {
        "url": "/libs/datatables-fa.json"
    },
    columns: [
        { data: 'action', name: 'action', 'searchable': false, 'orderable': false },
        { data: 'id', name: 'messages.id' },
        { data: 'person.name', name: 'person.name', orderable: false },
        { data: 'message', name: 'message', orderable: false },
        { data: 'status', name: '', searchable: false },
        { data: 'created_at', name: '', searchable: false },
    ],
    order: [[1, 'desc']]
});

// Add event listener for opening and closing details
$('#datatable tbody').on('click', '.details-control', function () {
    var tr = $(this).closest('tr');
    var row = table.row( tr );
    var id  = $(this).data('id');

    if ( row.child.isShown() ) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
    }
    else {
        // Add Message Info ROW
        messageInfo(id, function(data){
            row.child(data).show();
            tr.addClass('shown');
        });
    }
});

function messageInfo(id, callback) {
    $.ajax({
        type: 'get',
        url: "{{route('messages.info')}}",
        data: {id: id},
        success: callback
    });
}
</script>
@endpush
