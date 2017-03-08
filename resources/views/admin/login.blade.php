<?php
view()->share('bodyClass', 'login');
view()->share('htmlClass', 'login-html');
?>

@extends('layouts.admin-base')
@section('body')
    <div class="login-box">
        <div class="logo"></div>
        <h1>欢迎使用EasyCare管理系统</h1>
        <div class="login-form">
            <form method="post" id="login-form">
                <div class="login-error"></div>
                <div class="form-group">
                    <label for=""><i class="icon-personal"></i></label>
                    <input type="text" name="username" placeholder="请输入账号">
                </div>
                <div class="form-group">
                    <label for=""><i class="icon-lock"></i></label>
                    <input type="password" name="password" placeholder="请输入密码">
                </div>
                <button class="login-btn">登录</button>
            </form>
        </div>
        <div class="login-code">
            <p class="tips">请打开微信扫一扫 <br>扫描下方二维码进行身份验证</p>
            <p>更换登录帐号，请点击<a href="javascript:" id="close-login-code">此处</a></p>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{assets('js/login.js')}}" type="text/javascript"></script>
@endsection