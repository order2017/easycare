<?php
view()->share('bodyClass', 'gray');
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <form method="post" class="padding-bottom-20">
        {{csrf_field()}}
        <input type="hidden" name="coupon_id" value="{{$model['id']}}">
        <div class="block-shop-apply">
            <div class="form-group" id="address">
                <label class="form-label-shopApply">标&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp题:</label>
                <input type="text" name="title" class="form-control"  value="{{$model['title']}}" placeholder="20个汉子以内">
            </div>
            <div class="form-group" id="type">
                <label class="form-label">类型</label>
                <select name="type" id="employee-coupon-type-select" class="form-control">
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
            <div class="form-group" id="scope">
                <label class="form-label-shopApply">适用范围:</label>
                <input type="text" name="scope" class="form-control" value="{{$model['scope']}}" placeholder="请输入使用范围">
            </div>
            <div class="form-group" id="condition">
                <label class="form-label-shopApply">使用条件:</label>
                <input type="number" step="0.01" name="condition" class="form-control" value="{{$model['condition']}}" placeholder="请输入使用条件">
            </div>
            <div class="form-group" id="money"
                 @if($model['type']!= \App\CouponApply::TYPE_DIYONGQUAN) style="display: none" @endif>
                <label class="form-label-shopApply">抵扣金额:</label>
                <input type="number" step="0.01" name="money" class="form-control"  value="{{$model['money']}}"  placeholder="请输入抵扣金额">
            </div>
            <div class="form-group" id="discount-money"
                 @if($model['type']!= \App\CouponApply::TYPE_ZHEKOUQUAN) style="display: none" @endif>
                <label class="form-label-shopApply">折扣:</label>
                <input type="number" name="discount" class="form-control" value="{{$model['discount']}}" placeholder="请输入折扣数">
            </div>
            <div class="form-group" id="phone">
                <label class="form-label-shopApply">积分价值:</label>
                <input type="number" name="integral" class="form-control" value="{{$model['integral']}}"  placeholder="请输入需兑换的积分">
            </div>
            <div class="form-group" id="time_type">
                <label class="form-label" for="employee-couponApply-role-select">有效类型:</label>
                <select name="time_type" id="employee-couponApply-role-select" class="form-control">
                    @foreach(\App\CouponApply::timeLimit() as $timeId=>$time)
                        <option value="{{$timeId}}"
                                @if($timeId == $model['time_type']) selected @endif>{{$time}}</option>
                    @endforeach
                </select>
            </div>
            <div class="sale-commission-filter form-group" id="time-term"
                 @if($model['time_type']!= \App\CouponApply::TIME_TERM) style="display: none" @endif>
                <label class="form-label-shopApply">固定时间:</label>
                <input type="datetime-local" name="begin_time" value="{{$model['begin_time']}}" placeholder="开始时间">
                -
                <input type="datetime-local" name="end_time" value="{{$model['end_time']}}"   placeholder="结束时间">
            </div>
            <div class="form-group" id="time-length"
                 @if($model['time_type']!= \App\CouponApply::TIME_LENGTH) style="display: none" @endif>
                <label class="form-label-shopApply">固定时长:</label>
                <input type="number" name="duration" class="form-control" value="{{$model['duration']}}" placeholder="请输入有效时长(单位:秒)">
            </div>
        </div>
        <div class="line-title">上传照片</div>
        <div class="shop-upload-box">
            <div class="image-upload-box  @if(!empty($model['thumb'])) active @endif">
                <input type="hidden" name="thumb" value="{{$model['thumb']}}">
                @if(!empty($model['thumb']))
                    <img src="{{route('widget.images',['name'=>$model['thumb']])}}" alt="">
                @endif
            </div>
            @for($i=0;$i<=4;$i++)
                <div class="image-upload-box @if(!empty($model['images'][$i])) active @endif">
                    <input type="hidden" name="images[]" value="{{$model['images'][$i]}}">
                    @if(!empty($model['images'][$i]))
                        <img src="{{route('widget.images',['name'=>$model['images'][$i]])}}" alt="">
                    @endif
                </div>
            @endfor
            <div class="shop-upload-intro">
                *首张照片为封面，其他照片为图文详情<br/>
                *最少可上传1张，最多6张<br/>
                *所有的照片横向拍摄，建议长高比例为4:3<br/>
            </div>
        </div>
        <button class="btn">发布</button>
    </form>
@endsection