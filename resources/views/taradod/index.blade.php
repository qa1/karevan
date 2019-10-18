@extends('adminlte::page')

@section('title', 'ثبت تردد')

@section('content_header')
    <h1>ثبت تردد</h1>
@stop

@section('content')
<page-taradod inline-template>
    <div>
        {!! Form::open(['@submit.prevent' => 'submit']) !!}
        <div class="box" ref="box">
            <div class="box-body">
                <div class="text-center">
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-primary btn-md" :class="{'active': type == 'داخل'}" data-type="داخل" @click="type = 'داخل'">
                            <i class="fa fa-sign-in"></i>
                            <input type="radio" autocomplete="off" :checked="type == 'داخل'"> ورود
                        </label>
                        <label class="btn btn-primary btn-md" :class="{'active': type == 'خارج'}" data-type="خارج" @click="type = 'خارج'">
                            <i class="fa fa-sign-out"></i>
                            <input type="radio" autocomplete="off" :checked="type == 'خارج'"> خروج
                        </label>
                    </div>
                </div>

                <br>

                <div class="text-center">
                    <input type="text" name="code" class="form-control text-center clean clean-large clean-number" dir="ltr" placeholder="کد تردد یا کد ملی" autocomplete="off" data-minlen="1" data-maxlen="20" v-model="code" ref="code" :disabled="disable" @keydown.esc="code = ''" @blur="codeFocused = false" v-focus v-input-number>
                </div>

                <br>

                <div class="text-center">
                    <div class="col-md-6 col-md-offset-3">
                        <button type="submit" class="btn btn-primary btn-block btn-md" :disabled="disable">
                            <span v-if="loading" v-cloak><i class="fa fa-refresh fa-spin"></i></span>
                            <span v-if="!loading" v-cloak>ثبت @{{type == 'داخل' ? 'ورود' : 'خروج'}}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}

        <div class="col-xs-12" v-if="success" v-cloak @click="success = ''">
            <div class="row">
                <div class="callout callout-success">
                    <h4 style="margin-bottom: 0">@{{success}}</h4>
                </div>
            </div>
        </div>

        <div class="col-xs-12" v-if="error" v-cloak @click="error = ''">
            <div class="row">
                <div class="callout callout-danger">
                    <h4 style="margin-bottom: 0">@{{error}}</h4>
                </div>
            </div>
        </div>

        <div class="row" ref="result"></div>
    </div>
</page-taradod>
@stop