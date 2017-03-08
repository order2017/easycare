<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/7/8
 * Time: 15:39
 */

namespace App\Http\Controllers\WeChat;


use App\Http\Controllers\Controller;
use App\Http\Requests\SaleApplyRequest;
use App\Http\Requests\WithdrawApplyRequest;
use App\IntegralBlotter;
use App\Sale;
use App\Shop;
use App\ShopStaffApply;
use App\Withdraw;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;


class BossController extends Controller
{
    public function integralRecord()
    {
        $todayCount = IntegralBlotter::whereUserId(Auth::user()->id)->whereBetween('created_at', [Carbon::today(), Carbon::tomorrow()])->count();
        return view('frontend.boss.integral-record', [
            'list' => IntegralBlotter::whereUserId(Auth::user()->id)->orderBy('created_at','desc')->get()
        ]);
    }

    public function getWithdraw()
    {
        return view('frontend.boss.withdraw', ['user' => Auth::user()]);
    }

    public function postWithdraw(WithdrawApplyRequest $request)
    {
        if ($request->ajax()) {
            return null;
        }
        if ((new Withdraw())->fill($request->only(['money']))->save()) {
            return view('frontend.boss.withdraw-success');
        } else {
            return view('frontend.boss.withdraw-failed');
        }
    }

    public function withdrawRecord()
    {
        return view('frontend.boss.withdraw-record', ['list' => Withdraw::whereUserId(Auth::user()->id)->get()]);
    }

    public function getShopList(Request $request)  //店铺列表
    {
        $keyword = $request->input('keyword');
        $model = Shop::where(['shops.boss_id'=>Auth::user()->id])->where(['shops.status'=>Shop::STATUS_NORMAL]);
        if (!empty($keyword))
        {
            $model->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')->orWhere('phone', 'like', '%' . $keyword . '%');
            })->leftJoin('shop_applies', 'shop_applies_id', '=', 'shop_applies.id');
        }
        return view('frontend.boss.shops-list', ['list' => $model->get(),'keyword' => $keyword]);
    }

    public function getSaleList(Request $request)  //导购列表
    {
        $keyword = $request->input('keyword');
        $model = Sale::where(['sales.boss_id'=>Auth::user()->id])->where(['sales.status'=>Sale::STATUS_NORMAL]);
        if (!empty($keyword))
        {
            $model->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')->orWhere('mobile', 'like', '%' . $keyword . '%');
            })->leftJoin('shop_staff_applies', 'shop_staff_apply_id', '=', 'shop_staff_applies.id');
        }
        return view('frontend.boss.sale-list', ['list' => $model->get(),'keyword'=>$keyword]);
    }


    public function saleRecord()
    {
        return view('frontend.construction');
    }

    public function dataTable()
    {
        return view('frontend.boss.selldata-list');
    }

    public function totalData()
    {
        return view('frontend.boss.totaldata-list');
    }

    public function saleData()
    {
        return view('frontend.boss.saledata-list');
    }

    public function saleDetails()
    {
        return view('frontend.boss.saledetails-list');
    }

    public function shopData()
    {
        return view('frontend.boss.shopdata-list');
    }

    public function shopDetails()
    {
        return view('frontend.boss.shopdetails-list');
    }

}
