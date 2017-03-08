<?php
view()->share('htmlClass', 'full-screen');
view()->share('bodyClass', 'full-screen');
?>
@extends('layouts.admin-base')
@section('body')
    <div class="lion-header">
        <a class="lion-header-logo" href="{{url('/admin/')}}"></a>
        <div class="am-dropdown am-fr" data-am-dropdown>
            <div class="am-dropdown-toggle"
                 data-am-dropdown-toggle>超级管理员 <span class="am-icon-caret-down"></span></div>
            <ul class="am-dropdown-content">
                <li><a href="{{route('admin.change-password')}}">修改密码</a></li>
                <li><a href="{{route('admin.logout')}}">注销</a></li>
            </ul>
        </div>
        <div class="lion-header-message"></div>
    </div>
    <div class="lion-main">
        <div class="lion-sidebar">
            <ul class="lion-sidebar-menu">
                @foreach(\App\AdminMenu::sidebar() as $menu)
                    <li @if($menu['is_active']) class="active current" @endif>
                        <span>{{$menu['name']}}</span>
                        @if(isset($menu['children']))
                            <ul class="lion-sidebar-sub-menu">
                                @foreach($menu['children'] as $subMenu)
                                    <li @if($subMenu['is_active']) class="current" @endif>
                                        <a href="{{route($subMenu['url'])}}">
                                            <i class="{{$subMenu['icon']}} am-icon-fw"></i>{{$subMenu['name']}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="lion-content" id="content">
            @yield('content')
        </div>
    </div>
    <div class="am-modal am-modal-no-btn" tabindex="-1" id="modal-write-box">
        <div class="am-modal-dialog">
            <div class="am-modal-bd">

            </div>
        </div>
    </div>
    <div class="am-modal am-modal-confirm" tabindex="-1" id="delete-confirm">
        <div class="am-modal-dialog">
            <div class="am-modal-hd">伊斯卡尔管理系统</div>
            <div class="am-modal-bd">
                确定要删除这条记录吗？
            </div>
            <div class="am-modal-footer">
                <span class="am-modal-btn" data-am-modal-cancel>取消</span>
                <span class="am-modal-btn" data-am-modal-confirm>确定</span>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{assets('js/admin.js')}}" type="text/javascript"></script>
@endsection