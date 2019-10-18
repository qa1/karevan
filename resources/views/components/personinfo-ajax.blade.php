@if(!is_null($person->ban))
<div class="col-xs-12">
    <div class="callout callout-danger">
        <h4>این زائر مسدود شده است</h4>
        <p>
            {{$person->ban}}
        </p>
    </div>
</div>
@endif

<div class="col-xs-12 col-md-4">
    <div class="box box-primary">
        <div class="box-body">
            <p>
                @if(!isset($image_url))
                <a href="{{$person->imageUrl()}}" target="_blank">
                    <img src="{{$person->imageThumb()}}" class="img-responsive img-thumbnail" style="margin: auto;" alt="تصویر">
                </a>
                @else
                <a href="{{$image_url}}" target="_blank">
                    <img src="{{$image_url}}" class="img-responsive img-thumbnail" style="margin: auto;" alt="تصویر">
                </a>
                @endif
            </p>
            <p>
                <strong>نام و نام خانوداگی:</strong> {{$person->name}}
            </p>
            <p>
                <strong>کاروان:</strong> @if($person->modirkarevan){{$person->modirkarevan->name}}@endif
            </p>
            <p>
                <strong>شهر:</strong> @if($person->city){{$person->city->name}}@endif
            </p>
            <p>
                <strong>کد تردد:</strong> {{$person->code}}
            </p>
            <p>
                <strong>کد ملی:</strong> {{$person->melli}}
            </p>
        </div>
    </div>
</div>

<div class="col-xs-12 col-md-8">

    @if($person->messages()->where('status', 'خوانده نشده')->count() > 0)
    <div class="box box-warning">
        <div class="box-header with-border">
            <div class="box-title">پیام ها</div>
        </div>
        <div class="box-body">
            <ul class="list-group" style="margin: 0">
                @foreach($person->messages()->where('status', 'خوانده نشده')->get()->reverse() as $message)
                <li class="list-group-item list-group-item-buttoned">
                    {{$message->message}} - <span dir="rtl">{{$message->created_at->diffForHumans()}}</span>
                    <button type="button" class="btn btn-primary btn-xs" onclick="messsageRead(this, '{{route('messages.readed', [$message])}}')"><i class="fa fa-check"></i></button>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
    <div class="box box-info">
        <div class="box-header with-border">
            <div class="box-title">ترددها</div>
        </div>
        <div class="box-body">
            <div class="table-responsive" style="height: 250px">
                <table class="table table-bordered table-hover table-striped no-margin">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نوع</th>
                            <th>زمان</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($person->traffic()->with('user')->orderBy('id', 'desc')->get() as $traffic)
                        <tr>
                            <td>{{$traffic->id}}</td>
                            <td>
                                @if($traffic->isIn())
                                <span class="label label-success">ورود</span>
                                @else
                                <span class="label label-warning">خروج</span>
                                @endif
                            </td>
                            <td>
                                {{$traffic->created_at->diffForHumans()}} /
                                <small dir="ltr">{{jDate("Y/m/d - H:i:s", $traffic->created_at->timestamp)}}</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="100">هیچ ترددی برای ایشان ثبت نشده است</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if($person->error()->count() > 0)
    <div class="box box-warning">
        <div class="box-header with-border">
            <div class="box-title">خطاها</div>
        </div>
        <div class="box-body">
            <div class="table-responsive" style="height: 250px;">
                <table class="table table-bordered table-hover table-striped no-margin">
                    <thead>
                        <tr>
                            <th>پیام/نوع</th>
                            <th>زمان</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($person->error()->with('user')->orderBy('id', 'desc')->get() as $error)
                        <tr>
                            <td>
                                {{$error->message}}
                            </td>
                            <td>
                                {{$error->created_at->diffForHumans()}} /
                                <small dir="ltr">{{jDate("Y/m/d - H:i:s", $error->created_at->timestamp)}}</small>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
function messsageRead(that, url) {
    $.ajax({
        type: 'post',
        url: url
    }).always(function(){
        $(that).parent().remove();
    });
}
</script>