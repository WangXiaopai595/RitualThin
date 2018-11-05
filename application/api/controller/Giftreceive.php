<?php
namespace app\api\controller;


use think\Loader;

class Giftreceive extends Common
{
	/**
	 * 获取用户收礼总数
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 14:04
	 * @param $data
	 * @return int
	 */
	public function getTotal($data)
	{
		$map['uid'] = $data['uid'];
		$result = Loader::model('GiftReceive')->getGiftReceiveSum($map);
		return intval($result);
	}
}