@if(isset($permission))
{!! Form::model($permission, ['class' => 'form-horizontal']) !!}
@else
{!! Form::open(['class' => 'form-horizontal']) !!}
@endif
<div class="box">
	<div class="box-body">
		<div class="form-group {{$errors->first('name', 'has-error')}}">
			{!! Form::label('name', 'نام', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::text('name', null, ['class' => 'form-control', 'autofocus']) !!}
				{!!$errors->first('name', '<span class="help-block">:message</span>')!!}
			</div>
		</div>
	</div>
</div>
<div class="col-md-6 col-md-offset-3">
	<button class="btn btn-block btn-primary" type="submit">ذخیره</button>
</div>
{!! Form::close() !!}