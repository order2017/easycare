<?php
view()->share('bodyClass', 'gray');
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <form action="{{route('employee.coupon.apply.save',['id'=>$model['id']])}}" method="post">
        {{csrf_field()}}
        <div class="block">
            <div class="form-group" id="type">
                <label class="form-label">类型</label>
                <select name="type" id="employee-apply-role-select" class="form-control">
                    <option value="0">请选择优惠券类型</option>
                    @foreach(\App\CouponApply::typeList() as $typeId=>$type)
                        <option value="{{$typeId}}"
                                @if($typeId == $model['type']) selected @endif>{{$type}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group select" id="shop_name">
                <label class="form-label-shopApply">所属店铺:</label>
                <select name="shop_id" id="" class="form-control">
                    <option value="0">请选择所属店铺</option>
                    @foreach(\App\Shop::whereEmployeesId(Auth::user()->id)->get() as $shops)
                        <option value="{{$shops['id']}}"
                                @if($shops['id'] == $model['shop_id']) selected @endif>{{$shops['name']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" id="childName">
                <label class="form-label">标题</label>
                <input type="text" name="title" class="form-control" value="{{$model['title']}}" placeholder="请输入优惠劵标题">
            </div>
            <div class="form-group" id="childName">
                <label class="form-label">适用范围</label>
                <input type="text" name="scope" class="form-control" value="{{$model['scope']}}" placeholder="请输入优惠劵适用范围">
            </div>
            <div class="form-group" id="childName">
                <label class="form-label">使用条件</label>
                <input type="number" step="0.01" name="condition" class="form-control" value="{{$model['condition']}}" placeholder="请输入满多少元可用">
            </div>
            <div class="form-group" id="childName">
                <label class="form-label">抵扣金额</label>
                <input type="number" step="0.01" name="money" class="form-control" value="{{$model['money']}}" placeholder="请输入优惠劵可抵扣金额">
            </div>
            <div class="form-group" id="childName">
                <label class="form-label">折扣</label>
                <input type="number" step="0.1" name="discount" class="form-control" value="{{$model['discount']}}" placeholder="请输入优惠劵折扣">
            </div>
            <div class="form-group" id="childName">
                <label class="form-label">积分价值</label>
                <input type="number" name="integral" class="form-control" value="{{$model['integral']}}" placeholder="请输入优惠劵兑换所需积分">
            </div>
            <div class="form-group select" id="childName">
                <label class="form-label">有效类型</label>
                <select name="" id="" class="form-control">
                    <option value="1">固定时长</option>
                    <option value="2">固定日期</option>
                </select>
            </div>
            <div class="form-group select" id="childName">
                <label class="form-label">有效期</label>
                <input type="number" name="duration" class="form-control" value="{{$model['duration']}}" placeholder="请输入固定时长">
                <select name="" id="" class="form-control">
                    <option value="1">天</option>
                    <option value="2">时</option>
                    <option value="3">分</option>
                    <option value="4">秒</option>
                </select>
            </div>
            <div class="form-group" id="childName">
                <label class="form-label">有效期</label>
                <input type="datetime-local" name="begin_time" value="{{$model['begin_time']}}" class="form-control" placeholder="开始时间">
                <input type="datetime-local" name="end_time" value="{{$model['end_time']}}" class="form-control" placeholder="结束时间">
            </div>
        </div>
        <div class="line-title">上传照片</div>
        <div class="shop-upload-box">
            <div class="image-upload-box">
                <input type="hidden" name="thumb"  value="">
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
        </div>
        <button class="btn ">保存</button>
    </form>
@endsection
