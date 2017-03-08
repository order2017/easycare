<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/6/17
 * Time: 14:25
 */

namespace App\Http\Requests;


class ApplyEmployeeRequest extends Request
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
            'mobile' => 'required|mobile',
            'email' => 'email|required',
            'departments_id' => 'required|exists:departments,id',
            'address' => 'required',
            'province_id' => 'required|exists:region.region,id',
            'city_id' => 'required|exists:region.region,id',
            'county_id' => 'required|exists:region.region,id',
        ];
    }
    
}