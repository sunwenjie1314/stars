<?php
namespace app\edu\controller;

use think\Controller;
use think\Request;

class Test extends Controller{
    public function index(){
       $name= '12345';
       $this->assign('name',$name);
       //$this->display('index');
       return $this->fetch();
    }
    public function demo(){
        $request=Request::instance();
        echo 'domain:'.$request->domain().'</br>';
        echo 'file:'.$request->baseFile().'</br>';
        echo "当前模块是：".$request->module();
        echo "当前控制器是：".$request->controller();
        echo "当前操作名称是：".$request->action();
        echo "调度信息：".dump($request->dispatch()).'</br>';
        echo "这是utf-8字符集";
    }
}