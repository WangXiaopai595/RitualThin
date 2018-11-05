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
}