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

    /**
     * 礼薄列表
     * created by:Mp_Lxj
     * @date:2018/11/4 0:11
     * @param $param
     * @return mixed
     */
    public function getRitualThinList($param){
        $field = [
            't.id','t.name','t.start_time','t.uid','t1.nick_name'
        ];
        $map = [];
        if($param['id']){
            $map['t.id'] = ['=',$param['id']];
        }
        if($param['uid']){
            $map['t.uid'] = ['=',$param['uid']];
        }
        if($param['name']){
            $map['t.name'] = ['like','%' . $param['name'] . '%'];
        }
        $result['list'] = $this->commonModel
            ->alias('t')
            ->join('__USER__ t1','t.uid=t1.id','left')
            ->where($map)
            ->field($field)
            ->order('start_time desc')
            ->paginate(10,false,$param);
        $result['page'] = $result['list']->render();
        return $result;
    }
}