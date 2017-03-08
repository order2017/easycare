<?php
view()->share('bodyClass', 'gray');
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <form action="{{route('employee.goods.page.save',['id'=>$model['id']])}}" method="post">
        {{csrf_field()}}
        <div class="user-info-title">基本资料</div>
        <div class="block">
            <div class="form-group" id="childName">
                <label class="form-label">商品名称</label>
                <input type="text" name="name" class="form-control" value="{{$model['name']}}" placeholder="请输入商品名称">
            </div>
            <div class="form-group" id="childBirthday">
                <label class="form-label">现价</label>
                <input type="number" name="price" value="{{$model['price']}}" class="form-control"
                       placeholder="请输入现价格">
            </div>
            <div class="form-group" id="childBirthday">
                <label class="form-label">原价</label>
                <input type="text" name="original_price" value="{{$model['original_price']}}" class="form-control"
                       placeholder="请输入原价格">
            </div>
        </div>
        <div class="user-info-title">补充资料</div>
        <div class="block">
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
            <div class="form-group" id="childBirthday">
                <label class="form-label">库存</label>
                <input type="text" name="inventory" value="{{$model['inventory']}}" class="form-control"
                       placeholder="请输入库存数量">
            </div>
            <div class="form-group" id="goods_id" >
                <label class="form-label">商品介绍</label>
                <input type="text" name="intro" class="form-control" value="{{$model['intro']}}" placeholder="简介">
            </div>
        </div>
        <button class="btn ">保存</button>
    </form>
@endsection
