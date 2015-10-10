<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-7-23
 * Time: 上午9:06
 */

namespace ZuiHuiGou\libraries\api;


class jd
{
    public function display()
    {
        echo "this is a echo from jdapi<br />";
    }

    public function getinfo($url)
    {
        $goods = array();
        $r = mb_convert_encoding(file_get_contents($url), 'UTF-8', 'GBK,GB2312,UTF-8'); //用file_get_contents将网址打开并读取所打开的页面的内容
        preg_match('/skuid: (\d+),/', $r, $goods_id);
        $goods['id'] = $goods_id[1];

        $price_url = 'http://p.3.cn/prices/get?skuid=J_' . $goods['id'] . '&type=1';
        $p = mb_convert_encoding(file_get_contents($price_url), 'UTF-8', 'GBK,GB2312,UTF-8');
        preg_match("/\"p\":\"(\d*\.\d*)\"/", $p, $goods_price);
        $goods['price'] = $goods_price[1];

        preg_match("/<div id=\"itemInfo\">\s*<div id=\"name\">\s*<h1>(.*)<\/h1>/", $r, $goods_title); //匹配商品标题
        $goods['name'] = $goods_title[1]; //取第二层数组

        preg_match("/<div class=\"spec-items\">\s*<ul class=\"lh\">\s*<li><img class='img-hover' alt='.*' src='.*' data-url='(.*)' data-img/", $r, $goods_img); //匹配商品标题
        $goods['img'] = 'http://img11.360buyimg.com/n1/' . $goods_img[1]; //取第二层数组


        $error['code'] = 0;
        $error['msg'] = '';

        return array($error, $goods);
    }
} 