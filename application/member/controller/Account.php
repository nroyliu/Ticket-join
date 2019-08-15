<?php


namespace app\member\controller;


use app\model\LoginLog;
use think\Controller;
use think\Request;
use think\Session;

class account extends Base
{
    public function index(){
        $user = Session::get('Bill_Auth');
        return $this->fetch("/member/index");
    }
    public function getUserInfo(){
        $user = Session::get("Bill_Auth");
        $loginLog = LoginLog::where("user", "=", $user->username)->order("time","desc")->select();
        if ($loginLog->count()>1){
            $log = $loginLog->toArray()[0];
        }else{
            $log = [
                "time" => "-"
            ];
        }
        $data = [
            "id" => $user->id,
            "username" => $user->username,
            "ident" => $user->ident,
            "status" => $user->status,
            "log" => $log,
        ];
        return json_encode($data);
    }
    public function changePassword(Request $request){
        if ($request->isPost()){
            $username = Session::get("Bill_Auth")->username;
            $map  = array();
            $map['username'] = ["=",trim($username)];
            $map['password'] = ["=",md5(trim($request->param('oldpassword')))];
            $user = \app\model\User::where($map)->find();
            if (!is_null($user)){
                $password = md5(trim($request->param('password')));
                $confirm = md5(trim($request->param('confirm')));
                if ($password == $confirm){
                    $userModel = new \app\model\User();
                    $result = $userModel->where($map)->update(["password" => $password]);
                    if ($result){
                        return json_encode(["status" => 1, "message" => "修改成功"],JSON_UNESCAPED_UNICODE);
                    }else{
                        return json_encode(["status" => 0, "message" => "新密码不能与旧密码相同"],JSON_UNESCAPED_UNICODE);
                    }
                }else{
                    return json_encode(["status" => 0, "message" => "两次密码不一致"],JSON_UNESCAPED_UNICODE);
                }
            }else{
                return json_encode(["status" => 0, "message" => "原密码不符"],JSON_UNESCAPED_UNICODE);
            }
        }
    }
}