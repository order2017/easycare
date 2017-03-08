<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/6/15
 * Time: 9:38
 */

namespace App;

use Illuminate\Pagination\SimpleBootstrapThreePresenter;
use Illuminate\Support\HtmlString;

class NewSimplePaginationPresenter extends SimpleBootstrapThreePresenter
{

    public function render()
    {
        if ($this->hasPages()) {
            return new HtmlString(sprintf(
                '<ul class="am-pagination am-fr am-animation-slide-bottom">%s %s</ul>',
                $this->getPreviousButton(),
                $this->getNextButton()
            ));
        }

        return '';
    }

    protected function getAvailablePageWrapper($url, $page, $rel = null)
    {
        $rel = is_null($rel) ? '' : ' rel="'.$rel.'"';

        return '<li><a href="'.htmlentities($url).'"'.$rel.' data-toggle="page">'.$page.'</a></li>';
    }

    protected function getDisabledTextWrapper($text)
    {
        return '<li class="am-disabled"><span>' . $text . '</span></li>';
    }

    protected function getActivePageWrapper($text)
    {
        return '<li class="am-active"><span>' . $text . '</span></li>';
    }
}