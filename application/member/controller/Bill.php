<?php


namespace app\member\controller;


use app\model\Log;
use app\model\Uploadfile;
use think\Console;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Bill extends Controller
{
    public function user(){
        return $this->fetch("/member/bill_user");
    }
    public function create(Request $request){
        if ($request->isPost()){
            $data = $request->param();
            $order = Db::query("call GetSerialNo('bill_serialize',@result)");
            $data['bid'] = $order[0][0]['result'];
            $user = Session::get('Bill_Auth')['username'];
            if (!isset($data['user'])){
                $data['user'] = $user;
            }
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
                    "user" => $user,
                    "log" => "创建",
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
            if ($user->ident == 1){
                $param = "1,2,3,4,5";
                $Ticket = \app\model\Bill::where('user','=',$username)->where("status","in",$param)->order("create_time","desc")->select();
            }elseif ($user->ident == 2){
                $param = "1,2,3,4,5";
                $Ticket = \app\model\Bill::where("status","in",$param)->order("create_time","desc")->select();
            }elseif ($user->ident == 3){
                $param = "2,3,4";
                $Ticket = \app\model\Bill::where("status","in",$param)->order("create_time","desc")->select();
            }
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
    public function accept(Request $request){
        if ($request->isPost()){
            $bid = $request->param("id");
            $user = Session::get('Bill_Auth');
            $bill = \app\model\Bill::where("id","=",$bid)->find();
            if ($bill){
                if ($user->ident == 2){
                    if ($bill->status == 1){
                        $log = Log::create([
                            "bid" => $bid,
                            "user" => $user->username,
                            "log" => "已接收"
                        ]);
                        if ($log){
                            $bill->status = 2;
                            if ($bill->save()){
                                return json_encode(["status" => 1, "message" => "接收成功"]);
                            }
                        }
                    }
                }elseif ($user->ident == 3){
                    if ($bill->status == 2){
                        $log = Log::create([
                            "bid" => $bid,
                            "user" => $user->username,
                            "log" => "已支付"
                        ]);
                        if ($log){
                            $bill->status = 3;
                            if ($bill->save()){
                                return json_encode(["status" => 1, "message" => "支付成功"]);
                            }
                        }
                    }
                }
            }

        }
    }
    public function noaccept(Request $request){
        if ($request->isPost()){
            $bid = $request->param("id");
            $comment = $request->param("comment");
            $user = Session::get('Bill_Auth');
            $bill = \app\model\Bill::where("id","=",$bid)->find();
            if ($bill){
                if ($user->ident == 3){
                    if ($bill->status == 2){
                        $log = Log::create([
                            "bid" => $bid,
                            "user" => $user->username,
                            "log" => "拒支",
                            "comment" => $comment
                        ]);
                        if ($log){
                            $bill->status = 4;
                            if ($bill->save()){
                                return json_encode(["status" => 1, "message" => "拒支成功"]);
                            }
                        }
                    }
                }
                if ($user->ident == 2){
                    if ($bill->status == 1){
                        $log = Log::create([
                            "bid" => $bid,
                            "user" => $user->username,
                            "log" => "拒收",
                            "comment" => $comment
                        ]);
                        if ($log){
                            $bill->status = 5;
                            if ($bill->save()){
                                return json_encode(["status" => 1, "message" => "拒收成功"]);
                            }
                        }
                    }
                }
            }

        }
    }
    
}