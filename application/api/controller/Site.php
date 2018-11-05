<?php
namespace app\api\controller;


use think\Config;
use think\Loader;

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
}