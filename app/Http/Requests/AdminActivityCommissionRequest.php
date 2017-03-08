<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AdminActivityCommissionRequest extends Request
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
            'title' => 'required',
            'send_method' => 'required',
            'begin_time' => 'required|date',
            'end_time' => 'required|date|after:begin_time',
            'rules.total' => 'required|integer|min:1',
            'products' => 'required|array',
            'rules.'
        ];
    }
}
