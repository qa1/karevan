<div class="form-group {{$errors->has($name) ? 'has-error' : ''}}">
    @if(isset($label))<label for="{{$name}}">{{$label}}</label>@endif
    <select class="form-control" name="{{$name}}" id="{{$id}}" @if(isset($focus)) autofocus="" @endif @if(isset($multiple)) multiple="" @endif>
		@if(isset($option))
		{!! $option !!}
		@else
		<option value=""></option>
		@endif
		@foreach($data as $Key => $Val)
			<option value="{{$Key}}" @if($Key == $default) selected="" @endif>{{$Val}}</option>
		@endforeach
	</select>    
    @if($errors->has($name))<p class="help-block">{{$errors->first($name)}}</p>@endif
</div>