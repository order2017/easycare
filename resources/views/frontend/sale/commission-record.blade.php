<?php
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <div class="sale-commission-top">
        <div class="title">我的佣金</div>
        <div>{{\App\CommissionBlotter::whereUserId(Auth::user()->id)->where('numerical','>=',0)->sum('numerical')}}</div>
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
                    <div class="record-amount"><i class="icon icon-sure"></i>{{$line['numerical']}}元</div>
                </div>
            </li>
        @endforeach
    </ul>
@endsection