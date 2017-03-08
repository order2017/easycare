<?php
view()->share('bodyClass', 'gray');
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <a href="" class="user-integral-top">
        <img src="{{asset('/assets/images/member-integral.jpg')}}" alt="">
    </a>
    <div class="user-integral-info">
        <div class="user-integral-info-box">
            <div class="user-integral-info-title">收入</div>
            <div class="user-integral-info-amount">
                +{{\App\IntegralBlotter::whereUserId(Auth::user()->id)->whereStatus(\App\IntegralBlotter::STATUS_SUCCESS)->where('numerical','>',0)->sum('numerical')}}</div>
        </div>
        <div class="user-integral-info-box">
            <div class="user-integral-info-title">支出</div>
            <div class="user-integral-info-amount">{{\App\IntegralBlotter::whereUserId(Auth::user()->id)->whereStatus(\App\IntegralBlotter::STATUS_SUCCESS)->where('numerical','<',0)->sum('numerical')}}</div>
            <a href="{{route('goods.list')}}" class="user-integral-info-link">兑换商品</a>
        </div>
        <div class="user-integral-info-box">
            <div class="user-integral-info-title">余额</div>
            <div class="user-integral-info-balance">{{\App\User::whereId(Auth::user()->id)->value('integral')}}</div>
        </div>
    </div>
    <div class="user-integral-list-box">
        <div class="user-integral-title">收支账单</div>
        <ul class="user-integral-list">
            @foreach($list as $line)
                <li>
                    <div class="user-integral-list-left">
                        <div class="user-integral-list-title">{{$line['serial_number']}}</div>
                        <div>{{$line['created_at']}}</div>
                    </div>
                    <div class="user-integral-list-mid">
                        <div class="user-integral-list-title">{{$line['remark']}}</div>
                        <div>{{$line['numerical']}}</div>
                    </div>
                    <div class="user-integral-list-right">
                        <div class="user-integral-list-title">积分余额</div>
                        <div>{{$line['balance']}}</div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection