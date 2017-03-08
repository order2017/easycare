<?php
view()->share('bodyClass', 'gray');
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <a href="{{route('goods.list')}}" class="user-commission-top">
        <img src="{{asset('/assets/images/member-commission.png')}}" alt="">
    </a>
    <div class="user-commission-info">
        <div class="user-commission-total">
            <div class="user-commission-total-title">累计获得</div>
            <div class="user-commission-total-amount">{{\App\CommissionBlotter::whereUserId(Auth::user()->id)->where('status','=',40 )->orWhere('status','=',60)->where('numerical','>=','0')->sum('numerical')}}元</div>
            <div class="user-commission-total-count">{{\App\CommissionBlotter::whereUserId(Auth::user()->id)->where('status','=',40 )->orWhere('status','=',60)->where('numerical','>=','0')->count()}}笔</div>
        </div>
        <div class="user-commission-max">
            <div class="user-commission-max-title">历史最佳红包</div>
            <div class="user-commission-max-amount">{{\App\CommissionBlotter::whereUserId(Auth::user()->id)->where('status','=',40 )->orWhere('status','=',60)->where('numerical','>=','0')->orderBy('numerical','desc')->value('numerical')}}元</div>
        </div>
    </div>
    <div class="user-commission-list-box">
        <div class="user-commission-list-title">红包账单</div>
        <ul class="user-commission-list">
            @foreach($list as $line)
                <li>
                    <div class="user-commission-list-info">
                        <div class="user-commission-list-info-left">
                            <div class="title">流水：{{$line['serial_number']}}</div>
                            <div>{{$line['created_at']}}</div>
                        </div>
                        <div class="user-commission-list-info-right">
                            <div class="title">红包积分</div>
                            <div>{{$line['numerical']}}元</div>
                        </div>
                    </div>
                    <div class="user-commission-list-status">
                        <div class="title">状态</div>
                        <div>{{$line['status_text']}}</div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection