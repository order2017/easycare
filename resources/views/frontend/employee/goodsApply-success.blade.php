<?php
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <div class="tips-box success">
        <i class="icon icon-sure"></i>
        <b>申请已提交</b>
        <small>工作人员将会在7个工作日内审核完成，请留意公众号内信息。</small>
    </div>
    <a href="{{route('employee.goods.list')}}" class="btn">返回</a>
@endsection