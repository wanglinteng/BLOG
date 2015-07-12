<?php

namespace Home\Controller;

use Think\Controller;

class IndexController extends BaseController {



    /**

     * 显示首页&&列表页

     * @author MR.WLT

     */

    public function index($kind = null,$title = null){

        if($kind != null){

           $map['kind'] = $kind;

        }

        if($title != null){

            $map['title'] = array('like', '%'.$title.'%');

        }

        $map['status'] = 1;

        //正文

        $Article = M('Article');

        $list = $Article->where($map)->limit(10)->order('create_time desc')->select();

        $this->assign('list',$list);

        //右侧导航

        $right = $Article->where($map)->limit(20)->order('create_time desc')->select();

        $this->assign('right',$right);



        $this->display();

    }

    /**

     * 详情页

     * @author MR.WLT

     */

    public function detail($id = null,$kind = null){

        $Article = M('Article');



        //获取有导航栏

        if($kind != null){

            $map['kind'] = $kind;

        }

        $map['status'] = 1;

        $right = $Article->where($map)->limit(20)->order('create_time desc')->select();

        $this->assign('right',$right);

        //详情

        $info = $Article->where(array('id'=>$id))->find();

        $this->assign('info',$info);

        $this->display();

    }

    /**

     * 浏览量统计

     * @author MR.WLT

     */

    public function census($id = null){

        $Article = M('Article');

        $map = array('id'=>$id);

        $census = $Article->where($map)->getField('view');

        $data['view'] = $census + 1;

        $return = $Article->where($map)->save($data);

        if(!$return){

            $this->error('浏览数量统计错误！');

        }

    }





}