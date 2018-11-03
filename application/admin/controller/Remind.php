<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/3
 * Time: 22:07
 */

namespace app\admin\controller;


use think\Loader;
use think\Request;

class Remind extends Common
{
    /**
     * 提醒列表
     * created by:Mp_Lxj
     * @date:2018/11/3 22:29
     * @return mixed
     */
    public function index()
    {
        $param = Request::instance()->param();
        $this->assign('param',$param);

        $remindList = Loader::model('Remind')->getRemindList($param);
        $remind = $this->remindStatus($remindList);
        $this->assign('remind',$remind);
        return $this->fetch();
    }

    /**
     * 检测提醒是否过期
     * created by:Mp_Lxj
     * @date:2018/11/3 22:27
     * @param $remind
     * @return mixed
     */
    public function remindStatus($remind)
    {
        $remindList = $remind['list']->toArray();
        $remind['list'] = $remindList['data'];
        foreach($remind['list'] as &$value){
            if($value['start_time'] > time()){
                $value['status'] = true;
            }else{
                $value['status'] = false;
            }
        }
        return $remind;
    }
}