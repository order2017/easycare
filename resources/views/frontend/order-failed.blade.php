<?php
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <div class="tips-box warning">
        <i class="icon icon-warning"></i>
        <b>购买失败，积分不足</b>
    </div>
    <a href="{{route('goods.list')}}" class="btn">返回</a>
@endsection