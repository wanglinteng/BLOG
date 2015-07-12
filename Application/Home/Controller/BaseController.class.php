<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller {
    /**
     * 网页基本信息
     * @author MR.WLT
     */
    public function _initialize(){
        $nav_list = F('nav_list');
        if(!$nav_list){
            $Kind = M('Kind');
            $map = array('status'=>1);
            $nav_list = $Kind->where($map)->order('location')->select();
            F('nav_List',$nav_list);
        }
        $this->assign('nav_list',$nav_list);
        //获取当前日期
        $this->assign('now',NOW_TIME);
    }
}