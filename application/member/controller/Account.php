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
}