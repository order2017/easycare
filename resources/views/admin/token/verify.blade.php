<?php
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <div class="verify-box">
        <i class="icon icon-time"></i>
        <p>您确认登录伊斯卡尔<br>管理系统吗？</p>
        <form method="post">
            {!! csrf_field() !!}
            <button class="confirm-btn">确认</button>
        </form>
        <form method="post">
            {!! csrf_field() !!}
            {{ method_field('DELETE') }}
            <button class="cancel-btn">取消</button>
        </form>
    </div>
@endsection