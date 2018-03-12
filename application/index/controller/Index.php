<?php
namespace app\index\controller;

class Index extends Base
{
    public function index()
    {
        $this->isLogin();      //进行登录状态检测，测试用户是否登录。
       return $this->fetch(); 
    }
    
    public function hello($name = 'thinkphp')
    {
        $this->assign('name', $name);
        return $this->fetch();
    }
   
}
