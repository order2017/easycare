<?php
/**
 * Created by PhpStorm.
 * User: 87212
 * Date: 2016/7/1
 * Time: 15:19
 */

namespace App\Http\Controllers\Admin;


use App\Coupon;
use App\Goods;
use App\Http\Controllers\Controller;
use App\Shop;
use App\ShopApply;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $searchKey = ['name' => 'shop_applies.name', 'phone' => 'shop_applies.phone'];
        $query = Shop::join('shop_applies', 'shops.shop_applies_id', '=', 'shop_applies.id');
        $search = [];
        foreach ($searchKey as $key => $col) {
            $search[$key] = $request->input($key);
            $query->where($col, 'like', '%' . $request->input($key) . '%');
        }

        //return view('admin.shop.list', ['list' => Shop::paginate(15)]);
        return view('admin.shop.list', ['list' => $query->paginate(15),'search'=>$search]);
    }

    public function delete($id){
        \DB::beginTransaction();
        try{
            if (Shop::where('shop_applies_id','=',$id)->delete() && ShopApply::where('id','=',$id)->delete()) {
                \DB::commit();
                return response()->json(['code' => 1, 'message' => '删除成功', 'url' => '']);
            } else {
                \DB::rollBack();
                return response()->json(['code' => 0, 'message' => '删除失败']);
            }
        }catch (\Exception $e){
            \DB::rollBack();
            return response()->json(['code' => 0, 'message' => '系统错误，删除失败']);
        }
    }

    public function commodityList()
    {
        return view('admin.shop.commodity-list', ['list' => Goods::where('shop_id', '!=', null)->orderBy('order','desc')->paginate(15)]);
    }

    protected function getGoodsModel($id)
    {
        return $id === null ? new Goods() : Goods::findOrFail($id);
    }

    public function getgoodsPage($id = null)
    {
        return view('admin.shop.commodity-page', ['model' => $this->getGoodsModel($id)]);
    }

    public function shopgoodsPage(Request $request,$id = null)
    {
        Goods::where('id', '=', $id)->update(['order' =>$request->input(['order'])]);
        return response()->json(['code' => 1, 'url' => '', 'message' => '保存成功']);
    }

    public function couponList(Request $request)
    {
        return view('admin.shop.coupon-list', ['list' => Coupon::where('shop_id', '!=', null)->orderBy('order','desc')->paginate(15)]);
    }

    protected function getCouponModel($id)
    {
        return $id === null ? new Coupon() : Coupon::findOrFail($id);
    }

    public function getPage($id = null)
    {
        return view('admin.shop.page', ['model' => $this->getCouponModel($id)]);
    }

    public function shopPage(Request $request,$id = null)
    {
        Coupon::where('id', '=', $id)->update(['order' =>$request->input(['order'])]);
        return response()->json(['code' => 1, 'url' => '', 'message' => '保存成功']);
    }

}