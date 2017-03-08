<?php
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <div class="tips-box success">
        <i class="icon icon-sure"></i>
        <b>申请已提交</b>
        <small>感谢您的支持，我们将处理您反应的问题。</small>
    </div>
    <a href="{{route('user.feedback')}}" class="btn">返回</a>
@endsection