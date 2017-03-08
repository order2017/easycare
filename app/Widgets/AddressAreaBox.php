<?php

namespace App\Widgets;

use App\Region;
use Arrilot\Widgets\AbstractWidget;

class AddressAreaBox extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $provinceId = isset($this->config['province_id']) ? $this->config['province_id'] : null;
        $cityId = isset($this->config['city_id']) ? $this->config['city_id'] : null;
        $countyId = isset($this->config['county_id']) ? $this->config['county_id'] : null;
        $provinceList = Region::whereParent(0)->get();
        $provinceId = empty($provinceId) ? $provinceList[0]->id : $provinceId;
        $cityList = Region::whereParent($provinceId)->get();
        $cityId = empty($cityId) ? $cityList[0]->id : $cityId;
        $countyList = Region::whereParent($cityId)->get();
        $countyId = empty($countyId) ? $countyList[0]->id : $countyId;
        return view("widgets.address_area_box", [
            'provinceList' => $provinceList,
            'provinceId' => $provinceId,
            'cityList' => $cityList,
            'cityId' => $cityId,
            'countyList' => $countyList,
            'countyId' => $countyId,
        ]);
    }
}