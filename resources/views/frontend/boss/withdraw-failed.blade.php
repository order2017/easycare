<?php
view()->share('nav', false);
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <div class="tips-box warning">
        <i class="icon icon-warning"></i>
        <b>提交申请失败</b>
        <small>今天提现额度已达上限，请稍后再试。</small>
    </div>
    <a href="javascript:history.back(-1);" class="btn">返回</a>
@endsection