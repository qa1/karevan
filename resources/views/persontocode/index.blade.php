@extends('adminlte::page')

@section('title', 'ارتباط زائر با کد تردد')

@section('content_header')
    <h1>ارتباط زائر با کد تردد</h1>
@stop

@section('content')
<page-persontocode inline-template>
<div class="col-md-12">
    {!! Form::open(['@submit.prevent' => 'submit']) !!}
    <div class="box" ref="box">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-8 col-md-9">
                    <div class="form-group">
                        <input type="text" name="code" class="form-control text-center clean clean-large clean-number" dir="ltr" placeholder="کد ملی یا نام و نام خانوادگی زائر" autocomplete="off" v-model="code" ref="code" :disabled="disable" @keydown.esc="code = ''" v-focus>
                    </div>
                </div>
                <div class="col-sm-4 col-md-3">
                    <div class="form-group">
                        <input type="text" name="father" id="father" class="form-control text-center clean clean-large" dir="ltr" placeholder="نام پدر" ref="father" v-model="father" :disabled="disable">
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-6 col-md-offset-3">
                    <button type="submit" class="btn btn-primary btn-block btn-md" :disabled="disable">
                        <span v-if="loading" v-cloak><i class="fa fa-refresh fa-spin"></i></span>
                        <span v-if="!loading" v-cloak>جستجو</span>
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

    {{-- <div class="row" ref="result"></div> --}}
    <div class="row" v-if="persons.length" v-cloak>
        <div class="col-xs-12" id="persontocode-list-container">
            <div class="col-xs-10">
                <ul class="list-group-personinfo noborder">
                    <li>نام</li>
                    <li>کد ملی</li>
                    <li>نام پدر</li>
                </ul>
            </div>
            <div class="clearfix"></div>
            <ul class="list-group" id="list-group">
                <page-persontocode-person v-for="(person, index) in persons" :index="index" inline-template url="{{route('persontocode.setcode')}}" :type="type">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-xs-10">
                                <ul class="list-group-personinfo">
                                    <li>@{{persons[index].name ? persons[index].name : '&nbsp;'}}</li>
                                    <li>@{{persons[index].melli ? persons[index].melli : '&nbsp;'}}</li>
                                    <li>@{{persons[index].father ? persons[index].father : '&nbsp;'}}</li>
                                </ul>
                            </div>
                            <div class="col-xs-2">
                                <input type="text" class="form-control pull-left code-input" placeholder="کد تردد" @keyup.enter="submit(persons[index].id, $event.currentTarget.value)" v-model="persons[index].code">
                            </div>
                        </div>
                    </li>
                </page-persontocode-person>
            </ul>
        </div>
    </div>

    <div class="col-xs-12" ref="cameraContainer" :class="{'hide': persons.length == 0}" v-cloak>
        <div class="form-group">
            <div class="controls text-center">
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-primary btn-md" :class="{'active': type == 'داخل'}" @click="type = 'داخل'">
                        <i class="fa fa-sign-in"></i>
                        <input type="radio" autocomplete="off" :checked="type == 'داخل'"> ورود
                    </label>
                    <label class="btn btn-primary btn-md" :class="{'active': type == ''}" @click="type = ''">
                        <input type="radio" autocomplete="off" :checked="type == ''"> هیچکدام
                    </label>
                    <label class="btn btn-primary btn-md" :class="{'active': type == 'خارج'}" @click="type = 'خارج'">
                        <i class="fa fa-sign-out"></i>
                        <input type="radio" autocomplete="off" :checked="type == 'خارج'"> خروج
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <camera-screenshot inline-template ref="camera">
                <div class="controls text-center">
                    <button type="button" class="btn btn-primary" @click="takeScreenshot()">
                        <i class="fa fa-camera"></i>
                        تهیه عکس
                    </button>
                    <button type="button" class="btn btn-danger" @click="clear()" :class="{'hide': !showCanvas}">
                        <i class="fa fa-times"></i>
                        ریست تصویر
                    </button>
                    <label class="btn btn-success">
                        <input type="checkbox" id="autoss" checked>
                        تهیه عکس خودکار در حین ثبت فرم
                    </label>
                    <br>
                    <br>
                    <video height="300" ref="video" autoplay="autoplay"></video>
                    <hr>
                    <div class="text-center" :class="{'hide': !showCanvas}">
                        <canvas ref="canvas" width="300" height="225" style="display: none; cursor: no-drop" @click="clear()"></canvas>
                    </div>
                    <input ref="input" type="hidden" id="person_camera_data" name="person_camera_data"/>
                </div>
            </camera-screenshot>
        </div>
    </div>

</div>
</page-persontocode>
@stop