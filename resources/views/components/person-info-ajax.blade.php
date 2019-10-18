<table class="table table-striped" style="margin: 0">
    <tr>
        <td>نام پدر:</td>
        <td>{{$person->father}}</td>
    </tr>
    <tr>
        <td>تصویر:</td>
        <td>
            @if($person->hasImage())
            <img src="{{$person->imageThumb()}}" class="img img-thumbnail">
            @else
            ...
            @endif
        </td>
    </tr>
    <tr>
        <td>مسدود:</td>
        <td>
        	@if(is_null($person->ban))
        	<span class="label label-success">خیر</span>
        	@else
        	<span class="label label-danger">{{$person->ban}}</span>
        	@endif
        </td>
    </tr>
    <tr>
    	<td>پیام ها:</td>
    	<td style="padding: 0">
    		<table>
    		@forelse($person->messages()->get() as $message)
    			<tr>
    				<td>{{$message->message}} - {!!$message->isRead() ? "<span class='label label-success'>خوانده شده</span>" : "<span class='label label-default'>خوانده نشده</span>"!!}</td>
    			</tr>
			@empty
				<tr>
					<td>...</td>
				</tr>
    		@endforelse
    		</table>
    	</td>
    </tr>
</table>