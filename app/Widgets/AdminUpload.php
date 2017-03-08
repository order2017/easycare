<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/7/29
 * Time: 9:20
 */

namespace App\Widgets;


use Arrilot\Widgets\AbstractWidget;

class AdminUpload extends AbstractWidget
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
        if (!array_key_exists('name', $this->config) || !array_key_exists('value', $this->config)) {
            throw new \InvalidArgumentException('name and value must be set');
        }
        return view('widgets.admin-upload', ['name' => $this->config['name'], 'value' => $this->config['value']]);
    }
}