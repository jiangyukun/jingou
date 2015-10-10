<?php namespace ZuiHuiGou\Http;
use Illuminate\Support\Facades\File;

/**
 * Created by PhpStorm.
 * User: DT27
 * Date: 15/6/3
 * Time: 13:17
 */
class Helper{
    function mt_rand_str ($l, $c = 'abcdefghijklmnopqrstuvwxyz1234567890') {
        for ($s = '', $cl = strlen($c)-1, $i = 0; $i < $l; $s .= $c[mt_rand(0, $cl)], ++$i);
        return $s;
    }
    function chstr($str,$in){
        $tmparr = explode($in,$str);
        if(count($tmparr)>1){
            return true;
        }else{
            return false;
        }
    }


    /**
     * 保存远程图片到服务器
     * @param $url 远程图片的完整URL地址，不能为空。
     * @param string $filename 可选变量: 如果为空，本地文件名将基于时间和日期自动生成。
     * @param string $savefile
     * @return bool|string
     */
    function get_thumb($url,$filename='',$savefile='thumb/goods/')
    {
        $imgArr = array('gif','bmp','png','ico','jpg','jepg');

        if(!$url) return false;

        if(!$filename) {
            $tmp_url=explode('.',$url);
            $ext=strtolower(end($tmp_url));
            if(!in_array($ext,$imgArr)) return false;
            $filename=date("dMYHis").'.'.$ext;
        }

        if(!is_dir($savefile)) mkdir($savefile, 0777);
        if(!is_readable($savefile)) chmod($savefile, 0777);

        $filename = $savefile.$filename;

        ob_start();
        readfile($url);
        $img = ob_get_contents();
        ob_end_clean();
        $size = strlen($img);

        $fp2=@fopen($filename, "a");
        fwrite($fp2,$img);
        fclose($fp2);

        return $filename;
    }


}