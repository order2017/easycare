<?php
view()->share('bodyClass', 'gray');
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <form method="post" class="padding-bottom-20">
        {{csrf_field()}}
        <input type="hidden" name="goods_id" value="{{$model['id']}}">
        <div class="block-shop-apply">
            <div class="form-group" id="name">
                <label class="form-label-shopApply">商品名称:</label>
                <input type="text" name="name" class="form-control" value="{{$model['name']}}" placeholder="请输入商品名称">
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
            <div class="form-group" id="address">
                <label class="form-label-shopApply">价&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp格:</label>
                <input type="number" step="0.01" name="price" class="form-control" value="{{$model['price']}}" placeholder="现价">
            </div>
            <div class="form-group" id="phone">
                <label class="form-label-shopApply">原&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp价:</label>
                <input type="number" step="0.01" name="original_price" class="form-control" value="{{$model['original_price']}}" placeholder="原价">
            </div>
            <div class="form-group" id="phone">
                <label class="form-label-shopApply">库&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp存:</label>
                <input type="number" name="inventory" class="form-control" value="{{$model['inventory']}}"  placeholder="库存">
            </div>
            <div class="form-group" id="goods_id" >
                <label class="form-label">商品介绍</label>
                <input type="text" name="intro" class="form-control" value="{{$model['intro']}}" placeholder="简介">
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