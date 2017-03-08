<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\ShopStaffApply;
use App\User;

class SaleApplyRequest extends Request
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
            'role' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'county_id' => 'required',
        ];
    }

}
