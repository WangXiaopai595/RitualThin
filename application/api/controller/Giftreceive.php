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

	/**
	 * 获取收礼列表
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 16:26
	 * @param $data
	 * @return mixed
	 */
	public function getGiftReceive($data)
	{
		$map = [];
		if(isset($data['uid'])){
			$map['uid'] = ['=',$data['uid']];
		}
		if(isset($data['rt_id'])){
			$map['rt_id'] = ['=',$data['rt_id']];
		}
		if(isset($data['name'])){
			$map['name'] = ['like','%' . $data['name'] . '%'];
		}
		$field = [
			'id','name','money','relation','give_time','index','event'
		];
		$result = Loader::model('GiftReceive')->getGiftReceiveList($map,$field);
		return $result;
	}
}