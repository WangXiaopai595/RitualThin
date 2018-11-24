<?php
/**
 * ajax成功返回
 * created by:Mp_Lxj
 * @date:2018/11/2 22:52
 * @param string $msg
 * @param string $data
 * @return array
 */
function trueAjax($msg = '',$data = '')
{
	return ['status' => 1,'msg' => $msg,'data' => $data];
}

/**
 * ajax失败返回数据
 * created by:Mp_Lxj
 * @date:2018/11/2 22:52
 * @param string $msg
 * @param string $data
 * @return array
 */
function falseAjax($msg = '',$data = '')
{
	return ['status' => 0,'msg' => $msg,'data' => $data];
}

/**
 * 文件上传--递归上传、支持多图、单图上传
 * created by:Mp_Lxj
 * @date:2018/11/2 23:05
 * @param $file
 * @return array
 */
function uploadFile($file){
	$result = [];
	$config = [
		'size' => 2*1024*1024,
		'ext'  => 'jpg,png,gif,jpeg',
	];
	$savePath = date('Ymd',time());
	$path = ROOT_PATH.'public'.DS.'upload'.DS.$savePath;
	foreach($file as $k=>$v){
		$math = rand(1000,9999);
		$fileName = date('YmdHis',time()).$math;
		if(is_array($v) && $v){
			$recursion = uploadFile($v);
			$result[$k] = implode(',',$recursion);
		}else{
			$info = $v->validate($config)->move($path,$fileName);
			if($info){
				$result[$k] = '/upload/'.$savePath.'/'.$info->getSaveName();
			}else{
				exit(json_encode(['status'=>0,'msg'=>$v->getError()]));
			}
		}
	}
	return $result;
}