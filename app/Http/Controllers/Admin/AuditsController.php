<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/6/28
 * Time: 10:28
 */

namespace App\Http\Controllers\Admin;


use App\Boss;
use App\BossApply;
use App\Coupon;
use App\CouponApply;
use App\Employee;
use App\EmployeeApply;
use App\Goods;
use App\GoodsApply;
use App\Http\Controllers\Controller;
use App\Sale;
use App\SaleApply;
use App\Shop;
use App\ShopApply;
use Illuminate\Http\Request;

class AuditsController extends Controller
{
    public function employeeList()   //员工审核列表
    {
        return view('admin.audit.employee-list', ['list' => EmployeeApply::whereStatus(EmployeeApply::STATUS_WAIT)->paginate(15)]);
    }

    public function getEmployee($id)
    {
        $apply = EmployeeApply::findOrFail($id);
        $model = Employee::find($apply['user_id']);
        return view('admin.audit.employee-page', ['apply' => $apply, 'model' => $model]);
    }

    public function approvalEmployee($id)
    {
        EmployeeApply::findOrFail($id)->approve();
        return response()->json(['code' => 1, 'url' => '', 'message' => '审核成功']);
    }

    public function refusalEmployee(Request $request, $id)
    {
        EmployeeApply::findOrFail($id)->refusal($request->input('reason'));
        return response()->json(['code' => 1, 'url' => '', 'message' => '审核成功']);
    }

    public function bossList()
    {
        return view('admin.audit.boss-list', ['list' => BossApply::whereStatus(BossApply::STATUS_WAIT)->paginate(15)]);
    }

    public function getBoss($id)
    {
        $apply = BossApply::findOrFail($id);
        $model = Boss::find($apply['user_id']);
        return view('admin.audit.boss-page', ['apply' => $apply, 'model' => $model]);
    }

    public function approvalBoss($id)
    {
        BossApply::findOrFail($id)->approve();
        return response()->json(['code' => 1, 'url' => '', 'message' => '审核成功']);
    }

    public function refusalBoss(Request $request, $id)
    {
        BossApply::findOrFail($id)->refusal($request->input('reason'));
        return response()->json(['code' => 1, 'url' => '', 'message' => '审核成功']);
    }

    public function saleList()
    {
        return view('admin.audit.sale-list', ['list' => SaleApply::whereStatus(SaleApply::STATUS_WAIT)->paginate(15)]);
    }

    public function getSale($id)
    {
        $apply = SaleApply::findOrFail($id);
        $model = Sale::find($apply['user_id']);
        return view('admin.audit.sale-page', ['apply' => $apply, 'model' => $model]);
    }

    public function approvalSale($id)
    {
        SaleApply::findOrFail($id)->approve();
        return response()->json(['code' => 1, 'url' => '', 'message' => '审核成功']);
    }

    public function refusalSale(Request $request, $id)
    {
        SaleApply::findOrFail($id)->refusal($request->input('reason'));
        return response()->json(['code' => 1, 'url' => '', 'message' => '审核成功']);
    }

    public function shopList()      //店铺审核列表
    {
        return view('admin.audit.shop-list',['list' => ShopApply::whereStatus(ShopApply::STATUS_WAIT)->paginate(15)]);
    }

    public function getShop($id)     //店铺审核
    {
        $apply = ShopApply::findOrFail($id);
        $model = Shop::find($apply['shop_id']);
        return view('admin.audit.shop-page', ['apply' => $apply, 'model' => $model]);

    }

    public function approvalShop($id)
    {
       ShopApply::findOrFail($id)->approve();
        return response()->json(['code' => 1, 'url' => '', 'message' => '审核成功']);
    }

    public function refusalShop(Request $request, $id)
    {
        ShopApply::findOrFail($id)->refusal($request->input('reason'));
        return response()->json(['code' => 1, 'url' => '', 'message' => '审核成功']);
    }
    
    public function commodityList()  //商品审核列表
    {
        return view('admin.audit.commodity-list',['list' => GoodsApply::whereStatus(GoodsApply::STATUS_WAIT)->paginate(15)]);
    }


    public function getCommodity($id)     //商品审核
    {
        $apply = GoodsApply::findOrFail($id);
        $model = Goods::find($apply['goods_id']);
        return view('admin.audit.commodity-page', ['apply' => $apply, 'model' => $model]);
    }

    public function approvalCommodity($id) 
    {
        GoodsApply::findOrFail($id)->approve();
        return response()->json(['code' => 1, 'url' => '', 'message' => '审核成功']);
    }

    public function refusalCommodity(Request $request, $id)
    {
        GoodsApply::findOrFail($id)->refusal($request->input('reason'));
        return response()->json(['code' => 1, 'url' => '', 'message' => '审核成功']);
    }

    public function couponList() //店铺优惠券审核列表
    {
        return view('admin.audit.coupon-list',['list' => CouponApply::whereStatus(CouponApply::STATUS_WAIT)->paginate(15)]);
    }

    public function getCoupon($id)     //优惠券审核
    {
        $apply = CouponApply::findOrFail($id);
        $model = Coupon::find($apply['coupon_id']);
        return view('admin.audit.coupon-page', ['apply' => $apply, 'model' => $model]);
    }

    public function approvalCoupon($id)
    {
        CouponApply::findOrFail($id)->approve();
        return response()->json(['code' => 1, 'url' => '', 'message' => '审核成功']);
    }
    
    public function refusalCoupon(Request $request, $id)
    {
        CouponApply::findOrFail($id)->refusal($request->input('reason'));
        return response()->json(['code' => 1, 'url' => '', 'message' => '审核成功']);
    }

}