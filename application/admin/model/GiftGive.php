<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/3
 * Time: 15:20
 */

namespace app\admin\model;


use think\Db;
use think\Model;

class GiftGive extends Model
{
    public $tableName = 'gift_give';

    public function __construct()
    {
        parent::__construct();
        $this->commonModel = Db::name($this->tableName);
    }

    /**
     * 获取送礼记录数量
     * created by:Mp_Lxj
     * @date:2018/11/3 15:22
     * @param $map
     * @return int|string
     */
    public function getGiftGiveCount($map)
    {
        return $this->commonModel->where($map)->count();
    }
}