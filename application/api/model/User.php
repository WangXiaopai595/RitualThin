<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2018/11/5
 * Time: 9:02
 */

namespace app\api\model;

use think\Db;
use think\Model;
class User extends Model
{
	public $tableName = 'user';

	public function __construct()
	{
		parent::__construct();
		$this->commonModel = Db::name($this->tableName);
	}

	/**
	 * 获取用户基本信息
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 9:05
	 * @param $map-条件
	 * @param $field-要取的字段
	 * @return array|false|\PDOStatement|string|Model
	 */
	public function getUserData($map,$field)
	{
		return $this->commonModel->where($map)->field($field)->find();
	}

	/**
	 * 更新用户信息
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 9:48
	 * @param $map-条件
	 * @param $data-更新的字段
	 * @return int|string
	 * @throws \think\Exception
	 */
	public function userUpdate($map,$data)
	{
		return $this->commonModel->where($map)->update($data);
	}

	/**
	 * 写入新的数据，并返回主键
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 9:51
	 * @param $data-写入的数据
	 * @return string
	 */
	public function userCreate($data)
	{
		$this->commonModel->insert($data);
		return $this->getLastInsID();
	}
}