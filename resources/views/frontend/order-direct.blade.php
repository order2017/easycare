<?php
view()->share('bodyClass', 'gray');
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <form action="{{route('order.direct')}}" method="post">
        <input type="hidden" name="goods_id" value="{{$goods['id']}}">
        <input type="hidden" name="address_id" value="">
        {{csrf_field()}}
        <div class="order-top-box">
            <div class="order-address-box-empty">
                请填写收货地址
            </div>
            <div class="order-address-box" style="display: none">
                <div class="name" id="address-box-contact"></div>
                <div class="mobile" id="address-box-phone"></div>
                <div class="address" id="address-box-address"></div>
            </div>
        </div>
        @include('frontend.order-common')
    </form>
    <div class="order-address-write-box" id="address-write-box">
        <form action="{{route('user.address.save')}}" data-normal>
            <div class="block">
                <div class="form-group" id="contact">
                    <label class="form-label">收件人：</label>
                    <input type="text" name="contact" class="form-control" value="" placeholder="请输入您的姓名">
                </div>
                <div class="form-group" id="phone">
                    <label class="form-label">手机号：</label>
                    <input type="number" name="phone" class="form-control" value="" placeholder="请输入您的手机号码">
                </div>
                <div class="form-group">
                    <label class="form-label">选择地区</label>
                    @widget('addressAreaBox')
                </div>
                <div class="form-group" id="address">
                    <label class="form-label">地址：</label>
                    <input type="text" name="address" class="form-control" value="" placeholder="请输入详细地址">
                </div>
            </div>
            <button class="btn">保存</button>
        </form>
        {{--<div class="order-address-select-title">历史收货地址</div>--}}
        {{--<ul class="order-address-select-box" id="address-select-box">--}}
        {{--<li class="active">--}}
        {{--<div class="order-address-select-box-name">李纷纷</div>--}}
        {{--<div class="order-address-select-box-mobile">13512345678</div>--}}
        {{--<div class="order-address-select-box-address">放假阿莱卡发卡量降低了房价阿康决定离开房间啊旅客身份</div>--}}
        {{--</li>--}}
        {{--<li>--}}
        {{--<div>李纷纷</div>--}}
        {{--<div>13512345678</div>--}}
        {{--<div>放假阿莱卡发卡量降低了房价阿康决定离开房间啊旅客身份</div>--}}
        {{--</li>--}}
        {{--</ul>--}}
    </div>
@endsection