<?php
namespace Admin\Model;
use Think\Model;
class ArticleModel extends Model {
    //自动验证提交表单是否为空
    protected $_validate = array(
        array('title','require','标题不允许为空！'),
        array('kind','require','分类不允许为空！'),
        array('content','require','内容不允许为空！'),
    );
    protected $_auto = array (
        array('status','1'),
        array('create_time','time',1,'function')
    );
}