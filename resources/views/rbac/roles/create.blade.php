@extends('adminlte::page')

@section('title', 'ایجاد نقش جدید')

@section('content_header')
    <h1>ایجاد نقش جدید</h1>
@stop

@section('content')
@include('rbac.roles.form')
@stop