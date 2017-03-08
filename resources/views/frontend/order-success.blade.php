<?php
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <div class="tips-box success">
        <i class="icon icon-sure"></i>
        <b>购买成功</b>
        <small>您的兑换已经成功，系统正在处理中，请稍后在订单详情查看结果！</small>
    </div>
    <a href="{{route('user.order.page',['id'=>$order['id']])}}" class="btn">查看订单</a>
@endsection