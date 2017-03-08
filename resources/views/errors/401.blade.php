<?php
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <div class="tips-box warning">
        <i class="icon icon-warning"></i>
        <b>您没有权限访问此页面</b>
    </div>
@endsection