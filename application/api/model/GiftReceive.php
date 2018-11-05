<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2018/11/5
 * Time: 14:02
 */

namespace app\api\model;

use think\Db;
use think\Model;
class GiftReceive extends Model
{
	public $tableName = 'gift_receive';

	public function __construct()
	{
		parent::__construct();
		$this->commonModel = Db::name($this->tableName);
	}

	/**
	 * 获取收礼统计
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 14:03
	 * @param $map
	 * @return float|int
	 */
	public function getGiftReceiveSum($map)
	{
		return $this->commonModel->where($map)->sum('money');
	}

	/**
	 * 获取收礼总数
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 14:40
	 * @param $map
	 * @return int|string
	 */
	public function getGiftReceiveCount($map)
	{
		return $this->commonModel->where($map)->count();
	}
}