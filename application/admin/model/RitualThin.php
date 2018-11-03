<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/3
 * Time: 21:48
 */

namespace app\admin\model;


use think\Db;
use think\Model;

class RitualThin extends Model
{
    public $tableName = 'ritual_thin';

    public function __construct()
    {
        parent::__construct();
        $this->commonModel = Db::name($this->tableName);
    }

    /**
     * 获取礼薄数量
     * created by:Mp_Lxj
     * @date:2018/11/3 21:49
     * @param $map
     * @return int|string
     */
    public function getRitualThinCount($map)
    {
        return $this->commonModel->where($map)->count();
    }
}