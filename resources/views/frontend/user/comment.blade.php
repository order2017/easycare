<?php
view()->share('bodyClass', 'gray');
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <form action="{{route('user.comment',['id' => $model['id']])}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="point" value="5" id="comment-score">
        <div class="comment-goods">
            <div class="comment-goods-img">
                <img src="{{$model['goods']['thumb_url']}}" alt="">
            </div>
            <div class="comment-goods-name">
                {{$model['goods']['name']}}
            </div>
        </div>
        <textarea name="content" class="comment-write-box" placeholder="写点心得给其他顾客参考吧！"></textarea>
        <div class="comment-upload">
            <div class="comment-upload-title">添加图片
                <small>(您最多可以上传3张图片)</small>
            </div>
            <div class="shop-upload-box">
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
        </div>
        <div class="comment-score">
            <div class="comment-score-name">评分</div>
            <div class="comment-score-input" >
                <i class="active"></i>
                <i class="active"></i>
                <i class="active"></i>
                <i class="active"></i>
                <i class="active"></i>
            </div>
        </div>
        <button class="btn">发表</button>
    </form>
@endsection