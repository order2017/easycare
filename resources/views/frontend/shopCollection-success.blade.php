<?php
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <div class="tips-box success">
        <i class="icon icon-sure"></i>
        <b>收藏成功</b>
        <small>恭喜你收藏店铺成功。</small>
    </div>
    <a href="{{route('shop.page',['id'=>$id])}}" class="btn">返回</a>
@endsection