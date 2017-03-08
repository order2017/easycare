<?php
view()->share('bodyClass', 'gray');
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <div class="tab-nav">
        <a href="{{route('user.favourites',['type'=>'goods'])}}" @if($type == 'goods')class="active" @endif>收藏的商品</a>
        <div class="line"></div>
        <a href="{{route('user.favourites',['type'=>'shop'])}}"  @if($type == 'shop')class="active" @endif>收藏的店铺</a>
        <div class="line"></div>
        <a href="{{route('user.favourites',['type'=>'coupon'])}}"  @if($type == 'coupon')class="active" @endif>收藏的优惠券</a>
    </div>
    <div class="favourite-total" @if(!empty($count['type'])) style="display: none" @endif>您还没有收藏哦>_< </div>
    <div class="favourite-total" @if(empty($count['type'])) style="display: none" @endif>您收藏了<b>{{$count['count_favor']}}</b>个</div>
    <div class="tab-box" @if($type != 'goods') style="display: none" @endif>
        @foreach($list as $line)
            <div class="user-favourite-list" >
                <div class="user-favourite-img">
                  @if(!empty($line['goods_id']))<img src="{{$line['goods_thumb_url']}}" alt=""> @endif
                </div>
                <div class="user-favourite-info">
                    <div class="user-favourite-goods"> @if(!empty($line['goods_id'])){{$line['goods_name']}} @endif</div>
                    <div class="user-favourite-integral">
                        <b> @if(!empty($line['goods_id'])){{$line['integral']}}@endif </b>积分
                    </div>
                    <a href="{{route('collection.delete',['id' => $line['id']])}}" class="user-favourite-btn">取消收藏</a>
                    <a href="{{route('goods.page',['id' => $line['goods_id']])}}" class="user-favourite-btn">立即兑换</a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="tab-box"  @if( $type != 'shop' ) style="display: none" @endif >
        @foreach($list as $line)
            <div class="user-favourite-list" >
                  <div class="user-favourite-img">
                   @if(!empty($line['shop_id']))<img src="{{$line['shop_thumb_url']}}" alt=""> @endif
                  </div>
                  <div class="user-favourite-info">
                      <div class="user-favourite-goods"> @if(!empty($line['shop_id'])){{$line['shop_name']}} @endif</div>
                      <div class="user-favourite-integral">
                           <b> @if(!empty($line['shop_id'])){{$line['intro']}}@endif </b>
                      </div>
                      <a href="{{route('collection.delete',['id' => $line['id']])}}" class="user-favourite-btn">取消收藏</a>
                  </div>
            </div>
        @endforeach
    </div>
    <div class="tab-box"  @if( $type != 'coupon' ) style="display: none" @endif >
        @foreach($list as $line)
            <div class="user-favourite-list" >
                <div class="user-favourite-img">
                    @if(!empty($line['coupon_id']))<img src="{{$line['coupon_thumb_url']}}" alt="">@endif
                </div>
                <div class="user-favourite-info">
                    <div class="user-favourite-goods"> @if(!empty($line['coupon_id'])){{$line['title']}} @endif</div>
                    <div class="user-favourite-integral">
                        <b> @if(!empty($line['coupon_id'])){{$line['coupon_integral']}}分@endif </b>
                    </div>
                    <a href="{{route('collection.delete',['id' => $line['id']])}}" class="user-favourite-btn">取消收藏</a>
                    <a href="{{route('coupon.page',['id' => $line['goods_id']])}}" class="user-favourite-btn">立即兑换</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection