<?php
$navActive = 'index';
?>
@extends('layouts.wechat')
@section('content')
    <div class="tab-nav">
        <a href="{{route('shop.list',['type'=>'all'])}}" data-auto-load
           data-ajax-list @if($type == 'all')class="active" @endif>全部</a>
        <div class="line"></div>
        <a href="{{route('shop.list',['type'=>'Newest'])}}" data-ajax-list @if($type == 'Newest')class="active" @endif>最新</a>
        <div class="line"></div>
        <a href="{{route('shop.list',['type'=>'Popularity'])}}" data-ajax-list @if($type == 'Popularity')class="active" @endif>人气</a>
    </div>
    <div class="shop-list-box">
        @foreach($list as $line)
            <a href="{{route('shop.page',['id'=>1])}}">
                <div class="shop-list-img">
                    <img src="{{$line['thumb_url']}}" alt="">
                </div>
                <div class="shop-list-info">
                    <h3>{{$line['name']}}</h3>
                    <div class="shop-list-intro">
                       {{$line['intro']}}
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endsection