<?php
view()->share('bodyClass', 'gray');
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <form action="{{route('employee.shopApplyRefuse.page',['id'=>$model['id']])}}" method="post">
        {{csrf_field()}}
        <div class="reason-box">{{$model['reason']}}</div>
        <div class="user-info-title">基本资料</div>
        <div class="block">
            <div class="form-group" id="childName">
                <label class="form-label">店铺名称</label>
                <input type="text" name="name" class="form-control" value="{{$model['name']}}" placeholder="请输入店铺名称">
            </div>
            <div class="form-group" id="childBirthday">
                <label class="form-label">电话号码</label>
                <input type="number" name="phone" value="{{$model['phone']}}" class="form-control"
                       placeholder="请输入电话号码">
            </div>
            <div class="form-group" id="childBirthday">
                <label class="form-label">详细地址</label>
                <input type="text" name="address" value="{{$model['address']}}" class="form-control"
                       placeholder="请输出详细地址">
            </div>
        </div>
        <div class="user-info-title">补充资料</div>
        <div class="block">
            <div class="form-group" id="boss_id" >
                <label class="form-label">所属老板ID</label>
                <select name="boss_id" id="" class="form-control">
                    <option value="0">请选择所属老板</option>
                    @foreach(\App\Boss::whereEmployeesId(\Auth::user()->id)->get() as $boss)
                        <option value="{{$boss['id']}}"
                                @if($boss['id'] == $model['boss_id']) selected @endif>{{$boss['name']}}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" id="shop_intro" >
                <label class="form-label">店铺介绍</label>
                <input type="text" name="intro" class="form-control" value="{{$model['intro']}}" placeholder="简介">
            </div>
            <div class="form-group">
                <label class="form-label">所属地区:</label>
                @widget('addressAreaBox',['province_id'=>$model['province_id'],'city_id'=>$model['city_id'],'county_id'=>$model['county_id']])
            </div>
        </div>
        <button class="btn ">保存</button>
    </form>
@endsection
