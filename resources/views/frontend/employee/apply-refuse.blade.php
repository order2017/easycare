<?php
view()->share('bodyClass', 'gray');
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <form action="" method="post">
        {{csrf_field()}}
        <div class="reason-box">不通过的原因：{{$model['reason']}}</div>
        <div class="user-info-title">基本资料</div>
        <div class="block">
            <div class="form-group" id="childName">
                <label class="form-label">姓名</label>
                <input type="text" name="name" class="form-control" value="{{$model['name']}}" placeholder="请输入名称">
            </div>
            <div class="form-group" id="childBirthday">
                <label class="form-label">手机号码</label>
                <input type="number" name="mobile" value="{{$model['mobile']}}" class="form-control"
                       placeholder="请输入手机号码">
            </div>
        </div>
        <div class="user-info-title">补充资料</div>
        <div class="block">
            <div class="form-group" id="childName">
                <label class="form-label">角色</label>
                <select name="role" id="employee-apply-role-select" class="form-control">
                    @foreach(\App\ShopStaffApply::roleList() as $roleId=>$role)
                        <option value="{{$roleId}}" @if($roleId == $model['role']) selected @endif>{{$role}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" id="boss_id"
                 @if($model['role'] == \App\User::ROLE_BOSS) style="display: none" @endif>
                <label class="form-label">所属老板</label>
                <select name="boss_id" id="" class="form-control">
                    <option value="0">请选择所属老板</option>
                    @foreach(\App\Boss::whereEmployeesId(\Auth::user()->id)->get() as $boss)
                        <option value="{{$boss['id']}}"
                                @if($boss['id'] == $model['boss_id']) selected @endif>{{$boss['name']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">所属地区:</label>
                @widget('addressAreaBox',['province_id'=>$model['province_id'],'city_id'=>$model['city_id'],'county_id'=>$model['county_id']])
            </div>
        </div>
        <button class="btn ">保存</button>
    </form>
@endsection
