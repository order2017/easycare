<?php
view()->share('bodyClass', 'gray');
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <div class="employee-list-search">
        <form action="">
            <div class="employee-list-search-form">
                <input type="text" name="keyword" value="{{$keyword}}" placeholder="请输入店名/电话">
                <button><i class="icon icon-search"></i></button>
            </div>
        </form>
    </div>
    <ul class="tab-shops-list-box" data-ajax-load id="tab-box">
        @foreach($list as $line)
            <li>
                <ul class="info">
                    <li><i class="icon icon-people1"></i>{{$line['name']}}</li>
                    <li><i class="icon icon-phone"></i>{{$line['phone']}}</li>
                    <li><i class="icon "></i>店铺介绍:{{$line['intro']}}</li>
                </ul>
            </li>
        @endforeach
    </ul>
@endsection