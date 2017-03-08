<?php
if (!function_exists('assets')) {
    /**
     *
     * @param  $file
     * @param $baseUrl
     * @return string
     *
     */
    function assets($file, $baseUrl = null)
    {
        $baseUrl = $baseUrl === null ? config('ASSETS_BASE_URL', '') : $baseUrl;
        return $baseUrl . elixir($file, 'assets');
    }
}