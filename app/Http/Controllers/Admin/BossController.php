<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/6/28
 * Time: 11:24
 */

namespace App\Http\Controllers\Admin;


use App\Boss;
use App\Http\Controllers\Controller;
use App\ShopStaffApply;
use App\User;
use Illuminate\Http\Request;

class BossController extends Controller
{
    public function index(Request $request)
    {
        $searchKey = ['name' => 'shop_staff_applies.name', 'mobile' => 'shop_staff_applies.mobile'];
        $query = Boss::join('shop_staff_applies','bosses.shop_staff_apply_id','=','shop_staff_applies.id');
        $search = [];
        foreach ($searchKey as $key => $col) {
            $search[$key] = $request->input($key);
            $query->where($col, 'like', '%' . $request->input($key) . '%');
        }

        return view('admin.boss.list',['list' => $query->paginate(15),'search'=>$search]);
    }

    public function getdel($id)
    {
        \DB::beginTransaction();
        try{
            if (User::where('id','=',$id)->delete() && ShopStaffApply::where('user_id','=',$id)->delete() && Boss::where('id','=',$id)->delete()) {
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
}