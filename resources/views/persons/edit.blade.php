@extends('adminlte::page')

@section('title', 'ویرایش زائر')

@section('content_header')
    <h1>ویرایش زائر</h1>
@stop

@section('content')
{!! Form::model($person, ['files' => true]) !!}
<div class="col-md-8 col-md-offset-2">
	<div class="box box-primary">
	    <div class="box-body">
	    	<div class="form-group {{$errors->first('code', 'has-error')}}">
	    		<label>کد تردد</label>
	        	{!! Form::text('code', null, ['class' => 'form-control', 'autocomplete' => 'off', 'v-focus v-english-digit']) !!}
	        	{!!$errors->first('code', '<span class="help-block">:message</span>')!!}
	    	</div>
	    	<div class="form-group {{$errors->first('name', 'has-error')}}">
	    		<label>نام و نام خانوادگی</label>
	        	{!! Form::text('name', null, ['class' => 'form-control']) !!}
	        	{!!$errors->first('name', '<span class="help-block">:message</span>')!!}
	    	</div>
	    	<div class="form-group {{$errors->first('father', 'has-error')}}">
	    		<label>نام پدر</label>
	        	{!! Form::text('father', null, ['class' => 'form-control']) !!}
	        	{!!$errors->first('father', '<span class="help-block">:message</span>')!!}
	    	</div>
	    	<div class="form-group {{$errors->first('melli', 'has-error')}}">
	    		<label>کد ملی</label>
	        	{!! Form::text('melli', null, ['class' => 'form-control', 'data-minlen' => 1, 'data-maxlen' => 11, 'v-input-number v-english-digit']) !!}
	        	{!!$errors->first('melli', '<span class="help-block">:message</span>')!!}
	    	</div>
	    	<div class="form-group {{$errors->first('city_id', 'has-error')}}">
	    		<label>شهر</label>
	        	{!! Form::select('city_id', \App\Models\City::pluck('name', 'id'), null, ['class' => 'form-control']) !!}
	        	{!!$errors->first('city_id', '<span class="help-block">:message</span>')!!}
	    	</div>
	    	<div class="form-group {{$errors->first('modirkarevan_id', 'has-error')}}">
	    		<label>مدیر کاروان</label>
	        	{!! Form::select('modirkarevan_id', \App\Models\Modirkarevan::pluck('name', 'id'), null, ['class' => 'form-control']) !!}
	        	{!!$errors->first('modirkarevan_id', '<span class="help-block">:message</span>')!!}
	    	</div>
	    	<div class="form-group {{$errors->first('image', 'has-error')}}">
	    		<label>تصویر</label>
	        	{!! Form::file('image', ['class' => 'form-control']) !!}
	        	{!!$errors->first('image', '<span class="help-block">:message</span>')!!}
	    	</div>
	        <div class="form-group {{$errors->has('camera') ? 'has-error' : ''}}">
	            <label for="person_camera">دوربین</label>
	            <div class="controls">
	                <video width="300" id="person_camera" autoplay="autoplay"></video>
	                <br>
	                <button type="button" class="btn btn-primary" onclick="takeSs()">
	                    <i class="fa fa-camera"></i>
	                    تهیه عکس
	                </button>
	            </div>
	            <canvas id="person_camera_canvas" width="300" height="225" style="display: none"></canvas>
	            <input type="hidden" name="person_camera_data" id="person_camera_data"/>
	            @if($errors->has('camera'))<p class="help-block">{{$errors->first('camera')}}</p>@endif
	        </div>
	        @if($person->hasImage())
	        <div class="form-group">
	            <label>تصویر فعلی</label>
	            <div class="controls">
	                <p><a href="{{$person->imageUrl()}}" target="_blank"><img class="img img-thumbnail" src="{{$person->imageThumb()}}"></a></p>
	                <p><a onclick="return confirm('آیا اطمینان دارید؟')" href="{{route('persons.deleteimage', $person)}}" class="btn btn-danger">حذف تصویر</a></p>
	            </div>
	        </div>
	        @endif
	        <hr>
	        <div class="form-group {{$errors->first('ban', 'has-error')}}">
	    		<label>مسدود</label>
	    		<br><i>در صورت تمایل به مسدود کردن این زائر، لطفا دلیل آن را ذکر کنید در غیر این صورت این کادر را خالی رها کنید</i>
	        	{!! Form::text('ban', null, ['class' => 'form-control']) !!}
	        	{!!$errors->first('ban', '<span class="help-block">:message</span>')!!}
	    	</div>
	    </div>
	</div>
	<div class="col-md-8 col-md-offset-2">
		<button class="btn btn-primary btn-block" type="submit">ثبت اطلاعات</button>
	</div>
</div>
{!! Form::close() !!}
@stop

@push('scripts')
<script>
var Camera = new Camera(document.getElementById('person_camera'));
function takeSs() {
    Camera.ss(
        $("#person_camera_data"),
        document.getElementById("person_camera_canvas")
    );
}
</script>
@endpush