<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/7/29
 * Time: 10:15
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WidgetController extends Controller
{
    public function upload(Request $request)
    {
        $fileName = sha1(microtime());
        \Storage::put($fileName, file_get_contents($request->file('file')->getFileInfo()->getPathname()));
        return response()->json([
            'key' => $fileName,
        ]);
    }
}