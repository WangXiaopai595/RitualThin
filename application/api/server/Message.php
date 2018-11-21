<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2018/11/21
 * Time: 15:55
 */

namespace app\api\server;


use think\Config;

class Message
{
	public function sendMsg($phone)
	{
		$config = Config::get('msg');
		$rand = rand(100000,999999);
		$data = [
			'content' => '您的验证码是：'.$rand,
			'mobile' => $phone,
			'sign' => '礼薄',
			'templateType' => 1,
			'token' => $config['token'],
			'uid' => $config['uid']
		];
		$res = $this->sendCurl($config['msgUrl'],json_encode($data),['Content-Type: application/json']);
		if(!$res){
			return ['status' => true,'msg' => $rand];
		}else{
			return ['status' => false,'msg' => $res['msg']];
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