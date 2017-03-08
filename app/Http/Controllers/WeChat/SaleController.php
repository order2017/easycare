<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/7/8
 * Time: 15:34
 */

namespace App\Http\Controllers\WeChat;


use App\Barcode;
use App\CommissionBlotter;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use App\Shop;
use Auth;
use Illuminate\Support\Facades\Input;

class SaleController extends Controller
{
    public function commissionRecord()
    {
        return view('frontend.sale.commission-record',['list' => CommissionBlotter::whereUserId(Auth::user()->id)->get()]);
    }

    public function shopList(Request $request)
    {
      $keyword = $request->input('keyword');  
      $shop = Shop::join('sales','shops.boss_id','=','sales.boss_id')
          ->select('shops.*')
          ->where('sales.id','=',Auth::user()->id);
        if (!empty($keyword)) {
            $shop->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')->orWhere('phone','like','%'.$keyword.'%');
            })->leftJoin('shop_applies', 'shop_applies_id', '=', 'shop_applies.id');
        }
        return view('frontend.sale.shop-list',['list' => $shop->get(),'keyword' => $keyword]);
    }


   /* public function saleRecord()
    {
        return view('frontend.construction');
    }*/

    public function dataTable()
    {
        return view('frontend.sale.saledata-list');
    }

    public function totalDataTable()
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
}