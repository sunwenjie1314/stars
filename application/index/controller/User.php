<?php
namespace app\index\controller;

use think\Request;
use app\index\model\User as UserModel;
use think\Session;

class User extends Base
{

    // 用户登录
    public function login()
    {
        $this->alreadyLogin();          //调用alreadyLogin方法防止重复登录
        return $this->fetch();
    }

    // 登录检测
    public function checkLogin(Request $request)
    {
        $status = 0;
        $result = '';
        $data = $request->param();
        
        // 创建验证规则
        $rule = [
            'name|用户名' => 'require',
            'password|登录密码' => 'require',
            'verify|验证码' => 'require|captcha'
        ];
        // 创建自定义提示
        $msg = [
            'name' => [
                'require' => '用户名不能为空,请检查!'
            ],
            'password' => [
                'require' => '用户密码为空,请检查!'
            ],
            'verify' => [
                'require' => '验证码不能为空,请检查!',
                'capthcha' => '验证码错误'
            ]
        ];
        
        // 进行验证
        $result = $this->validate($data, $rule);

        // 如果验证通过则执行
         if ($result === true) {
            // 构造查询条件
            $map = [
                'name' => $data['name'],          //用户名等于从前台获取的用户名
                'password' => md5($data['password'])    //对从前端获取的用户密码进行加密
            ];
            // 查询用户信息
            $user = UserModel::get($map);  
            if ($user === null) {
                $result = '没有找到该用户!';
            } else {
                $status = 1;
                $result = '点击确定进入系统!';
               //设置使用记录用户登录信息session
               Session::set('user_id',$user->id);
               Session::set('user_info',$user->getData());//设置获取用户所有登录信息
            } 
        } 
        return [
            'status' => $status,
            'message' => $result,
            'data' => $data
        ];
    }

    // 退出登录（注销session）
    public function logout( )
    {
       Session::delete('user_id');      //删除用户的id信息
       Session::delete('user_info');    //删除用户的全部信息
       $this->success('注销登录,正在返回',url('user/login'));
    }
}