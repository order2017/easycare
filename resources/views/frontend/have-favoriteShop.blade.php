<?php
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <div class="tips-box success">
        <i class="icon icon-sure"></i>
        <b>收藏失败</b>
        <small>你已经收藏过该商店啦。</small>
    </div>
    <a href="{{route('shop.page',['id'=>$id])}}" class="btn">返回</a>
@endsection