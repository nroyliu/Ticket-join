<?php


namespace app\member\controller;


use think\Controller;
use think\Session;

class Base extends Controller
{
    protected function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->Check_Auth();
    }
    public function Check_Auth(){
        $User = Session::get('Bill_Auth');
        if (is_null($User)){
            echo "<script>window.location.href = '/'</script>";
        }
    }
}