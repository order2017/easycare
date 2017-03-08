<?php
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <div class="boss-integral-top">
        <div class="boss-integral-total-title">累计总积分</div>
        <div class="boss-integral-total">{{\App\IntegralBlotter::whereUserId(Auth::user()->id)->where('numerical','>=',0)->sum('numerical')}}</div>
        <div class="boss-integral-total-box">
            <div>
                <div class="boss-integral-total-box-title">今日积分</div>
                <div class="boss-integral-total-box-number">20</div>
            </div>
            <div>
                <div class="boss-integral-total-box-title">可兑换积分</div>
                <div class="boss-integral-total-box-number">{{\App\User::whereId(Auth::user()->id)->value('integral')}}</div>
            </div>
            <div>
                <div class="boss-integral-total-box-title">已兑换积分</div>
                <div class="boss-integral-total-box-number">{{\App\IntegralBlotter::whereUserId(Auth::user()->id)->where('numerical','>=',0)->sum('numerical') - \App\User::whereId(Auth::user()->id)->value('integral')}}</div>
            </div>
        </div>
    </div>
    <div class="sale-commission-filter">
        <form action="">
            <input type="date" name="beginTime" max="2016-07-01">
            -
            <input type="date" name="endTime" min="2016-06-01">
            <select name="status">
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
                <div class="record-remark">{{$line['remark']}}</div>
            </div>
            <div class="clear">
                <div class="record-time">{{$line['created_at']}}</div>
                <div class="record-amount">{{$line['numerical']}}积分</div>
            </div>
        </li>
        @endforeach
    </ul>
@endsection
