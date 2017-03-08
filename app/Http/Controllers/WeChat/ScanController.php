<?php
namespace App\Http\Controllers\WeChat;

use App\BarCode;
use App\Http\Controllers\Controller;
use App\MemberBarcode;
use App\Order;
use App\SaleBarcode;
use App\UserCoupon;
use Auth;
use Request;

class ScanController extends Controller
{

    public function member($serialNumber, $password)
    {
        if (!$barCode = MemberBarcode::findCode($serialNumber, $password)) {
            return view('frontend.scan.not-found-member');
        }
        if (!Auth::user()->is_member) {
            return view('frontend.scan.illegal-request');
        }
        $barCode->scan(Auth::user());
        if ($barCode->is_used) {
            return view('frontend.scan.verified-member', ['barCode' => $barCode]);
        }
        return $barCode->rewards(Auth::user());
    }

    public function sale($serialNumber, $password)
    {
        if (!$barCode = SaleBarcode::findCode($serialNumber, $password)) {
            return view('frontend.scan.illegal-request');
        }
        if (Auth::user()->is_member) {
            return view('frontend.scan.thanks');
        }
        if (!Auth::user()->is_sale) {
            return view('frontend.scan.illegal-request');
        }
        $barCode->scan(Auth::user());
        if ($barCode->is_used) {
            return view('frontend.scan.verified-sale', ['barCode' => $barCode]);
        }
        return $barCode->rewards(Auth::user());
    }

    public function getGoods($orderNumber, $password)
    {
        if (!$order = Order::where('order_number', $orderNumber)->where('password', $password)->first()) {
            return view('frontend.scan.illegal-request');
        }
        if ($order->is_used) {
            return view('frontend.scan.used');
        }
        if (!Auth::user()->is_sale && !Auth::user()->is_boss) {
            return view('frontend.scan.illegal-request');
        }
        return view('frontend.scan.exchange-goods', ['order' => $order]);
    }

    public function postGoods($orderNumber, $password)
    {
        if (!$order = Order::where('order_number', $orderNumber)->where('password', $password)->first()) {
            return view('frontend.scan.illegal-request');
        }
        if ($order->is_used) {
            return view('frontend.scan.used');
        }
        if (!Auth::user()->is_sale && !Auth::user()->is_boss) {
            return view('frontend.scan.illegal-request');
        }
        if ($order->exchange()) {
            return view('frontend.scan.exchange-success', ['integral' => $order->integral]);
        }
        return view('frontend.scan.exchange-failed');
    }

    public function getCoupon($couponNumber, $password)
    {
        if (!$coupon = UserCoupon::where('coupon_number', $couponNumber)->where('password', $password)->first()) {
            return view('frontend.scan.illegal-request');
        }
        if ($coupon->is_expired || $coupon->is_used) {
            return view('frontend.scan.used');
        }
        if (!Auth::user()->is_sale && !Auth::user()->is_boss) {
            return view('frontend.scan.illegal-request');
        }
        return view('frontend.scan.exchange-coupon', ['coupon' => $coupon]);
    }

    public function postCoupon($couponNumber, $password)
    {
        if (!$coupon = UserCoupon::where('coupon_number', $couponNumber)->where('password', $password)->first()) {
            return view('frontend.scan.illegal-request');
        }
        if ($coupon->is_expired || $coupon->is_used) {
            return view('frontend.scan.used');
        }
        if (!Auth::user()->is_sale && !Auth::user()->is_boss) {
            return view('frontend.scan.illegal-request');
        }
        if ($coupon->exchange()) {
            return view('frontend.scan.exchange-success', ['integral' => $coupon->integral]);
        }
        return view('frontend.scan.exchange-failed');
    }
}