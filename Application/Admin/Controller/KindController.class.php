<?php
namespace Admin\Controller;
use Think\Controller;
class KindController extends BaseController {
    /**
     * 分类管理
     * @author MR.WLT
     */
    public function index(){
        //过滤状态
        $map['status'] = 1;
        $Kind = M('Kind');
        /**分页start**/
        $count = $Kind->where($map)->count();

        $page = new \Think\Page($count,10);
        //配置信息
        $page->setConfig('header','条记录');
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('first','首页');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','共 %TOTAL_ROW% 条记录 %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        //配置信息end
        $show = $page->show();
        $this -> assign('page',$show);
        /**分页end**/
        $list = $Kind->where($map)->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('list',$list);
        //输出页面
        $this->display();
    }
    /**
     * 分类添加
     * @author MR.WLT
     */
    public function add(){
        if(IS_POST){
            $name = I('name');
            $location = I('location');
            if($name == null){
                $this->error('分类名称不能为空！');
            }
            $data = array(
                'name'    => $name,
                'location'=> $location,
                'status'  => 1,
            );
            $return = M('Kind')->data($data)->add();
            if($return){
                $this->success('分类添加成功！',U('index'));
            }else{
                $this->error('分类添加失败！');
            }
        }else{
            $this->display();
        }

    }
    /**
     * 分类删除
     * @author MR.WLT
     */
    public function delete_one($id = null){
        $return = M('Kind')->where(array('id'=>$id))->delete();
        if($return){
            $this->success('删除成功！');
        }else{
            $this->error('删除失败！');
        }

    }
    /**
     * 分类编辑
     * @author MR.WLT
     */
    public function edit($id = null,$name = null,$location = null){
        $Kind = M('Kind');
        if(IS_POST){
            $return = $Kind->where(array('id'=>$id))->data(array('name'=>$name,'location'=>$location))->save();
            if($return){
                $this->success('更新成功！',U('index'));
            }else{
                $this->error('更新失败！');
            }
        }else{
            $info = $Kind->where(array('id'=>$id))->find();
            $this->assign('info',$info);
            $this->display();
        }
    }
}