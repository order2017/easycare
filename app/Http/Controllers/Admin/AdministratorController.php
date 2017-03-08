<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/6/28
 * Time: 11:15
 */

namespace App\Http\Controllers\Admin;


use App\Administrator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdministratorController extends Controller
{
    public function index()
    {
        return view('admin.administrator.list', ['list' => Administrator::paginate(15)]);
    }

    protected function getAdministratorModel($id)
    {
        return $id === null ? new Order() : Administrator::findOrFail($id);
    }

    public function getAdminPage($id = null)
    {
        return view('admin.administrator.page', ['model' => $this->getAdministratorModel($id)]);
    }

    public function AdminPage(Request $request,$id = null)
    {
        Administrator::where('id', '=', $id)->update(['name' =>$request->input(['name']),'mobile'=>$request->input(['mobile'])]);
        return response()->json(['code' => 1, 'url' => '', 'message' => '保存成功']);
    }
}