<?php

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminDepartmentRequest;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $list = Department::paginate(15);
        return view('admin.department.list', ['list' => $list]);
    }

    public function getPage($id = null)
    {
        $model = $id === null ? new Department() : Department::findOrFail($id);
        return view('admin.department.page', ['model' => $model]);
    }

    public function postPage(AdminDepartmentRequest $request, $id = null)
    {
        $model = $id === null ? new Department() : Department::findOrFail($id);
        $model->setAttribute('name', $request->input('name'))->saveOrFail();
        return response()->json(['code' => 1, 'url' => '', 'message' => '保存成功']);
    }

    public function delete($id)
    {
        $model = Department::findOrFail($id);
        return $model->delete() ? response()->json(['code' => 1, 'url' => '', 'message' => '删除成功']) : response()->json(['code' => 1, 'url' => '', 'message' => '删除失败']);
    }
}