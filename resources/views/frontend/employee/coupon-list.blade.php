<?php
view()->share('bodyClass', 'gray');
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <div class="tab-nav">
        <a href="{{route('employee.coupon.list',['type'=>'wait'])}}" @if($type == 'wait') class="active" @endif>待审核</a>
        <div class="line"></div>
        <a href="{{route('employee.coupon.list',['type'=>'approve'])}}" @if($type == 'approve') class="active" @endif>已通过</a>
        <div class="line"></div>
        <a href="{{route('employee.coupon.list',['type'=>'refusal'])}}" @if($type == 'refusal') class="active" @endif>不通过</a>
    </div>

    @if($type == 'approve')
    <div class="employee-list-search">
        <form action="">
            <div class="employee-list-search-form">
                <input type="text" name="keyword" value="{{$keyword}}" placeholder="请输入优惠劵名称">
                <button><i class="icon icon-search"></i></button>
            </div>
        </form>
    </div>
    @endif

@foreach($list as $line)
    <div class="employee-coupon-listlg">
      <div class="employee-coupon-leftlg">
          <div class="employee-coupon-titlelg">
              <div class="employee-coupon-title-name">{{$line->title}}</div>
              <div class="employee-coupon-title-time">
                  <div class="employee-coupon-time-type">有效期:</div>
                  <div class="employee-coupon-time-limit"><span>{{date("Y-m-d",strtotime("$line->begin_time"))}}</span> <span>{{date("Y-m-d",strtotime($line->end_time))}}</span></div>
              </div>
          </div>
          <div class="employee-coupon-discountlg">
              抵扣{{$line->discount}}元
          </div>
      </div>
      <div class="employee-coupon-right">
          <div class="coupon-list-info">
              <h3>{{$line->title}}</h3>
              <div class="coupon-list-integral"><b>{{$line['integral']}}</b>分</div>
              <div class="coupon-list-shop-name">{{$line['shop_name']}}</div>
          </div>
          @if($type == 'wait')
              <a class="goods-list-btn goods-list-btnlg" href="{{route('employee.coupon.apply',['id'=>$line['id'],'status'=>$line['status']])}}">编辑</a>
          @elseif($type == 'approve')
          <a class="goods-list-btn goods-list-btnlg" href="{{route('coupon.page',['id'=>$line['id']])}}">查看</a>
          <a class="goods-list-btn goods-list-btnlg" href="{{route('employee.coupon.apply',['id'=>$line['id']])}}">编辑</a>
          @elseif($type == 'refusal')
              <a class="goods-list-btn goods-list-btnlg" href="{{route('employee.coupon.apply',['id'=>$line['id'],'status'=>$line['status']])}}">编辑</a>
          @endif
      </div>
    </div>
@endforeach

  <!--  <ul class="tab-shops-list-box" data-ajax-load id="tab-box">
        @foreach($list as $line)
            <li>
                <ul class="info">
                    <li><i class="icon icon-warning2"></i>{{$line['title']}}</li>
                    <li><i class="icon icon-warning2"></i>{{$line['integral']}}分</li>
                    <li><i class="icon icon-warning2"></i>{{$line['shop_name']}}</li>
                    <li><i class="icon icon-warning2"></i>{{$line['type_name']}}</li>
                </ul>
                <a href="{{route('employee.coupon.apply',['id'=>$line['id']])}}" class="list-btn">编辑</a>
            </li>
        @endforeach
    </ul> -->
@endsection