<!DOCTYPE html>
<html lang="en" class="page-load">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .page-load, .page-load body {
            overflow: hidden
        }

        .page-load body > * {
            visibility: hidden
        }

        .page-load #loading_layer {
            visibility: visible;
            display: block !important;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #fff;
            z-index: 10000;
            text-align: center;
        }

        .spinner {
            position: fixed;
            top: 50%;
            left: 50%;
            margin: -50px 0 0 -30px;
            width: 60px;
            height: 100px;
            text-align: center;
            font-size: 10px;
        }

        .spinner > div {
            background-color: #55b6c4;
            height: 100%;
            width: 6px;
            display: inline-block;

            -webkit-animation: stretchdelay 1.2s infinite ease-in-out;
            animation: stretchdelay 1.2s infinite ease-in-out;
        }

        .spinner .rect2 {
            -webkit-animation-delay: -1.1s;
            animation-delay: -1.1s;
        }

        .spinner .rect3 {
            -webkit-animation-delay: -1.0s;
            animation-delay: -1.0s;
        }

        .spinner .rect4 {
            -webkit-animation-delay: -0.9s;
            animation-delay: -0.9s;
        }

        .spinner .rect5 {
            -webkit-animation-delay: -0.8s;
            animation-delay: -0.8s;
        }

        @-webkit-keyframes stretchdelay {
            0%, 40%, 100% {
                -webkit-transform: scaleY(0.4)
            }
            20% {
                -webkit-transform: scaleY(1.0)
            }
        }

        @keyframes stretchdelay {
            0%, 40%, 100% {
                transform: scaleY(0.4);
                -webkit-transform: scaleY(0.4);
            }
            20% {
                transform: scaleY(1.0);
                -webkit-transform: scaleY(1.0);
            }
        }

        .page-load .tab-pane {
            display: block !important
        }

        .page-load .hide {
            display: inherit
        }
    </style>
    <link rel="stylesheet" href="{{ assets('css/all.css') }}">
    @yield('css')
</head>
<body class="{{$bodyClass or ''}} {{(isset($nav) && $nav==false) ? 'not-nav' : ''}}">
@if((isset($nav) ? $nav : true))
    <div class="nav-bar">
        <a href="{{route('index')}}" @if($navActive == 'index') class="active" @endif>
            <i class="icon icon-home"></i>首页
        </a>
        <a href="{{route('goods.list')}}" @if($navActive == 'goods') class="active" @endif>
            <i class="icon icon-shop3"></i>换商品
        </a>
        <a href="{{route('coupon.list')}}" @if($navActive == 'coupon') class="active" @endif>
            <i class="icon icon-coupon1"></i>优惠劵
        </a>
        <a href="{{route('user.index')}}" @if($navActive == 'user') class="active" @endif>
            <i class="icon icon-people"></i>个人中心
        </a>
    </div>
@endif
<div id="loading_layer" style="display:none">
    <div class="spinner">
        <div class="rect1"></div>
        <div class="rect2"></div>
        <div class="rect3"></div>
        <div class="rect4"></div>
        <div class="rect5"></div>
    </div>
</div>
@yield('content')
<div id="alert-message"></div>
<div id="alert-confirm"></div>
<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    wx.config({!! app('wechat')->js->config(['onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareWeibo','onMenuShareQZone','startRecord','stopRecord','onVoiceRecordEnd','playVoice','pauseVoice','stopVoice','onVoicePlayEnd','uploadVoice','downloadVoice','chooseImage','previewImage','uploadImage','downloadImage','translateVoice','getNetworkType','openLocation','getLocation','hideOptionMenu','showOptionMenu','hideMenuItems','showMenuItems','hideAllNonBaseMenuItem','showAllNonBaseMenuItem','closeWindow','scanQRCode','chooseWXPay','openProductSpecificView','addCard','chooseCard','openCard']) !!});
</script>
<script src="{{assets('js/all.js')}}" type="text/javascript"></script>
@yield('script')
<script>
    (function (d, c) {
        var e = d.documentElement, b = "orientationchange" in window ? "orientationchange" : "resize", a = function () {
            var f = e.clientWidth;
            if (!f) {
                return
            }
            e.style.fontSize = 100 * (f / 640) + "px"
        };
        if (!d.addEventListener) {
            return
        }
        c.addEventListener(b, a, false);
        d.addEventListener("DOMContentLoaded", a, false)
    })(document, window);
    $(window).load(function () {
        $("html").removeClass("page-load")
    });</script>
</body>
</html>