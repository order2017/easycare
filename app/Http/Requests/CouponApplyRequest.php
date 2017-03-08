<?php
/**
 * Created by PhpStorm.
 * User: 87212
 * Date: 2016/7/11
 * Time: 16:36
 */

namespace App\Http\Requests;


class CouponApplyRequest extends Request
{
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
            'type' =>'required',
            'title' => 'required',
            'shop_id' => 'required',
            'scope' => 'required',
            'condition' => 'required',
            'integral' => 'required|integer',
        ];
    }

}