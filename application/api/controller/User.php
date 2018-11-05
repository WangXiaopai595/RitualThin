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
	 * 获取默认手机号码，
	 * created by:Mp_Lxj
	 * @date:2018/11/5 21:56
	 * @return array
	 */
	public function getDefaultPhone()
	{
		$param = Request::instance()->param();
		$map['id'] = $param['uid'];
		$field = ['phone'];
		$result = Loader::model('User')->getUserData($map,$field);
		return trueAjax('',$result);
	}
}