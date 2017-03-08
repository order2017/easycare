<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/6/15
 * Time: 14:39
 */

namespace App\Http\Controllers\Admin;

use App\Boss;
use App\Coupon;
use App\CouponApply;
use App\Employee;
use App\Goods;
use App\GoodsApply;
use App\Http\Controllers\Controller;
use App\Sale;
use App\Shop;
use App\ShopApply;
use App\ShopStaffApply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class EmployeeController extends Controller
{
    public function index()
    {
        $id = Input::get('id');
        $parameter = Input::get('parameter');
        if($parameter==1){
            $emp = Employee::where('id', '=', $id)->update(['status' => Employee::STATUS_LEAVE]);
            if($emp){
                return response()->json(['code' => 1, 'message' => '离职成功', 'url' => '']);
            }else{
                return response()->json(['code' => 0, 'message' => '离职失败', 'url' => '']);
            }
        }elseif($parameter==2){
            $emp = Employee::where('id', '=', $id)->update(['status' => Employee::STATUS_NORMAL]);
            if($emp){
                return response()->json(['code' => 1, 'message' => '复职成功', 'url' => '']);
            }else{
                return response()->json(['code' => 0, 'message' => '复职失败', 'url' => '']);
            }
        }
        return view('admin.employee.list', ['list' => Employee::paginate(15)]);
    }

    protected function getEmployeeModel($id)
    {
        return $id === null ? new Employee() : Employee::findOrFail($id);
    }

    public function getEmployeePage($id = null)
    {
        $employee = Employee::get();
        return view('admin.employee.page', ['model' => $this->getEmployeeModel($id),'employee'=>$employee]);
    }

    public function EmployeePage(Request $request,$id = null)
    {
        \DB::beginTransaction();
        try {
            Shop::where('employees_id', '=', $id)->update(['employees_id' => $request->input(['employees_id'])]);
            ShopApply::where('employees_id', '=', $id)->update(['employees_id' => $request->input(['employees_id'])]);
            ShopStaffApply::where('employees_id', '=', $id)->update(['employees_id' => $request->input(['employees_id'])]);

            Boss::where('employees_id', '=', $id)->update(['employees_id' => $request->input(['employees_id'])]);
            Sale::where('employees_id', '=', $id)->update(['employees_id' => $request->input(['employees_id'])]);

            Goods::where('employees_id', '=', $id)->update(['employees_id' => $request->input(['employees_id'])]);
            GoodsApply::where('employees_id', '=', $id)->update(['employees_id' => $request->input(['employees_id'])]);

            Coupon::where('employees_id', '=', $id)->update(['employees_id' => $request->input(['employees_id'])]);
            CouponApply::where('employees_id', '=', $id)->update(['employees_id' => $request->input(['employees_id'])]);

            \DB::commit();
            return response()->json(['code' => 1, 'url' => '', 'message' => '迁移成功']);

        }catch (\Exception $e){
            \DB::rollBack();
            return response()->json(['code' => 0, 'message' => '系统错误，迁移失败']);
        }

    }
}