<?php
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <div class="tips-box success">
        <i class="icon icon-sure"></i>
        <b>兑换成功</b>
    </div>
    @if(Auth::user()->is_boss)
        <div class="verify-tips">
            您已获得<span class="red">{{$integral}}</span>积分<br>
        </div>
        <a href="{{route('boss.record.integral')}}" class="btn">立即查看</a>
    @endif
@endsection