<?php
namespace app\api\controller;


use think\Db;
use think\Loader;
use think\Request;

class Ritualthin extends Common
{
	/**
	 * 小程序首页数据
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 14:41
	 * @return array|\Illuminate\Http\JsonResponse|void
	 */
	public function index()
	{
		$Site = new Site();
		$Giftgive = new Giftgive();
		$Giftreceive = new Giftreceive();
		$Remind = new Remind();

		$param = Request::instance()->param();
		$data = [];

		Db::startTrans();
		try{
			$data['banner'] = $Site->getBannerList();//获取幻灯片
			$data['gift_give_total'] = $Giftgive->getTotal($param);//送礼总数统计
			$data['gift_receive_total'] = $Giftreceive->getTotal($param);//收礼总数统计
			$data['remind'] = $Remind->getNotExpiredRemind($param);//获取提醒列表
			$ritual_thin = $this->getRitualThin($param);//获取礼薄
			$data['ritualthin'] = $this->titualThinTotal($ritual_thin);//礼薄统计后结果
			Db::commit();
			return trueAjax('',$data);
		}catch(\Exception $e){
			Db::rollback();
			return falseAjax($e->getMessage());
		}
	}

	/**
	 * 礼薄统计
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 14:37
	 * @param $data
	 * @return mixed
	 */
	public function titualThinTotal($data)
	{
		foreach($data as &$value){
			$map['rt_id'] = $value['id'];
			$value['count'] = Loader::model('GiftReceive')->getGiftReceiveCount($map);
			$value['money'] = Loader::model('GiftReceive')->getGiftReceiveSum($map);
		}
		return $data;
	}

	/**
	 * 获取礼薄列表
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 14:35
	 * @param $data
	 * @return mixed
	 */
	public function getRitualThin($data)
	{
		$map['uid'] = $data['uid'];
		$field = [
			'id','name','start_time'
		];
		$result = Loader::model('RitualThin')->getRitualThinList($map,$field);
		return $this->dateFormat($result);
	}

	/**
	 * 时间格式化
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 14:38
	 * @param $data
	 * @param $field
	 * @return mixed
	 */
	public function dateFormat($data,$field = 'start_time')
	{
		foreach($data as &$value){
			$value[$field] = date('Y-m-d',$value[$field]);
			if(isset($value['money'])){
				$value['money'] = intval($value['money']);
			}
		}
		return $data;
	}

	/**
	 * 礼薄翻页
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 14:44
	 * @return array|\Illuminate\Http\JsonResponse|void
	 */
	public function getRitualThinList()
	{
		$param = Request::instance()->param();
		$map['uid'] = $param['uid'];
		$first_page = ($param['page'] - 1) * 10;
		$limit = $first_page . ',10';
		$field = [
			'id','name','start_time'
		];
		$result = Loader::model('RitualThin')->getRitualThinList($map,$field,$limit);
		return trueAjax('',$this->dateFormat($result));
	}

	/**
	 * 礼薄详情---收礼记录
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 16:46
	 * @return array|\Illuminate\Http\JsonResponse|void
	 */
	public function getGiftReceiveDetail()
	{
		$Giftreceive = new Giftreceive();
		$param = Request::instance()->param();
		$gift_receive = $Giftreceive->getGiftReceive($param);
		$result = asciiGroup($this->dateFormat($gift_receive,'give_time'));
		return trueAjax('',$result);
	}
}