<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/3
 * Time: 14:59
 */

namespace app\admin\model;


use think\Db;
use think\Model;

class User extends Model
{
    public $tableName = 'user';

    public function __construct()
    {
        parent::__construct();
        $this->commonModel = Db::name($this->tableName);
    }

    /**
     * 用户列表
     * created by:Mp_Lxj
     * @date:2018/11/3 15:03
     * @param $param
     * @return mixed
     */
    public function userList($param){
        $map = [];
        if($param['id']){
            $map['id'] = ['=',$param['id']];
        }
        if($param['nick_name']){
            $map['nick_name'] = ['like','%' . $param['nick_name'] . '%'];
        }
        $result['list'] = $this->commonModel->where($map)->paginate(10,false,$param);
        $result['page'] = $result['list']->render();
        return $result;
    }

    /**
     * 修改用户信息
     * created by:Mp_Lxj
     * @date:2018/11/3 15:12
     * @param $map
     * @param $data
     * @return int|string
     */
    public function userEdit($map,$data){
        $res = $this->commonModel->where($map)->update($data);
        if($res){
            return trueAjax('修改成功');
        }else{
            return falseAjax('修改失败，请刷新后再试');
        }
    }

    /**
     * 获取用户总数
     * created by:Mp_Lxj
     * @date:2018/11/4 14:51
     * @param $map
     * @return int|string
     */
    public function getUserCount($map)
    {
        return $this->commonModel->where($map)->count();
    }
}