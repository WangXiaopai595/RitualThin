<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/3
 * Time: 23:45
 */

namespace app\admin\controller;


use think\Loader;
use think\Request;

class Giftgive extends Common
{
    /**
     * 送礼列表
     * created by:Mp_Lxj
     * @date:2018/11/3 23:50
     * @return mixed
     */
    public function index()
    {
        $param = Request::instance()->param();
        $this->assign('param',$param);

        $Giftgive = Loader::model('GiftGive')->getGiftGiveList($param);
        $this->assign('Giftgive',$Giftgive);
        return $this->fetch();
    }
}