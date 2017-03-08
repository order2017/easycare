<?php
view()->share('bodyClass', 'gray');
?>
@extends('layouts.wechat')
@section('content')
    <div class="tab-nav">
        <a href="{{route('employee.applies.ajax',['type'=>\App\ShopStaffApply::STATUS_WAIT])}}" data-auto-load
           data-ajax-list
           target="#tab-box"
           >待处理</a>
        <div class="line"></div>
        <a href="{{route('employee.applies.ajax',['type'=>30])}}" data-ajax-list target="#tab-box">已通过</a>
        <div class="line"></div>
        <a href="{{route('employee.applies.ajax',['type'=>20])}}" data-ajax-list target="#tab-box">不通过</a>
    </div>
    <ul class="tab-list-box" data-ajax-load id="tab-box">
        @foreach($list as $line)
            <li>
                <ul class="info">
                    <li><i class="icon icon-warning2"></i>{{$line['name']}}</li>
                    <li><i class="icon icon-warning2"></i>{{$line['mobile']}}</li>
                </ul>
                <a href="{{route('employee.apply.page',['id'=>$line['id']])}}" class="list-btn">补充资料</a>
            </li>
        @endforeach
    </ul>
@endsection