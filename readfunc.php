<?php
// $shouldtimes = ['8:00','12:00','13:30','17:30','18:30','21:30'];
// $str         = '07:5512:0513:2817:07';
// $dayarr      = dayRecord($str,$shouldtimes);
/**
 * 根据一天打卡记录'07:5512:0513:2817:07'输出时间和是否合格
 * @param string $dayclockstr
 * @param array $shouldtimearr 
 * @return array 时间+是否合格
 */
function dayRecord($dayclockstr,$shouldtimearr){
	array_walk($shouldtimearr, "arrtotime");
	$isMatched = preg_match_all('/\d\d:\d\d/', $dayclockstr, $matches);
	$matche = $matches[0];
	$day=array_fill(0,6,["",false]);
	array_walk($matche, "arrtotime");
	foreach ($matche as $key => $time) {
		switch (true) {
			//上午上班
			case ($shouldtimearr[0]-40<$time&&$time<$shouldtimearr[0]+40):
				$day[0]=[$matches[0][$key],isOkayGo($time,$shouldtimearr[0])];
				break;
			//上午下班
			case ($shouldtimearr[1]-40<$time&&$time<$shouldtimearr[1]+40):
				$day[1]=[$matches[0][$key],isOkayGo($time,$shouldtimearr[1])];
				break;
			//下午上班
			case ($shouldtimearr[2]-40<$time&&$time<$shouldtimearr[2]+40):
				$day[2]=[$matches[0][$key],isOkayGo($time,$shouldtimearr[2])];
				break;
			//下午下班
			case ($shouldtimearr[3]-40<$time&&$time<$shouldtimearr[3]+40):
				$day[3]=[$matches[0][$key],isOkayGo($time,$shouldtimearr[3])];
				break;
			//加班上班
			case ($shouldtimearr[4]-40<$time&&$time<$shouldtimearr[4]+40):
				$day[4]=[$matches[0][$key],isOkayGo($time,$shouldtimearr[4])];
				break;
			//加班下班
			case ($shouldtimearr[5]-40<$time&&$time<$shouldtimearr[5]+40):
				$day[5]=[$matches[0][$key],isOkayGo($time,$shouldtimearr[5])];
				break;
			default:
				break;
		}
	}

	return $day;
}

// var_dump($dayarr);

/**
 * 将字符串转为int
 * @param  [string]	$value '8:00'
 * @return [int]	8*60
 */
function arrtotime(&$value){
	$HandM=explode(':', $value);
	$value = intval($HandM[0])*60+intval($HandM[1]);
}
/**
 * @param  $value 打卡时间int
 * @param  $shouldtime 应到时间int
 * @return $flag 	boolean 是否迟到
 */
function isOkayGo($value,$shouldtime){
	$flag=true;
	if($value>$shouldtime){
		$flag=false;
	}
	return $flag;
}
/**
 * @param  $value
 * @param  $shouldtime 应退时间int
 * @return $flag 是否早退 boolean
 */
function isOkayLeave($value,$shouldtime){
	$flag = true;
	if($value < $shouldtime){
		$flag = false;
	}
	return $flag;
}
