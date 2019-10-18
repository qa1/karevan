@extends('adminlte::page')

@section('title', 'ثبت نام')

@section('content')
<person-register inline-template>
{!! Form::open(['ref' => 'form', '@submit.prevent' => 'submit']) !!}

<div class="alert alert-success" v-if="result.type == 'success'" @click="result = {}" v-cloak>@{{result.message}}</div>
<div class="alert alert-danger" v-if="result.type == 'error'" @click="result = {}" v-cloak>@{{result.message}}</div>

<div class="row">
	<div class="col-xs-12 col-md-6">
	    <div class="box box-primary">

	        <div class="box-body">
	            <div class="row">
	                <div class="col-xs-12">
	                    <div class="form-group" :class="{'has-error': errors.code}">
	                        <label for="code">کد تردد <strong class="text-danger">*</strong></label>
	                        <input class="form-control" id="code" name="code" ref="code" type="text" autocomplete="off" data-minlen="1" data-maxlen="20" v-focus v-input-number />
	                        <span class="help-block" v-if="errors.code">@{{errors.code[0]}}</span>
	                    </div>
	                </div>
	            </div>
	            <div class="row">
	                <div class="col-xs-7">
	                	<div class="form-group" :class="{'has-error': errors.city_id}">
	                		<label for="city_id">شهر <strong class="text-danger">*</strong></label>
		                	{!! Form::select('city_id', ['' => ''] + \App\Models\City::get()->pluck('name', 'id')->toArray(), null, ['class' => 'form-control', 'ref' => 'city_id', '@change' => "\$refs.city_name.value = ''"]) !!}
		                	<span class="help-block" v-if="errors.city_id">@{{errors.city_id[0]}}</span>
	                	</div>
	                </div>
	                <div class="col-xs-5">
	                    <div class="form-group" :class="{'has-error': errors.city_name}">
	                    	<label>&nbsp;</label>
		                    <input type="text" name="city_name" class="form-control" placeholder="شهر جدید" ref="city_name" autocomplete="off" @input="$refs.city_id.value = ''">
		                    <span class="help-block" v-if="errors.city_name">@{{errors.city_name[0]}}</span>
	                    </div>
	                </div>
	            </div>
	            <div class="row">
	                <div class="col-xs-7">
	                	<div class="form-group" :class="{'has-error': errors.modirkarevan_id}">
	                		<label for="modirkarevan_id">مدیر کاروان <strong class="text-danger">*</strong></label>
		                	{!! Form::select('modirkarevan_id', ['' => ''] + \App\Models\Modirkarevan::get()->pluck('name', 'id')->toArray(), null, ['class' => 'form-control', 'ref' => 'modirkarevan_id', '@change' => "\$refs.modirkarevan_name.value = ''"]) !!}
		                	<span class="help-block" v-if="errors.modirkarevan_id">@{{errors.modirkarevan_id[0]}}</span>
	                	</div>
	                </div>
	                <div class="col-xs-5">
	                    <div class="form-group" :class="{'has-error': errors.modirkarevan_name}">
	                    	<label>&nbsp;</label>
		                    <input type="text" name="modirkarevan_name" class="form-control" placeholder="مدیر کاروان جدید" autocomplete="off" ref="modirkarevan_name" @input="$refs.modirkarevan_id.value = ''">
		                    <span class="help-block" v-if="errors.modirkarevan_name">@{{errors.modirkarevan_name[0]}}</span>
	                    </div>
	                </div>
	            </div>
	        </div>

	    </div>

	    <div class="box box-primary">

	        <div class="box-body">
	            <div class="form-group" :class="{'has-error': errors.name}">
                    <label for="person_name">نام و نام خانوادگی</label>
                    <input class="form-control" id="person_name" name="name" ref="name" type="text" autocomplete="off" />
                    <span class="help-block" v-if="errors.name">@{{errors.name[0]}}</span>
                </div>
            	<div class="form-group" :class="{'has-error': errors.father}">
                    <label for="father">نام پدر</label>
                    <input class="form-control" id="father" name="father" ref="father" type="text" autocomplete="off" />
                    <span class="help-block" v-if="errors.father">@{{errors.father[0]}}</span>
                </div>
                <div class="form-group" :class="{'has-error': errors.melli}">
                    <label for="melli">کد ملی</label>
                    <input class="form-control" id="melli" name="melli" ref="melli" type="text" autocomplete="off" data-minlen="1" data-maxlen="15" v-input-number />
                    <span class="help-block" v-if="errors.melli">@{{errors.melli[0]}}</span>
                </div>
	        </div>

	    </div>
	</div>

	<div class="col-xs-12 col-md-6">
		<div class="box box-primary">
	    	<div class="box-body">
	    		<camera-screenshot inline-template ref="camera">
		        	<div class="text-center">
		        		<div class="form-group">
			                <div class="controls">
			                    <video height="300" ref="video" autoplay="autoplay"></video>
			                    <br>
			                    <button type="button" class="btn btn-primary" @click="takeScreenshot()">
			                        <i class="fa fa-camera"></i>
			                        تهیه عکس
			                    </button>
			                </div>
		        		</div>
		                <div class="text-center" :class="{'hide': !showCanvas}">
		                	<canvas ref="canvas" width="300" height="225" style="display: none; cursor: no-drop" @click="clear()"></canvas>
		                </div>
		                <input ref="input" type="hidden" name="person_camera_data"/>
		        	</div>
		        </camera-screenshot>
	    	</div>
	    </div>

	    <div class="box">
	    	<div class="box-body">
                <div class="form-group">
                    <label>
                    	<input type="checkbox" name="vorood">
	                    <i class="fa fa-users"></i> ثبت ورود پس از ثبت نام
                    </label>
                </div>
                <div class="form-group">
                    <label>
                    	<input type="checkbox" name="autoss" ref="autoss">
                        <i class="fa fa-camera"></i> تهیه عکس خودکار در حین ثبت فرم
                    </label>
                </div>
	    	</div>
	    </div>

	    <div class="col-md-10 col-md-offset-1">
	    	<button class="btn btn-success btn-block" type="submit">
	    		<span v-if="loading" v-cloak><i style="font-size: 35px;" class="fa fa-refresh fa-spin"></i></span>
	    		<span v-if="!loading" v-cloak>ثبت نام</span>
	    	</button>
	    </div>
	</div>
</div>
{!! Form::close() !!}
</person-register>
@stop