@extends('adminlte::page')

@section('title', 'مشاهده کامل اطلاعات زائر')

@section('content_header')
    <h1>مشاهده کامل اطلاعات زائر</h1>
@stop

@section('content')
<person-search inline-template>
<div class="row">
    <div class="col-md-12">
        {!! Form::open(['@submit.prevent' => 'submit']) !!}
        <div class="box" id="box">
            <div class="box-body">
                <div class="text-center">
                    <input type="text" class="form-control text-center clean clean-large clean-number" dir="ltr" placeholder="کد تردد یا کد ملی" data-minlen="1" data-maxlen="20" v-focus v-input-number v-model="code" @keyup.esc="code = ''" ref="code" :disabled="disable">
                </div>
                <br>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-md" :disabled="disable">
                        <span v-if="loading"><i class="fa fa-refresh fa-spin"></i></span>
                        <span v-if="!loading">نمایش مشخصات و وضعیت زائر</span>
                    </button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}

        <div class="col-xs-12" v-if="error" v-cloak>
            <div class="row">
                <div class="callout callout-danger">
                    <h4>@{{error}}</h4>
                </div>
            </div>
        </div>

        @if(!$person)
            <div class="row" ref="result" style="display: none"></div>
        @else
            <div class="row" ref="result">
                @include('components.personinfo-ajax')
            </div>
        @endif
    </div>
</div>
</person-search>
@stop