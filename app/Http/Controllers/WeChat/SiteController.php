<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/5/26
 * Time: 22:11
 */

namespace App\Http\Controllers\WeChat;


use App\Advertising;
use App\Comment;
use App\Coupon;
use App\Favorite;
use App\Goods;
use App\Http\Controllers\Controller;
use App\Shop;
use Auth;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $banner = Advertising::whereType(Advertising::TYPE_INDEX_BANNER)->orderBy('order', 'desc')->get();
        $ad = Advertising::whereType(Advertising::TYPE_INDEX_AD1)->first();
        $hotShop = Shop::limit(1)->orderBy('created_at', 'desc')->get();
        $hotGoodsList = Goods::limit(2)->orderBy('created_at', 'desc')->get();
        return view('frontend.index',
            ['hotGoodsList' => $hotGoodsList, 'hotShop' => $hotShop, 'banner' => $banner, 'ad' => $ad]);
    }


    public function goodsList(Request $request,$type = null)
    {
        $type = $type === null ? 'all' : $type;
        $query = Goods::join('goods_applies','goods.goods_apply_id','=','goods_applies.id')->where('goods.status','=',Goods::STATUS_NORMAL)->orderBy('order','desc');
        switch ($type) {
            case 'all':
                break;
            case 'Newest':
                $query->orderBy('goods.created_at', 'desc');
                break;
            case 'Popularity':
                $query->orderBy('goods.created_at', 'asc');
                break;
        }
        if(!empty($request->input('keyword'))){
          $query->where('goods_applies.name','like','%'.$request->input('keyword').'%');
        }
        $goodsList = $query->get();
        return view('frontend.goods-list', ['list' => $goodsList, 'type' => $type]);
    }

    public function shopGoodsList(Request $request){
        $query = Goods::join('goods_applies','goods.goods_apply_id','=','goods_applies.id')->where('goods.status','=',Goods::STATUS_NORMAL);

        if(!empty($request->input('keyword'))){
            $query->where('goods_applies.name','like','%'.$request->input('keyword').'%');
        }
        $goodsList = $query->get();
        return view('frontend.shop-goods-list', ['list' => $goodsList]);
    }

    public function goods($id)
    {
        $goods = Goods::findOrFail($id);
        $comment = Comment::join('orders', 'comments.order_id', '=', 'orders.id')
            ->where('goods_id', '=', $id)
            ->select('comments.*')
            ->get();
        return view('frontend.goods-detail', ['goods' => $goods, 'comment' => $comment]);
    }

    public function couponList(Request $request)
    {
        $query = Coupon::join('coupon_applies','coupons.coupon_applies_id','=','coupon_applies.id')->where('coupons.status','=',Coupon::STATUS_NORMAL)->orderBy('order','desc');

        if(!empty($request->input('keyword'))){
            $query->where('coupon_applies.title','like','%'.$request->input('keyword').'%');
        }

        $couponList = $query->get();

       // return view('frontend.coupon-list', ['list' => Coupon::whereStatus(Coupon::STATUS_NORMAL)->get()]);
        return view('frontend.coupon-list', ['list' => $couponList]);
    }

    public function coupon($id)
    {
        return view('frontend.coupon-detail', ['model' => Coupon::findOrFail($id)]);
    }

    public function shopList($type = null)
    {
        $type = $type === null ? 'all' : $type;
        $query = Shop::whereStatus(Shop::STATUS_NORMAL);
        switch ($type) {
            case 'all':
                break;
            case 'Newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'Popularity':
                $query->orderBy('created_at', 'asc');
                break;
        }
        $shopList = $query->get();

        return view('frontend.shop-list', ['list' => $shopList, 'type' => $type]);
    }



    // public function shopListAjax($type, $page = 1)
    // {
    //     $list = Shop::whereStatus($type)->orderBy('created_at', 'desc')->offset($page - 1)->limit(20)->get();
    //     return view('frontend.shop-list', ['list' => $list]);
    // }

    public function shop($id)
    {
        $shop = Shop::findOrFail($id);
        return view('frontend.shop-detail', ['shop' => $shop]);
    }

    public function GoodsCollection($id)
    {

        if (!Favorite::whereUserId(Auth::user()->id)->where('goods_id', '=', $id)->exists()) {
            $favourite = new Favorite(['goods_id' => $id, 'user_id' => Auth::user()->id]);
            $favourite->setAttribute('type', Favorite::TYPE_GOODS)->saveOrFail();
            return view('frontend.goodsCollection-success', ['id' => $id]);
        } else {
            return view('frontend.have-collection', ['id' => $id]);
        }
    }


    public function ShopsCollection($id)
    {
        if (!Favorite::whereUserId(Auth::user()->id)->where('shop_id', '=', $id)->exists()) {
            $favourite = new Favorite(['shop_id' => $id, 'user_id' => Auth::user()->id]);
            $favourite->setAttribute('type', Favorite::TYPE_SHOP)->saveOrFail();
            return view('frontend.shopCollection-success', ['id' => $id]);
        } else {
            return view('frontend.have-collection', ['id' => $id]);
        }
    }


    public function CouponCollection($id)
    {
        if (!Favorite::whereUserId(Auth::user()->id)->where('coupon_id', '=', $id)->exists()) {
            $favourite = new Favorite(['coupon_id' => $id, 'user_id' => Auth::user()->id]);
            $favourite->setAttribute('type', Favorite::TYPE_COUPON)->saveOrFail();
            return view('frontend.shopCollection-success', ['id' => $id]);
        } else {
            return view('frontend.have-collection', ['id' => $id]);
        }
    }

    public function destroyCollection($id)
    {
        $post = Favorite::find($id);
        if ($post->delete()) {
            return redirect(route('user.favourites.shop'));
        }

    }

}