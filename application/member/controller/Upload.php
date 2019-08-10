<?php


namespace app\member\controller;


use app\model\Uploadfile;
use think\Request;

class Upload extends Base
{
    public function file(Request $request){
        if ($request->isPost()){
            $file = $request->file("file");
            $info = $file->validate(["ext" => "jpg,png,gif,jpeg"])->move(ROOT_PATH . "public" . DS . "uploads");
            if ($info){
                $data = array();
                $data['filename'] = $info->getInfo('name');
                $data['filepath'] = $info->getSaveName();
                $uploadModel = new Uploadfile($data);
                $result = $uploadModel->save();
                if ($result){
                    return json_encode(["status" => 1,"fileid" => $uploadModel->id],JSON_UNESCAPED_UNICODE);
                }
            }
        }
    }
}