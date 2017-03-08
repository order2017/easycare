<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/6/12
 * Time: 17:49
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminProductActivityRequest;
use App\Http\Requests\ProductRequest;
use App\Product;
use App\ProductActivity;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $searchKey = ['name', 'model'];
        $query = Product::query();
        $search = [];
        foreach ($searchKey as $key) {
            $search[$key] = $request->input($key);
            $query->where($key, 'like', '%' . $request->input($key) . '%');
        }
        return view('admin.product.list', ['list' => $query->paginate(15), 'search' => $search]);
    }

    protected function getProductModel($id)
    {
        return $id === null ? new Product() : Product::findOrFail($id);
    }

    public function getPage($id = null)
    {
        return view('admin.product.page', ['model' => $this->getProductModel($id)]);
    }

    public function postPage(ProductRequest $request, $id = null)
    {
        $model = $this->getProductModel($id);
        $model->fill($request->only(['model', 'name', 'integral', 'commission']))->saveOrFail();
        return response()->json(['code' => 1, 'url' => '', 'message' => '保存成功']);
    }

    public function delete($id)
    {
        if (Product::findOrFail($id)->delete()) {
            return response()->json(['code' => 1, 'message' => '删除成功', 'url' => '']);
        } else {
            return response()->json(['code' => 0, 'message' => '删除失败']);
        }
    }

    public function activityList()
    {
        return view('admin.product.activity-list', ['list' => ProductActivity::paginate(15)]);
    }

    /**
     * @param $id
     * @return ProductActivity
     */

    protected function getProductActivityModel($id)
    {
        return $id === null ? new ProductActivity() : ProductActivity::findOrFail($id);
    }

    public function getActivityPage($id = null)
    {
        return view('admin.product.activity-page', ['model' => $this->getProductActivityModel($id)]);
    }

    public function postActivityPage(AdminProductActivityRequest $request, $id = null)
    {
        $model = $this->getProductActivityModel($id);
        $model->fill($request->only(['title', 'total', 'type', 'send_type', 'send_method', 'begin_time', 'end_time', 'products', 'rules']))->saveOrFail();
        return response()->json(['code' => 1, 'url' => route('admin.productActivity.list'), 'message' => '保存成功']);
    }

    public function activityProduct(Request $request)
    {
        $type = $request->input('type');
        $beginTime = $request->input('beginTime');
        $endTime = $request->input('endTime');
        if (!empty($type) && in_array($type, array_keys(ProductActivity::typeLabelList()))) {
            $activity = ProductActivity::select('products')->whereType($type)->where(function (Builder $query) use ($beginTime, $endTime) {
                $query->whereBetween('begin_time', [$beginTime, $endTime])->orWhereBetween('end_time', [$beginTime, $endTime]);
            })->get();
            $ids = [];
            foreach ($activity as $item) {
                $ids = array_merge($ids, $item['products']);
            }
            $product = Product::whereNotIn('id', $ids)->orderBy('model')->get();
            return response()->json(['code' => 1, 'data' => $product]);
        }
        return response()->json(['code' => 0, 'message' => '非法请求']);
    }

    public function deleteActivity($id)
    {
        if (ProductActivity::findOrFail($id)->delete()) {
            return response()->json(['code' => 1, 'message' => '删除成功', 'url' => '']);
        } else {
            return response()->json(['code' => 0, 'message' => '删除失败']);
        }
    }
}