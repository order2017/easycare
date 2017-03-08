<?php
view()->share('bodyClass', 'gray');
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <div class="tab-box-none" @if($type == 1) style="display: none" @endif>
        暂无消息
    </div>
    <ul class="user-address-list">
        @foreach($list as $line)
            <li>
                <div class="user-address-list-name">{{$line['name']}}</div>
                <div class="user-address-list-mobile">{{$line['phone']}}</div>
                <a href="{{route('user.address.delete',['id'=>$line['id']])}}"><i class="icon icon-delete2"></i></a>
                <div class="user-address-list-detail">
                    {{$line['address']}}
                </div>
            </li>
        @endforeach
    </ul>
@endsection