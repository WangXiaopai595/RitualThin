<?php
namespace app\api\model;

use think\Db;
use think\Model;
class Banner extends Model
{
	public $tableName = 'banner';

	public function __construct()
	{
		parent::__construct();
		$this->commonModel = Db::name($this->tableName);
	}

	/**
	 * 获取banner列表
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 13:49
	 * @return false|\PDOStatement|string|\think\Collection
	 */
	public function getBanner()
	{
		$field = [
			'title','path'
		];
		return $this->commonModel->field($field)->order('sort')->select();
	}
}