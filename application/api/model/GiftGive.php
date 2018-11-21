<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2018/11/5
 * Time: 13:56
 */

namespace app\api\model;

use think\Db;
use think\Model;
class GiftGive extends Model
{
	public $tableName = 'gift_give';

	public function __construct()
	{
		parent::__construct();
		$this->commonModel = Db::name($this->tableName);
	}

	/**
	 * 统计送礼总数
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 13:57
	 * @param $map
	 * @return float|int
	 */
	public function getGiftGiveSum($map)
	{
		return $this->commonModel->where($map)->sum('money');
	}

	/**
	 * 获取送礼列表
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 17:05
	 * @param $map
	 * @param $field
	 * @return false|\PDOStatement|string|\think\Collection
	 */
	public function getGiftGiveList($map,$field)
	{
		return $this->commonModel->where($map)->field($field)->order('index')->select();
	}

	/**
	 * 更新送礼信息
	 * created by:Mp_Lxj
	 * @date:2018/11/5 20:32
	 * @param $map
	 * @param $data
	 * @return int|string
	 */
	public function GiftGiveUpdate($map,$data)
	{
		return $this->commonModel->where($map)->update($data);
	}

	/**
	 * 删除送礼数据
	 * created by:Mp_Lxj
	 * @date:2018/11/5 20:40
	 * @param $map
	 * @return int
	 */
	public function GiftGiveDel($map)
	{
		return $this->commonModel->where($map)->delete();
	}

	/**
	 * 新增收礼信息
	 * Created by：Mp_Lxj
	 * @date 2018/11/6 15:28
	 * @param $data
	 * @return int|string
	 */
	public function GiftGiveCreate($data)
	{
		return $this->commonModel->insert($data);
	}
}