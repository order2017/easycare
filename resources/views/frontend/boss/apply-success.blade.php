<?php
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <div class="tips-box success">
        <i class="icon icon-sure"></i>
        <b>申请已提交</b>
        <small>请耐心等待后台审核。</small>
    </div>
    <a href="{{route('employee.shops.list')}}" class="btn">返回</a>
@endsection