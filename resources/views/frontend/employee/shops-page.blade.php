<?php
view()->share('bodyClass', 'gray');
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <form method="post" class="padding-bottom-20">
        {{csrf_field()}}
        <div class="block">
            <div class="form-group" id="name">
                <label class="form-label-shopApply">店铺名称:</label>
                <input type="text" name="name" class="form-control" value="{{$model['name']}}" placeholder="请输入您的店铺名称">
            </div>
            <div class="form-group" id="landmark">
                <label class="form-label-shopApply">附近地标:</label>
                <input type="text" name="landmark" class="form-control" value="{{$model['landmark']}}" placeholder="请输入附近地标">
            </div>
            <div class="form-group" id="location">
                <label class="form-label-shopApply">所在地区:</label>
                @widget('addressAreaBox',['province_id'=>$model['province_id'],'city_id'=>$model['city_id'],'county_id'=>$model['county_id']])
            </div>
            <div class="form-group" id="address">
                <label class="form-label-shopApply">详细地址:</label>
                <input type="text" name="address" class="form-control" value="{{$model['address']}}" placeholder="请输入详细地址">
            </div>
            <div class="form-group" id="phone">
                <label class="form-label-shopApply">联系电话:</label>
                <input type="text" name="phone" class="form-control" value="{{$model['phone']}}" placeholder="请输入店铺联系电话">
            </div>
            <div class="form-group select" id="boss_id">
                <label class="form-label-shopApply" for="boss_id">店铺老板:</label>
                <select name="boss_id" id="boss_id" class="form-control">
                    <option value="0">请选择所属老板</option>
                    @foreach(\App\Boss::whereEmployeesId(\Auth::user()->id)->get() as $boss)
                        <option value="{{$boss['id']}}" @if($boss['id'] == $model['boss_id']) selected @endif>{{$boss['name']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" id="intro">
                <label class="form-label-shopApply">简介:</label>
                <input name="intro" id="intro"  value="{{$model['intro']}}" placeholder="请输入店铺简介">
            </div>
        </div>

        <div class="line-title">上传照片</div>
        <div class="shop-upload-box">
            <div class="image-upload-box">
                <input type="hidden" name="thumb" value="">
            </div>
            <div class="image-upload-box">
                <input type="hidden" name="images[]" value="">
            </div>
            <div class="image-upload-box">
                <input type="hidden" name="images[]" value="">
            </div>
            <div class="image-upload-box">
                <input type="hidden" name="images[]" value="">
            </div>
            <div class="image-upload-box">
                <input type="hidden" name="images[]" value="">
            </div>
            <div class="image-upload-box">
                <input type="hidden" name="images[]" value="">
            </div>
            <div class="shop-upload-intro">
                *首张照片为封面，其他照片为图文详情<br/>
                *最少可上传1张，最多6张<br/>
                *所有的照片横向拍摄，建议长高比例为4:3<br/>
            </div>
        </div>
        <button class="btn">提交申请</button>
    </form>
@endsection