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

    /**
     * 获取送礼列表
     * created by:Mp_Lxj
     * @date:2018/11/3 23:50
     * @param $param
     * @return mixed
     */
    public function getGiftGiveList($param){
        $field = [
            't.id','t.name','t.money','t.give_time','t.matter','t.relation','t.uid','t1.nick_name'
        ];
        $map = [];
        if($param['id']){
            $map['t.id'] = $param['id'];
        }
        if($param['uid']){
            $map['t.uid'] = $param['uid'];
        }
        $result['list'] = $this->commonModel
            ->alias('t')
            ->join('__USER__ t1','t.uid=t1.id','left')
            ->where($map)
            ->field($field)
            ->order('give_time desc')
            ->paginate(10,false,$param);
        $result['page'] = $result['list']->render();
        return $result;
    }
}