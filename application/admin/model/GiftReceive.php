<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/3
 * Time: 21:40
 */

namespace app\admin\model;


use think\Db;
use think\Model;

class GiftReceive extends Model
{
    public $tableName = 'gift_receive';

    public function __construct()
    {
        parent::__construct();
        $this->commonModel = Db::name($this->tableName);
    }

    /**
     * 获取收礼记录数量
     * created by:Mp_Lxj
     * @date:2018/11/3 15:22
     * @param $map
     * @return int|string
     */
    public function getGiftReceiveCount($map)
    {
        return $this->commonModel->where($map)->count();
    }
}