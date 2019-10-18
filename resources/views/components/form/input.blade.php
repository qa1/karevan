<div class="form-group {{$errors->has($name) ? 'has-error' : ''}} @if(isset($moreclass)) {{$moreclass}} @endif">
    <label @if(isset($id)) for="{{$id}}" @endif>{{$label}}</label>
    @if(isset($notes)) {!! $notes !!} @endif
    <input class="form-control" @if(isset($id)) id="{{$id}}" @endif name="{{$name}}" type="{{$type}}" value="{{isset($default) ? $default : ''}}" @if(isset($focus)) autofocus="" @endif />
    @if($errors->has($name))<p class="help-block">{{$errors->first($name)}}</p>@endif
</div>