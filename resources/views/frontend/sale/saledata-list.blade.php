<?php
view()->share('bodyClass', 'gray');
?>
@extends('layouts.wechat')
@section('content')
    <div class="user-center-top">
        销售数据分析
    </div>
    <div class="user-center-menu-box">
        <a href="{{route('sale.data.total')}}" class="user-center-menu"><i
                    class="icon icon-integralrecord introduce color-2d9cd8"></i>总体销售数据</a>
    </div>
@endsection