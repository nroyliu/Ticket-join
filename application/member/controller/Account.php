<?php


namespace app\member\controller;


use think\Controller;
use think\Session;

class account extends Base
{
    public function index(){
        $user = Session::get('Bill_Auth');
        return $this->fetch("/member/index");
    }
    public function getUserInfo(){
        $user = Session::get("Bill_Auth");
        $data = [
            "id" => $user->id,
            "username" => $user->username,
            "ident" => $user->ident,
            "status" => $user->status,
        ];
        return json_encode($data);
    }
}