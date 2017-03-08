<?php
view()->share('bodyClass', 'gray');
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <div class="tab-nav">
        <a href="{{route('employee.shop-applies.ajax',['type'=>\App\ShopApply::STATUS_WAIT])}}" data-auto-load
           data-ajax-list
           target="#tab-box"
           >待审核</a>
        <div class="line"></div>
        <a href="{{route('employee.shop-applies.ajax',['type'=>30])}}" data-ajax-list target="#tab-box" class="active">已通过</a>
        <div class="line"></div>
        <a href="{{route('employee.shop-applies.ajax',['type'=>20])}}" data-ajax-list target="#tab-box">不通过</a>
    </div>
    <ul class="tab-list-box" data-ajax-load id="tab-box">
        @foreach($list as $line)
            <li>
                <ul class="info">
                    <li><i class="icon icon-warning2"></i>{{$line['name']}}</li>
                    <li><i class="icon icon-warning2"></i>{{$line['phone']}}</li>
                </ul>
            </li>
        @endforeach
    </ul>
@endsection