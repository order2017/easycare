<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DirectOrderRequest extends Request
{
    public function messages()
    {
        return [
            'address_id.required' => '请填写收货地址'
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
            'goods_id' => 'required',
            'address_id' => 'required',
        ];
    }
}
