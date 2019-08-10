<?php


namespace app\member\controller;


use think\Controller;
use think\Request;

class Bill extends Controller
{
    public function user(){
        return $this->fetch("/member/bill_user");
    }
    public function finance(){
        return $this->fetch("/member/bill_finance");
    }
    public function teller(){
        return $this->fetch("/member/bill_teller");
    }
    public function create(Request $request){

    }
    public function getList(){
        echo('[
        {"id":"20190731001","title":"活动费用","create_time": "2019-8-02","status":"1"},
        {"id":"20190731001","title":"活动费用","create_time": "2019-8-02","status":"2"},
        {"id":"20190731001","title":"活动费用","create_time": "2019-8-02","status":"3"},
        {"id":"20190731001","title":"活动费用","create_time": "2019-8-02","status":"4"},
        {"id":"20190731001","title":"活动费用","create_time": "2019-8-02","status":"1"},
        {"id":"20190731001","title":"活动费用","create_time": "2019-8-02","status":"1"},
        {"id":"20190731001","title":"活动费用","create_time": "2019-8-02","status":"1"},
        {"id":"20190731001","title":"活动费用","create_time": "2019-8-02","status":"1"},
        {"id":"20190731001","title":"活动费用","create_time": "2019-8-02","status":"1"},
        {"id":"20190731001","title":"活动费用","create_time": "2019-8-02","status":"1"}
        ]');
    }
    
}