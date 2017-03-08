<?php
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <div class="sale-commission-filter">
        <form action="" method="post">
            <input style="width:100px; font-size:12px;" type="date" name="beginTime" max="2016-07-01">
            -
            <input style="width:100px; font-size:12px" type="date" name="endTime" min="2016-06-01">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input style="width:60px;" type="submit" name="dosubmit" value="查询">
        </form>
    </div>

    {{--<div class="employee-list-search">
    </div>--}}

    @if($list)
        @foreach($list as $line)
            <ul class="tab-shops-list-box">
                <li>
                    <ul class="info">
                        <li>产品型号: {{ $line['model'] }}</li>
                        <li>积分: {{ $line['commission'] }}</li>
                    </ul>
                    <a class="list-btn">{{ $line['count'] }}件</a>
                </li>
            </ul>
        @endforeach
        <div class="goods-detail-bar">
            <a class="goods-detail-bar-bottom" >佣金总额:{{ $alltotal or 0 }} 元</a>
            <a class="goods-detail-bar-btn" href="">销售总佣金:{{ $total or 0 }} 元</a>
        </div>
    @else
        <ul class="tab-shops-list-box">
            <li>
                <ul class="info">
                    <li>暂无数据</li>
                </ul>
            </li>
        </ul>
    @endif
@endsection