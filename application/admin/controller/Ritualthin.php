<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/4
 * Time: 0:03
 */

namespace app\admin\controller;


use think\Loader;
use think\Request;

class Ritualthin extends Common
{
    /**
     * 礼薄列表
     * created by:Mp_Lxj
     * @date:2018/11/4 0:17
     * @return mixed
     */
    public function index()
    {
        $param = Request::instance()->param();
        $this->assign('param',$param);

        $RitualThinList = Loader::model('RitualThin')->getRitualThinList($param);
        $RitualThin = $this->getRitualThinTotal($RitualThinList);
        $this->assign('RitualThin',$RitualThin);
        return $this->fetch();
    }

    /**
     * 统计总送礼人数、金额
     * created by:Mp_Lxj
     * @date:2018/11/4 0:17
     * @param $RitualThin
     * @return mixed
     */
    public function getRitualThinTotal($RitualThin)
    {
        $RitualThinList = $RitualThin['list']->toArray();
        $RitualThin['list'] = $RitualThinList['data'];

        foreach($RitualThin['list'] as &$value){
            $map['rt_id'] = $value['id'];
            $value['user_total'] = Loader::model('GiftReceive')->getGiftReceiveCount($map);
            $value['money_total'] = Loader::model('GiftReceive')->getGiftReceiveSum($map);
        }
        return $RitualThin;
    }

    /**
     * 礼薄详情----收礼列表
     * created by:Mp_Lxj
     * @date:2018/11/4 13:44
     * @return mixed
     */
    public function detail()
    {
        $param = Request::instance()->param();
        $this->assign('param',$param);

        $rithul_thin = Loader::model('RitualThin')->getRitualThinData($param);
        $this->assign('RitualThin',$rithul_thin);

        $gift_receive = Loader::model('GiftReceive')->getGiftReceiveList($param);
        $this->assign('GiftReceive',$gift_receive);
        return $this->fetch();
    }
}