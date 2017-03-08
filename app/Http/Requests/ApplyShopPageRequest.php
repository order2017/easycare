<?php
/**
 * Created by PhpStorm.
 * User: zane
 * Date: 2016/7/6
 * Time: 15:16
 */

namespace App\Http\Requests;


class ApplyShopPageRequest extends Request
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
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'location' => 'required',
        ];
    }

}