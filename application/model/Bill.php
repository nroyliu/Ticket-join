<?php


namespace app\model;


use think\Model;

class Bill extends Model
{
    protected $autoWriteTimestamp = "datetime";
    protected $updateTime = false;
}