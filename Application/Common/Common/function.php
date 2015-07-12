<?php
/**
 * 获取记录状态
 * @author MR.WLT
 */
function get_status($status = null){
    switch($status){
        case  1:  return '正　常';break;
        case -1:  return '已删除';break;
    }
}
/**
 * 检验验证码是否正确
 * @author MR.WLT
 */
function check_verify($code = null, $id = null){
    $verify = new \Think\Verify();
    return  $verify->check($code, $id);

}
/**
 * 获取文章分类
 * @author MR.WLT
 */
function get_kind_name($kind = null){
    $name = M('Kind')->where(array('id'=>$kind))->getField('name');
    return $name;
}
/**
 * 通过id返回用户名
 * @author MR.WLT
 */
function get_name($id = null){
    $username = M('Member')->where(array('id'=>$id))->getField('username');
    return $username;
}

function real_strip_tags($str, $allowable_tags = "")
{
    $str = html_entity_decode($str, ENT_QUOTES, 'UTF-8');
    return strip_tags($str, $allowable_tags);
}
/**
 * t函数用于过滤标签，输出没有html的干净的文本
 * @param string text 文本内容
 * @return string 处理后内容
 */
function op_t($text)
{
    $text = nl2br($text);
    $text = real_strip_tags($text);
    $text = addslashes($text);
    $text = trim($text);
    return $text;
}
/**
 * 字符串截取，支持中文和其他编码
 * @static
 * @access public
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @return string
 */
function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true)
{
    if (function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif (function_exists('iconv_substr')) {
        $slice = iconv_substr($str, $start, $length, $charset);
        if (false === $slice) {
            $slice = '';
        }
    } else {
        $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("", array_slice($match[0], $start, $length));
    }
    return $suffix ? $slice . '...' : $slice;
}

/**
 * 截取指定标题长度
 * @author MR.WLT
 */
function num_get_sort($string = null)
{    
    //过滤HTML代码
    $string = op_t($string);
    //判断字符串长度
    if(strlen($string) > 200){
        //截取字符串
        return msubstr($string, 0, 200, "utf-8", true);
    }else{
        //截取字符串
        return msubstr($string, 0, 200, "utf-8", false);
    }
}
