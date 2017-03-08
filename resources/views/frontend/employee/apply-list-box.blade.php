<?php
$navActive = 'user';
view()->share('bodyClass', 'gray');
?>
@extends('layouts.wechat')
@section('content')
    <div class="tab-nav">
        <a href="{{route('employee.applies',['type'=>'wait'])}}" @if($type == 'wait') class="active" @endif>待处理</a>
        <div class="line"></div>
        <a href="{{route('employee.applies',['type'=>'approve'])}}" @if($type == 'approve') class="active" @endif>已通过</a>
        <div class="line"></div>
        <a href="{{route('employee.applies',['type'=>'refusal'])}}" @if($type == 'refusal') class="active" @endif>不通过</a>
    </div>
    <ul class="tab-list-box" data-ajax-load id="tab-box">
        @foreach($list as $line)
            <li>
                <ul class="info">
                    <li><i class="icon icon-people1"></i>{{$line['name']}}</li>
                    <li><i class="icon icon-phone"></i>{{$line['mobile']}}</li>
                </ul>
                @if($type == 'wait')
                    <a href="{{route('employee.apply.page',['id'=>$line['id']])}}" class="list-btn">补充资料</a>
                @elseif($type == 'refusal')
                    <a href="{{route('employee.apply.refuse.page',['id'=>$line['id']])}}" class="list-btn">修改资料</a>
                @endif
            </li>
        @endforeach
    </ul>
@endsection