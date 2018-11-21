<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2018/11/5
 * Time: 14:25
 */

namespace app\api\model;

use think\Db;
use think\Model;
class RitualThin extends Model
{
	public $tableName = 'ritual_thin';

	public function __construct()
	{
		parent::__construct();
		$this->commonModel = Db::name($this->tableName);
	}

	/**
	 * 获取礼薄列表
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 14:28
	 * @param $map
	 * @param $field
	 * @param $limit
	 * @return false|\PDOStatement|string|\think\Collection
	 */
	public function getRitualThinList($map,$field)
	{
		return $this->commonModel->where($map)->field($field)->order('start_time desc')->select();
	}

	/**
	 * 修改礼薄信息
	 * created by:Mp_Lxj
	 * @date:2018/11/5 20:59
	 * @param $map
	 * @param $data
	 * @return int|string
	 */
	public function rtUpdate($map,$data)
	{
		return $this->commonModel->where($map)->update($data);
	}

	/**
	 * 删除礼薄信息
	 * created by:Mp_Lxj
	 * @date:2018/11/5 21:03
	 * @param $map
	 * @return int
	 */
	public function rtRemove($map)
	{
		return $this->commonModel->where($map)->delete();
	}

	/**
	 * 写入礼薄信息
	 * Created by：Mp_Lxj
	 * @date 2018/11/6 15:22
	 * @param $data
	 * @return int|string
	 */
	public function rtCreate($data)
	{
		return $this->commonModel->insert($data);
	}
}