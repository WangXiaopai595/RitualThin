<?php
namespace app\api\controller;


use think\Loader;

class Remind extends Common
{
	/**
	 * 获取首页提醒列表
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 14:18
	 * @param $data
	 * @return mixed
	 */
	public function getNotExpiredRemind($data)
	{
		$map['uid'] = ['=',$data['uid']];
		$map['start_time'] = ['<',time()];
		$field = [
			'id','name','start_time','event'
		];
		$result = Loader::model('Remind')->getRemindList($map,$field);
		foreach($result as &$value){
			$value['start_time'] = date('Y-m-d H:i',$value['start_time']);
		}
		return $result;
	}
}