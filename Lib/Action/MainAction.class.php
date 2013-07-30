<?php
//主界面
class MainAction extends Action {
	public function main() {
		if(session('?uName')) {
			$this->assign('msg', session('uId') . '::' . session('uName').'::'.$this->_param('msg'));
			//获取所有签到项
			$options=M('options');
			$list=$options->select();
			$this->assign('list', $list);
			$this->assign('shistory', $this->monthsign(date('Y'), date('m')));
				
			$this->display();
		} else {
			$this->error('not login', '__APP__');
		//	$this->redirect('Index/index', null, 3, '请登录');
		}
		
		
	}
	
	public function sign() {
		$uid=session('uId');
		foreach($this->_param('clist') as $oid) {
			$sign=M('sign');
			$shistory=M('shistory');
			
			//sign中是否存在数据
			if($result=$sign->where("uid='%s' AND oid='%s'", $uid, $oid)->find()) {
				//根据日期判断是否已经签到
				if(0<=strcmp($result['slastdate'], date('Y-m-d'))) {
					$msg=$msg.'.'.$oid.'已签到';
				} else {
					//是否连续签到
					if(1==datecmp(date('Y-m-d'), $result['slastdate'])) {
						$result['scount']++;
					} else {
						$result['scount']=1;
					}
					$result['stotal']++;
					$result['slastdate']=date('Y-m-d');
					$sign->save($result);
					
					//shistory中是否存在数据，是否已经进入下一个月份
					if($history=$shistory->where("uid='%s' AND oid='%s' AND sdate='%s'", $uid, $oid, date('Y-m'))->find()) {
						$msg=$msg.','.'qweends';
						$history['shistory']=intval($history['shistory'], 10)+pow(2, date(d)-1);
						$shistory->save($history);
					} else {	//进入下一月份则增加记录
						unset($data);
						$data['uid']=$uid;
						$data['oid']=$oid;
						$data['sdate']=date('Y-m');
						$data['shistory']=pow(2, date(d)-1);
						$shistory->data($data)->add();
					}
					$msg=$msg.'.'.$oid.'签到成功';
				}
			} else {
				//新建数据，sign表
				unset($data);
				$data['uid']=$uid;
				$data['oid']=$oid;
				$data['scount']=1;
				$data['stotal']=1;
				$data['slastdate']=date('Y-m-d');
				$sign->data($data)->add();
				
				//新建数据，shistory表
				unset($data);
				$data['uid']=$uid;
				$data['oid']=$oid;
				$data['sdate']=date('Y-m');
				$data['shistory']=pow(2, date(d)-1);
				$shistory->data($data)->add();
				$msg=$msg.'.'.$oid.'签到成功';
			}
		}
		$this->redirect('main', array('msg'=>$msg), 0, '正在跳转'.$msg);
	//	$this->assign('msg', $msg);
	}
	
	public function result() {
		$uid=session('uId');
		$qwe="qwe";
		$msg=$this->_param('msg').'##'.$qwe[0];
		
		//获取签到信息sign
		$sign=M('sign');
		$res_sign=$sign->where("uid='%s'", $uid)->select();
		$this->assign('sign', $res_sign);
		
		//获取签到历史
		$shistory=M('shistory');
		$res_history=$shistory->where("uid='%s'", $uid)->select();
		for($i=0; $i<count($res_history, COUNT_NORMAL); $i++) {
			//获取2进制表示的签到历史数组(arr)，并获得当月天数(month)
			$res_history[$i]['arr']=toarray($res_history[$i]['shistory'], $res_history[$i]['sdate'], $res_history[$i]['month']);
			//返回签到历史数组，json格式
			$res_history[$i]['jso']=json_encode($res_history[$i]['arr'], JSON_FORCE_OBJECT);
		//	print_r($res_history[$i]['arr']);
		//	echo $res_history[$i]['jso'];
		}
		$this->assign('shistory', $res_history);
		
		$this->assign('msg', $msg);
		$this->display();
	}
	
	private function monthsign($year, $month) {
		$shistory=M('shistory');
		$res_shistory=$shistory->where("sdate='%s'", $year.'-'.$month)->select();
		for($i=0; $i<count($res_shistory, COUNT_NORMAL); $i++) {
			//获取2进制表示的签到历史数组(arr)，并获得当月天数(month)
			$res_shistory[$i]['arr']=toarray($res_shistory[$i]['shistory'], $res_shistory[$i]['sdate'], $res_shistory[$i]['month']);
			//返回签到历史数组，json格式
			$res_shistory[$i]['jso']=json_encode($res_shistory[$i]['arr'], JSON_FORCE_OBJECT);
		}
		
		return $res_shistory;
	}
}