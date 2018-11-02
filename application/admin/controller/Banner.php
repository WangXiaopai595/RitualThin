<?php
namespace app\admin\controller;


use think\Db;
use think\Loader;
use think\Request;

class Banner extends Common
{
    /**
     * 幻灯片列表
     * created by:Mp_Lxj
     * @date:2018/11/2 22:48
     * @return mixed
     */
    public function index()
    {
        $result = Loader::model('Banner')->bannerList();
        $this->assign('banner',$result);
        return $this->fetch();
    }

    /**
     * 添加幻灯片
     * created by:Mp_Lxj
     * @date:2018/11/2 23:10
     * @return mixed
     */
    public function addBanner()
    {
        if(Request::instance()->isAjax()){
            $data = Request::instance()->param();
            $file = Request::instance()->file();
			$path = uploadFile($file);
			if($path){
				foreach($path as $k=>$v){
					$data[$k] = $v;
				}
			}
            $result = Loader::model('Banner')->insertBanner($data);
            return $result;
        }else{
            return $this->fetch();
        }
    }

    /**
     * 修改幻灯片数据
     * created by:Mp_Lxj
     * @date:2018/11/2 23:28
     * @return array|mixed
     */
    public function updateBanner()
    {
        $data = Request::instance()->param();
        if(Request::instance()->isAjax()){
            $file = Request::instance()->file();
            //数据库事物
            Db::startTrans();
            try{
                $path = uploadFile($file);
                if($path){
                    foreach($path as $k=>$v){
                        $data[$k] = $v;
                    }
                }
                $map['id'] = $data['id'];
                Loader::model('Banner')->bannerEdit($map,$data);
                Db::commit();
                return trueAjax('修改成功');
            }catch(\Exception $e){
                Db::rollback();
                //返回执行错误信息
                return falseAjax($e->getMessage());
            }
        }else{
            $banner = Loader::model('Banner')->getBannerData($data['id']);
            $this->assign('banner',$banner);
            return $this->fetch();
        }
    }

    /**
     * 幻灯片排序
     * created by:Mp_Lxj
     * @date:2018/11/2 22:43
     * @return array
     */
    public function sortBanner()
    {
        $data = Request::instance()->param();
        $groupID = explode(',',$data['id']);
        $groupSort = explode(',',$data['sort']);
        foreach($groupID as $k=>$v){
            $map['id'] = $v;
            $arr['sort'] = $groupSort[$k];
            Loader::model('Banner')->bannerEdit($map,$arr);
        }
        return ['status'=>1,'msg'=>'更新成功'];
    }

    /**
     * 单条、批量删除幻灯片
     * created by:Mp_Lxj
     * @date:2018/11/2 22:48
     * @return mixed
     */
    public function delBanner()
    {
        $data = Request::instance()->param();
        $map['id'] = ['in',$data['id']];
        $result = Loader::model('Banner')->bannerDel($map);
        return $result;
    }
}