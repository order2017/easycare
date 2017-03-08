<?php
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <div class="verify-box">
        <i class="icon icon-time"></i>
        <p>您确认兑换此商品吗？</p>
        <form method="post" data-normal>
            {!! csrf_field() !!}
            <button class="confirm-btn">确认</button>
        </form>
        <form method="post" data-normal>
            {!! csrf_field() !!}
            {{ method_field('DELETE') }}
            <button class="cancel-btn">取消</button>
        </form>
    </div>
@endsection