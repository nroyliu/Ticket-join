<?php


namespace app\member\controller;


use think\Controller;
use think\Request;

class Bill extends Controller
{
    public function index(){
        return $this->fetch("/member/bill");
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