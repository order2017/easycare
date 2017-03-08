<?php
view()->share('nav', false);
view()->share('bodyClass', 'gray');
?>
@extends('layouts.wechat')
@section('content')
    <div class="tips-box success">
        <i class="icon icon-sure"></i>
        <b>您的个人资料已保存！</b>
    </div>
    <a class="btn" href="{{route('user.info')}}">查看我的个人资料</a>
@endsection