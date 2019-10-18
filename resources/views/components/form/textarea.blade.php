<div class="form-group {{$errors->has($name) ? 'has-error' : ''}}">
    <label @if(isset($id)) for="{{$id}}" @endif>{{$label}}</label>
    @if(isset($notes)) {!! $notes !!} @endif
    <textarea @if(isset($id)) id="{{$id}}" @endif class="form-control" rows="5" name="{{$name}}" @if(isset($focus)) autofocus="" @endif>{{isset($default) ? $default : ''}}</textarea>
    @if($errors->has($name))<p class="help-block">{{$errors->first($name)}}</p>@endif
</div>