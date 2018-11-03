<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/3
 * Time: 21:41
 */

namespace app\admin\model;


use think\Db;
use think\Model;

class Remind extends Model
{
    public $tableName = 'remind';

    public function __construct()
    {
        parent::__construct();
        $this->commonModel = Db::name($this->tableName);
    }

    /**
     * 获取提醒数量
     * created by:Mp_Lxj
     * @date:2018/11/3 15:22
     * @param $map
     * @return int|string
     */
    public function getRemindCount($map)
    {
        return $this->commonModel->where($map)->count();
    }

    /**
     * 提醒表列表
     * created by:Mp_Lxj
     * @date:2018/11/3 22:22
     * @param $param
     * @return mixed
     */
    public function getRemindList($param){
        $field = [
            't.id','t.name','t.start_time','t.address','t.phone','t.time','t.uid','t.event','t1.nick_name'
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
            ->order('start_time desc')
            ->paginate(10,false,$param);
        $result['page'] = $result['list']->render();
        return $result;
    }
}