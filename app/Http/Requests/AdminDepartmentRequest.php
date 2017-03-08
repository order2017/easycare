<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AdminDepartmentRequest extends Request
{
    public function messages()
    {
        return [
            'name.required' => '部门名称不能为空',
            'name.unique' => '部门名称不能重复'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:departments,name,' . $this->route('id')
        ];
    }
}
