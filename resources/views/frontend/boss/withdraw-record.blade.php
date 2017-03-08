<?php
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <div class="sale-commission-top">
        <div class="title">累计提现金额</div>
        <div>{{\APP\Withdraw::whereUserId(Auth::user()->id)->sum('money')}}元</div>
    </div>
    <div class="sale-commission-filter">
        <form action="">
            <input type="date" name="beginTime" max="2016-07-01" placeholder="开始日期">
            -
            <input type="date" name="endTime" min="2016-06-01" placeholder="结束日期">
            <select name="status" title="状态">
                <option value="">已到帐</option>
                <option value="">待处理</option>
            </select>
        </form>
    </div>
    <ul class="record-list">
        @foreach($list as $line)
            <li>
                <div class="clear">
                    <div class="record-number">流水:{{$line['serial_number']}}</div>
                    <div class="record-remark">-{{$line['integral']}}积分</div>
                </div>
                <div class="clear">
                    <div class="record-time">{{$line['created_at']}}</div>
                    <div class="record-amount">+{{$line['money']}}元</div>
                </div>
            </li>
        @endforeach
    </ul>
@endsection
