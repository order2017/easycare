<?php
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <div class="tips-box warning">
        <i class="icon icon-warning"></i>
        <b>重复提交</b>
        <small>您的申请已提交，请耐心等待!</small>
    </div>
@endsection