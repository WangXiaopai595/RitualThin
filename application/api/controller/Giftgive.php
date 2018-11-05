<?php
namespace app\api\controller;


use think\Loader;

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
}