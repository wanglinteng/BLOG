<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends BaseController {
    /**
     * 用户管理
     * @author MR.WLT
     */
    public function index(){
        //过滤状态
        $map['status'] = 1;
        $Member = M('Member');
        /**分页start**/
        $count = $Member->where($map)->count();

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
        $list = $Member->where($map)->order('land_time desc')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('list',$list);
        //输出页面
        $this->display();
    }
    public function log(){
        //过滤状态
        $map['status'] = 1;
        $Log = M('Log');
        /**分页start**/
        $count = $Log->where($map)->count();

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
        $list = $Log->where($map)->order('land_time desc')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('list',$list);
        //输出页面
        $this->display();
    }
    /**
     * 修改密码
     * @author MR.WLT
     */
    public function change($password = null ,$sure = null){
        if(IS_POST){
            if($password != $sure){
                $this->error('两次输入密码不一致！');
            }else{
                $username = session('username');
                $data = array('password'=>md5($password));
                $return = M('Member')->where(array('username'=>$username))->data($data)->save();
                if($return){
                    $this->success('密码修改成功,下次登录请使用新密码！',U('index'));
                }else{
                    $this->error('密码修改失败！');
                }
            }
        }else{
            $this->display();
        }
    }
}