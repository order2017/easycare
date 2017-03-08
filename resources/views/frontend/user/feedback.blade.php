<?php
view()->share('bodyClass', 'gray');
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <form  method="post">
        {{csrf_field()}}
        <div class="feedback-form-box">
            <div class="form-group">
                <label for="type">反馈类型</label>
                <select name="type" id="type" >
                    @foreach(\App\FeedBack::typeList() as $typeId=>$type)
                    <option value="{{$typeId}}">{{$type}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="content">反馈内容</label>
                <textarea name="content" id="content">

            </textarea>
            </div>
            <div class="form-group">
                <label for="contact">联系方式</label>
                <input type="text" name="mobile" id="contact">
            </div>
            <button class="btn">提交</button>
        </div>
    </form>
@endsection