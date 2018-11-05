<?php
namespace app\api\controller;


use think\Cache;
use think\Db;
use think\Loader;
use think\Request;

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
		$map['start_time'] = ['>',time()];
		$result = $this->getRemindList($map);
		return $result;
	}

	/**
	 * 获取未过期提醒列表
	 * created by:Mp_Lxj
	 * @date:2018/11/5 19:21
	 * @return array
	 */
	public function getRemindNotExpired()
	{
		$param = Request::instance()->param();
		$map['uid'] = $param['uid'];
		$map['start_time'] = ['>',time()];
		$result = $this->getRemindList($map);
		return trueAjax('',$result);
	}

	/**
	 * 获取已过期提醒列表
	 * created by:Mp_Lxj
	 * @date:2018/11/5 19:22
	 * @return array
	 */
	public function getRemindExpired()
	{
		$param = Request::instance()->param();
		$map['uid'] = $param['uid'];
		$map['start_time'] = ['<=',time()];
		$result = $this->getRemindList($map);
		return trueAjax('',$result);
	}

	/**
	 * 提醒列表
	 * created by:Mp_Lxj
	 * @date:2018/11/5 19:22
	 * @param $map
	 * @return mixed
	 */
	public function getRemindList($map)
	{
		$field = [
			'id','name','start_time','address','event'
		];
		$result = Loader::model('Remind')->getRemindList($map,$field);
		foreach($result as &$value){
			$value['start_time'] = date('Y-m-d H:i',$value['start_time']);
		}
		return $result;
	}

	/**
	 * 删除提醒
	 * created by:Mp_Lxj
	 * @date:2018/11/5 20:53
	 * @return array
	 */
	public function remindRemove()
	{
		$param = Request::instance()->param();
		$map['id'] = $param['id'];
		$map['uid'] = $param['uid'];
		Db::startTrans();
		try{
			Loader::model('Remind')->remindDel($map);
			Db::commit();
			return trueAjax('删除成功');
		}catch(\Exception $e){
			Db::rollback();
			return falseAjax($e->getMessage());
		}
	}

	/**
	 * 更新提醒信息
	 * created by:Mp_Lxj
	 * @date:2018/11/5 21:45
	 * @return array
	 */
	public function remindUpdate()
	{
		$param = Request::instance()->param();
		$data = $this->checkRemind($param);
		if($data['status']){
			$remind = $data['data'];
			$map['id'] = $remind['id'];
			$map['uid'] = $remind['uid'];
			Db::startTrans();
			try{
				Loader::model('Remind')->remindUpdate($map,$remind);
				Db::commit();
				return trueAjax('更新成功');
			}catch(\Exception $e){
				Db::rollback();
				return falseAjax($e->getMessage());
			}
		}else{
			return $data;
		}
	}

	/**
	 * 验证信息新增、更新验证处理
	 * created by:Mp_Lxj
	 * @date:2018/11/5 21:41
	 * @param $data
	 * @return array
	 */
	public function checkRemind($data)
	{
		if($data['is_check']){
			$code = Cache::get('validate_code_' . $data['phone']);
			if($code != $data['code']){
				return falseAjax('验证码错误');
			}

			Cache::rm('validate_code_' . $data['phone']);
			$map['id'] = $data['uid'];
			$user['phone'] = $data['phone'];
			Loader::model('User')->userUpdate($map,$user);
		}
		unset($data['code']);
		unset($data['is_check']);
		$data['start_time'] = strtotime($data['start_time']);
		return trueAjax('',$data);
	}
}