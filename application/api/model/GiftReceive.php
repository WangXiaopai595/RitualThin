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

	/**
	 * 获取收礼列表
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 16:21
	 * @param $map
	 * @param $field
	 * @return false|\PDOStatement|string|\think\Collection
	 */
	public function getGiftReceiveList($map,$field)
	{
		return $this->commonModel->where($map)->field($field)->order('index')->select();
	}

	/**
	 * 更新收礼信息
	 * created by:Mp_Lxj
	 * @date:2018/11/5 20:23
	 * @param $map
	 * @param $data
	 * @return int|string
	 */
	public function GiftReceiveUpdate($map,$data)
	{
		return $this->commonModel->where($map)->update($data);
	}

	/**
	 * 删除收礼信息
	 * created by:Mp_Lxj
	 * @date:2018/11/5 20:29
	 * @param $map
	 * @return int
	 */
	public function GiftReceiveDel($map)
	{
		return $this->commonModel->where($map)->delete();
	}

	/**
	 * 新增收礼信息
	 * Created by：Mp_Lxj
	 * @date 2018/11/6 15:34
	 * @param $data
	 * @return int|string
	 */
	public function giftReceiveCreate($data)
	{
		return $this->commonModel->insert($data);
	}
}