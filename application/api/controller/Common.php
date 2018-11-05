<?php
namespace app\api\controller;
use think\Controller;
use think\Loader;
use think\Request;

class Common extends Controller
{
	/**
	 * 构造函数
	 * 检测请求用户权限状态等问题
	 * Common constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$param = Request::instance()->param();

		if(isset($param['uid'])){
			$map['id'] = $param['uid'];
			$field = [
				'status'
			];
			$userData = Loader::model('User')->getUserData($map,$field);
			if(!$userData['status']){
				return falseAjax('帐号已被禁用，请联系程序管理员!');
			}
		}
	}
}