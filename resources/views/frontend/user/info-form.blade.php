<?php
view()->share('bodyClass', 'gray');
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <form action="{{route('user.info')}}" method="post">
        {{csrf_field()}}
        <div class="user-info-title">个人资料</div>
        <div class="block">
            <div class="form-group" id="name">
                <label class="form-label">姓名</label>
                <input type="text" name="name" class="form-control" value="{{$user['name']}}" placeholder="请输入您的姓名">
            </div>
            <div class="form-group" id="sex">
                <label class="form-label">性别</label>
                <select name="sex" class="form-control">
                    <option value="10" @if($user['sex'] == \App\User::SEX_MAN) selected @endif>男</option>
                    <option value="20"  @if($user['sex'] == \App\User::SEX_WOMAN) selected @endif>女</option>
                </select>
            </div>
            <div class="form-group" id="birthday">
                <label class="form-label">生日</label>
                <input type="date" name="birthday" class="form-control" value="{{$user['birthday']}}">
            </div>
            <div class="form-group" id="mobile">
                <label class="form-label">手机</label>
                <input type="number" name="mobile" class="form-control" value="{{$user['mobile']}}" placeholder="请输入您的手机号码">
            </div>
        </div>
        <div class="user-info-title">宝贝资料</div>
        <div class="block">
            <div class="form-group" id="childName">
                <label class="form-label">姓名</label>
                <input type="text" name="childName" class="form-control" value="{{$user['childName']}}" placeholder="请输入宝贝姓名">
            </div>
            <div class="form-group" id="childSex">
                <label class="form-label">性别</label>
                <select name="childSex" class="form-control">
                    <option value="10" @if($user['childSex'] == \App\User::SEX_MAN) selected @endif>男</option>
                    <option value="20"  @if($user['childSex'] == \App\User::SEX_WOMAN) selected @endif>女</option>
                </select>
            </div>
            <div class="form-group" id="childBirthday">
                <label class="form-label">生日</label>
                <input type="date" name="childBirthday" value="{{$user['childBirthday']}}" class="form-control">
            </div>
        </div>
        <button class="btn ">保存</button>
    </form>
@endsection