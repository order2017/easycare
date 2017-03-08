<?php
view()->share('nav', false);
view()->share('bodyClass', 'gray');
?>
@extends('layouts.wechat')
@section('content')
    <div class="tips-box success">
        <i class="icon icon-sure"></i>
        <b>删除成功！</b>
    </div>
    <a class="btn" href="{{route('user.addresses')}}">返回</a>
@endsection