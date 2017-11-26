<?php

if (!function_exists('homepage_slider'))
{
    function homepage_slider()
    {
        $slider_values = App\Models\Hamahang\BasicdataValue::where('parent_id', 6)->get();
        $output = view('index.helper.homepage_slider')
            ->with('slider_values', $slider_values);
        return $output;
    }
}

if (!function_exists('homepage_ads'))
{
    function homepage_ads()
    {
        $ads_values = App\Models\Hamahang\BasicdataValue::where('parent_id', 7)->get();
        $output = view('index.helper.homepage_ads')
            ->with('ads_values', $ads_values);
        return $output;
    }
}

if (!function_exists('homepage_news'))
{
    function homepage_news($tab)
    {
        $output = view('index.helper.homepage_news')
            ->with('tab', $tab);
        return $output;
    }
}