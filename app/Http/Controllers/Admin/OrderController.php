<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/6/30
 * Time: 14:58
 */

namespace App\Http\Controllers\Admin;


use App\Comment;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $searchKey = ['order_number','created_at'];
        $query = Order::query();
        $search = [];
        foreach ($searchKey as $key) {
            $search[$key] = $request->input($key);
            $query->where($key, 'like', '%' . $request->input($key) . '%');
        }
        return view('admin.order.list',['list' =>$query->paginate(15),'search' => $search]);

        //return view('admin.order.list',['list' => Order::paginate(15)]);
    }

    protected function getOrderModel($id)
    {
        return $id === null ? new Order() : Order::findOrFail($id);
    }

    public function getOrderPage($id = null)
    {
        return view('admin.order.page', ['model' => $this->getOrderModel($id)]);
    }

    public function orderPage(Request $request,$id = null)
    {
        Order::where('id', '=', $id)->update(['number' =>$request->input(['number'])]);
        return response()->json(['code' => 1, 'url' => '', 'message' => '保存成功']);
    }

    public function commentList()
    {
        return view('admin.comment.list',['list' => Comment::paginate(15)]);
    }

    public function exportFormOrder()
    {
        $list = Order::get();

        foreach ($list as $key => $value) {
            $export[] = array(
                '订单号' => $value['order_number'],
                '订单状态' => $value['order_type'],
                '快递单号' => $value['number'],
                '用户名称' => $value['user']['name'],
                '商品名称' => $value['goods']['name'],
                '所属店铺' => $value['shop_name'],
                '积分' => $value['goods']['price'],
                '购买时间' => $value['created_at'],
            );
        }

        $tab_name = '订单列表';
        Excel::create($tab_name, function($excel) use ($export) {
            $excel->sheet('export', function($sheet) use ($export) {
                $sheet->fromArray($export);
            });
        })->export('xls');
        iconv('UTF-8', 'GBK',$tab_name);

        return redirect(route('admin.order.list'));
    }
}