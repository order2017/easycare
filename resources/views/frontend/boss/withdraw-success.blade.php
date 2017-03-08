<?php
view()->share('nav', false);
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <div class="tips-box success">
        <i class="icon icon-time"></i>
        <b>提现申请已提交</b>
        <small>请注意查收微信账户。</small>
    </div>
    <a href="{{route('boss.withdraw.apply')}}" class="btn">返回</a>
@endsection