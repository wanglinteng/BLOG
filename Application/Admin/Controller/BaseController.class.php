<?php
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller {
    /**
     * 登陆检测->前置操作
     * @author MR.WLT
     */
    public function _initialize(){
        $username = session('username');
        if(!isset($username)){
            $this->redirect('Login/index');
        }
    }
}