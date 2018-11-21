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


}