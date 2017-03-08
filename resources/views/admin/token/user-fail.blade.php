<?php
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
<div class="tips-box warning">
    <i class="icon icon-warning"></i>
    <b>请使用绑定的微信号扫描</b>
</div>
@endsection