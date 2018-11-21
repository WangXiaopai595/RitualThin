<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

return [
	'default_return_type'    => 'json',//默认输出类型

	'wxConfig' => [
		'appid' => '',
		'appSecret' => ''
	],

	'site_url' => 'http://127.0.0.1',//本机域名

	'msg' => [
		'uid' => '26665',
		'token' => '1528fac001e1dc20740a3f0000e586b38754de05e421149728f45f7cd580b28e',
		'msgUrl' => 'http://sms.reactor.uworks.cc/sms/msg/send'
	]
];