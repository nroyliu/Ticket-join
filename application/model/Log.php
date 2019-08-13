<?php


namespace app\model;


use think\Model;

class Log extends Model
{
    protected $autoWriteTimestamp = "datetime";
    protected $updateTime = false;
}