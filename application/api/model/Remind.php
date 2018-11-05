<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2018/11/5
 * Time: 14:11
 */

namespace app\api\model;

use think\Db;
use think\Model;
class Remind extends Model
{
	public $tableName = 'remind';

	public function __construct()
	{
		parent::__construct();
		$this->commonModel = Db::name($this->tableName);
	}

	/**
	 * 获取所有提醒列表
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 14:14
	 * @param $map
	 * @param $field
	 * @return false|\PDOStatement|string|\think\Collection.
	 */
	public function getRemindList($map,$field)
	{
		return $this->commonModel->where($map)->field($field)->order('start_time desc')->select();
	}

	/**
	 * 删除提醒
	 * created by:Mp_Lxj
	 * @date:2018/11/5 20:52
	 * @param $map
	 * @return int
	 */
	public function remindDel($map)
	{
		return $this->commonModel->where($map)->delete();
	}

	/**
	 * 更新提醒信息
	 * created by:Mp_Lxj
	 * @date:2018/11/5 21:44
	 * @param $map
	 * @param $data
	 * @return int|string
	 */
	public function remindUpdate($map,$data)
	{
		return $this->commonModel->where($map)->update($data);
	}
}