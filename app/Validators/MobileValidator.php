<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/6/7
 * Time: 21:24
 */

namespace App\Validators;

class MobileValidator
{
    protected $number = [
        '134', '135', '136', '137', '138', '139', '147', '150', '151', '152', '157', '158', '159', '178', '182',
        '183', '184', '187', '188', '130', '131', '132', '145', '155', '156', '176', '185', '186', '133', '153',
        '177', '180', '181', '189', '170'
    ];

    public function validate($attribute, $value, $parameters)
    {
        return (preg_match('/^\d{11}$/', $value) === 1) && in_array(substr($value, 0, 3), $this->number);
    }
}