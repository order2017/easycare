<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/6/2
 * Time: 22:18
 */

namespace App\Http\Controllers\WeChat;


use App\Barcode;
use App\BarcodeVerifyRecord;
use App\Boss;
use App\Coupon;
use App\CouponApply;
use App\Goods;
use App\GoodsApply;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApplyShopPageRequest;
use App\Http\Requests\ApplyShopRequest;
use App\Http\Requests\CouponApplyRequest;
use App\Http\Requests\GoodsApplyRequest;
use App\Http\Requests\NewCouponRequest;
use App\Http\Requests\NewGoodsRequest;
use App\Http\Requests\ShopStaffApplyRequest;
use App\Product;
use App\Sale;
use App\Shop;
use App\ShopApply;
use App\ShopStaffApply;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use QrCode;
use Illuminate\Database\Eloquent\Model;

class EmployeeController extends Controller
{
    //员工中心
    public function index()
    {
        return view('employee.index');
    }

    //邀请链接
    public function invite()
    {
        $url = route('user.apply.shop-staff', ['token' => Auth::user()->employee->token]);
        $codeSrc = 'data:image/png;base64,'
            . base64_encode(QrCode::format('png')->size(200)->margin(0)->generate($url));
        return view('frontend.employee.invite', ['codeSrc' => $codeSrc, 'url' => $url]);
    }

    //导购/老板申请列表
    public function applies($type = null)
    {
        $query = ShopStaffApply::whereEmployeesId(Auth::user()->id);
        $type = $type === null ? 'wait' : $type;
        switch ($type) {
            case 'wait':
                $query->whereStatus(ShopStaffApply::STATUS_WAIT_FOT_PADDING);
                break;
            case 'approve':
                $query->whereStatus(ShopStaffApply::STATUS_APPROVE);
                break;
            case 'refusal':
                $query->whereStatus(ShopStaffApply::STATUS_REFUSAL);
                break;
        }
        return view('frontend.employee.apply-list-box', ['list' => $query->get(), 'type' => $type]);
    }

    public function getShopStaffApplyModel($id)
    {
        return ShopStaffApply::findOrFail($id);
    }

    //资料补充页面
    public function getApply($id)
    {
        return view('frontend.employee.apply', ['model' => $this->getShopStaffApplyModel($id)]);
    }

    //资料补充处理页面
    public function postApply(ShopStaffApplyRequest $request, $id)
    {
        if ($request->ajax()) {
            return null;
        }
        $this->getShopStaffApplyModel($id)->setAttribute('status', ShopStaffApply::STATUS_WAIT)->fill($request->only(['name', 'mobile', 'role', 'boss_id', 'province_id', 'city_id', 'county_id']))->saveOrFail();
        return view('frontend.employee.apply-success');
    }

    //不通过资料修改页面
    public function getApplyRefuse($id)
    {
        return view('frontend.employee.apply-refuse', ['model' => $this->getShopStaffApplyModel($id)]);
    }

    //不通过资料处理页面
    public function postApplyRefuse(ShopStaffApplyRequest $request, $id)
    {
        if ($request->ajax()) {
            return null;
        }
        $this->getShopStaffApplyModel($id)->setAttribute('status', ShopStaffApply::STATUS_WAIT)->fill($request->only(['name', 'mobile', 'role', 'boss_id', 'province_id', 'city_id', 'county_id']))->saveOrFail();
        return view('frontend.employee.apply-success');
    }

