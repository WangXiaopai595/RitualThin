<?php
namespace app\api\controller;


use think\Loader;
use think\Request;

class Giftgive extends Common
{
	/**
	 * 统计送礼总数
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 13:59
	 * @param $data
	 * @return int
	 */
	public function getTotal($data)
	{
		$map['uid'] = $data['uid'];
		$result = Loader::model('GiftGive')->getGiftGiveSum($map);
		return intval($result);
	}

	/**
	 * 获取送礼列表
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 17:07
	 * @return array|\Illuminate\Http\JsonResponse|void
	 */
	public function giftGiveList()
	{
		$Ritualthin = new Ritualthin();
		$param = Request::instance()->param();
		$gift_give = $this->getGiftgiveList($param);//送礼列表
		$result = asciiGroup($Ritualthin->dateFormat($gift_give,'give_time'));//送礼列表A-Z分类
		$res['money'] = $this->giftGiveTotal($gift_give);//礼金统计
		$res['count'] = count($gift_give);//送礼总数
		$res['gift_give'] = $result;
		return trueAjax('',$res);
	}

	/**
	 * 送礼总金额统计---避免查库多次
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 17:16
	 * @param $data
	 * @return array
	 */
	public function giftGiveTotal($data)
	{
		$money = 0;
		foreach($data as $value){
			$money += $value['money'];
		}
		return $money;
	}

	/**
	 * 获取送礼列表
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 17:06
	 * @param $data
	 * @return mixed
	 */
	public function getGiftgiveList($data)
	{
		$map = [];
		if(isset($data['uid'])){
			$map['uid'] = ['=',$data['uid']];
		}
		if(isset($data['name'])){
			$map['name'] = ['like','%' . $data['name'] . '%'];
		}
		$field = [
			'id','name','money','relation','give_time','index','matter'
		];
		$result = Loader::model('GiftGive')->getGiftGiveList($map,$field);
		return $result;
	}
}