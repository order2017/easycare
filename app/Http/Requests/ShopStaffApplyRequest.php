<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\ShopStaffApply;
use App\User;

class ShopStaffApplyRequest extends Request
{
    protected function getValidatorInstance()
    {
        $v = parent::getValidatorInstance();
        $v->sometimes('boss_id', 'required|exists:bosses,id,employees_id,' . \Auth::user()->id, function ($input) {
            return $input->role == User::ROLE_SALE;
        });
        return $v;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->is_employee;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'province_id' => 'required',
            'city_id' => 'required',
            'county_id' => 'required',
        ];
    }

}
