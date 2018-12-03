<?php
/**
 * 提取汉字首字母
 * Created by：Mp_Lxj
 * @date 2018/11/5 16:36
 * @param $str
 * @return null|string
 */
function GetFirst($str){
	$str = mb_substr($str,0,1);
	if(empty($str)){return '';}
	if(is_numeric($str{0})) return $str{0};// 如果是数字开头 则返回数字
	$fchar=ord($str{0});
	if($fchar>=ord('A')&&$fchar<=ord('z')) return strtoupper($str{0}); //如果是字母则返回字母的大写
	$s1=iconv('UTF-8','gb2312',$str);
	$s2=iconv('gb2312','UTF-8',$s1);
	$s=$s2==$str?$s1:$str;
	$asc=ord($s{0})*256+ord($s{1})-65536;
	if($asc>=-20319&&$asc<=-20284) return 'A';//这些都是汉字
	if($asc>=-20283&&$asc<=-19776) return 'B';
	if($asc>=-19775&&$asc<=-19219) return 'C';
	if($asc>=-19218&&$asc<=-18711) return 'D';
	if($asc>=-18710&&$asc<=-18527) return 'E';
	if($asc>=-18526&&$asc<=-18240) return 'F';
	if($asc>=-18239&&$asc<=-17923) return 'G';
	if($asc>=-17922&&$asc<=-17418) return 'H';
	if($asc>=-17417&&$asc<=-16475) return 'J';
	if($asc>=-16474&&$asc<=-16213) return 'K';
	if($asc>=-16212&&$asc<=-15641) return 'L';
	if($asc>=-15640&&$asc<=-15166) return 'M';
	if($asc>=-15165&&$asc<=-14923) return 'N';
	if($asc>=-14922&&$asc<=-14915) return 'O';
	if($asc>=-14914&&$asc<=-14631) return 'P';
	if($asc>=-14630&&$asc<=-14150) return 'Q';
	if($asc>=-14149&&$asc<=-14091) return 'R';
	if($asc>=-14090&&$asc<=-13319) return 'S';
	if($asc>=-13318&&$asc<=-12839) return 'T';
	if($asc>=-12838&&$asc<=-12557) return 'W';
	if($asc>=-12556&&$asc<=-11848) return 'X';
	if($asc>=-11847&&$asc<=-11056) return 'Y';
	if($asc>=-11055&&$asc<=-10247) return 'Z';
	return null;
}
function GetFirsts($str)
{
	$str= iconv('UTF-8','gb2312', $str);//编码转换
	if (preg_match('/^[\x7f-\xff]/', $str)) {
		$fchar=ord($str{0});
		if($fchar>=ord('A') && $fchar<=ord('z') )return strtoupper($str{0});
		$a = $str;
		$val=ord($a{0})*256+ord($a{1})-65536;
		if($val>=-20319 && $val<=-20284)return 'A';
		if($val>=-20283 && $val<=-19776)return 'B';
		if($val>=-19775 && $val<=-19219)return 'C';
		if($val>=-19218 && $val<=-18711)return 'D';
		if($val>=-18710 && $val<=-18527)return 'E';
		if($val>=-18526 && $val<=-18240)return 'F';
		if($val>=-18239 && $val<=-17923)return 'G';
		if($val>=-17922 && $val<=-17418)return 'H';
		if($val>=-17417 && $val<=-16475)return 'J';
		if($val>=-16474 && $val<=-16213)return 'K';
		if($val>=-16212 && $val<=-15641)return 'L';
		if($val>=-15640 && $val<=-15166)return 'M';
		if($val>=-15165 && $val<=-14923)return 'N';
		if($val>=-14922 && $val<=-14915)return 'O';
		if($val>=-14914 && $val<=-14631)return 'P';
		if($val>=-14630 && $val<=-14150)return 'Q';
		if($val>=-14149 && $val<=-14091)return 'R';
		if($val>=-14090 && $val<=-13319)return 'S';
		if($val>=-13318 && $val<=-12839)return 'T';
		if($val>=-12838 && $val<=-12557)return 'W';
		if($val>=-12556 && $val<=-11848)return 'X';
		if($val>=-11847 && $val<=-11056)return 'Y';
		if($val>=-11055 && $val<=-10247)return 'Z';
	}
	else {
		return null;
	}
}

/**
 * 数据查询结果根据A-Z分组
 * Created by：Mp_Lxj
 * @date 2018/11/5 16:43
 * @param $data
 * @return mixed
 */
function asciiGroup($data)
{
	$index = [
		'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H','I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T','U','V', 'W', 'X', 'Y', 'Z'
	];
	$arr['A'] = [];
	$arr['B'] = [];
	$arr['C'] = [];
	$arr['D'] = [];
	$arr['E'] = [];
	$arr['F'] = [];
	$arr['G'] = [];
	$arr['H'] = [];
	$arr['I'] = [];
	$arr['J'] = [];
	$arr['K'] = [];
	$arr['L'] = [];
	$arr['M'] = [];
	$arr['N'] = [];
	$arr['O'] = [];
	$arr['P'] = [];
	$arr['Q'] = [];
	$arr['R'] = [];
	$arr['S'] = [];
	$arr['T'] = [];
	$arr['U'] = [];
	$arr['V'] = [];
	$arr['W'] = [];
	$arr['X'] = [];
	$arr['Y'] = [];
	$arr['Z'] = [];
	$arr['#'] = [];

	foreach($data as $value){
		if(in_array($value['index'],$index)){
			$arr[$value['index']][] = $value;
		}else{
			$arr['#'][] = $value;
		}
	}
	return $arr;
}