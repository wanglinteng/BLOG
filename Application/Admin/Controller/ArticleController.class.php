<?php
namespace Admin\Controller;
use Think\Controller;
class ArticleController extends BaseController {
    /**
     * 读取文章列表
     * @author MR.WLT
     */
    public function index($title = null){
        //搜索匹配
        if($title != null){
            $map['title'] = array('like', '%'.$title.'%');
        }
        //过滤状态
        $map['status'] = 1;

        /**分页start**/
        $count = M('Article')->where($map)->count();

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
        $list = M('Article')->where($map)->order('create_time desc')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('list',$list);
        $this->display();
    }

    /**
     * 添加文章
     * @author Mr.WLT
     */
    public function add(){
        if(IS_POST){
            //自动验证表单是否为空
            $Article = D("Article");
            if (!$Article->create()){
                $error = $Article->getError();//获取错误信息
                $this->error($error);//输出错误信息
            }else{
                $Article->create_ip = get_client_ip(1);//获取ip
                $return = $Article->add();//添加信息
                $this->chk_ret($return);
            }
        }else{
            $this->kind_list();
            $this->display();
        }
    }

    /**
     * @param $return
     * 判断返回状态
     * @author MR.WLT
     */
    private function chk_ret($return = null,$url = null){
        if($return){
            if($url != null){
                $this->success('操作成功！',U($url));
            }else{
                $this->success('操作成功！');
            }
        }else{
            $this->error('操作失败！');
        }
    }
    /**
     * 编辑文章
     * @author MR.WLT
     */
    public function edit($id = null){
        $Article = M('Article');
        if(IS_POST){
            //自动验证表单是否为空
            $Article = D("Article");
            if (!$Article->create()){
                $error = $Article->getError();//获取错误信息
                $this->error($error);//输出错误信息
            }else{
                $return = $Article->where(array('id'=>$id))->save();//添加信息
                $this->chk_ret($return,'index');
            }

        }else{
            $info = $Article->where(array('id'=>$id))->find();
            $this->assign('info',$info);
            $this->kind_list();
            $this->display();
        }
    }
    /**
     * 获取文章分类
     * @author MR.WLt
     */
    private function kind_list(){
        //获取文章分类
        $map = array(
            'status' => 1
        );
        $kind_list = M('kind')->where($map)->select();
        $this->assign('_kind_list',$kind_list);
    }
    /**
     * 状态改变
     * @author Mr.WLT
     */
    public function status($id = null,$method = null){
        $Article = M('Article');
        switch($method){
            case 'delete':   $data['status'] = -1; break;
            case 'reduction':$data['status'] =  1; break;
            default:$this->error('参数有误！');
        }
        $return = $Article->where(array('id'=>$id))->data($data)->save();
        $this->chk_ret($return);
    }
    /**
     * 文章回收
     * @author MR.WLT
     */
    public function recycle(){
        //过滤状态
        $map['status'] = -1;

        /**分页start**/
        $count = M('Article')->where($map)->count();

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
        $list = M('Article')->where($map)->order('create_time desc')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('list',$list);
        $this->display();
    }
    /**
     * 删除一条记录
     * @author MR.WLT
     */
    public function delete_one($id = null){
        $return = M('Article')->where(array('id'=>$id))->delete();
        $this->chk_ret($return);
    }
}