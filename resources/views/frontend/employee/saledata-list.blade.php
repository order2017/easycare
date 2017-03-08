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
@foreach($list as $line)
    <ul class="tab-shops-list-box">
        <li>
            <ul class="info">
                <li><i class="icon icon-people1"></i>{{ $line['name'] }}</li>
                <li><i class="icon icon-phone"></i>{{ $line['mobile'] }}</li>
            </ul>
            <a class="list-btn" href="{{route('employee.saledetails.list',['id'=>$line['id']])}}">{{ $line['count'] }}件</a>
        </li>
    </ul>
@endforeach
    <div class="nav-bar">
        <div style="color: white; background: #55b6c4; text-align: center; font-size: 0.36rem;;">销售总数:{{ $allConut }}件</div>
    </div>
@endsection