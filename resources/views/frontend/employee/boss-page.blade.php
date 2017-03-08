<?php
view()->share('bodyClass', 'gray');
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <form action="" method="post">
        {{csrf_field()}}
        <div class="user-info-title">基本资料</div>
        <div class="block">
            <div class="form-group" id="name">
                <label class="form-label">姓名</label>
                <input type="text" name="name" class="form-control" value="{{$model['name']}}" placeholder="请输入名称">
            </div>
            <div class="form-group" id="mobile">
                <label class="form-label">手机号码</label>
                <input type="number" name="mobile" value="{{$model['mobile']}}" class="form-control"
                       placeholder="请输入手机号码">
            </div>
            <div class="form-group" id="role">
                <label class="form-label">角色</label>
                <div class="form-control-text">
                    {{$model['role_name']}}
                </div>
            </div>
        </div>
        <div class="block">
            <div class="form-group">
                <label class="form-label">所属地区:</label>
                @widget('addressAreaBox',['province_id'=>$model['province_id'],'city_id'=>$model['city_id'],'county_id'=>$model['county_id']])
            </div>
        </div>
        <button class="btn ">保存</button>
    </form>
@endsection
