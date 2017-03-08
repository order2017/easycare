<?php
view()->share('nav', false);
view()->share('bodyClass', 'gray');
?>
@extends('layouts.wechat')
@section('content')
    <div class="shop-staff-apply-logo"></div>
    <div class="shop-staff-apply-text">填写资料成为老板/导购</div>
    <form method="post">
        {{csrf_field()}}
        <div class="block">
            <div class="form-group" id="name">
                <label class="form-label">姓名</label>
                <input type="text" name="name" class="form-control" placeholder="请输入您的姓名">
            </div>
            <div class="form-group" id="mobile">
                <label class="form-label">手机</label>
                <input type="text" name="mobile" class="form-control" placeholder="请输入您的手机号码">
            </div>
        </div>
        <button class="btn">提交申请</button>
    </form>
@endsection