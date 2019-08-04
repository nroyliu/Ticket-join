<?php


namespace app\member\controller;


use think\Controller;

class account extends Controller
{
    public function index(){
        return $this->fetch("/member/index");
    }
    public function login(){
        return "login";
    }
}