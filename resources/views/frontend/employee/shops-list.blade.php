<?php
view()->share('bodyClass', 'gray');
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <div class="employee-list-search">
        <form action="">
            <div class="employee-list-search-form">
                <input type="text" name="keyword" value="{{$keyword}}" placeholder="请输入店铺名称/电话">
                <button><i class="icon icon-search"></i></button>
            </div>
        </form>
    </div>
    <div class="shop-list-box">
        @foreach($list as $line)
            <div class="employee-shop-list employee-list">
                <div class="shop-list-img">
                    <img src="{{$line['thumb_url']}}" alt="">
                </div>
                <div class="shop-list-info">
                    <h3>{{$line['name']}}</h3>
                    <div class="shop-list-intro">
                        {{$line['intro']}}
                    </div>
                    <div class="shop-list-status">状态：审核中</div>
                </div>
                <div class="action-bar two">
                    <a href="{{route('employee.shop.apply',['id'=>$line['id']])}}" class="green">编辑</a>
                    <a href="{{route('shop.page',['id'=>$line['id']])}}">查看</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection