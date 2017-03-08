<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/6/27
 * Time: 13:51
 */

namespace App\Http\Controllers\Admin;


use App\BarcodeVerifyRecord;
use App\CommissionBlotter;
use App\Http\Controllers\Controller;
use App\IntegralBlotter;
use App\Withdraw;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RecordController extends Controller
{
    public function integral(Request $request)
    {
        $searchKey = ['serial_number','created_at'];
        $query = IntegralBlotter::query();
        $search = [];
        foreach ($searchKey as $key) {
            $search[$key] = $request->input($key);
            $query->where($key, 'like', '%' . $request->input($key) . '%');
        }
        return view('admin.record.integral',['list' =>$query->paginate(15),'search' => $search]);

       // return view('admin.record.integral', ['list' => IntegralBlotter::paginate(15)]);
    }

    public function cash(Request $request)
    {
        $searchKey = ['serial_number','created_at'];
        $query = CommissionBlotter::query();
        $search = [];
        foreach ($searchKey as $key) {
            $search[$key] = $request->input($key);
            $query->where($key, 'like', '%' . $request->input($key) . '%');
        }
        return view('admin.record.cash',['list' =>$query->paginate(15),'search' => $search]);

       // return view('admin.record.cash', ['list' => CommissionBlotter::paginate(15)]);
    }

    public function withdraw()
    {
        return view('admin.record.withdraw', ['list' => Withdraw::paginate(15)]);
    }

    public function barcodeVerify(Request $request)
    {
        $searchKey = ['verified_at'];
        $query = BarcodeVerifyRecord::query();
        $search = [];
        foreach ($searchKey as $key) {
            $search[$key] = $request->input($key);
            $query->where($key, 'like', '%' . $request->input($key) . '%');
        }
        return view('admin.record.barcode-verify',['list' =>$query->paginate(15),'search' => $search]);

       // return view('admin.record.barcode-verify', ['list' => BarcodeVerifyRecord::paginate(15)]);
    }

    public function exportFormInte()
    {
        $list = IntegralBlotter::get();

        foreach ($list as $key => $value) {
            $export[] = array(
                '交易流水号' => $value['serial_number'],
                '用户ID' => $value['user']['id'],
                '积分' => $value['numerical'],
                '来源条码' => $value['barcode']['serial_number'],
                '参与活动' => $value['product_activity'],
                '中奖规则' => $value['product_activity_rule'],
                '消费订单' => $value['order'],
                '发放后用户余额' => $value['balance'],
                '备注' => $value['remark'],
                '创建时间' => $value['created_at'],
                '发放状态' => $value['status_text'],
                '发放时间' => $value['updated_at'],
            );
        }

        $tab_name = '积分发放记录表';
        Excel::create($tab_name, function($excel) use ($export) {
            $excel->sheet('export', function($sheet) use ($export) {
                $sheet->fromArray($export);
            });
        })->export('xls');
        iconv('UTF-8', 'GBK',$tab_name);

        return redirect(route('admin.record.integral'));
    }

    public function exportFormCash()
    {
        $list = CommissionBlotter::get();

        foreach ($list as $key => $value) {
            $export[] = array(
                '交易流水号' => $value['serial_number'],
                '用户ID' => $value['user']['id'],
                '积分' => $value['numerical'],
                '来源条码' => $value['barcode']['serial_number'],
                '参与活动' => $value['product_activity'],
                '中奖规则' => $value['product_activity_rule'],
                '消费订单' => $value['order'],
                '发放后用户余额' => $value['balance'],
                '备注' => $value['remark'],
                '创建时间' => $value['created_at'],
                '发放状态' => $value['status_text'],
                '发放时间' => $value['updated_at'],
            );
        }

        $tab_name = '现金发放记录表';
        Excel::create($tab_name, function($excel) use ($export) {
            $excel->sheet('export', function($sheet) use ($export) {
                $sheet->fromArray($export);
            });
        })->export('xls');
        iconv('UTF-8', 'GBK',$tab_name);

        return redirect(route('admin.record.cash'));
    }

    public function exportFormBarcode()
    {
        $list = BarcodeVerifyRecord::get();

        foreach ($list as $key => $value) {
            $export[] = array(
                '条码编号' => $value['barcode']['serial_number'],
                '用户ID' => $value['user']['id'],
                '扫描类型' => $value['verify_type_text'],
                '扫描时间' => $value['verified_at'],
                '是否已关注' => $value['is_subscribe_text'],

            );
        }

        $tab_name = '标签扫描记录表';
        Excel::create($tab_name, function($excel) use ($export) {
            $excel->sheet('export', function($sheet) use ($export) {
                $sheet->fromArray($export);
            });
        })->export('xls');
        iconv('UTF-8', 'GBK',$tab_name);

        return redirect(route('admin.record.barcode-verify'));
    }
}