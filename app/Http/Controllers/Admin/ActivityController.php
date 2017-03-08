<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminActivityCommissionRequest;
use App\Http\Requests\AdminActivityIntegralRequest;
use App\Http\Requests\AdminActivityRedPacketRequest;
use App\Product;
use App\ProductActivity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function searchProduct(Request $request)
    {
        return ProductActivity::getProducts($request->input('type'), $request->input('beginTime'), $request->input('endTime'));
    }

    public function getModel($id)
    {
        return $id === null ? new ProductActivity() : ProductActivity::findOrFail($id);
    }

    public function integralList(Request $request)
    {

        $searchKey = ['title','products'];
        $query = ProductActivity::whereType(ProductActivity::TYPE_MEMBER_INTEGRAL)->orderBy('created_at', 'desc');
        $search = [];
        foreach ($searchKey as $key) {
            $search[$key] = $request->input($key);
            $query->where($key, 'like', '%' . $request->input($key) . '%');
        }

        return view('admin.activity.integral-list', ['list' => $query->paginate(20),'products'=>Product::all(),'search' => $search]);

       // return view('admin.activity.integral-list', ['list' => ProductActivity::whereType(ProductActivity::TYPE_MEMBER_INTEGRAL)->paginate(20)]);
    }

    public function getIntegral($id = null)
    {
        $model = $this->getModel($id);
        return view('admin.activity.integral-page', ['model' => $model]);
    }

    public function postIntegral(AdminActivityIntegralRequest $request, $id = null)
    {
        $model = $this->getModel($id);
        if ($model->fill($request->only(['title', 'type', 'send_method', 'begin_time', 'end_time', 'rules.multiple', 'products']))->setAttribute('type', ProductActivity::TYPE_MEMBER_INTEGRAL)->save()) {
            return response()->json(['code' => 1, 'message' => '保存成功', 'url' => route('admin.activity.integral.list')]);
        }
        return response()->json(['code' => 0, 'message' => '保存失败']);
    }

    public function deleteIntegral($id)
    {
        if (ProductActivity::findOrFail($id)->delete()) {
            return response()->json(['code' => 1, 'message' => '删除成功', 'url' => route('admin.activity.integral.list')]);
        }
        return response()->json(['code' => 0, 'message' => '删除失败']);
    }

    public function upOrDownIntegral($id)
    {
        $model = ProductActivity::findOrFail($id);
        if ($model->is_down) {
            if ($model->setAttribute('status', ProductActivity::STATUS_UP)->save()) {
                return response()->json(['code' => 1, 'message' => '上架成功', 'url' => route('admin.activity.integral.list')]);
            }
        } else {
            if ($model->setAttribute('status', ProductActivity::STATUS_DOWN)->save()) {
                return response()->json(['code' => 1, 'message' => '下架成功', 'url' => route('admin.activity.integral.list')]);
            }
        }
    }

    public function redPacketList(Request $request)
    {

        $searchKey = ['title','products'];
        $query = ProductActivity::whereType(ProductActivity::TYPE_MEMBER_RED_PACKETS)->orderBy('created_at', 'desc');
        $search = [];
        foreach ($searchKey as $key) {
            $search[$key] = $request->input($key);
            $query->where($key, 'like', '%' . $request->input($key) . '%');
        }

        return view('admin.activity.red-packet-list', ['list' => $query->paginate(20),'products'=>Product::all(),'search' => $search]);

        //return view('admin.activity.red-packet-list', ['list' => ProductActivity::whereType(ProductActivity::TYPE_MEMBER_RED_PACKETS)->paginate(20)]);
    }

    public function getRedPacket($id = null)
    {
        $model = $this->getModel($id);
        return view('admin.activity.red-packet-page', ['model' => $model]);
    }

    public function postRedPacket(AdminActivityRedPacketRequest $request, $id = null)
    {
        $model = $this->getModel($id);
        if ($model->fill($request->only(['title', 'type', 'send_method', 'begin_time', 'end_time', 'rules.min', 'rules.max', 'products']))->setAttribute('type', ProductActivity::TYPE_MEMBER_RED_PACKETS)->save()) {
            return response()->json(['code' => 1, 'message' => '保存成功', 'url' => route('admin.activity.red-packet.list')]);
        }
        return response()->json(['code' => 0, 'message' => '保存失败']);
    }

    public function deleteRedPacket($id)
    {
        if (ProductActivity::findOrFail($id)->delete()) {
            return response()->json(['code' => 1, 'message' => '删除成功', 'url' => route('admin.activity.red-packet.list')]);
        }
        return response()->json(['code' => 0, 'message' => '删除失败']);
    }

    public function upOrDownRedPacket($id)
    {
        $model = ProductActivity::findOrFail($id);
        if ($model->is_down) {
            if ($model->setAttribute('status', ProductActivity::STATUS_UP)->save()) {
                return response()->json(['code' => 1, 'message' => '上架成功', 'url' => route('admin.activity.red-packet.list')]);
            }
        } else {
            if ($model->setAttribute('status', ProductActivity::STATUS_DOWN)->save()) {
                return response()->json(['code' => 1, 'message' => '下架成功', 'url' => route('admin.activity.red-packet.list')]);
            }
        }
    }

    public function commissionList(Request $request)
    {
        $searchKey = ['title','products'];
        $query = ProductActivity::whereType(ProductActivity::TYPE_SALE_COMMISSION)->orderBy('created_at', 'desc');
        $search = [];
        foreach ($searchKey as $key) {
            $search[$key] = $request->input($key);
            $query->where($key, 'like', '%' . $request->input($key) . '%');
        }

        return view('admin.activity.commission-list', ['list' => $query->paginate(20),'products'=>Product::all(),'search' => $search]);

        //return view('admin.activity.commission-list', ['list' => ProductActivity::whereType(ProductActivity::TYPE_SALE_COMMISSION)->paginate(20)]);
    }

    public function getCommission($id = null)
    {
        $model = $this->getModel($id);
        return view('admin.activity.commission-page', ['model' => $model]);
    }

    public function postCommission(AdminActivityCommissionRequest $request, $id = null)
    {
        $model = $this->getModel($id);
        if ($model->fill($request->only(['title', 'type', 'send_method', 'begin_time', 'end_time', 'rules.total', 'products', 'rules.list']))->setAttribute('type', ProductActivity::TYPE_SALE_COMMISSION)->save()) {
            return response()->json(['code' => 1, 'message' => '保存成功', 'url' => route('admin.activity.commission.list')]);
        }
        return response()->json(['code' => 0, 'message' => '保存失败']);
    }

    public function deleteCommission($id)
    {
        if (ProductActivity::findOrFail($id)->delete()) {
            return response()->json(['code' => 1, 'message' => '删除成功', 'url' => route('admin.activity.commission.list')]);
        }
        return response()->json(['code' => 0, 'message' => '删除失败']);
    }

    public function upOrDownCommission($id)
    {
        $model = ProductActivity::findOrFail($id);
        if ($model->is_down) {
            if ($model->setAttribute('status', ProductActivity::STATUS_UP)->save()) {
                return response()->json(['code' => 1, 'message' => '上架成功', 'url' => route('admin.activity.commission.list')]);
            }
        } else {
            if ($model->setAttribute('status', ProductActivity::STATUS_DOWN)->save()) {
                return response()->json(['code' => 1, 'message' => '下架成功', 'url' => route('admin.activity.commission.list')]);
            }
        }
    }


}