<?php
view()->share('bodyClass', 'gray');
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <div class="apply-employee-top">
        填写申请资料
    </div>
    <form method="post" class="padding-bottom-20">
        {{csrf_field()}}
        @if(!empty($apply['reason']))
            <div class="reason-box">{{$apply['reason']}}</div>
        @endif
        <div class="block">
            <div class="form-group" id="name">
                <label class="form-label">姓名</label>
                <input type="text" name="name" class="form-control" value="{{$apply['name']}}" placeholder="请输入您的姓名">
            </div>
            <div class="form-group" id="mobile">
                <label class="form-label">手机</label>
                <input type="text" name="mobile" class="form-control" value="{{$apply['mobile']}}"
                       placeholder="请输入您的手机号码">
            </div>
            <div class="form-group" id="email">
                <label class="form-label">邮箱</label>
                <input type="text" name="email" class="form-control" value="{{$apply['email']}}"
                       placeholder="请输入您的电子邮箱">
            </div>
            <div class="form-group">
                <label class="form-label">所属地区:</label>
                @widget('addressAreaBox',['province_id'=>$apply['province_id'],'city_id'=>$apply['city_id'],'county_id'=>$apply['county_id']])
            </div>
            <div class="form-group" id="address">
                <label class="form-label">地址</label>
                <input type="text" name="address" class="form-control" value="{{$apply['address']}}"
                       placeholder="请输入您的工作地址">
            </div>
            <div class="form-group select" id="departments_id">
                <label class="form-label">部门</label>
                <select name="departments_id" class="form-control">
                    @foreach(\App\Department::all() as $department)
                        <option value="{{$department['id']}}"
                                @if($apply['departments_id'] == $department['id']) selected @endif>{{$department['name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button class="btn">提交申请</button>
    </form>
@endsection