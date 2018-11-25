<?php
namespace app\api\controller;
use think\Controller;
use think\Loader;
use think\Request;

class User extends Controller
{
	/**
	 * 微信登录
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 10:04
	 * @return mixed
	 */
	public function login()
	{
		$param = Request::instance()->param();
		$result = Loader::controller('WxLogin','server')->code2Session($param);
		return $result;
	}

	/**
	 * 脚本----定时提醒
	 * created by:Mp_Lxj
	 * @date:2018/11/25 14:03
	 */
	public function remind()
	{
		$map['start_time'] = ['between',[time(),time() + 60*60*2]];
		$map['is_remind'] = ['=',0];
		$field = ['id','name','phone','event','address'];
		$remind = Loader::model('Remind')->getRemindList($map,$field);
		foreach($remind as $value){
			if($value['phone']){
				$sendRemind = Loader::controller('Message','server')->sendRemind($value);
				if($sendRemind['status']){
					$updateMap['id'] = $value['id'];
					Loader::model('Remind')->remindUpdate($updateMap,['is_remind' => 1]);
				}
			}
		}
	}

}