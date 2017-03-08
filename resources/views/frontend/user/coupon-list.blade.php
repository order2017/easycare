<?php
view()->share('bodyClass', 'gray');
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <div class="tab-nav">
        <a href="{{route('user.coupon.list',['type'=>'wait'])}}" @if($type == 'wait') class="active" @endif>待使用</a>
        <div class="line"></div>
        <a href="{{route('user.coupon.list',['type'=>'finish'])}}" @if($type == 'finish') class="active" @endif>已使用</a>
        <div class="line"></div>
        <a href="{{route('user.coupon.list',['type'=>'expired'])}}"
           @if($type == 'expired') class="active" @endif>已过期</a>
    </div>
    <div class="tab-box">
        @if(!$list->isEmpty())
            @foreach($list as $line)
                <a href="{{route('user.coupon.exchange',['id'=>$line['id']])}}" class="user-coupon-list">
                    <div class="user-coupon-title">
                        <div class="user-coupon-title-img">
                            @if($line['coupon']['type'] == \App\CouponApply::TYPE_DIYONGQUAN)
                                <img src="{{asset('/assets/images/coupon-mon.jpg')}}" alt="">
                            @else
                                <img src="{{asset('/assets/images/coupon-dis.jpg')}}" alt="">
                            @endif
                        </div>
                        <div class="user-coupon-title-box">
                            {{$line['coupon']['title']}}
                        </div>
                        {{--<div class="user-coupon-timeout">快过期</div>--}}
                    </div>
                    <div class="user-coupon-line">
                        <div class="left"></div>
                        <div class="right"></div>
                    </div>
                    <div class="user-coupon-info">
                        <div class="user-coupon-info-left">
                            @if($line['coupon']['type'] == \App\CouponApply::TYPE_DIYONGQUAN)
                                <div class="user-coupon-info-amount">￥<b>{{$line['coupon']['money']}}</b></div>
                            @else
                                <div class="user-coupon-info-amount"><b>{{$line['coupon']['discount']}}</b>折</div>
                            @endif
                            <div class="user-coupon-info-intro">{{$line['coupon']['title_text']}}</div>
                        </div>
                        <div class="user-coupon-info-right">
                            <div class="user-coupon-info-time-title">使用期限</div>
                            <div class="user-coupon-info-time-begin">{{$line['begin_time']}}</div>
                            <div class="user-coupon-info-time-end">{{$line['end_time']}}</div>
                        </div>
                    </div>
                </a>
            @endforeach
        @else
            <div class="tab-box-none">喔喔，没有找到数据。</div>
        @endif
    </div>
    <a href="{{route('coupon.list')}}" class="user-coupon-btn">去领劵中心看看<i class="icon icon-right1"></i></a>
@endsection