<?php


namespace app\model;


use think\Model;

class LoginLog extends Model
{
    protected $autoWriteTimestamp = "datetime";
    protected $updateTime = false;
    protected $createTime = "time";
}