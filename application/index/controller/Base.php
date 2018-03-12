<?php
namespace app\index\controller;

use think\Controller;
use think\Session;

class Base extends Controller
{
  protected  function _initialize(){
      parent::_initialize();        //继承父类型的初始化操作;
      define('USER_ID', Session::get('user_id'));       //静态的定义“USER_ID”这个常量，用于后续的判定操作。USER_ID就是SESSION中的用户id。   
  }
  //判断用户是否登录，放在后台的入口文件中：index/index    即index控制的index方法中
  protected  function isLogin() {
      if (empty(USER_ID)) {
          $this->error('用户未登录，无权访问!',url('user/login'));
      }
  }
  //防止用户重复登录
  protected  function alreadyLogin() {
     if (!empty(USER_ID)) {
         $this->error('用户已经登录,请勿重复登录!',url('index/index'));
     }
  }
}
