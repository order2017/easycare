<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProductRequest extends Request
{
    public function messages()
    {
        return [
            'model.required' => '产品型号不能为空',
            'model.unique' => '产品型号不能重复',
            'model.integer' => '产品型号必须为纯数字',
            'name.required' => '产品名称不能为空',
            'integral.required' => '基础积分不能为空',
            'integral.integer' => '基础积分必须为数字',
            'commission.numeric' => '请输入正确的基础佣金',
            'commission.required' => '基础佣金不能为空'
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
            'model' => 'required|integer|unique:products,model,' . $this->route('id'),
            'name' => 'required',
            'integral' => 'required|integer',
            'commission' => 'required|numeric'
        ];
    }
}
