<?php


namespace app\member\controller;


use app\model\Log;
use app\model\LoginLog;
use think\Controller;
use think\Request;
use think\Session;

class User extends Controller
{
    public function login(Request $request){
        if ($request->isPost()){
            $map  = array();
            $map['username'] = ["=",trim($request->param('username'))];
            $map['password'] = ["=",md5(trim($request->param('password')))];
            $user = \app\model\User::where($map)->find();
            if (!is_null($user)){
                Session::set("Bill_Auth",$user);
                $log = LoginLog::create([
                    "user" => $user->username,
                    "ip" => $request->ip(),
                ]);
                return json_encode(["status" => 1, "messages" => "登录成功"],JSON_UNESCAPED_UNICODE);
            }else{
                return json_encode(["status" => 0, "messages" => "账号或密码错误"],JSON_UNESCAPED_UNICODE);
            }
        }

    }
    public function logout(){
        Session::set("Bill_Auth",null);
    }
}