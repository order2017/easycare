<?php
/**
 * Created by PhpStorm.
 * User: 87212
 * Date: 2016/7/11
 * Time: 16:36
 */

namespace App\Http\Requests;


class CommentRequest extends Request
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
           'content' => 'required'
        ];
    }

}