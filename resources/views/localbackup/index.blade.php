@extends('layouts.panel')
@section('title', 'لوکال بک آپ')

@push('breadcrumb')
<li><a href="{{route('localbackup')}}">لوکال بک آپ</a></li>
<li class="active">تهیه بک آپ</li>
@endpush

@push('content')

<div class="col-md-12">

    @include('components.alert-both')

    <form action="" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
        <div class="box box-primary">

            <div class="box-body">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label class="btn btn-default">
                            <input type="checkbox" name="db">
                            دیتابیس
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="btn btn-default">
                            <input type="checkbox" name="app">
                            سورس کد
                        </label>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label class="btn btn-danger">
                            <input type="checkbox" name="app_delete">
                            حذف سوس کد برنامه بعد از بک آپ گیری
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="btn btn-danger">
                            <input type="checkbox" name="db_delete">
                            حذف پایگاه داده بعد از بک آپ گیری
                        </label>
                    </div>
                </div>
            </div>
            {{-- Body --}}

            <div class="box-footer">
                {{csrf_field()}}
                <button class="btn btn-primary" type="submit">شروع بک آپ گیری</button>
            </div>
            {{-- Footer --}}

        </div>
        {{-- Box --}}
    </form>

</div>
@endpush