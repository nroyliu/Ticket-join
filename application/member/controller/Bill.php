<?php


namespace app\member\controller;


use app\model\Log;
use app\model\Uploadfile;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

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
        if ($request->isPost()){
            $data = $request->param();
            $order = Db::query("call GetSerialNo('bill_serialize',@result)");
            $data['bid'] = $order[0][0]['result'];
            $data['user'] = Session::get('Bill_Auth')['username'];
            $data['bill_time'] = date("Y-m-d",strtotime($data['bill_time']));
            $billModel = new \app\model\Bill($data);
            $result = $billModel->allowField(['bid','bill_id','user','title','description','money_type','money','bill_time','type'])->save();
            $bid = $billModel->id;
            $createTime = $billModel->create_time;
            if (empty($data['upload'])){

            }else{
                $fileid = array();
                foreach($data['upload'] as $item){
                    $fileid[] = $item['response']['fileid'];
                }
                $uploadModel = new Uploadfile();
                $uploadModel->where("id", "in", implode(",", $fileid))->update(["bid" => $bid]);
            }
            if ($result){
                $log = Log::create([
                    "bid" => $bid,
                    "user" => $data['user'],
                    "log" => "创建于",
                    "create_time" => $createTime,
                ]);
                return json_encode([
                    "status" => 1,
                    "message" => "创建成功"
                ]);
            }
        }
    }
    public function getList(Request $request){
        if ($request->isPost()){
            $user = Session::get("Bill_Auth");
            $username = $user->username;
            $Ticket = \app\model\Bill::where('user','=',$username)->order("create_time","desc")->select();
            if ($Ticket){
                return $Ticket->toJson();
            }
        }
    }
    public function getTicket(Request $request){
        if ($request->isPost()){
            $Ticket = \app\model\Bill::where('id','=',$request->param("id"))->find();
            $files = Uploadfile::where('bid','=',$request->param("id"))->select();
            $logs = Log::where('bid','=',$request->param("id"))->select();
            if ($request){
                return json_encode([
                    "status" => 1,
                    "ticket" => $Ticket,
                    "files" => $files,
                    "logs" => $logs
                ]);
            }
        }
    }
    
}