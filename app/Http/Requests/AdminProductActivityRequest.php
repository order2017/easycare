<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AdminProductActivityRequest extends Request
{
    public function messages()
    {
        return [
            'title.required' => '活动名称不能为空',
            'total.required' => '总参与人数不能为空',
            'rules.rules' => '奖品数量或奖励数不能为空',
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
            'title' => 'required',
            'type' => 'required',
            'send_method' => 'required',
            'begin_time' => 'required|date',
            'end_time' => 'required|date|after:begin_time',
            'products' => 'required|array',
            'rules' => 'array|rules|required',
        ];
    }
}
