<?php

namespace App\Http\Controllers\Admin;

use App\Coupon;
use App\CouponApply;
use App\Goods;
use App\GoodsApply;
use App\Http\Requests\DirectCouponRequest;
use App\Http\Requests\DirectGoodsRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DirectController extends Controller
{
    //直营商品开始
    public function index(Request $request)  //直营商品列表
    {
        $searchKey = ['id' => 'goods.id', 'name' => 'goods_applies.name'];
        $query = Goods::join('goods_applies', 'goods.goods_apply_id', '=', 'goods_applies.id')->select(['goods.*', 'goods_applies.name'])->where('goods.shop_id', '=', null);
        $search = [];
        foreach ($searchKey as $key => $col) {
            $search[$key] = $request->input($key);
            $query->where($col, 'like', '%' . $request->input($key) . '%');
        }
        return view('admin.direct.goods-list', ['list' => $query->paginate(20), 'search' => $search]);
    }

    public function newOrChangeGoods($id)
    {
        return $id === null ? new GoodsApply() : GoodsApply::findOrFail($id);
    }

    public function getGoodsPage($id = null)
    {
        return view('admin.direct.goods-page', ['model' => $this->newOrChangeGoods($id)]);
    }

    public function postGoodsPage(DirectGoodsRequest $request, $id = null)
    {
        $model = $this->newOrChangeGoods($id);
        $model->setAttribute('status', GoodsApply::STATUS_APPROVE)->fill($request->only(['name', 'price', 'original_price', 'inventory', 'thumb', 'images','description']))->saveOrFail();
        return response()->json(['code' => 1, 'url' => route('admin.direct-goods.list'), 'message' => '保存成功']);
    }

    public function goodsDelete($id)
    {
        if (Goods::findOrFail($id)->delete()) {
            return response()->json(['code' => 1, 'message' => '删除成功', 'url' => '']);
        } else {
            return response()->json(['code' => 0, 'message' => '删除失败']);
        }
    }

    //直营商品到此结束

    //直营优惠券开始
    public function getCouponList(Request $request)
    {
        $searchKey = ['id' => 'coupons.id', 'title' => 'coupon_applies.title', 'scope' => 'coupon_applies.scope'];
        $query = Coupon::join('coupon_applies', 'coupons.coupon_applies_id', '=', 'coupon_applies.id')->where('coupons.shop_id', '=', null);
        $search = [];
        foreach ($searchKey as $key => $col) {
            $search[$key] = $request->input($key);
            $query->where($col, 'like', '%' . $request->input($key) . '%');
        }
        return view('admin.direct.coupon-list', ['list' => $query->paginate(20), 'search' => $search]);
    }

    public function newOrChangeCoupon($id)
    {
        return $id === null ? new CouponApply() : CouponApply::findOrFail($id);
    }

    public function getCouponPage($id = null)
    {
        return view('admin.direct.coupon-page', ['model' => $this->newOrChangeCoupon($id)]);
    }

    public function postCouponPage(DirectCouponRequest $request, $id = null)
    {
        $model = $this->newOrChangeCoupon($id);
        $model->setAttribute('status', CouponApply::STATUS_APPROVE)->fill($request->only(['thumb', 'title', 'type', 'scope', 'condition', 'money', 'integral', 'discount', 'begin_time', 'end_time', 'duration', 'time_type', 'images','description']))->saveOrFail();
        return response()->json(['code' => 1, 'url' => route('admin.direct-coupon.list'), 'message' => '保存成功']);
    }

    public function CouponDelete($id)
    {
        if (Coupon::findOrFail($id)->delete()) {
            return response()->json(['code' => 1, 'message' => '删除成功', 'url' => '']);
        } else {
            return response()->json(['code' => 0, 'message' => '删除失败']);
        }
    }
}
