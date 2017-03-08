<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/6/3
 * Time: 17:40
 */

namespace App\Http\Controllers\Admin;

use App\Barcode;
use App\BarcodeExport;
use App\BarcodeVerifyRecord;
use App\GenerateBarcodeTask;
use App\Http\Controllers\Controller;
use App\Http\Requests\BarcodeTaskRequest;
use App\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BarCodeController extends Controller
{

    public function index(Request $request)
    {
        $searchKey = ['serial_number', 'product_id', 'commission_status', 'integral_status'];
        $query = Barcode::orderBy('created_at', 'desc');
        $search = [];
        foreach ($searchKey as $key) {
            $search[$key] = $request->input($key);
            $query->where($key, 'like', '%' . $request->input($key) . '%');
        }

        $status = [
            ['stname' => Barcode::STATUS_WAIT],
            ['stname' => Barcode::STATUS_CANCEL],
            ['stname' => Barcode::STATUS_USED],
        ];

        return view('admin.barcode.list', ['list' => $query->simplePaginate(100), 'search' => $search, 'products' => Product::all(), 'status' => $status]);
    }

    public function exportForm()
    {
        $list = Barcode::get();

        foreach ($list as $key => $value) {
            $export[] = array(
                '产品型号' => $value['product']['model'],
                '条形码' => $value['serial_number'],
                '佣金状态' => $value['commission_status_text'],
                '佣金次数' => $value['commission_verify_times'],
                '佣金数目' => $value['commission_send_number'],
                '佣金首次时间' => $value['commission_first_time'],
                '佣金领取人' => $value['commission_used_user'],
                '积分状态' => $value['integral_status_text'],
                '积分次数' => $value['integral_verify_times'],
                '积分数目' => $value['integral_send_number'],
                '积分首次时间' => $value['integral_first_time'],
                '积分领取人' => $value['integral_used_user'],
                '创建时间' => $value['created_at'],
            );
        }

        $tab_name = '标签列表';
        Excel::create($tab_name, function($excel) use ($export) {
            $excel->sheet('export', function($sheet) use ($export) {
                $sheet->fromArray($export);
            });
        })->export('xls');
        iconv('UTF-8', 'GBK',$tab_name);

        return redirect(route('admin.barcode.list'));
    }


    public function functionStatus($res)
    {
        if ($res) {
            return response()->json(['code' => 1, 'message' => '作废成功', 'url' => '']);
        } else {
            return response()->json(['code' => 0, 'message' => '作废失败', 'url' => '']);
        }
    }

    public function cancel(Request $request)
    {
        $res = Barcode::where('id', '=', $request->input('id'))->update(['commission_status' => Barcode::STATUS_CANCEL, 'integral_status' => Barcode::STATUS_CANCEL]);
        return $this->functionStatus($res);
    }


    public function getCancel()
    {
        return view('admin.barcode.cancel-page', ['products' => Product::all(), 'generate' => GenerateBarcodeTask::all()]);
    }

    public function postCancel(Request $request)
    {
        $bar = Barcode::where('product_id', '=', $request->input('product_id'))->update(['commission_status' => Barcode::STATUS_CANCEL, 'integral_status' => Barcode::STATUS_CANCEL]);
        $genbar = GenerateBarcodeTask::where('id', '=', $request->input('id'))->update(['status' => GenerateBarcodeTask::STATUS_CANCEL]);
        if ($bar && $genbar) {
            return response()->json(['code' => 1, 'url' => '', 'message' => '批量作废失败']);
        } else {
            return response()->json(['code' => 1, 'url' => '', 'message' => '批量作废成功']);
        }
    }

    public function exportList()
    {
        return view('admin.barcode.export-list', ['list' => BarcodeExport::paginate(15)]);
    }

    public function postExportPage($id)
    {
        GenerateBarcodeTask::findOrFail($id)->exportTask()->save(new BarcodeExport());
        return response()->json(['code' => 1, 'url' => route('admin.export-barcode-task.list'), 'message' => '任务提交成功，请留意处理进度']);
    }

    public function downloadExport($id)
    {
        $model = GenerateBarcodeTask::findOrFail($id);
        return response()->download(storage_path('upload/' . $model->serial_number . '.txt'));
    }

    public function importTask(Request $request)
    {
        GenerateBarcodeTask::findOrFail($request->input('id'))->import();
        return response()->json(['code' => 1, 'url' => route('admin.generate-barcode-task.list'), 'message' => '任务提交成功，请留意处理进度']);
    }

    public function cancelExport($id)
    {
        BarcodeExport::findOrFail($id)->cancel();
        return response()->json(['code' => 1, 'url' => '', 'message' => '取消成功']);
    }

    public function taskList()
    {
        $list = GenerateBarcodeTask::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.barcode.tasks', ['list' => $list]);
    }

    public function getTaskPage()
    {
        return view('admin.barcode.task-page', ['products' => Product::all()]);
    }

    public function postTaskPage(BarcodeTaskRequest $request)
    {
        $model = new GenerateBarcodeTask();
        $model->fill($request->only(['product_id', 'box_unit', 'box_num']))->saveOrFail();
        return response()->json(['code' => 1, 'url' => '', 'message' => '任务提交成功，请留意处理进度']);
    }

}