<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-7-23
 * Time: 上午8:47
 */

namespace ZuiHuiGou\libraries\api;


class taobao {

    public function display()
    {
        echo "this is a echo from taobaoapi<br />";
    }

    public function getinfo($url)
    {
        $goods = array();
        $r = mb_convert_encoding(file_get_contents($url), 'UTF-8', 'GBK,GB2312,UTF-8'); //用file_get_contents将网址打开并读取所打开的页面的内容
        preg_match('/J_itemViewed[\S\s]+?J_showContract/', $r, $goods_id);


        preg_match('/{[\S\s]+?}/', $goods_id[0], $infos);
        $oneinfo=json_decode($infos[0]);

        $goods['id'] = $oneinfo->itemId;
        $goods['price'] = $oneinfo->price/100;
        $goods['name'] = $oneinfo->title;
        $goods['img'] = 'http://gd2.alicdn.com/bao/uploaded/i2/' . $oneinfo->pic;

        $error['code'] = 0;
        $error['msg'] = '';
        return array($error, $goods);
    }
} 