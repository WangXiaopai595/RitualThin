<?php
namespace app\api\controller;


use think\Db;
use think\Loader;
use think\Request;

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
			'id','name','money','relation','give_time','index'
		];
		$result = Loader::model('GiftReceive')->getGiftReceiveList($map,$field);
		return $result;
	}

	/**
	 * 更新收礼内容信息
	 * created by:Mp_Lxj
	 * @date:2018/11/5 20:24
	 * @return array
	 */
	public function giftReceiveUpdate()
	{
		$param = Request::instance()->param();
		$map['id'] = $param['id'];
		$map['uid'] = $param['uid'];
		Db::startTrans();
		try{
			$param['index'] = GetFirst($param['name']);
			Loader::model('GiftReceive')->GiftReceiveUpdate($map,$param);
			Db::commit();
			return trueAjax('更新成功');
		}catch(\Exception $e){
			Db::rollback();
			return falseAjax($e->getMessage());
		}
	}

	/**
	 * 删除收礼信息
	 * created by:Mp_Lxj
	 * @date:2018/11/5 20:29
	 * @return array
	 */
	public function giftReceiveRemove()
	{
		$param = Request::instance()->param();
		$map['id'] = $param['id'];
		$map['uid'] = $param['uid'];
		Db::startTrans();
		try{
			Loader::model('GiftReceive')->GiftReceiveDel($map);
			Db::commit();
			return trueAjax('删除成功');
		}catch(\Exception $e){
			Db::rollback();
			return falseAjax($e->getMessage());
		}
	}

	/**
	 * 新增收礼信息
	 * Created by：Mp_Lxj
	 * @date 2018/11/6 15:34
	 * @return array|\Illuminate\Http\JsonResponse|void
	 */
	public function giftReceiveCreate()
	{
		$param = Request::instance()->param();
		$param['time'] = time();
		$param['give_time'] = strtotime($param['give_time']);
		$param['index'] = GetFirst($param['name']);
		Db::startTrans();
		try{
			Loader::model('GiftReceive')->giftReceiveCreate($param);//写入送礼信息
			Db::commit();
			return trueAjax('新增成功');
		}catch(\Exception $e){
			Db::rollback();
			return falseAjax($e->getMessage());
		}
	}
}