    //老板列表
    public function getBossList(Request $request)
    {
        $keyword = $request->input('keyword');
        $model = Boss::select('bosses.*')->where('bosses.employees_id', Auth::user()->id);
        if (!empty($keyword)) {
            $model->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')->orWhere('mobile', 'like', '%' . $keyword . '%');
            })->join('shop_staff_applies', 'shop_staff_apply_id', '=', 'shop_staff_applies.id');
        }
        return view('frontend.employee.boss-list', ['list' => $model->get(), 'keyword' => $keyword]);
    }

    //编辑老板资料
    public function getBossPage($id)
    {
        return view('frontend.employee.boss-page', ['model' => Boss::findOrFail($id)]);
    }

    //处理编辑老板资料
    public function postBossPage(ShopStaffApplyRequest $request, $id)
    {
        if ($request->ajax()) {
            return null;
        }
        $apply = new ShopStaffApply(['user_id' => $id, 'boss_id' => $id, 'employees_id' => Auth::user()->id, 'role' => User::ROLE_BOSS]);
        $apply->setAttribute('status', ShopStaffApply::STATUS_WAIT)->fill($request->only(['name', 'mobile', 'province_id', 'city_id', 'county_id']))->saveOrFail();
        return view('frontend.employee.applyBoss-success');
    }

    //导购列表
    public function getSaleList(Request $request)
    {
        $keyword = $request->input('keyword');
        $model = Sale::select('sales.*')->where('sales.employees_id', Auth::user()->id);
        if (!empty($keyword)) {
            $model->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')->orWhere('mobile', 'like', '%' . $keyword . '%');
            })->join('shop_staff_applies', 'shop_staff_apply_id', '=', 'shop_staff_applies.id');
        }
        return view('frontend.employee.sale-list', ['list' => $model->get(), 'keyword' => $keyword]);
    }

    //导购资料编辑
    public function getSalePage($id)
    {
        return view('frontend.employee.sale-page', ['model' => Sale::findOrFail($id)]);
    }

    //处理导购资料编辑
    public function postSalePage(ShopStaffApplyRequest $request, $id)
    {
        if ($request->ajax()) {
            return null;
        }
        $apply = new ShopStaffApply(['user_id' => $id, 'employees_id' => Auth::user()->id, 'role' => User::ROLE_SALE]);
        $apply->setAttribute('status', ShopStaffApply::STATUS_WAIT)->fill($request->only(['name', 'mobile', 'province_id', 'city_id', 'county_id', 'boss_id']))->saveOrFail();
        return view('frontend.employee.applySale-success');
    }

    
    //店铺申请
    public function getShopApply($id = null)
    {
        $model = $id === null ? new ShopApply() : Shop::findOrFail($id);
        return view('frontend.employee.shop-apply', ['model' => $model]);
    }

    //店铺申请处理
    public function postShopApply(ApplyShopRequest $request)
    {
        if ($request->ajax()) {
            return null;
        }
        $apply = new ShopApply(['employees_id' => Auth::user()->id]);
        $apply->fill($request->only(['name', 'address', 'landmark', 'phone', 'boss_id', 'images', 'thumb', 'province_id', 'city_id', 'county_id', 'intro', 'shop_id']))->saveOrFail();
        return view('frontend.boss.apply-success');
    }

    //店铺列表
    public function getShopsList(Request $request)
    {
        $keyword = $request->input('keyword');
        $shop = Shop::select('shops.*')->where('shops.employees_id', Auth::user()->id);
        if (!empty($keyword)) {
            $shop->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')->orWhere('phone', 'like', '%' . $keyword . '%');
            })->leftJoin('shop_applies', 'shop_applies_id', '=', 'shop_applies.id');
        }
        return view('frontend.employee.shops-list', ['list' => $shop->get(), 'keyword' => $keyword]);
    }

    //编辑店铺资料
    // public function getShopsPage($id)
    // {
    //    return view('frontend.employee.shop-apply', ['model' => Shop::findOrFail($id)]);
    //}

    //新建商品
    public function getGoodsApply(Request $request,$id = null)
    {
        if($request->get('status') == Goods::STATUS_NORMAL or $request->get('status') == Goods::STATUS_LEAVE){
            $model = GoodsApply::findOrFail($id);
        }else{
            $model = $id === null ? new GoodsApply() : Goods::findOrFail($id);
        }
        return view('frontend.employee.goods-apply', ['model' => $model]);
    }

    //商品申请处理
    public function postGoodsApply(NewGoodsRequest $request)
    {
        if ($request->ajax()) {
            return null;
        }
        $apply = new GoodsApply(['employees_id' => Auth::user()->id]);
        $apply->fill($request->only(['name', 'price', 'original_price', 'shop_id', 'inventory', 'thumb', 'images', 'goods_id', 'intro']))->saveOrFail();
        return view('frontend.employee.goodsApply-success');
    }

    //商品列表
    public function getGoodsList(Request $request,$type = null)
    {
        $keyword = $request->input('keyword');
        $type = $type === null ? 'approve' : $type;
        switch ($type) {
            case 'wait':
                $model = GoodsApply::select('goods_applies.*')->where(['goods_applies.employees_id'=>Auth::user()->id,'goods_applies.status'=>GoodsApply::STATUS_WAIT]);
                break;
            case 'approve':
                $model = Goods::select('goods.*')->where('goods.employees_id', Auth::user()->id);
                if (!empty($keyword)) {
                    $model->where(function ($query) use ($keyword) {
                        $query->where('name', 'like', '%' . $keyword . '%');
                    })->leftJoin('goods_applies', 'goods_apply_id', '=', 'goods_applies.id');
                }
                break;
            case 'refusal':
                $model = GoodsApply::select('goods_applies.*')->where(['goods_applies.employees_id'=>Auth::user()->id,'goods_applies.status'=>GoodsApply::STATUS_REFUSAL]);
                break;
        }

        return view('frontend.employee.goods-list', ['list' => $model->get(), 'keyword' => $keyword,'type'=>$type]);
    }


    //新建优惠券页面
    public function getCouponApply($id = null)
    {
        $model = $id === null ? new CouponApply() : Coupon::findOrNew($id);
        return view('frontend.employee.coupon-apply', ['model' => $model]);
    }

    //优惠券申请处理
    public function postCouponApply(NewCouponRequest $request)
    {
        if ($request->ajax()) {
            return null;
        }
        $apply = new CouponApply(['employees_id' => Auth::user()->id]);
        $apply->fill($request->only(['type', 'title', 'shop_id', 'scope', 'condition', 'discount', 'money', 'integral', 'begin_time', 'end_time', 'duration', 'thumb', 'images', 'time_type', 'coupon_id']))->saveOrFail();
        return view('frontend.employee.couponApply-success');
    }

    //优惠券列表
    public function getCouponList(Request $request,$type = null)
    {
        $keyword = $request->input('keyword');
        $type = $type === null ? 'approve' : $type;
        switch ($type) {
            case 'wait':
                $model =  CouponApply::select('coupon_applies.*')->where(['coupon_applies.employees_id'=> Auth::user()->id,'coupon_applies.status'=>CouponApply::STATUS_WAIT]);
                break;
            case 'approve':
                $model = Coupon::select('coupons.*')->where('coupons.employees_id', Auth::user()->id);
                if (!empty($keyword)) {
                    $model->where(function ($query) use ($keyword) {
                        $query->where('title', 'like', '%' . $keyword . '%');
                    })->leftJoin('coupon_applies', 'coupon_applies_id', '=', 'coupon_applies.id');
                }
                break;
            case 'refusal':
                $model =  CouponApply::select('coupon_applies.*')->where(['coupon_applies.employees_id'=> Auth::user()->id,'coupon_applies.status'=>CouponApply::STATUS_REFUSAL]);
                break;
        }
        return view('frontend.employee.coupon-list', ['list' => $model->get(), 'keyword' => $keyword,'type'=>$type]);

    }

    public function dataTable()
    {
        return view('frontend.employee.selldata-list');
    }

    public function totalData()
    {
        $request = Input::get();
        if($request){
            $productList = Product::all();
            $list = [];
            foreach($productList as $product){
                $list[] = [
                    'model'=>$product['model'],
                    'commission'=>$product['commission'],
                    'count'=>Barcode::whereCommissionUserId(Auth::user()->id)->whereProductId($product['id'])->where('commission_verified_at',$request['beginTime'],$request['endTime'])->count(),
                ];
            }
            $allTotal = CommissionBlotter::whereUserId(Auth::user()->id)->sum('numerical');
            $total = CommissionBlotter::whereUserId(Auth::user()->id)->where('created_at',$request['beginTime'],$request['endTime'])->sum('numerical');
            return view('frontend.sale.total-sale-data',['list'=>$list,'alltotal'=>$allTotal,'total'=>$total]);
        }else{
            return view('frontend.sale.total-sale-data',['list'=>null]);
        }
    }


    public function saleData()
    {
        $saleList = Sale::whereEmployeesId(Auth::user()->id)->get();
        $list = [];
        $allCount = 0;
        foreach($saleList as $sale){
            $shopStaff = ShopStaffApply::whereId($sale['shop_staff_apply_id'])->first();
            $count = Barcode::whereCommissionUserId($shopStaff['user_id'])->count();
            $list[] = [
                'name'=>$sale['name'],
                'mobile'=>$sale['mobile'],
                'id'=>$sale['id'],
                'count'=>$count,
            ];
            $allCount += $count;
        }
       return view('frontend.employee.saledata-list',['list'=>$list,'allConut'=>$allCount]);
    }

    public function saleDetails()
    {
        $shopStaff = ShopStaffApply::whereUserId(Input::get('id'))->get();
        $barcode = Barcode::whereCommissionUserId(Input::get('id'))->get();
        $list = [];
        foreach($barcode as $barcode){
            $product[] = Product::whereId($barcode['product_id'])->first();
            $count = Barcode::whereCommissionUserId(Input::get('id'))->count();
            $list[] = [
                'product'=>$product,
                'shopstaff'=>$shopStaff,
                'count'=>$count,
            ];
        }
        return view('frontend.employee.saledetails-list',['list'=>$list]);
    }

    public function shopData()
    {
        return view('frontend.employee.shopdata-list');
    }

    public function shopDetails()
    {
        return view('frontend.employee.shopdetails-list');
    }

}