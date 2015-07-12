<?php
namespace Admin\Controller;
use Think\Controller;
class SiteController extends BaseController {
    /**
     * 网站管理
     * @author MR.WLT
     */
    public function index(){
        $info = array(
            'PhpOs'=>PHP_OS,
            'Server'=>$_SERVER["SERVER_SOFTWARE"],
            'PhpApi'=>php_sapi_name(),
            'ThinkPhp'=>THINK_VERSION,
            'FileSize'=>ini_get('upload_max_filesize'),
            'IP'=>$_SERVER['SERVER_NAME'].' [ '.gethostbyname($_SERVER['SERVER_NAME']).' ]',
        );
        $this->assign('info',$info);
        $this->display();
    }
}