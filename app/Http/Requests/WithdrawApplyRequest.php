<?php

namespace App\Http\Requests;


use Auth;

class WithdrawApplyRequest extends Request
{

    public function messages()
    {
        return [
            'money.required' => '请填写提现的金额',
            'money.numeric' => '提现金额必须是数字',
            'money.min' => '提现金额必须大于1元',
            'money.max' => '提现的金额超过可提金额'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->is_boss;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'money' => 'required|numeric|min:1|max:' . Auth::user()->can_convert_commission
        ];
    }
}
