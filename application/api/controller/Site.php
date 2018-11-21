<?php
namespace app\api\controller;


use think\Cache;
use think\Config;
use think\Loader;
use think\Request;

class Site extends Common
{
	/**
	 * 获取幻灯片列表
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 13:51
	 * @return mixed
	 */
	public function getBannerList()
	{
		$result = Loader::model('Banner')->getBanner();

		$url = Config::get('site_url');
		foreach($result as &$value){
			$value['path'] = $url . $value['path'];
		}
		return $result;
	}

	/**
	 * 获取短信验证码
	 * Created by：Mp_Lxj
	 * @date 2018/11/6 16:09
	 * @return array|\Illuminate\Http\JsonResponse|void
	 */
	public function getMessage()
	{
		$param = Request::instance()->param();
		Cache::set('validate_code_' . $param['phone'],'123456',300);
		return trueAjax('发送成功');
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