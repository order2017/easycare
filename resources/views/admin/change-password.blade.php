@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">新增/修改活动</h3>
    </div>
    <form method="post" class="am-form" action="">
        <div class="am-g">
            <div class="am-u-sm-6">
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">旧密码</label>
                    <input type="password" name="old_password" id="doc-ipt-email-1"
                           placeholder="请输入旧密码">
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">新密码</label>
                    <input type="password" name="new_password" id="doc-ipt-email-1"
                           placeholder="请输入新密码">
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">确认新密码</label>
                    <input type="password" name="new_password_confirmation" id="doc-ipt-email-1"
                           placeholder="请输入确认新密码">
                </div>
            </div>
        </div>
        <div class="am-g">
            <div class="am-u-sm-6 am-text-center">
                <button class="am-btn am-btn-primary inline-block">修改密码</button>
            </div>
        </div>
    </form>
@endsection