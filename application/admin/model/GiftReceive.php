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

    /**
     * 统计总金额
     * created by:Mp_Lxj
     * @date:2018/11/4 0:16
     * @param $map
     * @return float|int
     */
    public function getGiftReceiveSum($map)
    {
        return $this->commonModel->where($map)->sum('money');
    }

    /**
     * 获取送礼列表
     * created by:Mp_Lxj
     * @date:2018/11/4 13:40
     * @param $param
     * @return mixed
     */
    public function getGiftReceiveList($param){
        $field = [
            'id','name','give_time','money','relation'
        ];
        $map = [];
        if($param['id']){
            $map['rt_id'] = ['=',$param['rt_id']];
        }
        if($param['name']){
            $map['name'] = ['like','%' . $param['name'] . '%'];
        }
        $result['list'] = $this->commonModel
            ->where($map)
            ->field($field)
            ->order('give_time desc')
            ->paginate(10,false,$param);
        $result['page'] = $result['list']->render();
        return $result;
    }

}