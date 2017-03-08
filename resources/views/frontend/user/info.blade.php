<?php
view()->share('bodyClass', 'gray');
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <div class="user-info">
        <div class="user-info-title">个人资料</div>
        <ul class="user-info-box">
            <li><label>姓名:</label>{{$info['name'] or ''}}</li>
            <li><label>性别:</label>{{$info['sex_text'] or ''}}</li>
            <li><label>生日:</label>{{$info['birthday'] or ''}}</li>
            <li><label>电话:</label>{{$info['mobile'] or ''}}</li>
        </ul>
    </div>
    <div class="user-info">
        <div class="user-info-title">宝贝资料</div>
        <ul class="user-info-box">
            <li><label>姓名:</label>{{$info['childName'] or ''}}</li>
            <li><label>性别:</label>{{$info['child_sex_text'] or ''}}</li>
            <li><label>生日:</label>{{$info['childBirthday'] or ''}}</li>
        </ul>
    </div>
    <form action="{{route('user.info')}}" data-normal method="post">
        {{method_field('PUT')}}
        {{csrf_field()}}
        <button class="btn">修改资料</button>
    </form>
@endsection