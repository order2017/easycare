<?php
view()->share('bodyClass', 'gray');
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <div class="tab-box-none" @if($type == 1) style="display: none" @endif>
        暂无消息
    </div>
    <ul class="user-message-list">
        @foreach($list as $line)
            <li>
                <div class="user-message-list-time">{{$line['created_at']}}</div>
                <div class="user-message-list-content">{{$line['title']}}</div>
            </li>
        @endforeach
    </ul>
@endsection