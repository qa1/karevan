@extends('adminlte::page')

@section('title', 'ویرایش مجوز')

@section('content_header')
    <h1>ویرایش مجوز</h1>
@stop

@section('content')
@include('rbac.permissions.form')
@stop