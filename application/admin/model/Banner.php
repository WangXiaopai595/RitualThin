<?php
namespace app\admin\model;


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
     * 幻灯片列表
     * created by:Mp_Lxj
     * @date:2018/11/2 22:31
     * @return mixed
     */
    public function bannerList(){
        $result['list'] = $this->commonModel->order('sort')->paginate(10);
        $result['page'] = $result['list']->render();
        return $result;
    }

    /**
     * 数据更新
     * created by:Mp_Lxj
     * @date:2018/11/2 22:43
     * @param $map-条件
     * @param $data-更新的数据
     * @return int|string
     */
    public function bannerEdit($map,$data){
        return $this->commonModel->where($map)->update($data);
    }

    /**
     * 删除幻灯片
     * created by:Mp_Lxj
     * @date:2018/11/2 22:47
     * @param $map
     * @return int
     */
    public function bannerDel($map){
        $res = $this->commonModel->where($map)->delete();
        if($res){
            return trueAjax('删除成功');
        }else{
            return falseAjax('删除失败，请刷新后再试');
        }
    }

    /**
     * 添加新的幻灯片
     * created by:Mp_Lxj
     * @date:2018/11/2 23:11
     * @param $data
     * @return int|string
     */
    public function insertBanner($data){
        $res = $this->commonModel->insert($data);
        if($res){
            return trueAjax('添加成功');
        }else{
            return falseAjax('添加失败');
        }
    }

    /**
     * 获取单条banner详细信息
     * created by:Mp_Lxj
     * @date:2018/11/2 23:17
     * @param $id
     * @return array|false|mixed|\PDOStatement|string|Model
     */
    public function getBannerData($id){
        $map['id'] = $id;
        $result = $this->commonModel->where($map)->find();
        return $result;
    }
}