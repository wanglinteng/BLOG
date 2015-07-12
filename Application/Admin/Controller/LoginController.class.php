<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
    /**
     * 登陆主界面
     * @author MR.WLT
     */
    public function index(){
        //输出页面
        $this->display();
    }
    public function verify(){
        //生成验证码
        $config =  array(
            'fontSize'    =>    30,    // 验证码字体大小
            'length'      =>    4,     // 验证码位数
            'useNoise'    =>    true, // 关闭验证码杂点
        );
        $Verify =     new \Think\Verify($config);
        $Verify->entry(1);
    }
    /**
     * 验证登录信息
     * @author MR.WLT
     */
    public function check_login($code,$id = 1){
        $return = check_verify($code,$id);
        if(!$return){
            $this->ErrorInfo ='验证码填写有误！';
            $this->display('index');
        }else{
            $username = I('username');
            $password = md5(I('password'));

            $Member = M('Member');
            $map = array(
                'username' => $username,
                'status'   => 1,
            );
            $secret = $Member->where($map)->getField('password');
            $uid    = $Member->where($map)->getField('id');
            //判断密码是否正确
            if($password == $secret){
                //写入session跳转主界面
                session('username',$username);
                //写入本次登录信息
                $number = $Member->where($map)->getField('number');
                $data = array(
                    'number'    => $number + 1,
                    'land_time' => NOW_TIME,
                    'land_ip'   => get_client_ip(1),
                );
                $return = $Member->where($map)->data($data)->save();
                if(!$return){
                    $this->ErrorInfo = '登陆信息记录失败!';
                    $this->display('index');
                }else{
                    //写入本次登录信息end
                    //记录登陆日志
                    $log = array(
                        'uid'       => $uid,
                        'land_ip'   => get_client_ip(1),
                        'land_time' => NOW_TIME,
                    );
                    $return = M('Log')->data($log)->add();
                    if(!$return){
                        $this->ErrorInfo = '登陆日志记录失败！';
                        $this->display('index');
                    }else{
                        $this->redirect('Index/index');
                    }
                }
            }else{
                $this->ErrorInfo = '密码或用户名不正确！';
                $this->display('index');
            }
        }
    }
    /**
     * 判断操作状态
     * @author MR.WLT
     */
    function check_return($return = null,$notice){
        if($return){
            $this->success($notice.'成功！');
        }else{
            $this->error($notice.'失败！');
        }

    }
    /**
     * 注销登陆
     * @author MR.WLT
     */
    function logout(){
        session('username',null);//注销session
        $return = session('username');
        if($return == null){

            $this->success('登出成功！',U('Index/index'));
        }else{
            $this->error('登出失败！');
        }
    }
}