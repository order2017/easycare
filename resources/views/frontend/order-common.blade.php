<div class="order-goods-info">
    <div class="order-goods-image">
        <img src="{{$goods['thumb_url']}}" alt="">
    </div>
    <div class="order-goods-text">
        <h3 class="order-goods-title">{{$goods['name']}}</h3>
        <div class="order-goods-integral"><b>{{$goods['price']}}</b>积分</div>
    </div>
</div>
<div class="order-goods-delivery-method">
    配送方式
    <span>{{$goods['delivery_method']}}</span>
</div>
<div class="order-goods-total">
    <div class="order-total-integral">商品总积分：<b>{{$goods['price']}}积分</b></div>
    <button class="btn">确定</button>
</div>
<div class="order-goods-logo">
    <img src="{{asset('/assets/images/logo.png')}}" alt="">
</div>
