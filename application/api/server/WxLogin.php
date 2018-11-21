<?php
namespace app\api\server;


use think\Config;
use think\Loader;

class WxLogin
{
	/**
	 * 微信登录--获取回话id及加密字符
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 10:03
	 * @param $data-小程序获取到的用户CODE、IV等信息
	 * @return array|\Illuminate\Http\JsonResponse|void
	 */
	public function code2Session($data)
	{
		$appid = Config::get('wxConfig.appid');
		$secret = Config::get('wxConfig.appSecret');
		$url = 'https://api.weixin.qq.com/sns/jscode2session?appid='. $appid .'&secret='. $secret .'&js_code='. $data['code'] .'&grant_type=authorization_code';

		$result = $this->sendCurl($url,[],[],'GET',true);
		$resData = json_decode($result,true);
		if($resData['errcode'] == 0){
			$res = $this->wxDecrypt($resData,$data);
			return $res;
		}else{
			return falseAjax('登录失败，错误码' . $resData['errcode']);
		}
	}

	/**
	 * 微信小程序登录解密
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 9:27
	 * @param $data
	 * @return array|\Illuminate\Http\JsonResponse|void
	 */
	public function wxDecrypt($data,$param)
	{
		vendor('wxLogin.wxBizDataCrypt');
		$appid = Config::get('wxConfig.appid');
		$session_key = $data['session_key'];
		$sign = sha1($param['rawData'] . $session_key);
		if ($sign != $param['signature']) {
			return falseAjax('数据验签失败');
		}
		$Crypt = new \wxBizDataCrypt($appid,$session_key);
		$errCode = $Crypt->decryptData($param['encryptedData'],$param['iv'],$data);

		if($errCode == 0){
			$resData = trueAjax('',json_decode($data,true));
			return $this->wxLogin($resData);
		}else{
			return falseAjax($errCode);
		}
	}

	/**
	 * 微信登录、注册
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 10:00
	 * @param $data-获取到的微信信息
	 * @return array|\Illuminate\Http\JsonResponse|void
	 */
	public function wxLogin($data)
	{
		$map['openid'] = $data['openid'];
		$field = [
			'id as uid','nick_name','avatarUrl'
		];
		$userData = Loader::model('User')->getUserData($map,$field);
		//要更新或写入的数据
		$createData = [
			'openid' => $data['openid'],
			'unionId' => $data['unionId'],
			'nick_mame' => $data['nickName'],
			'gender' => $data['gender'],
			'city' => $data['city'],
			'province' => $data['province'],
			'country' => $data['country'],
			'avatarUrl' => $data['avatarUrl'],
			'last_login_time' => time()
		];

		//数据库是否存在记录，存在则更新，不存在则写入
		if($userData){
			Loader::model('User')->userUpdate($map,$createData);
			return trueAjax('',$userData);
		}else{
			$createData['time'] = time();
			$uid = Loader::model('User')->userCreate($createData);
			if($uid){
				$resData = [
					'uid' => $uid,
					'nick_name' => $createData['nick_name'],
					'avatarUrl' => $createData['avatarUrl'],
				];
				return trueAjax('',$resData);
			}else{
				return falseAjax('数据写入失败');
			}
		}
	}

	/**
	 * curl请求
	 * Created by：Mp_Lxj
	 * @date 2018/11/5 9:35
	 * @param $url
	 * @param array $data
	 * @param array $header
	 * @param string $method
	 * @param bool $ssl
	 * @return mixed
	 */
	private function sendCurl($url,$data=[],$header=[],$method='POST',$ssl=false)
	{
		$ch = curl_init($url);
		curl_setopt($ch , CURLOPT_CUSTOMREQUEST , $method);  //设置请求方式为POST
		curl_setopt($ch , CURLOPT_POSTFIELDS , $data);  //设置请求发送参数内容,参数值为关联数组
		curl_setopt($ch , CURLOPT_HTTPHEADER , $header );  //设置请求报头的请求格式为json, 参数值为非关联数组
		curl_setopt($ch , CURLOPT_RETURNTRANSFER , true);
		if($ssl){
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   //服务器要求使用安全链接https请求时，不验证证书和hosts
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		}

		$result = curl_exec($ch);  //发送请求并获取结果

		curl_close($ch); //关闭curl
		return $result;
	}
}