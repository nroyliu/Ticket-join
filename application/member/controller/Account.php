<?php


namespace app\member\controller;


use think\Controller;

class account extends Controller
{
    public function index(){
        $this->assign("page","/member/bill/finance.html");
        return $this->fetch("/member/index");
    }
}