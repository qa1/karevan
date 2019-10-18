@extends('adminlte::page')

@section('title', 'زائرین')

@section('content_header')
    <h1>زائرین</h1>
@stop

@section('content')
<div class="row">
    <div class="col-sm-6 col-md-3">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{App\Models\Person::count()}}</sup></h3>
                <p>کل افراد</p>
            </div>
            <div class="icon">
                <i class="fa fa-users" style="font-size: 83px;"></i>
            </div>
            <a href="{{route('persons.index', ['filter' => 'all'])}}" class="small-box-footer">
                مشاهده <i class="fa fa-arrow-circle-left"></i>
            </a>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{App\Models\Person::whereStatus('مراجعه نشده')->count()}}</sup></h3>
                <p>مراجعه نشده</p>
            </div>
            <div class="icon">
                <i class="fa fa-exclamation-triangle" style="font-size: 83px;"></i>
            </div>
            <a href="{{route('persons.index', ['filter' => 'مراجعه نشده'])}}" class="small-box-footer">
                مشاهده <i class="fa fa-arrow-circle-left"></i>
            </a>
        </div>
    </div>
	<div class="col-sm-6 col-md-3">
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{App\Models\Person::where('status', 'داخل')->count()}}</sup></h3>
                <p>افراد داخل</p>
            </div>
            <div class="icon">
                <i class="fa fa-sign-in"></i>
            </div>
            <a href="{{route('persons.index', ['filter' => 'داخل'])}}" class="small-box-footer">
              مشاهده <i class="fa fa-arrow-circle-left"></i>
            </a>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{App\Models\Person::where('status', 'خارج')->count()}}</sup></h3>
                <p>افراد خارج</p>
            </div>
            <div class="icon">
                <i class="fa fa-sign-out"></i>
            </div>
            <a href="{{route('persons.index', ['filter' => 'خارج'])}}" class="small-box-footer">
              مشاهده <i class="fa fa-arrow-circle-left"></i>
            </a>
        </div>
    </div>
</div>

<div class="row">
	{!! Form::open(['method' => 'get']) !!}
    <div class="col-xs-12 col-md-3">
        {!! Form::select('city', ['all' => 'همه شهرها'] + \App\Models\City::get()->pluck('name', 'id')->toArray(), request('city'), ['class' => 'form-control']) !!}
    </div>
    <div class="col-xs-12 col-md-3">
        <div class="form-group">
            {!! Form::select('modirkarevan', ['all' => 'همه مدیران کاروان ها'] + \App\Models\Modirkarevan::get()->pluck('name', 'id')->toArray(), request('modirkarevan'), ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-xs-12 col-md-2">
        <div class="form-group">
            <input type="hidden" name="filter" value="{{request('filter')}}">
            <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i></button>
        </div>
    </div>
    {!! Form::close() !!}
    @if(\RBAC::hasAnyPerm('خروجی زائرین'))
    <div class="col-xs-4 text-left">
        <div class="dropdown" style="display: inline-block;">
            <button class="btn btn-primary" type="button" data-toggle="dropdown">
                دریافت خروجی <i class="fa fa-download"></i>
            </button>
            <ul class="dropdown-menu" style="right: auto; left: 0">
                <li><a href="{{route('export.person', ['type' => 'csv'])}}">CSV</a></li>
                <li><a href="{{route('export.person', ['type' => 'xls'])}}">XLS</a></li>
                <li><a href="{{route('export.person', ['type' => 'xlsx'])}}">XLSX</a></li>
                <li><a href="{{route('export.person', ['type' => 'html'])}}">HTML</a></li>
                <li><a href="{{route('export.person', ['type' => 'txt'])}}">TXT</a></li>
            </ul>
        </div>
    </div>
    @endif
</div>

<div class="box">
    <div class="table-responsive">
    	<table class="table table-bordered table-striped table-hover" id="datatable">
            <thead>
                <tr>
                    {{-- <th>#</th> --}}
                    <th width="30"></th>
                    <th>تصویر</th>
                    <th>نام و نام خانوادگی</th>
                    <th>شماره تردد</th>
                    <th>کد ملی</th>
                    <th>شهر</th>
                    <th>مدیر کاروان</th>
                    <th>وضعیت</th>
                    <th>عضویت</th>
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
	pageLength  : 25,
	searching   : true,
	ordering    : false,
	autoWidth   : false,
    ajax	    : "{!! route('persons.index.datatable', request()->all()) !!}",
    language    : {
        "url": "/libs/datatables-fa.json"
    },
    columns: [
        // { data: 'id', name: 'id' },
        { data: 'action', name: 'action', 'searchable': false, 'orderable': false },
        { data: 'avatar', name: 'avatar', 'searchable': false, 'orderable': false },
        { data: 'name', name: 'name' },
        { data: 'code', name: 'code' },
        { data: 'melli', name: 'melli' },
        { data: 'city.name', name: 'city.name' },
        { data: 'modirkarevan.name', name: 'modirkarevan.name' },
        { data: 'status', name: 'status', 'searchable': false },
        { data: 'created_at', name: 'created_at' },
    ]
});

// Add event listener for opening and closing details
$('#datatable tbody').on('click', '.details-control', detailsRow);

function detailsRow() {
    var tr = $(this).closest('tr');
    var row = table.row( tr );
    var id  = $(this).data('id');

    if ( row.child.isShown() ) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
    }
    else {
        // Add User Info ROW
        userInfo(id, function(data){
            row.child(data).show();
            tr.addClass('shown');
        });
    }
}

function userInfo(id, callback) {
    $.ajax({
        type: 'get',
        url: "{{route('persons.info')}}",
        data: {id: id},
        success: callback
    });
}
</script>
@endpush
