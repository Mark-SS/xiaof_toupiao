<?php
defined('IN_IA') or exit('Access Denied');
class Xiaof_toupiaoModuleProcessor extends WeModuleProcessor 
{
	private $ll1ll1llll1ll1ll1lll1lll11lllll;
	public function respond() 
	{
		global $_W;
		$this->l1ll111llllllll1l11l1l11ll1llll();
		if ($this->message['type'] == 'text') 
		{
			$lll1l111111111ll1111l1l1l11llll = $this->message['content'];
			if (!empty($this->message['eventkey'])) 
			{
				if ($this->message['event'] == 'SCAN' or $this->message['event'] == 'subscribe') 
				{
					$llllllll1ll1ll1l111111l1l11ll1l = " `qrcid` = '" . $this->message['scene'] . "'";
					$lll1l111111111ll1111l1l1l11llll = pdo_fetchcolumn("SELECT `keyword` FROM " . tablename('qrcode') . " WHERE {$llllllll1ll1ll1l111111l1l11ll1l}
				AND `uniacid` = '{$_W['uniacid']}
			' limit 1");
		}
		else 
		{
			$lll1l111111111ll1111l1l1l11llll = $this->message['eventkey'];
		}
	}
	if ($l1l1ll1l11111lll1llll1111l1l1ll = pdo_fetch("SELECT * FROM " . tablename('xiaof_toupiao_rule') . " WHERE `uniacid` = '" . $_W['uniacid'] . "' AND `keyword` = '" . md5($lll1l111111111ll1111l1l1l11llll) . "' limit 1")) 
	{
		$this->ll11l1ll11llll1lllll1l11ll111l1();
	}
	elseif ($l1l1ll1l11111lll1llll1111l1l1ll = pdo_fetch("SELECT * FROM " . tablename('xiaof_toupiao_rule') . " WHERE `rid` = '" . $this->rule . "' limit 1")) 
	{
	}
	else 
	{
		return $this->respText("系统没有找到您要参与的活动");
	}
	if ($lll1l111111111ll1111l1l1l11llll == '退出' or $lll1l111111111ll1111l1l1l11llll == 'quit') 
	{
		$this->ll11l1ll11llll1lllll1l11ll111l1();
		$this->endContext();
		return $this->respText("缓存已清除");
	}
	if (empty($_SESSION['xiaofsid']) or $l1l1ll1l11111lll1llll1111l1l1ll['sid'] != $_SESSION['xiaofsid']) 
	{
		if ($l1ll1ll1l11ll1111l1l1l1l1ll11ll = pdo_fetch("SELECT `id`,`tit`,`data` FROM " . tablename("xiaof_toupiao_setting") . " WHERE `id` = :id", array(":id" => $l1l1ll1l11111lll1llll1111l1l1ll['sid']))) 
		{
			$l111llll1l11ll1l1l1l1l1l1lll1ll = $_SESSION['xiaofsid'] = $l1ll1ll1l11ll1111l1l1l1l1ll11ll['id'];
		}
		else 
		{
			return $this->respText("系统没有找到您要参与的活动。");
		}
	}
	else 
	{
		$l111llll1l11ll1l1l1l1l1l1lll1ll = intval($_SESSION['xiaofsid']);
		$l1ll1ll1l11ll1111l1l1l1l1ll11ll = pdo_fetch("SELECT `id`,`tit`,`data` FROM " . tablename("xiaof_toupiao_setting") . " WHERE `id` = :id", array(":id" => $l111llll1l11ll1l1l1l1l1l1lll1ll));
	}
	$this->mysetting = $l11111l111111ll11111ll1l11l1ll1 = iunserializer($l1ll1ll1l11ll1111l1l1l1l1ll11ll['data']);
	if (!empty($_SESSION['xiaofprocess'])) 
	{
		$l111l1llll11l1111l1l1l1ll1111ll = iunserializer($_SESSION['xiaofprocess']);
		if (isset($l111l1llll11l1111l1l1l1ll1111ll['vote'])) 
		{
			if (isset($l111l1llll11l1111l1l1l1ll1111ll['join'])) 
			{
				unset($l111l1llll11l1111l1l1l1ll1111ll['join']);
			}
			switch ($l111l1llll11l1111l1l1l1ll1111ll['vote']['step']) 
			{
				case 1: if (intval($l11111l111111ll11111ll1l11l1ll1['openmsgvote']) >= 1) 
				{
					return $this->respText("系统关闭了回复投票，请进活动页投票。<a href='" . $this->ll1lllllll1l11l1l111l111l1111ll('index') . "'>点击进入</a>");
				}
				if (!$ll11l111l111l11llllll1ll11ll1l1 = pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao") . " WHERE `sid` = :sid AND `uid` = :uid", array(":sid" => $l111llll1l11ll1l1l1l1l1l1lll1ll, ":uid" => intval($lll1l111111111ll1111l1l1l11llll)))) 
				{
					return $this->respText("系统没有找到您要投票的选手编号。请重新输入。");
				}
				if (intval($l11111l111111ll11111ll1l11l1ll1['votejump']) == 1) 
				{
					$l1l11ll11l1l1l1ll1l1ll11lllll1l = array('vote' => array('step' => 1));
					$_SESSION['xiaofprocess'] = iserializer($l1l11ll11l1l1l1ll1l1ll11lllll1l);
					return $this->l1llll1l111111llllll11l111l1ll1('我是：' . $ll11l111l111l11llllll1ll11ll1l1['name'] . '，编号：' . $ll11l111l111l11llllll1ll11ll1l1['uid'] . '。点击进入为我投票吧！', $ll11l111l111l11llllll1ll11ll1l1['pic'], $ll11l111l111l11llllll1ll11ll1l1['id']);
				}
				$llll1ll1l11ll11ll111ll1lll11111 = rand(1000, 9999);
				$l111l1llll11l1111l1l1l1ll1111ll['vote']['data'] = array('rand' => $llll1ll1l11ll11ll111ll1lll11111, 'pid' => $ll11l111l111l11llllll1ll11ll1l1['id']);
				$l111l1llll11l1111l1l1l1ll1111ll['vote']['step'] = 2;
				$_SESSION['xiaofprocess'] = iserializer($l111l1llll11l1111l1l1l1ll1111ll);
				return $this->respText("为防刷票请回复四位验证码：" . $llll1ll1l11ll11ll111ll1lll11111 . "");
				break;
				case 2: $ll1l11111llllll1l1l1111llllllll = $l111l1llll11l1111l1l1l1ll1111ll['vote']['data'];
				if ($lll1l111111111ll1111l1l1l11llll != $ll1l11111llllll1l1l1111llllllll['rand']) 
				{
					$llll1ll1l11ll11ll111ll1lll11111 = rand(1000, 9999);
					$l111l1llll11l1111l1l1l1ll1111ll['vote']['data']['rand'] = $llll1ll1l11ll11ll111ll1lll11111;
					$l111l1llll11l1111l1l1l1ll1111ll['vote']['step'] = 2;
					$_SESSION['xiaofprocess'] = iserializer($l111l1llll11l1111l1l1l1ll1111ll);
					return $this->respText("验证码错误。\n请重新回复四位验证码：" . $llll1ll1l11ll11ll111ll1lll11111 . "");
				}
				else 
				{
					if (!$ll11l111l111l11llllll1ll11ll1l1 = pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao") . " WHERE `id` = :id", array(":id" => intval($ll1l11111llllll1l1l1111llllllll['pid'])))) 
					{
						$l1l11ll11l1l1l1ll1l1ll11lllll1l = array('vote' => array('step' => 1));
						$_SESSION['xiaofprocess'] = iserializer($l1l11ll11l1l1l1ll1l1ll11lllll1l);
						return $this->respText("系统没有找到您要投票的选手编号。请重新输入");
					}
					if ($l11111l111111ll11111ll1l11l1ll1['verify'] == 1 && $ll11l111l111l11llllll1ll11ll1l1['verify'] != 1) 
					{
						if ($ll11l111l111l11llllll1ll11ll1l1['verify'] == 0) 
						{
							unset($_SESSION['xiaofprocess']);
							return $this->respText("该选手作品正在审核，暂不接受投票");
						}
					}
					if ($ll11l111l111l11llllll1ll11ll1l1['verify'] == 2) 
					{
						unset($_SESSION['xiaofprocess']);
						return $this->respText("该选手作品审核未通过，不接受投票");
					}
					if ($ll11l111l111l11llllll1ll11ll1l1['locking'] == 1) 
					{
						if ($ll11l111l111l11llllll1ll11ll1l1['locking_at'] >= time() or intval($l11111l111111ll11111ll1l11l1ll1['releasetime']) == 0) 
						{
							return $this->respText("系统检测该选手投票数据异常，已自动锁定，不再接受投票。");
						}
						else 
						{
							pdo_update("xiaof_toupiao", array('locking' => '0', 'locking_at' => '0'), array("id" => $ll11l111l111l11llllll1ll11ll1l1['id']));
						}
					}
					if (intval($l11111l111111ll11111ll1l11l1ll1['limitone']) >= 1) 
					{
						$l1111lll1llll11llll1ll1lll11lll = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename("xiaof_toupiao_log") . " WHERE `sid` = :sid AND `pid` = :pid AND `openid` = :openid", array(":sid" => $l111llll1l11ll1l1l1l1l1l1lll1ll, ":pid" => $ll11l111l111l11llllll1ll11ll1l1['id'], ":openid" => $_W['openid']));
						if ($l1111lll1llll11llll1ll1lll11lll >= intval($l11111l111111ll11111ll1l11l1ll1['limitone'])) 
						{
							unset($_SESSION['xiaofprocess']);
							return $this->respText("本次活动期间您对选手编号" . $ll11l111l111l11llllll1ll11ll1l1['uid'] . "允许最大投票数达到上限，不能再继续给Ta投票");
						}
					}
					if (pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao_log") . " WHERE `sid` = :sid AND `pid` = :pid AND `openid` = :openid AND `unique_at` = :unique_at", array(":sid" => $l111llll1l11ll1l1l1l1l1l1lll1ll, ":pid" => $ll11l111l111l11llllll1ll11ll1l1['id'], ":openid" => $_W['openid'], ":unique_at" => date("Ymd")))) 
					{
						unset($_SESSION['xiaofprocess']);
						return $this->respText("您今天已经给编号" . $ll11l111l111l11llllll1ll11ll1l1['uid'] . "投过票了，明天再来吧");
					}
					if (intval($l11111l111111ll11111ll1l11l1ll1['maxvotenum']) >= 1) 
					{
						$l1111lll1llll11llll1ll1lll11lll = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xiaof_toupiao_log') . " where `sid` = '" . $l111llll1l11ll1l1l1l1l1l1lll1ll . "' AND `openid` = '" . $_W['openid'] . "'");
						if ($l1111lll1llll11llll1ll1lll11lll >= $l11111l111111ll11111ll1l11l1ll1['maxvotenum']) 
						{
							unset($_SESSION['xiaofprocess']);
							return $this->respText("本次活动您共有" . $l11111l111111ll11111ll1l11l1ll1['maxvotenum'] . "票，已经用完，不能再投");
						}
					}
					if (intval($l11111l111111ll11111ll1l11l1ll1['maxgoodnum']) >= 1) 
					{
						if (time() <= strtotime($l11111l111111ll11111ll1l11l1ll1['maxgoodtime']) && $ll11l111l111l11llllll1ll11ll1l1['good'] >= $l11111l111111ll11111ll1l11l1ll1['maxgoodnum']) 
						{
							unset($_SESSION['xiaofprocess']);
							return $this->respText("本次活动" . $l11111l111111ll11111ll1l11l1ll1['maxgoodtime'] . "之前，每位选手最多允许被投" . $l11111l111111ll11111ll1l11l1ll1['maxgoodnum'] . "票，超出无效");
						}
					}
					$l1l11llllll1ll11l1l11l1ll1111l1 = empty($_W['fans']['fanid']) ? 0 : $_W['fans']['fanid'];
					pdo_insert("xiaof_toupiao_log", array( "sid" => $l111llll1l11ll1l1l1l1l1l1lll1ll, "fanid" => $l1l11llllll1ll11l1l11l1ll1111l1, "nickname" => $this->l1l111l11l11l111lll1l111ll1l11l('nickname'), "avatar" => $this->l1l111l11l11l111lll1l111ll1l11l('avatar'), "pid" => $ll11l111l111l11llllll1ll11ll1l1['id'], "openid" => $_W['openid'], "ip" => ip2long(CLIENT_IP), "unique_at" => date("Ymd"), "created_at" => time() ));
					$ll1111ll1ll1l1l1lll111ll11lll11 = 1;
					if (intval($l11111l111111ll11111ll1l11l1ll1['openvirtualclick']) >= 1) 
					{
						$l1l1ll1111ll1ll1llll1lllll1l1ll = rand(1, 10);
						$ll1111ll1ll1l1l1lll111ll11lll11 = $ll1111ll1ll1l1l1lll111ll11lll11 + $l1l1ll1111ll1ll1llll1lllll1l1ll;
					}
					pdo_query("UPDATE " . tablename("xiaof_toupiao") . " SET `good` = good+1, `click` = click+" . $ll1111ll1ll1l1l1lll111ll11lll11 . ", `updated_at` = '" . time() . "' WHERE `id` = '" . $ll11l111l111l11llllll1ll11ll1l1['id'] . "'");
					mc_credit_update($_W['member']['uid'], 'credit1', intval($l11111l111111ll11111ll1l11l1ll1['votecredit']), array(1, '男神女神投票赠送积分', 'system'));
					unset($_SESSION['xiaofprocess']);
					return $this->lll1l1111l1ll11ll11l1l111l11ll1($ll11l111l111l11llllll1ll11ll1l1['uid'], $ll11l111l111l11llllll1ll11ll1l1['name'], $ll11l111l111l11llllll1ll11ll1l1['pic'], $ll11l111l111l11llllll1ll11ll1l1['id']);
				}
				break;
			}
		}
		elseif (isset($l111l1llll11l1111l1l1l1ll1111ll['join'])) 
		{
			if (isset($l111l1llll11l1111l1l1l1ll1111ll['vote'])) 
			{
				unset($l111l1llll11l1111l1l1l1ll1111ll['vote']);
			}
			switch ($l111l1llll11l1111l1l1l1ll1111ll['join']['step']) 
			{
				case 1: if ($lll1l111111111ll1111l1l1l11llll == "") 
				{
					return $this->respText("名称不能为空！且填写后不允许修改。\n请重新输入");
				}
				$l111l1llll11l1111l1l1l1ll1111ll['join']['data'] = array('name' => $lll1l111111111ll1111l1l1l11llll);
				$l111l1llll11l1111l1l1l1ll1111ll['join']['step'] = 2;
				$_SESSION['xiaofprocess'] = iserializer($l111l1llll11l1111l1l1l1ll1111ll);
				return $this->respText("输入手机号码");
				break;
				case 2: if (!$this->l11l1lll111lll1l1ll11lllllll11l($lll1l111111111ll1111l1l1l11llll)) 
				{
					return $this->respText("不是正确的手机号，手机号填写后不允许修改。\n请重新输入");
				}
				if (pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao") . " WHERE `sid` = :sid AND `phone` = :phone", array(":sid" => $l111llll1l11ll1l1l1l1l1l1lll1ll, ":phone" => $lll1l111111111ll1111l1l1l11llll))) 
				{
					return $this->respText("错误,一个手机号只能报名一次。\n请重新输入");
				}
				$l111l1llll11l1111l1l1l1ll1111ll['join']['data']['phone'] = $lll1l111111111ll1111l1l1l11llll;
				$l111l1llll11l1111l1l1l1ll1111ll['join']['step'] = 3;
				$_SESSION['xiaofprocess'] = iserializer($l111l1llll11l1111l1l1l1ll1111ll);
				return $this->respText("请回复上传参赛的照片");
				break;
				case 4: if (!isset($l111l1llll11l1111l1l1l1ll1111ll['join']['data']['phone']) or !isset($l111l1llll11l1111l1l1l1ll1111ll['join']['data']['name']) or !isset($l111l1llll11l1111l1l1l1ll1111ll['join']['data']['pics'])) 
				{
					unset($l111l1llll11l1111l1l1l1ll1111ll['join']['data']);
					$l111l1llll11l1111l1l1l1ll1111ll['join']['step'] = 1;
					$_SESSION['xiaofprocess'] = iserializer($l111l1llll11l1111l1l1l1ll1111ll);
					return $this->respText("资料错误，请重试或联系我们。\n重试请回复名称");
				}
				$llllll1lllllll11111lll1l11lll1l = $this->l11l1l1lll11l11l1l1l1ll1ll1l111(reset($l111l1llll11l1111l1l1l1ll1111ll['join']['data']['pics']), 240);
				$lll1l11lll1l1lll1l11lll11llllll = array( "sid" => $l111llll1l11ll1l1l1l1l1l1lll1ll, "ip" => ip2long(CLIENT_IP), "openid" => $_W['openid'], "nickname" => $this->l1l111l11l11l111lll1l111ll1l11l('nickname'), "avatar" => $this->l1l111l11l11l111lll1l111ll1l11l('avatar'), "pic" => $llllll1lllllll11111lll1l11lll1l[1], "phone" => $l111l1llll11l1111l1l1l1ll1111ll['join']['data']['phone'], "name" => $l111l1llll11l1111l1l1l1ll1111ll['join']['data']['name'], "created_at" => time(), "updated_at" => time() );
				pdo_query("LOCK TABLES " . tablename("xiaof_toupiao") . " WRITE");
				if (!$l1111l1l11l111ll111l1lll1ll11ll = pdo_fetchcolumn("SELECT `uid` FROM " . tablename("xiaof_toupiao") . " WHERE `sid` = :sid ORDER BY `id` DESC limit 1", array(":sid" => $l111llll1l11ll1l1l1l1l1l1lll1ll))) 
				{
					$l1111l1l11l111ll111l1lll1ll11ll = 0;
				}
				$lll1l11lll1l1lll1l11lll11llllll['uid'] = $l1111l1l11l111ll111l1lll1ll11ll + 1;
				pdo_insert("xiaof_toupiao", $lll1l11lll1l1lll1l11lll11llllll);
				$ll11lll1111ll1ll11l1llllllll11l = pdo_insertid();
				pdo_query("UNLOCK TABLES");
				foreach ($l111l1llll11l1111l1l1l1ll1111ll['join']['data']['pics'] as $l111111l1ll11l1l11l111l1l1l1l1l => $llll11l111ll1lllll1llll1l111lll) 
				{
					$ll11l111l1llll111ll11111l111l11 = $this->l11l1l1lll11l11l1l1l1ll1ll1l111($llll11l111ll1lllll1llll1l111lll);
					pdo_insert("xiaof_toupiao_pic", array( "sid" => $l111llll1l11ll1l1l1l1l1l1lll1ll, "pid" => $ll11lll1111ll1ll11l1llllllll11l, "url" => $ll11l111l1llll111ll11111l111l11[0], "thumb" => $ll11l111l1llll111ll11111l111l11[1], "created_at" => time() ));
				}
				mc_credit_update($_W['member']['uid'], 'credit1', intval($l11111l111111ll11111ll1l11l1ll1['joincredit']), array(1, '男神女神报名赠送积分', 'system'));
				unset($_SESSION['xiaofprocess']);
				return $this->l1lll111111ll1ll1l1l1l1ll1ll1ll($l1111l1l11l111ll111l1lll1ll11ll + 1, $llllll1lllllll11111lll1l11lll1l[1], $ll11lll1111ll1ll11l1llllllll11l);
				break;
			}
		}
		else 
		{
			return $this->l11l1lll11111111l1111l11l1l11l1($l11111l111111ll11111ll1l11l1ll1['replytitle'], $l11111l111111ll11111ll1l11l1ll1['replycontent'], $l11111l111111ll11111ll1l11l1ll1['replythumb']);
		}
	}
	else 
	{
		if ($_SESSION['xiaofaction'] != $this->rule) 
		{
			$this->ll11l1ll11llll1lllll1l11ll111l1();
			$_SESSION['xiaofaction'] = $this->rule;
		}
		if (isset($l1l1ll1l11111lll1llll1111l1l1ll['action'])) 
		{
			switch ($l1l1ll1l11111lll1llll1111l1l1ll['action']) 
			{
				case '0': return $this->l11l1lll11111111l1111l11l1l11l1($l11111l111111ll11111ll1l11l1ll1['replytitle'], $l11111l111111ll11111ll1l11l1ll1['replycontent'], $l11111l111111ll11111ll1l11l1ll1['replythumb']);
				break;
				case '1': if ($l1ll111llll1lll1111l11111111lll = pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao") . " WHERE `sid` = :sid AND `openid` = :openid", array(":sid" => $l1ll1ll1l11ll1111l1l1l1l1ll11ll['id'], ":openid" => $_W['openid']))) 
				{
					$this->ll11l1ll11llll1lllll1l11ll111l1();
					return $this->l1llll1l111111llllll11l111l1ll1('您已参与本次活动！名称：' . $l1ll111llll1lll1111l11111111lll['name'] . '，编号：' . $l1ll111llll1lll1111l11111111lll['uid'], $l1ll111llll1lll1111l11111111lll['pic'], $l1ll111llll1lll1111l11111111lll['id']);
				}
				if (time() <= strtotime($l11111l111111ll11111ll1l11l1ll1['joinstart'])) 
				{
					return $this->respText("活动报名未开始，请开始后再报名，开始时间" . $l11111l111111ll11111ll1l11l1ll1['joinstart'] . "");
				}
				if (time() >= strtotime($l11111l111111ll11111ll1l11l1ll1['joinend'])) 
				{
					return $this->respText("活动已结束，敬请期待下次活动");
				}
				if (!$this->inContext) 
				{
					$this->beginContext();
				}
				$ll111lllll1l1l1lllll111llll11l1 = "报名请回复：您的名称";
				$l1l11ll11l1l1l1ll1l1ll11lllll1l = array('join' => array('step' => 1));
				$_SESSION['xiaofprocess'] = iserializer($l1l11ll11l1l1l1ll1l1ll11lllll1l);
				break;
				case '2': if (intval($l11111l111111ll11111ll1l11l1ll1['openmsgvote']) == 1) 
				{
					return $this->respText("系统关闭了回复投票，请进活动页投票。<a href='" . $this->ll1lllllll1l11l1l111l111l1111ll('index') . "'>点击进入</a>");
				}
				if (time() <= strtotime($l11111l111111ll11111ll1l11l1ll1['start'])) 
				{
					return $this->respText("活动未开始，请开始后再投票，开始时间" . $l11111l111111ll11111ll1l11l1ll1['start'] . "");
				}
				if (time() >= strtotime($l11111l111111ll11111ll1l11l1ll1['end'])) 
				{
					return $this->respText("活动已结束，敬请期待下次活动");
				}
				if ($l11111l111111ll11111ll1l11l1ll1['vnum'] >= 1) 
				{
					$l1111lll1llll11llll1ll1lll11lll = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xiaof_toupiao_log') . " where `openid` = '" . $_W['openid'] . "' AND `unique_at` = '" . date(Ymd) . "'");
					if ($l1111lll1llll11llll1ll1lll11lll >= $l11111l111111ll11111ll1l11l1ll1['vnum']) 
					{
						return $this->respText("一个微信号每天只能给" . $l11111l111111ll11111ll1l11l1ll1['vnum'] . "个选手投票");
					}
				}
				if (pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao_safe") . " WHERE `sid` = :sid AND `ip` = :ip ", array(":sid" => $l1ll1ll1l11ll1111l1l1l1l1ll11ll['id'], ":ip" => ip2long(CLIENT_IP)))) 
				{
					return $this->respText("抱歉，系统检测到您非正常投票，投票失败。还绿色公平环境，拒绝刷票。如有疑问联系我们的公众号申诉解封");
				}
				if (!$this->inContext) 
				{
					$this->beginContext();
				}
				$ll111lllll1l1l1lllll111llll11l1 = "投票请回复：选手编号";
				$l1l11ll11l1l1l1ll1l1ll11lllll1l = array('vote' => array('step' => 1));
				$_SESSION['xiaofprocess'] = iserializer($l1l11ll11l1l1l1ll1l1ll11lllll1l);
				break;
				case '3': if (intval($l11111l111111ll11111ll1l11l1ll1['openmsgvote']) == 1) 
				{
					return $this->respText("系统关闭了回复投票，请进活动页投票。<a href='" . $this->ll1lllllll1l11l1l111l111l1111ll('index') . "'>点击进入</a>");
				}
				if (time() <= strtotime($l11111l111111ll11111ll1l11l1ll1['start'])) 
				{
					return $this->respText("活动未开始，请开始后再投票，开始时间" . $l11111l111111ll11111ll1l11l1ll1['start'] . "");
				}
				if (time() >= strtotime($l11111l111111ll11111ll1l11l1ll1['end'])) 
				{
					return $this->respText("活动已结束，敬请期待下次活动");
				}
				if ($l11111l111111ll11111ll1l11l1ll1['vnum'] >= 1) 
				{
					$l1111lll1llll11llll1ll1lll11lll = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xiaof_toupiao_log') . " where `openid` = '" . $_W['openid'] . "' AND `unique_at` = '" . date(Ymd) . "'");
					if ($l1111lll1llll11llll1ll1lll11lll >= $l11111l111111ll11111ll1l11l1ll1['vnum']) 
					{
						return $this->respText("一个微信号每天只能给" . $l11111l111111ll11111ll1l11l1ll1['vnum'] . "个选手投票");
					}
				}
				if (pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao_safe") . " WHERE `ip` = :ip ", array(":ip" => ip2long(CLIENT_IP)))) 
				{
					return $this->respText("抱歉，系统检测到您非正常投票，投票失败。还绿色公平环境，拒绝刷票。如有疑问联系我们的公众号申诉解封");
				}
				preg_match("#.*(\d*)$#iUs", $lll1l111111111ll1111l1l1l11llll, $l1ll1111l1l1ll1lll1111ll1lll1ll);
				if (!$ll11l111l111l11llllll1ll11ll1l1 = pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao") . " WHERE `sid` = :sid AND `uid` = :uid", array(":sid" => $l1ll1ll1l11ll1111l1l1l1l1ll11ll['id'], ":uid" => intval($l1ll1111l1l1ll1lll1111ll1lll1ll[1])))) 
				{
					return $this->respText("系统没有找到您要投票的选手编号。请重新输入");
				}
				if (intval($l11111l111111ll11111ll1l11l1ll1['votejump']) == 1) 
				{
					return $this->l1llll1l111111llllll11l111l1ll1('我是：' . $ll11l111l111l11llllll1ll11ll1l1['name'] . '，编号：' . $ll11l111l111l11llllll1ll11ll1l1['uid'] . '。点击进入为我投票吧！', $ll11l111l111l11llllll1ll11ll1l1['pic'], $ll11l111l111l11llllll1ll11ll1l1['id']);
				}
				if (!$this->inContext) 
				{
					$this->beginContext();
				}
				$llll1ll1l11ll11ll111ll1lll11111 = rand(1000, 9999);
				$l111l1llll11l1111l1l1l1ll1111ll['vote']['data'] = array('rand' => $llll1ll1l11ll11ll111ll1lll11111, 'pid' => $ll11l111l111l11llllll1ll11ll1l1['id']);
				$l111l1llll11l1111l1l1l1ll1111ll['vote']['step'] = 2;
				$_SESSION['xiaofprocess'] = iserializer($l111l1llll11l1111l1l1l1ll1111ll);
				$ll111lllll1l1l1lllll111llll11l1 = "为防刷票请回复四位验证码：" . $llll1ll1l11ll11ll111ll1lll11111 . "";
				break;
				default: return $this->l11l1lll11111111l1111l11l1l11l1($l11111l111111ll11111ll1l11l1ll1['replytitle'], $l11111l111111ll11111ll1l11l1ll1['replycontent'], $l11111l111111ll11111ll1l11l1ll1['replythumb']);
				break;
			}
			return $this->respText($ll111lllll1l1l1lllll111llll11l1);
		}
		return $this->l11l1lll11111111l1111l11l1l11l1($l11111l111111ll11111ll1l11l1ll1['replytitle'], $l11111l111111ll11111ll1l11l1ll1['replycontent'], $l11111l111111ll11111ll1l11l1ll1['replythumb']);
	}
}
elseif ($this->message['type'] == 'image' && isset($_SESSION['xiaofprocess'])) 
{
	$l111l1llll11l1111l1l1l1ll1111ll = iunserializer($_SESSION['xiaofprocess']);
	if (isset($l111l1llll11l1111l1l1l1ll1111ll['join']['step']) && ($l111l1llll11l1111l1l1l1ll1111ll['join']['step'] == 3 or $l111l1llll11l1111l1l1l1ll1111ll['join']['step'] == 4)) 
	{
		$l111llll1l11ll1l1l1l1l1l1lll1ll = intval($_SESSION['xiaofsid']);
		$l1ll1ll1l11ll1111l1l1l1l1ll11ll = pdo_fetch("SELECT `id`,`tit`,`data` FROM " . tablename("xiaof_toupiao_setting") . " WHERE `id` = :id", array(":id" => $l111llll1l11ll1l1l1l1l1l1lll1ll));
		$l11111l111111ll11111ll1l11l1ll1 = iunserializer($l1ll1ll1l11ll1111l1l1l1l1ll11ll['data']);
		$l1l111l1ll11l1l1llllll1lll1l111 = count($l111l1llll11l1111l1l1l1ll1111ll['join']['data']['pics']);
		$lll1l1ll11lllll1ll11llll11l1l1l = $l1l111l1ll11l1l1llllll1lll1l111 + 1;
		$l111l1llll11l1111l1l1l1ll1111ll['join']['step'] = 4;
		$lllll11l1lll111111111ll1l111l11 = empty($l11111l111111ll11111ll1l11l1ll1['limitpic']) ? 5 : $l11111l111111ll11111ll1l11l1ll1['limitpic'];
		if ($lll1l1ll11lllll1ll11llll11l1l1l > $lllll11l1lll111111111ll1l111l11) 
		{
			return $this->respText("最多允许1-" . $lllll11l1lll111111111ll1l111l11 . "张，将只使用前" . $lllll11l1lll111111111ll1l111l11 . "张。请回复任意文字确定继续报名");
		}
		$l111l1llll11l1111l1l1l1ll1111ll['join']['data']['pics'][] = $this->message['picurl'];
		$_SESSION['xiaofprocess'] = iserializer($l111l1llll11l1111l1l1l1ll1111ll);
		if ($lll1l1ll11lllll1ll11llll11l1l1l == $lllll11l1lll111111111ll1l111l11) 
		{
			return $this->respText("请回复任意文字确定报名");
		}
		else 
		{
			return $this->respText("最多允许1-" . $lllll11l1lll111111111ll1l111l11 . "张，当前上传了" . $lll1l1ll11lllll1ll11llll11l1l1l . "张，您可以继续上传，或回复任意文字确定报名");
		}
	}
}
}
private function l11l1l1lll11l11l1l1l1ll1ll1l111($ll1ll111111llll1l11l1l11l1111ll, $ll11l11111l1lll11l1l11ll11111ll = 500) 
{
global $_W;
$ll1llll11l1ll11ll111l11ll1l11ll = $this->lll1llll1l111l111111l1l1l1l11ll();
$l1l1ll11lll11l1llll1111111l11ll = ihttp_get($ll1ll111111llll1l11l1l11l1111ll);
file_put_contents(ATTACHMENT_ROOT . '/' . $ll1llll11l1ll11ll111l11ll1l11ll, $l1l1ll11lll11l1llll1111111l11ll['content']);
$ll111ll1l111l111l11ll111ll1l11l = pathinfo($ll1llll11l1ll11ll111l11ll1l11ll);
$lll1111ll1111lllllllll1l1l1l111 = $l1l1ll111ll11ll111l1ll1llll111l = $ll111ll1l111l111l11ll111ll1l11l['dirname'] . '/' . $ll111ll1l111l111l11ll111ll1l11l['filename'] . '-' . $ll11l11111l1lll11l1l11ll11111ll . '.' . $ll111ll1l111l111l11ll111ll1l11l['extension'];
file_image_thumb(ATTACHMENT_ROOT . '/' . $ll1llll11l1ll11ll111l11ll1l11ll, IA_ROOT . '/attachment/' . $l1l1ll111ll11ll111l1ll1llll111l, $ll11l11111l1lll11l1l11ll11111ll);
if (!empty($_W['setting']['remote']['type'])) 
{
	$l1l1l1l1l1111ll11111l11111111ll = file_remote_upload($l1l1ll111ll11ll111l1ll1llll111l);
	if (is_error($l1l1l1l1l1111ll11111l11111111ll)) 
	{
		return array($ll1llll11l1ll11ll111l11ll1l11ll, $lll1111ll1111lllllllll1l1l1l111);
	}
}
return array($ll1llll11l1ll11ll111l11ll1l11ll, $l1l1ll111ll11ll111l1ll1llll111l);
}
private function lll1llll1l111l111111l1l1l1l11ll() 
{
global $_W;
$l1l111ll1111ll11lll1l1l1l1l1l11 = 'image';
load()->func('file');
$_W['uploadsetting'] = array();
$_W['uploadsetting']['image']['folder'] = 'images/' . $_W['uniacid'];
$_W['uploadsetting']['image']['extentions'] = $_W['config']['upload']['image']['extentions'];
$_W['uploadsetting']['image']['limit'] = $_W['config']['upload']['image']['limit'];
$l1ll1ll1l11ll1111l1l1l1l1ll11ll = $_W['uploadsetting'];
$lllll1l1111l1ll1l1lll1l1l1lll11 = array();
$ll1llll11l1ll11ll111l11ll1l11ll = "{$l1ll1ll1l11ll1111l1l1l1l1ll11ll[$l1l111ll1111ll11lll1l1l1l1l1l11]['folder']}
/" . date('Y/m/');
mkdirs(ATTACHMENT_ROOT . '/' . $ll1llll11l1ll11ll111l11ll1l11ll);
do 
{
$l1l1l11llll1l11llll1l1ll1l1l1l1 = random(30) . '.jpg';
}
while (file_exists(ATTACHMENT_ROOT . '/' . $ll1llll11l1ll11ll111l11ll1l11ll . $l1l1l11llll1l11llll1l1ll1l1l1l1));
$ll1llll11l1ll11ll111l11ll1l11ll .= $l1l1l11llll1l11llll1l1ll1l1l1l1;
return $ll1llll11l1ll11ll111l11ll1l11ll;
}
private function l11l1lll111lll1l1ll11lllllll11l($l1l111111l1lllll11llll1111l111l) 
{
if (!is_numeric($l1l111111l1lllll11llll1111l111l)) 
{
return false;
}
return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $l1l111111l1lllll11llll1111l111l) ? true : false;
}
private function ll11l1ll11llll1lllll1l11ll111l1() 
{
unset($_SESSION['xiaofprocess']);
unset($_SESSION['xiaofaction']);
}
private function l1ll111llllllll1l11l1l11ll1llll() 
{
global $_W;
$lll11l11l1l11lll11l1l1lll1ll111 = pdo_fetch("SELECT * FROM " . tablename("uni_settings") . " WHERE `uniacid` = :uniacid limit 1", array(':uniacid' => $_W['uniacid']));
$lll11l11l1l11lll11l1l1lll1ll111 = iunserializer($lll11l11l1l11lll11l1l1lll1ll111['oauth']);
if (!empty($lll11l11l1l11lll11l1l1lll1ll111['account'])) 
{
$ll11ll1ll11l1ll1l11l11lll1l1111 = $lll11l11l1l11lll11l1l1lll1ll111['account'];
}
elseif ($_W['account']['level'] == 4) 
{
$ll11ll1ll11l1ll1l11l11lll1l1111 = $_W['uniacid'];
}
else 
{
return false;
}
if (!$l1l1ll1l111111l111l11ll1l1l1l1l = pdo_fetch("SELECT * FROM " . tablename("xiaof_relation") . " WHERE `uniacid` = :uniacid AND `oauth_uniacid` = :oauth_uniacid AND `openid` = :openid limit 1", array(":uniacid" => $_W['uniacid'], ":oauth_uniacid" => $ll11ll1ll11l1ll1l11l11lll1l1111, ":openid" => $_W['openid']))) 
{
$l11l11lll1lll1lll1lll1l1ll1l111 = $this->l1l111l11l11l111lll1l111ll1l11l();
$l1l1111l1111llllllllll111lllll1 = array( "uniacid" => $_W['uniacid'], "openid" => $_W['openid'], "oauth_uniacid" => $ll11ll1ll11l1ll1l11l11lll1l1111, "nickname" => $l11l11lll1lll1lll1lll1l1ll1l111['nickname'], "avatar" => $l11l11lll1lll1lll1lll1l1ll1l111['avatar'], "unionid" => $l11l11lll1lll1lll1lll1l1ll1l111['unionid'], "follow" => 1 );
pdo_insert("xiaof_relation", $l1l1111l1111llllllllll111lllll1);
}
if ($l1l1ll1l111111l111l11ll1l1l1l1l['follow'] != 1) 
{
pdo_update("xiaof_relation", array('follow' => 1), array("id" => $l1l1ll1l111111l111l11ll1l1l1l1l['id']));
}
}
private function l1l111l11l11l111lll1l111ll1l11l($ll1lll11llll1ll1ll1lll111l111l1 = null) 
{
global $_W;
if (!is_null($ll1lll11llll1ll1ll1lll111l111l1)) 
{
if (isset($_SESSION['xiaofuserinfo']) && is_serialized($_SESSION['xiaofuserinfo'])) 
{
	$l11l11lll1lll1lll1lll1l1ll1l111 = iunserializer($_SESSION['xiaofuserinfo']);
	if (isset($l11l11lll1lll1lll1lll1l1ll1l111[$ll1lll11llll1ll1ll1lll111l111l1]) && !empty($l11l11lll1lll1lll1lll1l1ll1l111[$ll1lll11llll1ll1ll1lll111l111l1])) 
	{
		return $l11l11lll1lll1lll1lll1l1ll1l111[$ll1lll11llll1ll1ll1lll111l111l1];
	}
}
}
if ($ll1l1l1l1l1ll11llll1ll1l11l1lll = pdo_fetch("SELECT * FROM " . tablename("xiaof_relation") . " WHERE `uniacid` = :uniacid AND `openid` = :openid limit 1", array(":uniacid" => $_W['uniacid'], ":openid" => $_W['openid']))) 
{
$l111lllll1111l1lll11l11l11lll11['openid'] = $ll1l1l1l1l1ll11llll1ll1l11l1lll['openid'];
$l111lllll1111l1lll11l11l11lll11['nickname'] = $ll1l1l1l1l1ll11llll1ll1l11l1lll['nickname'];
$l111lllll1111l1lll11l11l11lll11['avatar'] = $ll1l1l1l1l1ll11llll1ll1l11l1lll['avatar'];
$l111lllll1111l1lll11l11l11lll11['unionid'] = $ll1l1l1l1l1ll11llll1ll1l11l1lll['unionid'];
if (is_null($ll1lll11llll1ll1ll1lll111l111l1)) 
{
	$_SESSION['xiaofuserinfo'] = iserializer($l111lllll1111l1lll11l11l11lll11);
	return $l111lllll1111l1lll11l11l11lll11;
}
else 
{
	if (!empty($l111lllll1111l1lll11l11l11lll11[$ll1lll11llll1ll1ll1lll111l111l1])) 
	{
		return $l111lllll1111l1lll11l11l11lll11[$ll1lll11llll1ll1ll1lll111l111l1];
	}
}
}
if ($_W['account']['level'] <= 2) 
{
return '';
}
$l11l1l1lllll11l1llllllll111l11l = WeixinAccount::create($_W['acid']);
$l1111ll1l111l111111llllll111l11 = $l11l1l1lllll11l1llllllll111l11l->fetch_token();
if (!is_null($l1111ll1l111l111111llllll111l11)) 
{
$ll11ll111l11ll1l1l11lll1ll11l11 = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $l1111ll1l111l111111llllll111l11 . "&openid=" . $_W['openid'] . "&lang=zh_CN";
$l11l1l1111111l1ll1lll1l111111ll = file_get_contents($ll11ll111l11ll1l1l11lll1ll11l11);
$l11l1l1111111l1ll1lll1l111111ll = substr(str_replace('\"', '"', json_encode($l11l1l1111111l1ll1lll1l111111ll)), 1, -1);
$ll1lll111ll1l1lll11l11lll11llll = json_decode($l11l1l1111111l1ll1lll1l111111ll, true);
}
$l111lllll1111l1lll11l11l11lll11 = array('nickname' => '', 'avatar' => '');
isset($ll1lll111ll1l1lll11l11lll11llll['nickname']) && $l111lllll1111l1lll11l11l11lll11['nickname'] = stripcslashes($ll1lll111ll1l1lll11l11lll11llll['nickname']);
if (isset($ll1lll111ll1l1lll11l11lll11llll['headimgurl'])) 
{
if (!empty($ll1lll111ll1l1lll11l11lll11llll['headimgurl'])) 
{
	$ll1lll111ll1l1lll11l11lll11llll['headimgurl'] = rtrim($ll1lll111ll1l1lll11l11lll11llll['headimgurl'], '0') . 132;
}
$l111lllll1111l1lll11l11l11lll11['avatar'] = istripslashes($ll1lll111ll1l1lll11l11lll11llll['headimgurl']);
}
isset($ll1lll111ll1l1lll11l11lll11llll['unionid']) && $l111lllll1111l1lll11l11l11lll11['unionid'] = $ll1lll111ll1l1lll11l11lll11llll['unionid'];
$_SESSION['xiaofuserinfo'] = iserializer($l111lllll1111l1lll11l11l11lll11);
return is_null($ll1lll11llll1ll1ll1lll111l111l1) ? $l111lllll1111l1lll11l11l11lll11 : $l111lllll1111l1lll11l11l11lll11[$ll1lll11llll1ll1ll1lll111l111l1];
}
private function l11l1lll11111111l1111l11l1l11l1($lll1lll1l1ll1lll11l11lll11ll1l1 = '', $ll1l1ll11l1llllllll111llll1ll1l = '', $ll1ll11111llll1ll1l1ll11ll1llll = '') 
{
empty($lll1lll1l1ll1lll11l11lll11ll1l1) && $lll1lll1l1ll1lll11l11lll11ll1l1 = "欢迎参与" . $this->mysetting['title'] . "活动！";
empty($ll1l1ll11l1llllllll111llll1ll1l) && $ll1l1ll11l1llllllll111llll1ll1l = "点击进入活动首页。";
empty($ll1ll11111llll1ll1l1ll11ll1llll) && $ll1ll11111llll1ll1l1ll11ll1llll = $this->mysetting['thumb'][0];
return $this->respNews(array( 'title' => $lll1lll1l1ll1lll11l11lll11ll1l1, 'description' => $ll1l1ll11l1llllllll111llll1ll1l, 'picurl' => tomedia($ll1ll11111llll1ll1l1ll11ll1llll), 'url' => $this->ll1lllllll1l11l1l111l111l1111ll('index') ));
}
private function lll1l1111l1ll11ll11l1l111l11ll1($l1ll11llll1l11l1llll11111llll1l, $llllll11ll1l1l1l111l11ll1lll1ll, $ll1ll11111llll1ll1l1ll11ll1llll, $ll11lll1111ll1ll11l1llllllll11l, $llll11111l1l1llll11l1l1llll1l11 = 1) 
{
$ll1l1ll111llll1111ll11lll11l1ll = array();
$ll1l1ll111llll1111ll11lll11l1ll[] = array( 'title' => '恭喜您成功为编号' . $l1ll11llll1l11l1llll11111llll1l . '' . $llllll11ll1l1l1l111l11ll1lll1ll . '投了' . $llll11111l1l1llll11l1l1llll1l11 . '票', 'description' => $this->mysetting['title'], 'picurl' => tomedia($ll1ll11111llll1ll1l1ll11ll1llll), 'url' => $this->ll1lllllll1l11l1l111l111l1111ll('show', 'xiaof_toupiao', '&id=' . $ll11lll1111ll1ll11l1llllllll11l . '') );
$ll1l1ll111llll1111ll11lll11l1ll[] = array( 'title' => $this->mysetting['title'], 'description' => $this->mysetting['title'], 'picurl' => tomedia($this->mysetting['thumb'][0]), 'url' => $this->ll1lllllll1l11l1l111l111l1111ll('index') );
return $this->respNews($ll1l1ll111llll1111ll11lll11l1ll);
}
private function l1lll111111ll1ll1l1l1l1ll1ll1ll($l1ll11llll1l11l1llll11111llll1l, $ll1ll11111llll1ll1l1ll11ll1llll, $ll11lll1111ll1ll11l1llllllll11l) 
{
$ll1l1ll111llll1111ll11lll11l1ll = array();
$ll1l1ll111llll1111ll11lll11l1ll[] = array( 'title' => '恭喜，报名成功！您的参赛编号为' . $l1ll11llll1l11l1llll11111llll1l . '', 'description' => $this->mysetting['title'], 'picurl' => tomedia($ll1ll11111llll1ll1l1ll11ll1llll), 'url' => $this->ll1lllllll1l11l1l111l111l1111ll('show', 'xiaof_toupiao', '&id=' . $ll11lll1111ll1ll11l1llllllll11l . '') );
$ll1l1ll111llll1111ll11lll11l1ll[] = array( 'title' => $this->mysetting['title'], 'description' => $this->mysetting['title'], 'picurl' => tomedia($this->mysetting['thumb'][0]), 'url' => $this->ll1lllllll1l11l1l111l111l1111ll('index') );
return $this->respNews($ll1l1ll111llll1111ll11lll11l1ll);
}
private function l1llll1l111111llllll11l111l1ll1($l111ll111l111ll1l1l1l1l1l11l1ll, $ll1ll11111llll1ll1l1ll11ll1llll, $ll11lll1111ll1ll11l1llllllll11l) 
{
$ll1l1ll111llll1111ll11lll11l1ll = array();
$ll1l1ll111llll1111ll11lll11l1ll[] = array( 'title' => $l111ll111l111ll1l1l1l1l1l11l1ll, 'description' => $this->mysetting['title'], 'picurl' => tomedia($ll1ll11111llll1ll1l1ll11ll1llll), 'url' => $this->ll1lllllll1l11l1l111l111l1111ll('show', 'xiaof_toupiao', '&id=' . $ll11lll1111ll1ll11l1llllllll11l . '') );
$ll1l1ll111llll1111ll11lll11l1ll[] = array( 'title' => $this->mysetting['title'], 'description' => $this->mysetting['title'], 'picurl' => tomedia($this->mysetting['thumb'][0]), 'url' => $this->ll1lllllll1l11l1l111l111l1111ll('index') );
return $this->respNews($ll1l1ll111llll1111ll11lll11l1ll);
}
private function ll1lllllll1l11l1l111l111l1111ll($l111l111l111ll1l11l11lllll111ll, $l1ll1l11lll1llll111l11l1lll1lll = 'xiaof_toupiao', $ll111l11lll1ll1l1ll11lllll1l1ll = '') 
{
global $_W, $_GPC;
$lll11l1lll1l111ll1l1lllllll111l = empty($this->mysetting['binddomain']) ? $_W['siteroot'] : $this->mysetting['binddomain'];
$l11lll11111lll111llll111ll11l11 = parse_url($lll11l1lll1l111ll1l1lllllll111l, PHP_URL_HOST);
$l111ll11ll1l1l11l1ll111l1l11ll1 = urlencode(base64_encode(authcode($_W['openid'], 'ENCODE', $l11lll11111lll111llll111ll11l11 . 'xi9aofhaha' . $_W['uniacid'], 43200)));
return $lll11l1lll1l111ll1l1lllllll111l . "app/index.php?c=entry&do={$l111l111l111ll1l11l11lllll111ll}
&m={$l1ll1l11lll1llll111l11l1lll1lll}
&i={$_W['uniacid']}
&sid={$_SESSION['xiaofsid']}
&xiaofopenid={$l111ll11ll1l1l11l1ll111l1l11ll1}
{$ll111l11lll1ll1l1ll11lllll1l1ll}
&wxref=mp.weixin.qq.com#wechat_redirect";
}
}
