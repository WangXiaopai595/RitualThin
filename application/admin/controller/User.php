<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/3
 * Time: 14:16
 */

namespace app\admin\controller;


use think\Loader;
use think\Request;

class User extends Common
{
    /**
     * 用户列表
     * created by:Mp_Lxj
     * @date:2018/11/3 15:04
     * @return mixed
     */
    public function index()
    {
        //接收参数并返回
        $param = Request::instance()->param();
        $this->assign('param',$param);

        $user = Loader::model('User')->userList($param);
        $user_total = $this->getUserTotal($user);
        $this->assign('user',$user_total);
        return $this->fetch();
    }

    /**
     * 获取用户数据统计
     * created by:Mp_Lxj
     * @date:2018/11/3 21:53
     * @param $user
     * @return mixed
     */
    public function getUserTotal($user)
    {
        $userList = $user['list']->toArray();
        $user['list'] = $userList['data'];
        foreach($user['list'] as &$value){
            $map['uid'] = $value['id'];
            $value['RitualThinCount'] = Loader::model('RitualThin')->getRitualThinCount($map);//礼薄数量
            $value['GiftGiveCount'] = Loader::model('GiftGive')->getGiftGiveCount($map);//送礼数量
            $value['RemindCount'] = Loader::model('Remind')->getRemindCount($map);//提醒数
            $value['GiftReceiveCount'] = Loader::model('GiftReceive')->getGiftReceiveCount($map);//收礼数
        }
        return $user;
    }

    /**
     * 修改用户状态
     * created by:Mp_Lxj
     * @date:2018/11/3 21:43
     * @return mixed
     */
    public function userStatus()
    {
        $data = Request::instance()->param();
        $map['id'] = $data['id'];
        $result = Loader::model('User')->userEdit($map,$data);
        return $result;
    }
}