<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/7/13
 * Time: 13:59
 */

namespace App\Http\Controllers;


use App\Region;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Storage;

class WidgetController extends Controller
{
    public function address(Request $request)
    {
        $id = $request->input('id');
        $type = $request->input('type');
        if ($type == 'province') {
            $cityList = Region::select(['id', 'name'])->whereLevel(2)->whereParent($id)->get();
            return response()->json(['code' => 1, 'data' => [
                Region::select(['id', 'name'])->whereLevel(3)->whereParent($cityList[0]->id)->get(),
                $cityList
            ]]);
        } else {
            return response()->json(['code' => 1, 'data' => [
                Region::select(['id', 'name'])->whereLevel(3)->whereParent($id)->get()
            ]]);
        }
    }

    public function location(Request $request)
    {
        $location = $request->input('location');
        $client = new Client();
        $res = $client->request('GET', 'http://apis.map.qq.com/ws/geocoder/v1/?location=' . $location . '&key=542BZ-WD6RU-IYMVX-4GVR5-ROPF3-JZFV2');
        if ($res->getStatusCode() == '200') {
            var_dump($res->getBody());
        } else {
            return response()->json(['code' => 0, 'message' => '查询失败']);
        }
    }

    public function images($name)
    {
        if (Storage::exists($name)) {
            header('Content-type: ' . Storage::mimeType($name));
            echo Storage::get($name);
        }
    }

    public function upload(Request $request)
    {
        var_dump($request->files);
    }
}