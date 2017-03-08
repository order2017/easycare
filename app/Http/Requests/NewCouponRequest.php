<?php
/**
 * Created by PhpStorm.
 * User: zane
 * Date: 2016/7/6
 * Time: 15:16
 */

namespace App\Http\Requests;


class NewCouponRequest extends Request
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
            'thumb' => 'required',
            'time_type' => 'required'
        ];
    }

}