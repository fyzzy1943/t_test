<?php

/**
 * 
 * 比较两个日期相隔多少天
 * @param unknown_type $date1
 * @param unknown_type $date2
 */
function datecmp($date1, $date2) {
	$date1ex=explode('-', $date1);
	$date2ex=explode('-', $date2);
	
	$day1=mktime(0, 0, 0, $date1ex[1], $date1ex[2], $date1ex[0]);
	$day2=mktime(0, 0, 0, $date2ex[1], $date2ex[2], $date2ex[0]);
	
	$day=round(($day1-$day2)/3600/24);
	return $day;
}

function calen() {
	$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
	$date = getdate(strtotime($date));
	$end = getdate(mktime(0, 0, 0, $date['mon'] + 1, 1, $date['year']) - 1);
	$start = getdate(mktime(0, 0, 0, $date['mon'], 1, $date['year']));
	$pre = date('Y-m-d', $start[0] - 1);
	$next = date('Y-m-d', $end[0] + 86400);
	$html = '<table border="1">';
	$html .= '<tr>';
	$html .= '<td><a href="' . $PHP_SELF . '?date=' . $pre . '">-</a></td>';
	$html .= '<td colspan="5">' . $date['year'] . ';' . $date['month'] . '</td>';
	$html .= '<td><a href="' . $PHP_SELF . '?date=' . $next . '">+</a></td>';
	$html .= '</tr>';
	$arr_tpl = array(0 => '', 1 => '', 2 => '', 3 => '', 4 => '', 5 => '', 6 => '');
	$date_arr = array();
	$j = 0;
	for ($i = 0; $i < $end['mday']; $i++) {
		if (!isset($date_arr[$j])) {
			$date_arr[$j] = $arr_tpl;
		}
		$date_arr[$j][($i+$start['wday'])%7] = $i+1;
		if ($date_arr[$j][6]) {
			$j++;
		}
	}
	foreach ($date_arr as $value) {
		$html .= '<tr>';
		foreach ($value as $v) {
			if ($v) {
				if ($v == $date['mday']) {
					$html .= '<td><b>' . $v . '</b></td>';
				} else {
					$html .= '<td>' . $v . '</td>';
				}
			} else {
				$html .= '<td>&nbsp;</td>';
			}
		}
		$html .= '</tr>';
	}
	$html .= '</table>';
	echo $html;
}

function toarray($history, $date ,&$total_date) {
	$exdate=explode('-', $date);
	switch($exdate[1]) {
		case 1: case 3: case 5: case 7: case 8: case 10: case 12:
			$total_date=31;
			break;
		case 4: case 6: case 9: case 11:
			$total_date=30;
			break;
		case 2:
			if(($exdate[0]%4==0 && $exdate[0]%100!=0) || $exdate[0]%400==0) {
				$total_date=29;
			} else {
				$total_date=28;
			}
		default:
			$total_date=0;
	}
	$bin=decbin($history);
	$total_bin=strlen($bin);
	$sequence=array();
	
	for($i=$total_bin-1, $j=0; $i>=0; $i--, $j++) {
		$sequence[$j]=$bin[$i];
	}
	for($i=$total_bin; $i<$total_date; $i++) {
		$sequence[$i]=0;
	}
	
	return $sequence;
}