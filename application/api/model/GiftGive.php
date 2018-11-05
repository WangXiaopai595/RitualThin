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
}