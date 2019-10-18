@extends('adminlte::page')

@section('title', 'ویرایش نقش')

@section('content_header')
    <h1>ویرایش نقش</h1>
@stop

@section('content')
@include('rbac.roles.form')
@stop