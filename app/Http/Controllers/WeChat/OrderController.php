<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/7/8
 * Time: 16:37
 */

namespace App\Http\Controllers\WeChat;


use App\Coupon;
use App\Goods;
use App\Http\Controllers\Controller;
use App\Http\Requests\DirectOrderRequest;
use App\Order;
use App\UserAddress;
use App\UserCoupon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function coupon($id)
    {
        $coupon = Coupon::findOrFail($id);
        if ((new UserCoupon())->setAttribute('user_id', \Auth::user()->id)->setAttribute('coupon_id', $coupon['id'])->save()) {
            return response()->json(['code' => 1, 'message' => '购买成功', 'data' => route('user.coupon.list')]);
        } else {
            return response()->json(['code' => 0, 'message' => '购买失败，您的积分不够']);
        }
    }

    public function goods($id)
    {
        $goods = Goods::findOrFail($id);
        if ($goods->is_direct) {
            return view('frontend.order-direct', ['goods' => $goods, 'shop' => $goods->shop]);
        } else {
            return view('frontend.order-shop', ['goods' => $goods, 'shop' => $goods->shop]);
        }
    }

    public function shopGoods(Request $request)
    {
        if ($request->ajax()) {
            return null;
        }
        $order = new Order();
        if ($order->fill($request->only(['goods_id']))->save()) {
            return view('frontend.order-success', ['order' => $order]);
        }
        return view('frontend.order-failed');
    }

    public function directGoods(DirectOrderRequest $request)
    {
        if ($request->ajax()) {
            return null;
        }
        if (!$address = UserAddress::find($request->input('address_id'))) {
            return view('frontend.order-failed');
        }
        $order = new Order();
        if ($order->fill($request->only(['goods_id']))
            ->setAttribute('province_id', $address->province_id)
            ->setAttribute('city_id', $address->city_id)
            ->setAttribute('county_id', $address->county_id)
            ->save()) {
            return view('frontend.order-success', ['order' => $order]);
        }
        return view('frontend.order-failed');
    }
}