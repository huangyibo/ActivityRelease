<?php

use Illuminate\Support\Str;
use Illuminate\View\Expression;

// 如：db:seed 或者 清空数据库命令的地方调用
function insanity_check()
{
    if (App::environment('production')) {
        exit('别傻了? 这是线上环境呀。');
    }
}

function admin_link($title, $path, $id = '')
{
    return '<a href="' . admin_url($path, $id) . '" target="_blank">' . $title . '</a>';
}

function admin_url($path, $id = '')
{
    return env('APP_URL') . "/admin/$path" . ($id ? '/' . $id : '');
}

function admin_enum_style_output($value, $reverse = false)
{
    if ($reverse) {
        $class = ($value === true || $value == 'yes') ? 'danger' : 'success';
    } else {
        $class = ($value === true || $value == 'yes') ? 'success' : 'danger';
    }

    return '<span class="label bg-' . $class . '">' . $value . '</span>';
}


function make_excerpt($value)
{
    $excerpt = trim(preg_replace('/\s\s+/', ' ', strip_tags($value)));
    return str_limit($excerpt, 80);
}

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function markdown($text)
{
    return (new ParsedownExtra)->setBreaksEnabled(true)->text($text);
}

function cdn($filepath)
{
    if (config('app.url_static')) {
        return config('app.url_static') . $filepath;
    } else {
        return config('app.url') . $filepath;
    }
}

function img_crop($filepath, $width = 0, $height = 0)
{
    return $filepath . "?imageView2/1/w/{$width}/h/{$height}";
}

function navViewActive($url, $active = 'setting-nav-active')
{
    return Route::currentRouteName() === $url ? $active : '';
}

function navViewActiveByUrl($url, $active = 'setting-nav-active')
{
    return Request::path() === $url ? $active : '';
}

function gender_selected($option, $value, $selected = 'selected')
{
    return ($option === $value) ? $selected : '';
}

function time_show($time)
{
    $time_start = $time;
    if ($time == '') {
        $time_result = '--';
    } else {
        $time = time() - strtotime($time);
        if ($time <= 60) { //1分钟以内
            $time_result = $time . " 秒前";

        } elseif ($time <= 60 * 60) { //1小时以内
            $time_result = floor($time / 60) . " 分钟前";   //ceil向上取整，floor小数部分舍去取整

        } elseif ($time <= (60 * 60 * 24 * 1)) { //1天以内
            $time_result = floor($time / 3600) . " 小时前";

        } elseif ($time <= (60 * 60 * 24 * 7)) { //7天以内
            $time_result = floor($time / 3600 / 24) . " 天前";

        } elseif ($time <= (60 * 60 * 24 * 7 * 4)) { // 4周内
            $time_result = floor($time / 3600 / 24 / 7) . " 周前";

        } elseif ($time <= (60 * 60 * 24 * 7 * 4 * 12)) { // 12个月内
            $time_result = floor($time / 3600 / 24 / 7 / 4) . " 月前";

        } elseif ($time <= (60 * 60 * 24 * 7 * 4 * 12 * 5)) { // 5年内

            $time_result = floor($time / 3600 / 24 / 7 / 4 / 12) . " 年前";
        } else {
            $time_result = date("Y-m-d H:i", strtotime($time_start));

        }
    }
    return $time_result;
}

function format_time($time){
    return date("Y年m月d日 H:i", strtotime($time));
}


function is_http_url($url){
    return \Illuminate\Support\Str::startsWith($url, 'http');
}

function parseApplyTemplates($applyTemplates){
    $result = '';
    foreach ($applyTemplates as $applyTemplate){
        $html = '<div class="form-group">';
        $html += '<label for="'+ $applyTemplate->apply_attr_id +'" class="control-label">';
        if ($applyTemplate->is_required){
            $html += '<span style="color: red;">*</span>';
        }
        $html += $applyTemplate->apply_attr->attr_slug +'</label>';
        if (is_null($applyTemplate->apply_attr->attr_type)){
            $applyTemplate->apply_attr->attr_type = 'text';
        }

        switch ($applyTemplate->apply_attr->attr_type){
            case 'textarea':
                $html += '<textarea class="form-control" id="'+ $applyTemplate->apply_attr_id
                    +'" name="'+ $applyTemplate->apply_attr->attr_name + '" rows="3" placeholder="'+
                    $applyTemplate->apply_attr->attr_slug +'"></textarea>';
                break;
            default:
                $html += '<input type="' + $applyTemplate->apply_attr->attr_type + '" class="form-control" id="' +
                    $applyTemplate->apply_attr_id + '" name="' + $applyTemplate->apply_attr->attr_name + '" placeholder="'+
                    $applyTemplate->apply_attr->attr_slug + '" ';
                if ($applyTemplate->is_required){
                    $html += 'required';
                }
                $html += '>';
                break;
        }
        $html += '</div>';
        $result += $html;
    }
    return new Expression($result);
}

function is_existed($data){
    return (isset($data) && count($data)>0);
}

function format_datetime_local($data){
    return date('Y-m-d', strtotime($data)).'T'.date('H:i', strtotime($data));
}

function posts_show_form($post){

}