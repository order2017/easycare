<?php
view()->share('bodyClass', 'gray');
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <div class="tab-nav two">
        <a href="{{route('user.comments.wait')}}">待评价</a>
        <div class="line"></div>
        <a href="{{route('user.comments.has')}}" class="active">已评价</a>
    </div>
    <div class="tab-box-none" @if($type == 1) style="display: none" @endif>
        暂无消息
    </div>
    <div class="tab-box">
        @foreach($list as $line)
            <div class="user-comment-list">
                <a class="user-comment-goods">
                    <div class="user-comment-goods-img">
                        <img src="{{$line['goods']['thumb_url']}}" alt="">
                    </div>
                    <div class="user-comment-score">{{$line['point']}}分</div>
                    <div class="user-comment-goods-name">{{$line['goods']['name']}}</div>
                </a>
                <div class="user-comment-content">
                    {{$line['content']}}
                </div>
                <div class="user-comment-time">{{$line['created_at']}}</div>
            </div>
        @endforeach
    </div>
@endsection