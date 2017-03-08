<?php
view()->share('bodyClass', 'gray');
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <div class="tips-box success">
        <i class="icon icon-sure"></i>
        <b>评论成功</b>
    </div>
    <a href="{{route('user.comments.has')}}" class="btn">返回</a>
@endsection