@extends('adminlte::page')

@section('title', 'ایجاد مجوز جدید')

@section('content_header')
    <h1>ایجاد مجوز جدید</h1>
@stop

@section('content')
@include('rbac.permissions.form')
@stop