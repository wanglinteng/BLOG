<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends BaseController {
    public function index(){
        //读取一级导航
        $map_main = array(
            'level'  => 1,
            'status' => 1
        );
        $main = M('nav')->where($map_main)->select();
        $this->assign('_main',$main);
        //读取二级导航
        $map_second = array(
            'level'  => 2,
            'status' => 1
        );
        $second = M('nav')->where($map_second)->select();
        $this->assign('_second',$second);
    	$this->display();
    }
}