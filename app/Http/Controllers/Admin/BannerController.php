<?php

namespace App\Http\Controllers\Admin;

use App\Advertising;
use App\Http\Requests\BannerRequest;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    public function getBanner()
    {
        return view('admin.Advertise.banner', ['list' => Advertising::orderBy('id', 'desc')->paginate(15)]);
    }

    public function newOrChangeBanner($id)
    {
        return $id === null ? new Advertising() : Advertising::findOrFail($id);
    }

    public function getBannerPage($id = null)
    {
        return view('admin.Advertise.bannerPage', ['model' => $this->newOrChangeBanner($id)]);
    }

    public function postBannerPage(BannerRequest $request, $id = null)
    {
        $model = $this->newOrChangeBanner($id);
        $model->fill($request->only(['image', 'order', 'type','link']))->saveOrFail();
        return response()->json(['code' => 1, 'url' => route('admin.banner'), 'message' => '保存成功']);
    }

    public function bannerDelete($id)
    {
        if (Advertising::findOrFail($id)->delete()) {
            return response()->json(['code' => 1, 'message' => '删除成功', 'url' => '']);
        } else {
            return response()->json(['code' => 0, 'message' => '删除失败']);
        }
    }
}
