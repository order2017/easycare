<?php
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <div class="tips-box warning">
        <i class="icon icon-warning"></i>
        <b>当前二维码已被使用</b>
    </div>
    <div class="verify-tips">
        扫码时间：{{$barCode['last_verified_at']}}<br>
        扫码导购：{{$barCode['sale']['name']}}
    </div>
@endsection