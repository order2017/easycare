<?php
view()->share('bodyClass', 'gray');
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')

    <div class="tab-nav">
        <a href="{{route('employee.goods.list',['type'=>'wait'])}}" @if($type == 'wait') class="active" @endif>待审核</a>
        <div class="line"></div>
        <a href="{{route('employee.goods.list',['type'=>'approve'])}}" @if($type == 'approve') class="active" @endif>已通过</a>
        <div class="line"></div>
        <a href="{{route('employee.goods.list',['type'=>'refusal'])}}" @if($type == 'refusal') class="active" @endif>不通过</a>
    </div>
@if($type == 'approve')
    <div class="employee-list-search">
        <form action="">
            <div class="employee-list-search-form">
                <input type="text" name="keyword" value="{{$keyword}}" placeholder="请输入商品名称">
                <button><i class="icon icon-search"></i></button>
            </div>
        </form>
    </div>
@endif

    <ul class="goods-list">
        @foreach($list as $line)
                <li>
                    <div class="goods-list-image">
                        <img src="{{$line['thumb_url']}}" alt="">
                    </div>
                    <div class="goods-list-info">
                        <div class="goods-list-title">{{$line['name']}}</div>
                        <div class="goods-list-integral goods-list-integralcxl"><b>{{$line['price']}}</b>积分</div>
                        @if($type == 'wait')
                            <a class="goods-list-btn goods-list-btncxl" href="{{route('employee.goods.apply',['id'=>$line['id'],'status'=>$line['status']])}}">编辑</a>
                        @elseif($type == 'approve')
                            <a class="goods-list-btn goods-list-btncxl" href="{{route('goods.page',['id'=>$line['id']])}}">查看</a>
                            <a class="goods-list-btn goods-list-btncxl" href="{{route('employee.goods.apply',['id'=>$line['id']])}}">编辑</a>
                        @elseif($type == 'refusal')
                            <a class="goods-list-btn goods-list-btncxl" href="{{route('employee.goods.apply',['id'=>$line['id'],'status'=>$line['status']])}}">编辑</a>
                        @endif
                    </div>
                </li>
        @endforeach
    </ul>
@endsection