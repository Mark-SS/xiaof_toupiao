<?php

//decode by QQ:270656184 http://www.yunlu99.com/
defined('IN_IA') or die('Access Denied');
class Xiaof_toupiaoModuleSite extends WeModuleSite
{
	public function doWebTool()
	{
		global $_W, $_GPC;
		//$this->ll1111l1ll11l11l1lll11llll11ll1();
		include $this->template("tool");
	}
	public function doWebGlobalsetting()
	{
		global $_W, $_GPC;
		$ll111lllll1l1l1111l111l1lll111l = array('openmusic', 'openshare', 'openfollow');
		//$this->ll1111l1ll11l11l1lll11llll11ll1();
		$l1l1ll111l11ll1llll111l11lllll1 = md5($_SERVER['HTTP_HOST'] . $this->module['name'] . 'globalsetting');
		$l11lll1l1llll11lll1l1l1111l111l = cache_read("ipaddrr:" . $l1l1ll111l11ll1llll111l11lllll1);
		$l11lll1l1llll11lll1l1l1111l111l or $l11lll1l1llll11lll1l1l1111l111l = array('openmusic' => 1, 'openshare' => 1, 'openfollow' => 1);
		if ($_W['isajax']) {
			if (!in_array($_GPC['name'], $ll111lllll1l1l1111l111l1lll111l)) {
				die(0);
			}
			$l11lll1l1llll11lll1l1l1111l111l[$_GPC['name']] = intval($_GPC['ban']);
			cache_write("ipaddrr:" . $l1l1ll111l11ll1llll111l11lllll1, $l11lll1l1llll11lll1l1l1111l111l);
			die(1);
		}
		include $this->template("globalsetting");
	}
	public function doWebClearjs()
	{
		global $_W, $_GPC;
		//$this->ll1111l1ll11l11l1lll11llll11ll1();
		$ll111l1lllllll1lllllll11l1lllll = uni_setting_load();
		if ($_W['account']['level'] < 3) {
			if (!empty($ll111l1lllllll1lllllll11l1lllll['jsauth_acid'])) {
				$l1lllll1111ll11l1111l11l11ll1ll = $ll111l1lllllll1lllllll11l1lllll['jsauth_acid'];
			} elseif (!empty($ll111l1lllllll1lllllll11l1lllll['oauth']['account'])) {
				$l1lllll1111ll11l1111l11l11ll1ll = $ll111l1lllllll1lllllll11l1lllll['oauth']['account'];
			}
		} else {
			$l1lllll1111ll11l1111l11l11ll1ll = $_W['acid'];
		}
		if (!empty($l1lllll1111ll11l1111l11l11ll1ll)) {
			$l1l11l11lll1l11111111l1l111l1ll = "jsticket:{$l1lllll1111ll11l1111l11l11ll1ll}";
			$l1l111l1llll1l1l1l1l11ll1ll11ll = array();
			$l1l111l1llll1l1l1l1l11ll1ll11ll['ticket'] = '';
			$l1l111l1llll1l1l1l1l11ll1ll11ll['expire'] = 0;
			cache_write($l1l11l11lll1l11111111l1l111l1ll, $l1l111l1llll1l1l1l1l11ll1ll11ll);
			load()->classs('weixin.account');
			$ll111l1111111ll1l1l1lll111lll11 = WeAccount::create($l1lllll1111ll11l1111l11l11ll1ll);
			$l1111l1l1l11l1l1111lll1l1ll1ll1 = $ll111l1111111ll1l1l1lll111lll11->getJsApiTicket();
			if (is_error($l1111l1l1l11l1l1111lll1l1ll1ll1)) {
				message($l1111l1l1l11l1l1111lll1l1ll1ll1['message']);
			} else {
				message('jsApiTicket更新成功');
			}
		} else {
			message('没有获取到要使用的公众号');
		}
	}
	public function doWebClearcache()
	{
		global $_W, $_GPC;
		//$this->ll1111l1ll11l11l1lll11llll11ll1();
		cache_clean('iplongregion');
		cache_clean('ipaddr');
		$l11ll1111lllll11ll1ll111l11ll1l = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_rule') . " WHERE `uniacid` = '0'");
		foreach ($l11ll1111lllll11ll1ll111l11ll1l as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
			$l11lll1l1llll11lll1l1l1111l111l = pdo_fetch("SELECT * FROM " . tablename('rule') . " WHERE `id` = '" . $l1ll1ll1l11ll11l111llll1l1111ll['rid'] . "'");
			pdo_update("xiaof_toupiao_rule", array("uniacid" => $l11lll1l1llll11lll1l1l1111l111l['uniacid']), array("rid" => $l1ll1ll1l11ll11l111llll1l1111ll['rid']));
		}
		pdo_query("DELETE FROM " . tablename('xiaof_relation') . " WHERE `openid` = '' or `oauth_openid` = ''");
		message('清理完成');
	}
	public function doWebCleartoken()
	{
		global $_W, $_GPC;
		//$this->ll1111l1ll11l11l1lll11llll11ll1();
		$ll111l1lllllll1lllllll11l1lllll = uni_setting_load();
		if (!empty($ll111l1lllllll1lllllll11l1lllll['oauth']['account'])) {
			$ll1lll11llll11ll11l1ll1l11lll11 = $ll111l1lllllll1lllllll11l1lllll['oauth']['account'];
		} else {
			$ll1lll11llll11ll11l1ll1l11lll11 = $_W['account']['acid'];
		}
		if (!empty($ll1lll11llll11ll11l1ll1l11lll11)) {
			$l1l11l11lll1l11111111l1l111l1ll = "accesstoken:{$ll1lll11llll11ll11l1ll1l11lll11}";
			$l1l111l1llll1l1l1l1l11ll1ll11ll = array();
			$l1l111l1llll1l1l1l1l11ll1ll11ll['token'] = '';
			$l1l111l1llll1l1l1l1l11ll1ll11ll['expire'] = 0;
			cache_write($l1l11l11lll1l11111111l1l111l1ll, $l1l111l1llll1l1l1l1l11ll1ll11ll);
			load()->classs('weixin.account');
			$ll111l1111111ll1l1l1lll111lll11 = WeAccount::create($ll1lll11llll11ll11l1ll1l11lll11);
			$l1l1111lll111l11ll11111l1111111 = $ll111l1111111ll1l1l1lll111lll11->getAccessToken();
			if (is_error($l1l1111lll111l11ll11111l1111111)) {
				message($l1l1111lll111l11ll11111l1111111['message']);
			} else {
				message('accessToken更新成功');
			}
		} else {
			message('没有获取到要使用的公众号');
		}
	}
	public function doWebDiagnose()
	{
		global $_W, $_GPC;
		//$this->ll1111l1ll11l11l1lll11llll11ll1();
		$lll1ll1l1l1l1llll11l1lll11111l1 = '';
		$lll11l111lllll11111ll11ll111l1l = 100;
		if (intval($this->module['config']['openweixin']) == 1) {
			if (pdo_fieldexists("mc_mapping_fans", "unionid")) {
				$lll1ll1l1l1l1llll11l1lll11111l1 .= '粉丝开放平台数据表<span class="label label-success">正常</span>......<br/>';
				if (pdo_indexexists('mc_mapping_fans', 'unionid')) {
					$lll1ll1l1l1l1llll11l1lll11111l1 .= '粉丝开放平台数据表优化<span class="label label-success">正常</span>......<br/>';
				} else {
					$lll1ll1l1l1l1llll11l1lll11111l1 .= '粉丝开放平台数据表优化<span class="label label-warning">未优化</span>......<br/>';
				}
			} else {
				$lll1ll1l1l1l1llll11l1lll11111l1 .= '粉丝开放平台数据表<span class="label label-danger">不存在</span>......<br/>';
			}
			$lll1ll1l1l1l1llll11l1lll11111l1 .= '----------<br/>';
			$l1111l11l1llll1l11l1lll11l11lll = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_setting') . " WHERE `uniacid` = :uniacid", array(":uniacid" => $_W['uniacid']));
			$ll1l1l111ll1l1111l11ll111l1111l = array();
			foreach ($l1111l11l1llll1l11l1lll11l11lll as $l1ll1ll1l11ll11l111llll1l1111ll) {
				$ll1l1l111ll1l1111l11ll111l1111l[] = intval($l1ll1ll1l11ll11l111llll1l1111ll['id']);
			}
			load()->classs('account');
			$ll1ll11ll1l1111l1llll111l111111 = WeUtility::createModuleReceiver('xiaof_toupiao');
			if (empty($ll1ll11ll1l1111l1llll111l111111)) {
				$lll1ll1l1l1l1llll11l1lll11111l1 .= '模块订阅<span class="label label-danger">错误</span>......<br/>';
			}
			$ll1ll11ll1l1111l1llll111l111111->uniacid = $_W['uniacid'];
			$ll1ll11ll1l1111l1llll111l111111->acid = $_W['acid'];
			if (method_exists($ll1ll11ll1l1111l1llll111l111111, 'receive')) {
				$lll1ll1l1l1l1llll11l1lll11111l1 .= '模块订阅<span class="label label-success">正常</span>......<br/>';
			}
			$l1l1llllll1ll11lll11111l11ll11l = $_W['setting']['module_receive_ban'];
			if (!is_array($l1l1llllll1ll11lll11111l11ll11l)) {
				$l1l1llllll1ll11lll11111l11ll11l = array();
			}
			if (!isset($l1l1llllll1ll11lll11111l11ll11l['xiaof_toupiao'])) {
				$lll1ll1l1l1l1llll11l1lll11111l1 .= '模块订阅消息<span class="label label-success">已经打开</span>......<br/>';
			} else {
				$lll1ll1l1l1l1llll11l1lll11111l1 .= '模块订阅消息<span class="label label-danger">被关闭</span>......<a target="_blank" href="' . wurl('extension/subscribe/subscribe') . '">开启</a><br/>';
			}
			$lll1ll1l1l1l1llll11l1lll11111l1 .= '----------<br/>';
			$l111llll111l1l11l11111l111111l1 = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_acid') . " WHERE `sid` in ('" . implode("','", $ll1l1l111ll1l1111l11ll111l1111l) . "')");
			$l1111ll1l11ll1l1lllll1l1l1111ll[] = $_W['uniacid'];
			foreach ($l111llll111l1l11l11111l111111l1 as $l1ll1ll1l11ll11l111llll1l1111ll) {
				$l1111ll1l11ll1l1lllll1l1l1111ll[] = $l1ll1ll1l11ll11l111llll1l1111ll['acid'];
			}
			$l1111ll1l11ll1l1lllll1l1l1111ll = array_unique($l1111ll1l11ll1l1lllll1l1l1111ll);
			load()->classs('weixin.account');
			foreach ($l1111ll1l11ll1l1lllll1l1l1111ll as $l1ll1ll1l11ll11l111llll1l1111ll) {
				$l1l1111l111l1lll1l1ll111l111111 = uni_accounts($l1ll1ll1l11ll11l111llll1l1111ll);
				$l1l1ll111llll111llllll111l111l1 = uni_fetch($l1ll1ll1l11ll11l111llll1l1111ll);
				$l1l1ll111lll1l11lll111l1llll111 = $l1l1111l111l1lll1l1ll111l111111[$l1l1ll111llll111llllll111l111l1['default_acid']];
				if ($l1l11l11ll11l1l1111l1ll11ll1ll1 = pdo_fetch("SELECT * FROM " . tablename("mc_mapping_fans") . " WHERE `uniacid` = :uniacid ORDER BY `fanid` DESC limit 1", array(":uniacid" => $l1ll1ll1l11ll11l111llll1l1111ll))) {
					if (empty($l1l11l11ll11l1l1111l1ll11ll1ll1['unionid'])) {
						$lll1ll1l1l1l1llll11l1lll11111l1 .= '公众号【' . $l1l1ll111llll111llllll111l111l1['name'] . '】：开放平台数据<span class="label label-danger">有问题</span>......<br/>';
						if ($l1l1ll111lll1l11lll111l1llll111['level'] < 3) {
							$lll1ll1l1l1l1llll11l1lll11111l1 .= '公众号【' . $l1l1ll111llll111llllll111l111l1['name'] . '】：账号类型为未认证，跳过......<br/>';
						} else {
							$l11l1l11lllll11ll111l1ll1l1ll11 = WeixinAccount::create($l1l1ll111llll111llllll111l111l1['default_acid']);
							$llll11lll1111lll1111l11ll11ll1l = $l11l1l11lllll11ll111l1ll1l1ll11->fetch_token();
							$l11ll1111lll111lll11ll11ll111l1 = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $llll11lll1111lll1111l11ll11ll1l . "&openid=" . $l1l11l11ll11l1l1111l1ll11ll1ll1['openid'] . "&lang=zh_CN";
							$l1l1lll111ll111l1ll11l111l1ll1l = file_get_contents($l11ll1111lll111lll11ll11ll111l1);
							$l1l1lll111ll111l1ll11l111l1ll1l = substr(str_replace('\"', '"', json_encode($l1l1lll111ll111l1ll11l111l1ll1l)), 1, -1);
							$ll1ll11llll1l11l11llll1ll11ll1l = @json_decode($l1l1lll111ll111l1ll11l111l1ll1l, true);
							if (isset($ll1ll11llll1l11l11llll1ll11ll1l['unionid'])) {
								$lll1ll1l1l1l1llll11l1lll11111l1 .= '公众号【' . $l1l1ll111llll111llllll111l111l1['name'] . '】：获取开放平台数据成功，请尝试去该公众号运行获取粉丝信息......<a target="_blank" href="' . $this->createWebUrl('getunionid') . '">进入</a><br/>';
							} else {
								$lll1ll1l1l1l1llll11l1lll11111l1 .= '公众号【' . $l1l1ll111llll111llllll111l111l1['name'] . '】：获取开放平台数据<span class="label label-danger">失败</span>，该号未绑定开放平台......<br/>';
							}
						}
					} else {
						$lll1ll1l1l1l1llll11l1lll11111l1 .= '公众号【' . $l1l1ll111llll111llllll111l111l1['name'] . '】：开放平台<span class="label label-success">数据正常</span>......<br/>';
					}
				}
			}
			$lll1ll1l1l1l1llll11l1lll11111l1 .= '----------<br/>';
		} else {
			message('本工具只适用开放平台配置检测。');
		}
		include $this->template("diagnose");
	}
	public function doWebDrawlists()
	{
		global $_W, $_GPC;
		//$this->ll1111l1ll11l11l1lll11llll11ll1();
		if (!empty($_GPC['use'])) {
			if (empty($_GPC['did'])) {
				die('参数错误');
			}
			pdo_update("xiaof_toupiao_draw", array("uses" => '1', "bdelete_at" => time()), array("id" => intval($_GPC['did'])));
		}
		if (!empty($_GPC['del'])) {
			$l1l11lll1l1llll1ll1ll111ll1l111 = array();
			foreach ($_GPC['delete'] as $l1ll1ll1l11ll11l111llll1l1111ll) {
				$l1l11lll1l1llll1ll1ll111ll1l111[] = intval($l1ll1ll1l11ll11l111llll1l1111ll);
			}
			pdo_query("DELETE FROM " . tablename('xiaof_toupiao_draw') . " WHERE `id` IN ('" . implode("','", $l1l11lll1l1llll1ll1ll111ll1l111) . "')");
		}
		if (!empty($_GPC['pass'])) {
			$l1l11lll1l1llll1ll1ll111ll1l111 = array();
			foreach ($_GPC['delete'] as $l1ll1ll1l11ll11l111llll1l1111ll) {
				$l1l11lll1l1llll1ll1ll111ll1l111[] = intval($l1ll1ll1l11ll11l111llll1l1111ll);
			}
			pdo_query("UPDATE " . tablename('xiaof_toupiao_draw') . " SET `uses` = '1', `bdelete_at` = '" . time() . "' WHERE `id` IN ('" . implode("','", $l1l11lll1l1llll1ll1ll111ll1l111) . "')");
		}
		$l1111l11l1llll1l11l1lll11l11lll = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_setting') . " WHERE `uniacid` = :uniacid", array(":uniacid" => $_W['uniacid']));
		if (!empty($_GPC['sid'])) {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l = ' WHERE `sid`=:sid';
			$l1l11l1llll1llllll11l1llll1ll1l[':sid'] = intval($_GPC['sid']);
		} else {
			$ll1l1l111ll1l1111l11ll111l1111l = array();
			foreach ($l1111l11l1llll1l11l1lll11l11lll as $l1ll1ll1l11ll11l111llll1l1111ll) {
				$ll1l1l111ll1l1111l11ll111l1111l[] = intval($l1ll1ll1l11ll11l111llll1l1111ll['id']);
			}
			$l1l1l1l1l1ll1ll1ll11llll11ll11l = " WHERE `sid` in ('" . implode("','", $ll1l1l111ll1l1111l11ll111l1111l) . "')";
			$l1l11l1llll1llllll11l1llll1ll1l = array();
		}
		if (!empty($_GPC['key'])) {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l .= ' AND (`uid`=:uid or `uname`=:uname)';
			$l1l11l1llll1llllll11l1llll1ll1l[':uid'] = $_GPC['key'];
			$l1l11l1llll1llllll11l1llll1ll1l[':uname'] = $_GPC['key'];
			$l1l1ll111l11ll1llll111l11lllll1 = $_GPC['key'];
		}
		if (!empty($_GPC['uses'])) {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l .= ' AND `uses`=:uses';
			$l1l11l1llll1llllll11l1llll1ll1l[':uses'] = intval($_GPC['uses']);
		}
		if (!empty($_GPC['attr'])) {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l .= ' AND `attr`=:attr';
			$l1l11l1llll1llllll11l1llll1ll1l[':attr'] = intval($_GPC['attr']);
		}
		$ll1l1ll1l111lllll111111l111111l = max(1, intval($_GPC['page']));
		$lll1111llllll111l111lllll1l1l1l = 20;
		$ll1l1ll1111l11111l11111ll1ll11l = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xiaof_toupiao_draw') . $l1l1l1l1l1ll1ll1ll11llll11ll11l, $l1l11l1llll1llllll11l1llll1ll1l);
		$l11111l11ll11llll111ll111l1ll11 = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_draw') . $l1l1l1l1l1ll1ll1ll11llll11ll11l . " ORDER BY `id` DESC LIMIT " . ($ll1l1ll1l111lllll111111l111111l - 1) * $lll1111llllll111l111lllll1l1l1l . ',' . $lll1111llllll111l111lllll1l1l1l, $l1l11l1llll1llllll11l1llll1ll1l);
		foreach ($l11111l11ll11llll111ll111l1ll11 as &$ll1lll11llll11lllllll11ll1l11l1) {
			$ll111lll1lll1111ll1l11l1111l1l1 = $this->lllll111lllll1l111111ll1l11lll1();
			$l111l1l1l1lll1lll1lllll1ll1ll1l = pdo_fetchcolumn("SELECT `address` FROM " . tablename('xiaof_relation') . " WHERE `uniacid` IN ('" . implode("','", $ll111lll1lll1111ll1l11l1111l1l1) . "') AND `openid` = '" . $ll1lll11llll11lllllll11ll1l11l1['openid'] . "' AND `address` != '' ORDER BY `id` DESC limit 1");
			$ll1lll11llll11lllllll11ll1l11l1['address'] = iunserializer($l111l1l1l1lll1lll1lllll1ll1ll1l);
		}
		$ll11l1111l1llll1llll1l1l1l111l1 = pagination($ll1l1ll1111l11111l11111ll1ll11l, $ll1l1ll1l111lllll111111l111111l, $lll1111llllll111l111lllll1l1l1l);
		include $this->template("drawlists");
	}
	public function doWebGetunionid()
	{
		global $_W, $_GPC;
		//$this->ll1111l1ll11l11l1lll11llll11ll1();
		$l1lllllll1l1ll1ll1l1lll111ll11l = pdo_fieldexists("mc_mapping_fans", "unionid");
		if ($l1lllllll1l1ll1ll1l1lll111ll11l && isset($this->module['config']['openweixin']) && $this->module['config']['openweixin'] == 1) {
			$ll1ll1111ll1ll11l1l1ll11l11lll1 = intval($_W['acid']);
			$lllllll1llll111llll1ll11lll1ll1 = intval($_GPC['offset']);
			if (intval($_GPC['page']) == 0) {
				message('正在更新粉丝unionid,请不要关闭浏览器。已有unionid数据的将不再重复更新', $this->createWebUrl('getunionid', array('page' => 1, 'acid' => $ll1ll1111ll1ll11l1l1ll11l11lll1)), 'success');
			}
			$ll1l1ll1l111lllll111111l111111l = max(1, intval($_GPC['page']));
			$lll1111llllll111l111lllll1l1l1l = 50;
			$ll1l1ll1111l11111l11111ll1ll11l = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('mc_mapping_fans') . " WHERE `uniacid` = :uniacid AND `acid` = :acid AND `unionid` = :unionid", array(':uniacid' => $_W['uniacid'], ':acid' => $ll1ll1111ll1ll11l1l1ll11l11lll1, ':unionid' => ""));
			$l1111l1lll11l11111l11111l1ll1ll = pdo_fetchall("SELECT * FROM " . tablename('mc_mapping_fans') . " WHERE `uniacid` = :uniacid AND `acid` = :acid AND `unionid` = :unionid ORDER BY `fanid` DESC LIMIT " . $lllllll1llll111llll1ll11lll1ll1 . ',' . $lll1111llllll111l111lllll1l1l1l, array(':uniacid' => $_W['uniacid'], ':acid' => $ll1ll1111ll1ll11l1l1ll11l11lll1, ':unionid' => ""));
			$l11l1l11lllll11ll111l1ll1l1ll11 = WeAccount::create($ll1ll1111ll1ll11l1l1ll11l11lll1);
			$llll11lll1111lll1111l11ll11ll1l = $l11l1l11lllll11ll111l1ll1l1ll11->fetch_token();
			if (!empty($l1111l1lll11l11111l11111l1ll1ll)) {
				foreach ($l1111l1lll11l11111l11111l1ll1ll as $ll1lll11llll11lllllll11ll1l11l1) {
					$l11ll1111lll111lll11ll11ll111l1 = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $llll11lll1111lll1111l11ll11ll1l . "&openid=" . $ll1lll11llll11lllllll11ll1l11l1['openid'] . "&lang=zh_CN";
					$l1l111ll1lll11ll11llll1l111lll1 = file_get_contents($l11ll1111lll111lll11ll11ll111l1);
					$l1l111ll1lll11ll11llll1l111lll1 = substr(str_replace('\"', '"', json_encode($l1l111ll1lll11ll11llll1l111lll1)), 1, -1);
					$ll1ll11llll1l11l11llll1ll11ll1l = @json_decode($l1l111ll1lll11ll11llll1l111lll1, true);
					if (isset($ll1ll11llll1l11l11llll1ll11ll1l['unionid'])) {
						pdo_update("mc_mapping_fans", array("unionid" => $ll1ll11llll1l11l11llll1ll11ll1l['unionid']), array("fanid" => $ll1lll11llll11lllllll11ll1l11l1['fanid']));
					} else {
						$lllllll1llll111llll1ll11lll1ll1++;
					}
				}
			}
			$ll1l1ll1l111lllll111111l111111l++;
			$ll1l1111l11lll1ll1ll11l1ll11lll = ($ll1l1ll1l111lllll111111l111111l - 1) * $lll1111llllll111l111lllll1l1l1l;
			if ($lllllll1llll111llll1ll11lll1ll1 >= $ll1l1ll1111l11111l11111ll1ll11l) {
				message('粉丝unionid更新完成，共更新' . ($ll1l1111l11lll1ll1ll11l1ll11lll - $lllllll1llll111llll1ll11lll1ll1) . ' 条数据，数据获取失败' . $lllllll1llll111llll1ll11lll1ll1 . '条。', '', 'success');
			} else {
				message('正在更新粉丝unionid,请不要关闭浏览器,已完成更新 ' . ($ll1l1111l11lll1ll1ll11l1ll11lll - $lllllll1llll111llll1ll11lll1ll1) . ' 条数据。', $this->createWebUrl('getunionid', array('page' => $ll1l1ll1l111lllll111111l111111l, 'acid' => $ll1ll1111ll1ll11l1l1ll11l11lll1, 'offset' => $lllllll1llll111llll1ll11lll1ll1)));
			}
		} else {
			message('您的活动没有开启微信开放平台，请先去设置修改，并公众号需要在微信开放平台绑定', '/web/index.php?c=profile&a=module&do=setting&m=xiaof_toupiao', 'success');
		}
	}
	public function doWebSettinglists()
	{
		global $_W, $_GPC;
		//$this->ll1111l1ll11l11l1lll11llll11ll1();
		if (!empty($_GPC['del'])) {
			$l1l11lll1l1llll1ll1ll111ll1l111 = array();
			foreach ($_GPC['delete'] as $l1ll1ll1l11ll11l111llll1l1111ll) {
				$l1l11lll1l1llll1ll1ll111ll1l111[] = intval($l1ll1ll1l11ll11l111llll1l1111ll);
				pdo_query("DELETE FROM " . tablename('xiaof_toupiao') . " WHERE `sid` = '" . $l1ll1ll1l11ll11l111llll1l1111ll . "'");
				pdo_query("DELETE FROM " . tablename('xiaof_toupiao_draw') . " WHERE `sid` = '" . $l1ll1ll1l11ll11l111llll1l1111ll . "'");
				pdo_query("DELETE FROM " . tablename('xiaof_toupiao_drawlog') . " WHERE `sid` = '" . $l1ll1ll1l11ll11l111llll1l1111ll . "'");
				pdo_query("DELETE FROM " . tablename('xiaof_toupiao_log') . " WHERE `sid` = '" . $l1ll1ll1l11ll11l111llll1l1111ll . "'");
				pdo_query("DELETE FROM " . tablename('xiaof_toupiao_manage') . " WHERE `sid` = '" . $l1ll1ll1l11ll11l111llll1l1111ll . "'");
				pdo_query("DELETE FROM " . tablename('xiaof_toupiao_pic') . " WHERE `sid` = '" . $l1ll1ll1l11ll11l111llll1l1111ll . "'");
				pdo_query("DELETE FROM " . tablename('xiaof_toupiao_rule') . " WHERE `sid` = '" . $l1ll1ll1l11ll11l111llll1l1111ll . "'");
				pdo_query("DELETE FROM " . tablename('xiaof_toupiao_safe') . " WHERE `sid` = '" . $l1ll1ll1l11ll11l111llll1l1111ll . "'");
				pdo_query("DELETE FROM " . tablename('xiaof_toupiao_acid') . " WHERE `sid` = '" . $l1ll1ll1l11ll11l111llll1l1111ll . "'");
			}
			pdo_query("DELETE FROM " . tablename('xiaof_toupiao_setting') . " WHERE `id` IN ('" . implode("','", $l1l11lll1l1llll1ll1ll111ll1l111) . "')");
		}
		if (!empty($_GPC['pass'])) {
			set_time_limit(0);
			load()->func('file');
			$l1l11lll1l1llll1ll1ll111ll1l111 = array();
			foreach ($_GPC['delete'] as $l1ll1ll1l11ll11l111llll1l1111ll) {
				$l1l11lll1l1llll1ll1ll111ll1l111[] = intval($l1ll1ll1l11ll11l111llll1l1111ll);
				$lll1l1l111111ll11l1l1l11111l1ll = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_pic') . " WHERE `sid` = :sid", array(":sid" => intval($l1ll1ll1l11ll11l111llll1l1111ll)));
				foreach ($lll1l1l111111ll11l1l1l11111l1ll as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
					$lll1111111ll111l1l1l1ll1ll1l1ll = pathinfo($l1ll1ll1l11ll11l111llll1l1111ll['url']);
					file_delete($lll1111111ll111l1l1l1ll1ll1l1ll['dirname'] . '/' . $lll1111111ll111l1l1l1ll1ll1l1ll['filename'] . '-500.' . $lll1111111ll111l1l1l1ll1ll1l1ll['extension']);
					file_delete($lll1111111ll111l1l1l1ll1ll1l1ll['dirname'] . '/' . $lll1111111ll111l1l1l1ll1ll1l1ll['filename'] . '-240.' . $lll1111111ll111l1l1l1ll1ll1l1ll['extension']);
					file_delete($l1ll1ll1l11ll11l111llll1l1111ll['url']);
				}
				pdo_query("DELETE FROM " . tablename('xiaof_toupiao') . " WHERE `sid` = '" . $l1ll1ll1l11ll11l111llll1l1111ll . "'");
				pdo_query("DELETE FROM " . tablename('xiaof_toupiao_draw') . " WHERE `sid` = '" . $l1ll1ll1l11ll11l111llll1l1111ll . "'");
				pdo_query("DELETE FROM " . tablename('xiaof_toupiao_drawlog') . " WHERE `sid` = '" . $l1ll1ll1l11ll11l111llll1l1111ll . "'");
				pdo_query("DELETE FROM " . tablename('xiaof_toupiao_log') . " WHERE `sid` = '" . $l1ll1ll1l11ll11l111llll1l1111ll . "'");
				pdo_query("DELETE FROM " . tablename('xiaof_toupiao_manage') . " WHERE `sid` = '" . $l1ll1ll1l11ll11l111llll1l1111ll . "'");
				pdo_query("DELETE FROM " . tablename('xiaof_toupiao_pic') . " WHERE `sid` = '" . $l1ll1ll1l11ll11l111llll1l1111ll . "'");
				pdo_query("DELETE FROM " . tablename('xiaof_toupiao_rule') . " WHERE `sid` = '" . $l1ll1ll1l11ll11l111llll1l1111ll . "'");
				pdo_query("DELETE FROM " . tablename('xiaof_toupiao_safe') . " WHERE `sid` = '" . $l1ll1ll1l11ll11l111llll1l1111ll . "'");
				pdo_query("DELETE FROM " . tablename('xiaof_toupiao_acid') . " WHERE `sid` = '" . $l1ll1ll1l11ll11l111llll1l1111ll . "'");
			}
			pdo_query("DELETE FROM " . tablename('xiaof_toupiao_setting') . " WHERE `id` IN ('" . implode("','", $l1l11lll1l1llll1ll1ll111ll1l111) . "')");
		}
		$ll1l1ll1l111lllll111111l111111l = max(1, intval($_GPC['page']));
		$lll1111llllll111l111lllll1l1l1l = 10;
		$ll1l1ll1111l11111l11111ll1ll11l = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xiaof_toupiao_setting') . " WHERE `uniacid` = " . $_W['uniacid']);
		$ll11l11l1111l1ll1llll11111l11ll = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_setting') . " WHERE `uniacid` = :uniacid ORDER BY `id` DESC LIMIT " . ($ll1l1ll1l111lllll111111l111111l - 1) * $lll1111llllll111l111lllll1l1l1l . ',' . $lll1111llllll111l111lllll1l1l1l, array(":uniacid" => $_W['uniacid']));
		$l11111l11ll11llll111ll111l1ll11 = array();
		foreach ($ll11l11l1111l1ll1llll11111l11ll as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
			$l11lll1l1llll11lll1l1l1111l111l = array();
			$l11lll1l1llll11lll1l1l1111l111l['id'] = $l1ll1ll1l11ll11l111llll1l1111ll['id'];
			$l11lll1l1llll11lll1l1l1111l111l['created_at'] = $l1ll1ll1l11ll11l111llll1l1111ll['created_at'];
			$l11111l11ll11llll111ll111l1ll11[] = array_merge($l11lll1l1llll11lll1l1l1111l111l, unserialize($l1ll1ll1l11ll11l111llll1l1111ll['data']));
		}
		$l1l1llllll1ll11lll11111l11ll11l = $_W['setting']['module_receive_ban'];
		if (!is_array($l1l1llllll1ll11lll11111l11ll11l)) {
			$l1l1llllll1ll11lll11111l11ll11l = array();
		}
		$ll111l1lllllll1lllllll11l1lllll = pdo_fetch("SELECT * FROM " . tablename("uni_settings") . " WHERE `uniacid` = :uniacid limit 1", array(':uniacid' => $_W['uniacid']));
		$ll111l1lllllll1lllllll11l1lllll = iunserializer($ll111l1lllllll1lllllll11l1lllll['oauth']);
		$ll11l1111l1llll1llll1l1l1l111l1 = pagination($ll1l1ll1111l11111l11111ll1ll11l, $ll1l1ll1l111lllll111111l111111l, $lll1111llllll111l111lllll1l1l1l);
		include $this->template("settinglists");
	}
	public function doWebSettingedit()
	{
		global $_W, $_GPC;
		//$this->ll1111l1ll11l11l1lll11llll11ll1();
		load()->func('tpl');
		$l11lll1l1llll11lll1l1l1111l111l = array();
		if (isset($_GET['sid'])) {
			$l11lll1l1llll11lll1l1l1111l111l = $this->l1l11ll11ll1l1111lll11lllll1l11();
		} else {
			$l1l1ll111l11ll1llll111l11lllll1 = md5($_SERVER['HTTP_HOST'] . $this->module['name'] . 'globalsetting');
			$l1ll11ll1lll1l1l111llll1l1111ll = cache_read("ipaddrr:" . $l1l1ll111l11ll1llll111l11lllll1);
			$l1ll11ll1lll1l1l111llll1l1111ll or $l1ll11ll1lll1l1l111llll1l1111ll = array('openmusic' => 1, 'openshare' => 1, 'openfollow' => 1);
			$l11lll1l1llll11lll1l1l1111l111l['globalsetting'] = $l1ll11ll1lll1l1l111llll1l1111ll;
		}
		$ll1ll1lll1ll11ll1ll1l1l1l111111 = pdo_fetch("SELECT `detail`,`bottom` FROM " . tablename("xiaof_toupiao_setting") . " WHERE `id` = :id", array(":id" => $l11lll1l1llll11lll1l1l1111l111l['id']));
		$l11llll1l1l111ll11ll1l1ll1lllll = iunserializer($ll1ll1lll1ll11ll1ll1l1l1l111111['detail']);
		$l1l11111ll1llllll111ll11ll11lll = array();
		foreach ($l11lll1l1llll11lll1l1l1111l111l['prize'] as $l1ll1ll1l11ll11l111llll1l1111ll) {
			$l1l11111ll1llllll111ll11ll11lll[] = $l1ll1ll1l11ll11l111llll1l1111ll['probability'];
		}
		$l111l1l1111l11lll1111l1l1l11111 = array_sum($l1l11111ll1llllll111ll11ll11lll);
		$lll11ll1111l111111lll1l111ll11l = '01.一个微信号每天只能给同一个选手投一票<br/>		02.一个微信号每天可以给5位选手投票<br/>		03.一个IP最多只允许10个微信号参与<br/>		04.一个IP每天最多只允许50个投票<br/>		05.本次活动仅限**地区参与<br/>		06.报名提交的照片必须拥有所有权或经由所有权人授权，对因照片产生的纠纷由参赛者本人承担。<br/>		07.同一张照片中，不可以出现两个或者两个以上的参赛选手，如遇到两个人或多人在同一张照片中，将视为一人参赛，按1个名额颁发奖品。 <br/>		<br/>		<p>违反规则的投票，主办方有权封ip 剔除非正常数据 取消选手资格等。</p>		<p>本次活动所有解释权归主办方所有</p>';
		$l11lll1l11l11111l1l1l11l1111l11 = '本次活动由***公司主办，**公司赞助';
		$lll11l111l1ll1lll111l11ll1l1lll = '<p style="text-align: center;">    不管你是宅男、屌丝男、还是貌若潘安的美男子</p><p style="text-align: center;">    不管你是御姐、腐女、萝莉女、还是傲娇的女王</p><p style="text-align: center;">    自己只能刷微信微博看靓照？对这些统统说no！</p><p style="text-align: center;">    只要你有勇气晒出自己的照片并邀请好友来投票，就有机会赢得现金大奖！</p><p style="text-align: center;">    我有我风采，为什么不秀出来！</p><p style="text-align: center;">    晒出手机自拍照，</p><p style="text-align: center;">    用自己的气场HOLD住微信圈，</p><p style="text-align: center;">    让个人的魅力无限扩散！</p><p><br/></p>';
		empty($l11lll1l1llll11lll1l1l1111l111l['bodycolor']) && ($l11lll1l1llll11lll1l1l1111l111l['bodycolor'] = '#6e6e6f');
		empty($l11lll1l1llll11lll1l1l1111l111l['boxcolor']) && ($l11lll1l1llll11lll1l1l1111l111l['boxcolor'] = '#e44f4f');
		empty($l11lll1l1llll11lll1l1l1111l111l['titlecolor']) && ($l11lll1l1llll11lll1l1l1111l111l['titlecolor'] = '#544a4f');
		empty($l11lll1l1llll11lll1l1l1111l111l['textcolor']) && ($l11lll1l1llll11lll1l1l1111l111l['textcolor'] = '#e6d8a1');
		empty($l11lll1l1llll11lll1l1l1111l111l['bottomcolor']) && ($l11lll1l1llll11lll1l1l1111l111l['bottomcolor'] = '#3a3a3a');
		empty($l11lll1l1llll11lll1l1l1111l111l['buttoncolor']) && ($l11lll1l1llll11lll1l1l1111l111l['buttoncolor'] = '#dea543');
		empty($l11llll1l1l111ll11ll1l1ll1lllll['rules']) && ($l11llll1l1l111ll11ll1l1ll1lllll['rules'] = $lll11ll1111l111111lll1l111ll11l);
		empty($l11llll1l1l111ll11ll1l1ll1lllll['detail']) && ($l11llll1l1l111ll11ll1l1ll1lllll['detail'] = $l11lll1l11l11111l1l1l11l1111l11);
		empty($ll1ll1lll1ll11ll1ll1l1l1l111111['bottom']) && ($ll1ll1lll1ll11ll1ll1l1l1l111111['bottom'] = $lll11l111l1ll1lll111l11ll1l1lll);
		empty($l11lll1l1llll11lll1l1l1111l111l['double']) && ($l11lll1l1llll11lll1l1l1111l111l['double'] = 1);
		isset($l11lll1l1llll11lll1l1l1111l111l['prize']) or $l11lll1l1llll11lll1l1l1111l111l['prize'] = array();
		$l11lll1l1llll11lll1l1l1111l111l['prize'] = array_pad($l11lll1l1llll11lll1l1l1111l111l['prize'], 10, array('attr' => 0));
		if (count($l11lll1l1llll11lll1l1l1111l111l['prize']) >= 1) {
			foreach ($l11lll1l1llll11lll1l1l1111l111l['prize'] as &$ll1lll11llll11lllllll11ll1l11l1) {
				$ll1lll11llll11lllllll11ll1l11l1['total'] = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xiaof_toupiao_draw') . " WHERE `sid`='" . $l11lll1l1llll11lll1l1l1111l111l['id'] . "' AND `attr`='" . $ll1lll11llll11lllllll11ll1l11l1['attr'] . "' AND `name`='" . $ll1lll11llll11lllllll11ll1l11l1['name'] . "'");
			}
		}
		empty($l11lll1l1llll11lll1l1l1111l111l['accountqrcode']) && ($l11lll1l1llll11lll1l1l1111l111l['accountqrcode'] = $_W['account']['qrcode']);
		is_array($l11lll1l1llll11lll1l1l1111l111l['thumb']) or $l11lll1l1llll11lll1l1l1111l111l['thumb'] = array(0 => $l11lll1l1llll11lll1l1l1111l111l['thumb']);
		is_array($l11lll1l1llll11lll1l1l1111l111l['advotepic']) or $l11lll1l1llll11lll1l1l1111l111l['advotepic'] = array(0 => $l11lll1l1llll11lll1l1l1111l111l['advotepic']);
		if (!empty($l11lll1l1llll11lll1l1l1111l111l['city'])) {
			is_array($l11lll1l1llll11lll1l1l1111l111l['city']) or $l11lll1l1llll11lll1l1l1111l111l['city'] = array(0 => $l11lll1l1llll11lll1l1l1111l111l['city']);
		}
		$lll11l11llll11l111111111111llll = array();
		$lll11l11llll11l111111111111llll[] = array('sort' => '1', 'name' => '首页', 'url' => $_W['siteroot'] . 'app/index.php?c=entry&do=index&m=xiaof_toupiao&i={i}&sid={sid}&wxref=mp.weixin.qq.com#wechat_redirect', 'icon' => 'fa fa-home', 'isshow' => '1');
		$lll11l11llll11l111111111111llll[] = array('sort' => '2', 'name' => '抽奖', 'url' => $_W['siteroot'] . 'app/index.php?c=entry&do=creditdraw&m=xiaof_toupiao&i={i}&sid={sid}&wxref=mp.weixin.qq.com#wechat_redirect', 'icon' => 'fa fa-archive', 'isshow' => '1');
		$lll11l11llll11l111111111111llll[] = array('sort' => '3', 'name' => '报名', 'url' => $_W['siteroot'] . 'app/index.php?c=entry&do=join&m=xiaof_toupiao&i={i}&sid={sid}&wxref=mp.weixin.qq.com#wechat_redirect', 'icon' => 'fa fa-edit', 'isshow' => '1');
		$lll11l11llll11l111111111111llll[] = array('sort' => '4', 'name' => '活动详情', 'url' => $_W['siteroot'] . 'app/index.php?c=entry&do=detail&m=xiaof_toupiao&i={i}&sid={sid}&wxref=mp.weixin.qq.com#wechat_redirect', 'icon' => 'fa fa-gift', 'isshow' => '1');
		$lll11l11llll11l111111111111llll[] = array('sort' => '5', 'name' => '排行', 'url' => $_W['siteroot'] . 'app/index.php?c=entry&do=top&m=xiaof_toupiao&i={i}&sid={sid}&wxref=mp.weixin.qq.com#wechat_redirect', 'icon' => 'fa fa-bar-chart-o', 'isshow' => '0');
		$lll11l11llll11l111111111111llll[] = array('sort' => '6', 'name' => '最新', 'url' => $_W['siteroot'] . 'app/index.php?c=entry&do=index&type=new&m=xiaof_toupiao&i={i}&sid={sid}&wxref=mp.weixin.qq.com#wechat_redirect', 'icon' => 'fa fa-bar-chart-o', 'isshow' => '0');
		$lll11l11llll11l111111111111llll[] = array('sort' => '7', 'name' => '我的报名', 'url' => $_W['siteroot'] . 'app/index.php?c=entry&do=show&m=xiaof_toupiao&i={i}&sid={sid}&wxref=mp.weixin.qq.com#wechat_redirect', 'icon' => 'fa fa-user', 'isshow' => '0');
		empty($l11lll1l1llll11lll1l1l1111l111l['menu']) && ($l11lll1l1llll11lll1l1l1111l111l['menu'] = $lll11l11llll11l111111111111llll);
		if (checksubmit()) {
			if ($_W['isfounder']) {
				$l1ll1lllll1lll111111111ll1l1111['copyright'] = $_GPC['copyright'];
			} else {
				$l1ll1lllll1lll111111111ll1l1111['copyright'] = $l11lll1l1llll11lll1l1l1111l111l['copyright'];
			}
			$l1ll1lllll1lll111111111ll1l1111['openmsgvote'] = $_GPC['openmsgvote'];
			$l1ll1lllll1lll111111111ll1l1111['title'] = $_GPC['title'];
			$l1ll1lllll1lll111111111ll1l1111['describe'] = $_GPC['describe'];
			$l1ll1lllll1lll111111111ll1l1111['joinstart'] = $_GPC['jointimes']['start'];
			$l1ll1lllll1lll111111111ll1l1111['joinend'] = $_GPC['jointimes']['end'];
			$l1ll1lllll1lll111111111ll1l1111['start'] = $_GPC['times']['start'];
			$l1ll1lllll1lll111111111ll1l1111['end'] = $_GPC['times']['end'];
			$l1ll1lllll1lll111111111ll1l1111['doublestart'] = $_GPC['doubletimes']['start'];
			$l1ll1lllll1lll111111111ll1l1111['doubleend'] = $_GPC['doubletimes']['end'];
			$l1ll1lllll1lll111111111ll1l1111['double'] = $_GPC['double'];
			$l1ll1lllll1lll111111111ll1l1111['newjoindouble'] = intval($_GPC['newjoindouble']);
			$l1ll1lllll1lll111111111ll1l1111['maxgoodtime'] = $_GPC['maxgoodtime'];
			$l1ll1lllll1lll111111111ll1l1111['maxgoodnum'] = $_GPC['maxgoodnum'];
			$l1ll1lllll1lll111111111ll1l1111['verify'] = $_GPC['verify'];
			$l1ll1lllll1lll111111111ll1l1111['checkua'] = $_GPC['checkua'];
			$l1ll1lllll1lll111111111ll1l1111['openpopularity'] = $_GPC['openpopularity'];
			$l1ll1lllll1lll111111111ll1l1111['openvoteuser'] = $_GPC['openvoteuser'];
			$l1ll1lllll1lll111111111ll1l1111['indexloadnum'] = $_GPC['indexloadnum'];
			$l1ll1lllll1lll111111111ll1l1111['joinendtime'] = intval($_GPC['joinendtime']);
			$l1ll1lllll1lll111111111ll1l1111['adminopenid'] = $_GPC['adminopenid'];
			$l1ll1lllll1lll111111111ll1l1111['statisticcode'] = $_GPC['statisticcode'];
			$l1ll1lllll1lll111111111ll1l1111['binddomain'] = trim($_GPC['binddomain']);
			$l1ll1lllll1lll111111111ll1l1111['showshare'] = $_GPC['showshare'];
			$l1ll1lllll1lll111111111ll1l1111['followjointext'] = $_GPC['followjointext'];
			$l1ll1lllll1lll111111111ll1l1111['followvotetext'] = $_GPC['followvotetext'];
			$l1ll1lllll1lll111111111ll1l1111['followdrawtext'] = $_GPC['followdrawtext'];
			$l1ll1lllll1lll111111111ll1l1111['noticetitle'] = $_GPC['noticetitle'];
			$l1ll1lllll1lll111111111ll1l1111['openvirtualclick'] = $_GPC['openvirtualclick'];
			$l1ll1lllll1lll111111111ll1l1111['showtimeline'] = $_GPC['showtimeline'];
			$l1ll1lllll1lll111111111ll1l1111['opengroups'] = $_GPC['opengroups'];
			$l1ll1lllll1lll111111111ll1l1111['limitpic'] = intval($_GPC['limitpic']);
			$l1ll1lllll1lll111111111ll1l1111['veriftype'] = empty($_GPC['veriftype']) ? array() : $_GPC['veriftype'];
			$l1ll1lllll1lll111111111ll1l1111['verifysms'] = $_GPC['verifysms'];
			$l1ll1lllll1lll111111111ll1l1111['votejump'] = $_GPC['votejump'];
			$l1ll1lllll1lll111111111ll1l1111['minutenum'] = $_GPC['minutenum'];
			$l1ll1lllll1lll111111111ll1l1111['hournum'] = $_GPC['hournum'];
			$l1ll1lllll1lll111111111ll1l1111['daynum'] = $_GPC['daynum'];
			$l1ll1lllll1lll111111111ll1l1111['releasetime'] = $_GPC['releasetime'];
			$l1ll1lllll1lll111111111ll1l1111['ipmaxvote'] = $_GPC['ipmaxvote'];
			$l1ll1lllll1lll111111111ll1l1111['vnum'] = $_GPC['vnum'];
			$l1ll1lllll1lll111111111ll1l1111['citylevel'] = $_GPC['citylevel'];
			$l1ll1lllll1lll111111111ll1l1111['city'] = array_unique($_GPC['city']);
			$l1ll1lllll1lll111111111ll1l1111['openwapjoin'] = $_GPC['openwapjoin'];
			$l1ll1lllll1lll111111111ll1l1111['votefollow'] = $_GPC['votefollow'];
			$l1ll1lllll1lll111111111ll1l1111['joinfollow'] = $_GPC['joinfollow'];
			$l1ll1lllll1lll111111111ll1l1111['accountqrcode'] = $_GPC['accountqrcode'];
			$l1ll1lllll1lll111111111ll1l1111['advotetype'] = $_GPC['advotetype'];
			$l1ll1lllll1lll111111111ll1l1111['advotepic'] = $_GPC['advotepic'];
			$l1ll1lllll1lll111111111ll1l1111['advotelink'] = $_GPC['advotelink'];
			$l1ll1lllll1lll111111111ll1l1111['limitone'] = $_GPC['limitone'];
			$l1ll1lllll1lll111111111ll1l1111['maxvotenum'] = $_GPC['maxvotenum'];
			$l1ll1lllll1lll111111111ll1l1111['limitonevote'] = $_GPC['limitonevote'];
			$l1ll1lllll1lll111111111ll1l1111['followsetting'] = $_GPC['followsetting'];
			$l1ll1lllll1lll111111111ll1l1111['followmode'] = $_GPC['followmode'];
			$l1ll1lllll1lll111111111ll1l1111['joinjumplink'] = $_GPC['joinjumplink'];
			$l1ll1lllll1lll111111111ll1l1111['watermark'] = $_GPC['watermark'];
			$l1ll1lllll1lll111111111ll1l1111['audio'] = $_GPC['audio'];
			$l1ll1lllll1lll111111111ll1l1111['thumb'] = $_GPC['thumb'];
			$l1ll1lllll1lll111111111ll1l1111['thumblink'] = $_GPC['thumblink'];
			$l1ll1lllll1lll111111111ll1l1111['template'] = $_GPC['template'];
			$l1ll1lllll1lll111111111ll1l1111['bodycolor'] = $_GPC['bodycolor'];
			$l1ll1lllll1lll111111111ll1l1111['boxcolor'] = $_GPC['boxcolor'];
			$l1ll1lllll1lll111111111ll1l1111['bottomcolor'] = $_GPC['bottomcolor'];
			$l1ll1lllll1lll111111111ll1l1111['buttoncolor'] = $_GPC['buttoncolor'];
			$l1ll1lllll1lll111111111ll1l1111['titlecolor'] = $_GPC['titlecolor'];
			$l1ll1lllll1lll111111111ll1l1111['textcolor'] = $_GPC['textcolor'];
			$l1ll1lllll1lll111111111ll1l1111['replythumb'] = $_GPC['replythumb'];
			$l1ll1lllll1lll111111111ll1l1111['replytitle'] = $_GPC['replytitle'];
			$l1ll1lllll1lll111111111ll1l1111['replycontent'] = $_GPC['replycontent'];
			$l1ll1lllll1lll111111111ll1l1111['sharethumb'] = $_GPC['sharethumb'];
			$l1ll1lllll1lll111111111ll1l1111['sharetitle'] = preg_replace("#\s#is", '', $_GPC['sharetitle']);
			$l1ll1lllll1lll111111111ll1l1111['sharecontent'] = preg_replace("#\s#is", '', $_GPC['sharecontent']);
			$l1ll1lllll1lll111111111ll1l1111['mysharetitle'] = $_GPC['mysharetitle'];
			$l1ll1lllll1lll111111111ll1l1111['opencredit'] = $_GPC['opencredit'];
			$l1ll1lllll1lll111111111ll1l1111['creditnotice'] = $_GPC['creditnotice'];
			$l1ll1lllll1lll111111111ll1l1111['dynamicnotice'] = $_GPC['dynamicnotice'];
			$l1ll1lllll1lll111111111ll1l1111['joincredit'] = $_GPC['joincredit'];
			$l1ll1lllll1lll111111111ll1l1111['verifynotice'] = $_GPC['verifynotice'];
			$l1ll1lllll1lll111111111ll1l1111['votecredit'] = $_GPC['votecredit'];
			$l1ll1lllll1lll111111111ll1l1111['followtipstype'] = $_GPC['followtipstype'];
			$l1ll1lllll1lll111111111ll1l1111['followvoice'] = $_GPC['followvoice'];
			$l1ll1lllll1lll111111111ll1l1111['opendraw'] = $_GPC['opendraw'];
			$l1ll1lllll1lll111111111ll1l1111['drawcredit'] = $_GPC['drawcredit'];
			$l1ll1lllll1lll111111111ll1l1111['drawlimit'] = $_GPC['drawlimit'];
			$l1ll1lllll1lll111111111ll1l1111['prize'] = $_GPC['prize'];
			$l1ll1lllll1lll111111111ll1l1111['openposter'] = $_GPC['openposter'];
			$l1ll1lllll1lll111111111ll1l1111['qrcodetype'] = $_GPC['qrcodetype'];
			$l1ll1lllll1lll111111111ll1l1111['posterbg'] = $_GPC['posterbg'];
			$l1ll1lllll1lll111111111ll1l1111['posterqrcode'] = $_GPC['posterqrcode'];
			$l1ll1lllll1lll111111111ll1l1111['opensound'] = $_GPC['opensound'];
			$l1ll1lllll1lll111111111ll1l1111['soundautopaly'] = $_GPC['soundautopaly'];
			$_GPC['joinfield']['sign'] = array_filter(array_unique($_GPC['joinfield']['sign']));
			foreach ($_GPC['joinfield']['sign'] as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
				$llllll1llll111lll1l111l11llllll = array();
				$llllll1llll111lll1l111l11llllll['sign'] = $l1ll1ll1l11ll11l111llll1l1111ll;
				$llllll1llll111lll1l111l11llllll['name'] = $_GPC['joinfield']['name'][$l1l1l11l11l11111l1l11lll11l1ll1];
				$llllll1llll111lll1l111l11llllll['isnull'] = $_GPC['joinfield']['isnull'][$l1l1l11l11l11111l1l11lll11l1ll1];
				$llllll1llll111lll1l111l11llllll['isshow'] = $_GPC['joinfield']['isshow'][$l1l1l11l11l11111l1l11lll11l1ll1];
				$l1ll1lllll1lll111111111ll1l1111['joinfield'][] = $llllll1llll111lll1l111l11llllll;
			}
			foreach ($_GPC['menu']['sort'] as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
				if ($l1ll1lllll1lll111111111ll1l1111['binddomain'] != $l11lll1l1llll11lll1l1l1111l111l['binddomain']) {
					if (empty($l1ll1lllll1lll111111111ll1l1111['binddomain'])) {
						$_GPC['menu']['url'][$l1l1l11l11l11111l1l11lll11l1ll1] = str_replace($l11lll1l1llll11lll1l1l1111l111l['binddomain'], $_W['siteroot'], $_GPC['menu']['url'][$l1l1l11l11l11111l1l11lll11l1ll1]);
					} else {
						if (empty($l11lll1l1llll11lll1l1l1111l111l['binddomain'])) {
							$_GPC['menu']['url'][$l1l1l11l11l11111l1l11lll11l1ll1] = str_replace($_W['siteroot'], $l1ll1lllll1lll111111111ll1l1111['binddomain'], $_GPC['menu']['url'][$l1l1l11l11l11111l1l11lll11l1ll1]);
						} else {
							$_GPC['menu']['url'][$l1l1l11l11l11111l1l11lll11l1ll1] = str_replace($l11lll1l1llll11lll1l1l1111l111l['binddomain'], $l1ll1lllll1lll111111111ll1l1111['binddomain'], $_GPC['menu']['url'][$l1l1l11l11l11111l1l11lll11l1ll1]);
						}
					}
				}
				$ll1lll1111l1lll11l1l111l1ll11l1 = array();
				$ll1lll1111l1lll11l1l111l1ll11l1['sort'] = $l1ll1ll1l11ll11l111llll1l1111ll;
				$ll1lll1111l1lll11l1l111l1ll11l1['name'] = $_GPC['menu']['name'][$l1l1l11l11l11111l1l11lll11l1ll1];
				$ll1lll1111l1lll11l1l111l1ll11l1['url'] = $_GPC['menu']['url'][$l1l1l11l11l11111l1l11lll11l1ll1];
				$ll1lll1111l1lll11l1l111l1ll11l1['icon'] = $_GPC['menu']['icon'][$l1l1l11l11l11111l1l11lll11l1ll1];
				$ll1lll1111l1lll11l1l111l1ll11l1['isshow'] = $_GPC['menu']['isshow'][$l1l1l11l11l11111l1l11lll11l1ll1];
				preg_match("#do=(.*)&#iUs", $ll1lll1111l1lll11l1l111l1ll11l1['url'], $l111ll111ll111lll11llll1lll1l11);
				isset($l111ll111ll111lll11llll1lll1l11[1]) && ($ll1lll1111l1lll11l1l111l1ll11l1['do'] = $l111ll111ll111lll11llll1lll1l11[1]);
				$l1ll1lllll1lll111111111ll1l1111['menu'][] = $ll1lll1111l1lll11l1l111l1ll11l1;
			}
			$ll1ll11llll1l11l11llll1ll11ll1l = iserializer($l1ll1lllll1lll111111111ll1l1111);
			$l11l1ll11ll111l1ll11l1ll1l1l1ll['detail'] = $_GPC['detail'];
			$l11l1ll11ll111l1ll11l1ll1l1l1ll['noticecontent'] = $_GPC['noticecontent'];
			$l11l1ll11ll111l1ll11l1ll1l1l1ll['rules'] = $_GPC['rules'];
			$lll1111111lll1l111l1l11l11ll1l1 = iserializer($l11l1ll11ll111l1ll11l1ll1l1l1ll);
			$l11l1llll1ll1l11l11111ll1111l1l = array();
			$ll111ll111ll11111l111l1lll1111l = 0;
			if (count($l11lll1l1llll11lll1l1l1111l111l['groups']) >= 1) {
				$ll111ll111ll11111l111l1lll1111l = max(array_keys($l11lll1l1llll11lll1l1l1111l111l['groups']));
			}
			$_GPC['groupname'] = array_filter(array_unique($_GPC['groupname']));
			foreach ($_GPC['groupname'] as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
				if (empty($_GPC['groupid'][$l1l1l11l11l11111l1l11lll11l1ll1])) {
					$ll111ll111ll11111l111l1lll1111l++;
					$l1ll1l111111l1l1111l1l1lll1ll1l = $ll111ll111ll11111l111l1lll1111l;
				} else {
					$l1ll1l111111l1l1111l1l1lll1ll1l = $_GPC['groupid'][$l1l1l11l11l11111l1l11lll11l1ll1];
				}
				$l11l1llll1ll1l11l11111ll1111l1l[$l1ll1l111111l1l1111l1l1lll1ll1l]['name'] = $l1ll1ll1l11ll11l111llll1l1111ll;
				$l11l1llll1ll1l11l11111ll1111l1l[$l1ll1l111111l1l1111l1l1lll1ll1l]['sort'] = $_GPC['groupsort'][$l1l1l11l11l11111l1l11lll11l1ll1];
			}
			$l11l1llll1ll1l11l11111ll1111l1l = iserializer($l11l1llll1ll1l11l11111ll1111l1l);
			if ($_GPC['id'] >= 1) {
				pdo_update("xiaof_toupiao_setting", array("tit" => $_GPC['title'], "data" => $ll1ll11llll1l11l11llll1ll11ll1l, "groups" => $l11l1llll1ll1l11l11111ll1111l1l, "unfollow" => intval($_GPC['unfollow']), "detail" => $lll1111111lll1l111l1l11l11ll1l1, "bottom" => $_GPC['bottom']), array("id" => intval($_GPC['id'])));
				if (intval($_GPC['clearposter']) == 1) {
					pdo_update("xiaof_toupiao", array("poster" => ''), array("sid" => intval($_GPC['id'])));
				}
			} else {
				pdo_insert("xiaof_toupiao_setting", array("uniacid" => $_W['uniacid'], "tit" => $_GPC['title'], "data" => $ll1ll11llll1l11l11llll1ll11ll1l, "groups" => $l11l1llll1ll1l11l11111ll1111l1l, "unfollow" => intval($_GPC['unfollow']), "detail" => $lll1111111lll1l111l1l11l11ll1l1, "bottom" => $_GPC['bottom'], "created_at" => time()));
				$lll1lll111l111l11l1l11111ll11l1 = pdo_insertid();
				message('活动添加成功', $this->createWebUrl('settingedit', array('sid' => $lll1lll111l111l11l1l11111ll11l1)), 'success');
			}
			message('配置参数更新成功！', referer(), 'success');
		}
		include $this->template("settingedit");
	}
	public function doWebBindacid()
	{
		global $_W, $_GPC;
		//$this->ll1111l1ll11l11l1lll11llll11ll1();
		$lll1lll111l111l11l1l11111ll11l1 = intval($_GPC['sid']);
		if (empty($lll1lll111l111l11l1l11111ll11l1)) {
			message('参数错误', referer(), 'error');
		}
		if (checksubmit() && isset($_GPC['bindings']['acid'])) {
			$l1111ll1lll1111l11l1lll111l1lll = array();
			$l111llll111l1l11l11111l111111l1 = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_acid') . " WHERE `sid` = :sid", array(":sid" => $lll1lll111l111l11l1l11111ll11l1));
			foreach ($l111llll111l1l11l11111l111111l1 as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
				$l1111ll1lll1111l11l1lll111l1lll[] = $l1ll1ll1l11ll11l111llll1l1111ll['acid'];
			}
			$l1111ll11111l1l111l1lll11111lll = array_unique($_GPC['bindings']['acid']);
			$l111ll1lll11111ll11lll11111ll1l = array_diff($l1111ll1lll1111l11l1lll111l1lll, $l1111ll11111l1l111l1lll11111lll);
			if (count($l111ll1lll11111ll11lll11111ll1l) >= 1) {
				pdo_query("DELETE FROM " . tablename('xiaof_toupiao_acid') . " WHERE `sid` = '" . $lll1lll111l111l11l1l11111ll11l1 . "' AND `acid` IN ('" . implode("','", $l111ll1lll11111ll11lll11111ll1l) . "')");
			}
			foreach ($l1111ll11111l1l111l1lll11111lll as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
				if ($l11lll1l1llll11lll1l1l1111l111l = pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao_acid") . " WHERE `sid` = :sid AND `acid` = :acid", array(":sid" => $lll1lll111l111l11l1l11111ll11l1, ":acid" => intval($l1ll1ll1l11ll11l111llll1l1111ll)))) {
					pdo_update("xiaof_toupiao_acid", array("qrcode" => $_GPC['bindings']['qrcode'][$l1l1l11l11l11111l1l11lll11l1ll1]), array("id" => $l11lll1l1llll11lll1l1l1111l111l['id']));
				} else {
					pdo_insert("xiaof_toupiao_acid", array("sid" => $lll1lll111l111l11l1l11111ll11l1, "acid" => intval($l1ll1ll1l11ll11l111llll1l1111ll), "qrcode" => $_GPC['bindings']['qrcode'][$l1l1l11l11l11111l1l11lll11l1ll1]));
				}
			}
		}
		$l111llll111l1l11l11111l111111l1 = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_acid') . " WHERE `sid` = :sid", array(":sid" => $lll1lll111l111l11l1l11111ll11l1));
		load()->model('account');
		$l1l1111l111l1lll1l1ll111l111111 = uni_owned();
		include $this->template("bindacid");
	}
	public function doWebLists()
	{
		global $_W, $_GPC;
		//$this->ll1111l1ll11l11l1lll11llll11ll1();
		if (!empty($_GPC['verifys'])) {
			if (empty($_GPC['pid'])) {
				die('参数错误');
			}
			$ll1ll11llll1l11l11llll1ll11ll1l = array("verify" => intval($_GPC['verifys']));
			$l1l1ll1l11l1l1lll1l1l1l11l11111 = pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao") . " WHERE `id` = :id", array(":id" => intval($_GET['pid'])));
			if ($lll11ll1l1l111111lll111111l1l1l = pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao_setting") . " WHERE `id` = :id", array(":id" => $l1l1ll1l11l1l1lll1l1l1l11l11111['sid']))) {
				$l1lll1lllll1l1111l1l11llllll111 = iunserializer($lll11ll1l1l111111lll111111l1l1l['data']);
				if (intval($l1lll1lllll1l1111l1l11llllll111['verifynotice']) >= 1) {
					$ll111111l1ll111l1ll111ll1111111 = pdo_fetch("SELECT * FROM " . tablename("xiaof_relation") . " WHERE `openid` = :openid limit 1", array(":openid" => $l1l1ll1l11l1l1lll1l1l1l11l11111['openid']));
					isset($_SESSION) or session_start();
					$_SESSION['sid'] = $lll11ll1l1l111111lll111111l1l1l['id'];
					empty($l1lll1lllll1l1111l1l11llllll111['binddomain']) or $_W['siteroot'] = $l1lll1lllll1l1111l1l11llllll111['binddomain'];
					if ($_GPC['verifys'] == 1) {
						$this->ll11l1l111ll11l11llll111l1l1ll1($l1l1ll1l11l1l1lll1l1l1l11l11111['openid'], "您参与报名的" . $lll11ll1l1l111111lll111111l1l1l['tit'] . "活动，资料审核已经通过。<a href='" . $this->ll11ll1l1l11l11ll11llll1l1ll11l('show', 'xiaof_toupiao', '&id=' . $l1l1ll1l11l1l1lll1l1l1l11l11111['id']) . "'>点击查看</a>", $ll111111l1ll111l1ll111ll1111111['uniacid']);
					} else {
						if ($_GPC['verifys'] == 2) {
							$this->ll11l1l111ll11l11llll111l1l1ll1($l1l1ll1l11l1l1lll1l1l1l11l11111['openid'], "您参与报名的" . $lll11ll1l1l111111lll111111l1l1l['tit'] . "活动，资料审核未通过。<a href='" . $this->ll11ll1l1l11l11ll11llll1l1ll11l('show', 'xiaof_toupiao', '&id=' . $l1l1ll1l11l1l1lll1l1l1l11l11111['id']) . "'>点击查看</a>", $ll111111l1ll111l1ll111ll1111111['uniacid']);
						}
					}
				}
			}
			pdo_update("xiaof_toupiao", $ll1ll11llll1l11l11llll1ll11ll1l, array("id" => intval($_GPC['pid'])));
		}
		if (!empty($_GPC['lockings'])) {
			pdo_update("xiaof_toupiao", array('locking' => '0', 'locking_at' => '0'), array("id" => intval($_GPC['pid'])));
		}
		if (!empty($_GPC['del'])) {
			$l1l11lll1l1llll1ll1ll111ll1l111 = array();
			foreach ($_GPC['delete'] as $l1ll1ll1l11ll11l111llll1l1111ll) {
				$l1l11lll1l1llll1ll1ll111ll1l111[] = intval($l1ll1ll1l11ll11l111llll1l1111ll);
				pdo_query("DELETE FROM " . tablename('xiaof_toupiao_pic') . " WHERE `pid` = '" . $l1ll1ll1l11ll11l111llll1l1111ll . "'");
				pdo_query("DELETE FROM " . tablename('xiaof_toupiao_log') . " WHERE `pid` = '" . $l1ll1ll1l11ll11l111llll1l1111ll . "'");
			}
			pdo_query("DELETE FROM " . tablename('xiaof_toupiao') . " WHERE `id` IN ('" . implode("','", $l1l11lll1l1llll1ll1ll111ll1l111) . "')");
		}
		if (!empty($_GPC['pass'])) {
			$l1l11lll1l1llll1ll1ll111ll1l111 = array();
			foreach ($_GPC['delete'] as $l1ll1ll1l11ll11l111llll1l1111ll) {
				$l1l11lll1l1llll1ll1ll111ll1l111[] = intval($l1ll1ll1l11ll11l111llll1l1111ll);
			}
			pdo_query("UPDATE " . tablename('xiaof_toupiao') . " SET `verify` = '1' WHERE `id` IN ('" . implode("','", $l1l11lll1l1llll1ll1ll111ll1l111) . "')");
		}
		$l1111l11l1llll1l11l1lll11l11lll = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_setting') . " WHERE `uniacid` = :uniacid", array(":uniacid" => $_W['uniacid']));
		$l1lll1l1l11l11lllllll1lll11111l = '';
		if (!empty($_GPC['sid'])) {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l = ' WHERE `sid`=:sid';
			$l1l11l1llll1llllll11l1llll1ll1l[':sid'] = intval($_GPC['sid']);
			$l1lll1l1l11l11lllllll1lll11111l = $this->l1l11ll11ll1l1111lll11lllll1l11();
		} else {
			$ll1l1l111ll1l1111l11ll111l1111l = array();
			foreach ($l1111l11l1llll1l11l1lll11l11lll as $l1ll1ll1l11ll11l111llll1l1111ll) {
				$ll1l1l111ll1l1111l11ll111l1111l[] = intval($l1ll1ll1l11ll11l111llll1l1111ll['id']);
			}
			$l1l1l1l1l1ll1ll1ll11llll11ll11l = " WHERE `sid` in ('" . implode("','", $ll1l1l111ll1l1111l11ll111l1111l) . "')";
			$l1l11l1llll1llllll11l1llll1ll1l = array();
		}
		if (!empty($_GPC['groups'])) {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l .= ' AND `groups`=:groups';
			$l1l11l1llll1llllll11l1llll1ll1l[':groups'] = intval($_GPC['groups']);
		}
		if (!empty($_GPC['key'])) {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l .= ' AND (`uid`=:uid OR `name` like :name) ';
			$l1l11l1llll1llllll11l1llll1ll1l[':uid'] = intval($_GPC['key']);
			$l1l11l1llll1llllll11l1llll1ll1l[':name'] = "%" . $_GPC['key'] . "%";
			$l1l1ll111l11ll1llll111l11lllll1 = $_GPC['key'];
		}
		if (!empty($_GPC['verify']) && $_GPC['verify'] == 3) {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l .= ' AND `locking`=:locking';
			$l1l11l1llll1llllll11l1llll1ll1l[':locking'] = 1;
		} elseif (!empty($_GPC['verify']) or $_GPC['verify'] === '0') {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l .= ' AND `verify`=:verify';
			$l1l11l1llll1llllll11l1llll1ll1l[':verify'] = intval($_GPC['verify']);
		}
		if (empty($_GPC['order'])) {
			$l1l1lll1lll11l111ll111l1llll1ll = 'id';
		} else {
			$l1l1lll1lll11l111ll111l1llll1ll = 'good';
		}
		$ll1l1ll1l111lllll111111l111111l = max(1, intval($_GPC['page']));
		$lll1111llllll111l111lllll1l1l1l = 20;
		$ll1l1ll1111l11111l11111ll1ll11l = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xiaof_toupiao') . $l1l1l1l1l1ll1ll1ll11llll11ll11l, $l1l11l1llll1llllll11l1llll1ll1l);
		$l11111l11ll11llll111ll111l1ll11 = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao') . $l1l1l1l1l1ll1ll1ll11llll11ll11l . " ORDER BY `" . $l1l1lll1lll11l111ll111l1llll1ll . "` DESC LIMIT " . ($ll1l1ll1l111lllll111111l111111l - 1) * $lll1111llllll111l111lllll1l1l1l . ',' . $lll1111llllll111l111lllll1l1l1l, $l1l11l1llll1llllll11l1llll1ll1l);
		$ll11l1111l1llll1llll1l1l1l111l1 = pagination($ll1l1ll1111l11111l11111ll1ll11l, $ll1l1ll1l111lllll111111l111111l, $lll1111llllll111l111lllll1l1l1l);
		include $this->template("lists");
	}
	public function doWebLoadgroup()
	{
		global $_GPC;
		if (!isset($_GPC['sid'])) {
			die('缺少参数');
		}
		$l1lll1l1l11l11lllllll1lll11111l = $this->l1l11ll11ll1l1111lll11lllll1l11();
		$ll111l1l1l11l1ll111l1ll1l1l111l = $lll1ll1l1l1l1llll11l1lll11111l1 = '';
		foreach ($l1lll1l1l11l11lllllll1lll11111l['groups'] as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
			$lll1ll1l1l1l1llll11l1lll11111l1 .= '<option value="' . $l1l1l11l11l11111l1l11lll11l1ll1 . '">' . $l1ll1ll1l11ll11l111llll1l1111ll['name'] . '</option>';
		}
		foreach ($l1lll1l1l11l11lllllll1lll11111l['joinfield'] as $l11l1lll1111111ll1ll1111l11lll1) {
			$ll111l1l1l11l1ll111l1ll1l1l111l .= '<div class="form-group">
			                <label class="col-xs-12 col-sm-3 col-md-2 control-label" for="">' . $l11l1lll1111111ll1ll1111l11lll1['name'] . '</label>
			                <div class="col-sm-6"><input type="text" class="form-control" name="' . $l11l1lll1111111ll1ll1111l11lll1['sign'] . '" placeholder="' . $l11l1lll1111111ll1ll1111l11lll1['name'] . '" /></div>
			            </div>';
		}
		echo json_encode(array('groups' => $lll1ll1l1l1l1llll11l1lll11111l1, 'joinfield' => $ll111l1l1l11l1ll111l1ll1l1l111l));
	}
	public function doWebEdit()
	{
		global $_W, $_GPC;
		//$this->ll1111l1ll11l11l1lll11llll11ll1();
		load()->func('tpl');
		$l1111l11l1llll1l11l1lll11l11lll = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_setting') . " WHERE `uniacid` = :uniacid", array(":uniacid" => $_W['uniacid']));
		if (isset($_GET['pid'])) {
			$l11lll1l1llll11lll1l1l1111l111l = pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao") . " WHERE `id` = :id", array(":id" => intval($_GET['pid'])));
			$ll11l11l1111l1ll1llll11111l11ll = pdo_fetchall("SELECT `thumb` FROM " . tablename('xiaof_toupiao_pic') . " WHERE `pid` = :pid", array(":pid" => intval($_GET['pid'])));
			$_GPC['sid'] = $l11lll1l1llll11lll1l1l1111l111l['sid'];
			foreach ($ll11l11l1111l1ll1llll11111l11ll as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
				$lll1l1l111111ll11l1l1l11111l1ll[] = $l1ll1ll1l11ll11l111llll1l1111ll['thumb'];
			}
			$l11lll1l1llll11lll1l1l1111l111l['pics'] = $lll1l1l111111ll11l1l1l11111l1ll;
			$l11lll1l1llll11lll1l1l1111l111l['data'] = iunserializer($l11lll1l1llll11lll1l1l1111l111l['data']);
		}
		$l1lll1l1l11l11lllllll1lll11111l = $this->l1l11ll11ll1l1111lll11lllll1l11();
		if ($_W['ispost']) {
			load()->func('file');
			$ll11lll1ll1lll11l1l1l11ll1lll11 = array();
			if (is_array($l1lll1l1l11l11lllllll1lll11111l['joinfield'])) {
				foreach ($l1lll1l1l11l11lllllll1lll11111l['joinfield'] as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
					if (empty($_GPC[$l1ll1ll1l11ll11l111llll1l1111ll['sign']])) {
						if (empty($l1ll1ll1l11ll11l111llll1l1111ll['isnull'])) {
							message($l1ll1ll1l11ll11l111llll1l1111ll['name'] . '项不能为空', referer(), 'error');
						}
						continue;
					}
					$ll11lll1ll1lll11l1l1l11ll1lll11[$l1ll1ll1l11ll11l111llll1l1111ll['sign']] = $_GPC[$l1ll1ll1l11ll11l111llll1l1111ll['sign']];
				}
			}
			$ll1l111l11lll1ll111l1l1l1l11l11 = '';
			if (!empty($_GPC['sound'])) {
				$ll1lll11l1111l11lllllll1l1lll11 = $_GPC['sound'];
				if (strexists($ll1lll11l1111l11lllllll1l1lll11, 'http://') || strexists($ll1lll11l1111l11lllllll1l1lll11, 'https://') || !empty($_W['setting']['remote']['type'])) {
					$ll1l111l11lll1ll111l1l1l1l11l11 = $ll1lll11l1111l11lllllll1l1lll11;
				} else {
					$ll1l1l1llll11ll1ll1111l11ll1lll = $this->ll11ll1ll11l1l1l11l1l111l1l1lll($_GPC['sound']);
					if (is_error($ll1l1l1llll11ll1ll1111l11ll1lll)) {
						$ll1l111l11lll1ll111l1l1l1l11l11 = '';
					} else {
						$ll1l111l11lll1ll111l1l1l1l11l11 = $ll1l1l1llll11ll1ll1111l11ll1lll;
					}
				}
			}
			$l111l111llll1lll11111111lll1l11 = count($_GPC['pics']);
			$ll1lll1lllll1ll1ll11l11lllllll1 = empty($l1lll1l1l11l11lllllll1lll11111l['limitpic']) ? 5 : intval($l1lll1l1l11l11lllllll1lll11111l['limitpic']);
			if ($l111l111llll1lll11111111lll1l11 <= 0) {
				message('至少上传一张照片', referer(), 'error');
			} elseif ($l111l111llll1lll11111111lll1l11 > $ll1lll1lllll1ll1ll11l11lllllll1) {
				message('照片只允许1-' . $ll1lll1lllll1ll1ll11l11lllllll1 . '张', referer(), 'error');
			}
			if ($_GPC['id'] >= 1) {
				$l11ll111111l1ll111l1lll1l1l11ll = intval($_GPC['id']);
				$ll11lll111111lll1ll1ll1l111llll = $this->lllll1l1lll1l1l1111lll1l1ll11ll(reset($_GPC['pics']), 240);
				pdo_update("xiaof_toupiao", array("groups" => intval($_GPC['groups']), "pic" => $ll11lll111111lll1ll1ll1l111llll, "sound" => $ll1l111l11lll1ll111l1l1l1l11l11, "phone" => $_GPC['phone'], "name" => $_GPC['name'], "verify" => intval($_GPC['verify']), "describe" => preg_replace("#\s#is", '', $_GPC['describe']), "detail" => $_GPC['detail'], "data" => iserializer($ll11lll1ll1lll11l1l1l11ll1lll11)), array("id" => $l11ll111111l1ll111l1lll1l1l11ll));
				if ($_GPC['pics'] !== $l11lll1l1llll11lll1l1l1111l111l['pics']) {
					pdo_delete('xiaof_toupiao_pic', array('pid' => $l11ll111111l1ll111l1lll1l1l11ll));
					foreach ($_GPC['pics'] as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
						$l1l11l1ll1l11l1l111l111lll1ll11 = $this->lllll1l1lll1l1l1111lll1l1ll11ll($l1ll1ll1l11ll11l111llll1l1111ll);
						pdo_insert("xiaof_toupiao_pic", array("pid" => $l11ll111111l1ll111l1lll1l1l11ll, "url" => $l1ll1ll1l11ll11l111llll1l1111ll, "thumb" => $l1l11l1ll1l11l1l111l111lll1ll11, "created_at" => time()));
					}
				}
			} else {
				$lll1lll111l111l11l1l11111ll11l1 = intval($_GPC['sid']);
				if (pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao") . " WHERE `sid` = :sid AND `phone` = :phone", array(":sid" => $lll1lll111l111l11l1l11111ll11l1, ":phone" => $_GPC['phone']))) {
					message('该手机号已经参加本次活动', referer(), 'error');
				}
				$ll11lll111111lll1ll1ll1l111llll = $this->lllll1l1lll1l1l1111lll1l1ll11ll(reset($_GPC['pics']), 240);
				pdo_query("LOCK TABLES " . tablename("xiaof_toupiao") . " WRITE");
				if (!($l1l111l1l1l1l1l11l111lllllll1l1 = pdo_fetchcolumn("SELECT `uid` FROM " . tablename("xiaof_toupiao") . " WHERE `sid` = :sid ORDER BY `id` DESC limit 1", array(":sid" => $lll1lll111l111l11l1l11111ll11l1)))) {
					$l1l111l1l1l1l1l11l111lllllll1l1 = 0;
				}
				pdo_insert("xiaof_toupiao", array("sid" => $lll1lll111l111l11l1l11111ll11l1, "groups" => intval($_GPC['groups']), "uid" => $l1l111l1l1l1l1l11l111lllllll1l1 + 1, "openid" => 'mn-' . md5($lll1lll111l111l11l1l11111ll11l1 . $_GPC['phone']), "pic" => $ll11lll111111lll1ll1ll1l111llll, "sound" => $ll1l111l11lll1ll111l1l1l1l11l11, "phone" => $_GPC['phone'], "name" => $_GPC['name'], "verify" => intval($_GPC['verify']), "open" => intval($_GPC['open']), "describe" => preg_replace("#\s#is", '', $_GPC['describe']), "detail" => $_GPC['detail'], "data" => iserializer($ll11lll1ll1lll11l1l1l11ll1lll11), "created_at" => time(), "updated_at" => time()));
				$l11ll111111l1ll111l1lll1l1l11ll = pdo_insertid();
				pdo_query("UNLOCK TABLES");
				foreach ($_GPC['pics'] as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
					$l1l11l1ll1l11l1l111l111lll1ll11 = $this->lllll1l1lll1l1l1111lll1l1ll11ll($l1ll1ll1l11ll11l111llll1l1111ll);
					pdo_insert("xiaof_toupiao_pic", array("sid" => $lll1lll111l111l11l1l11111ll11l1, "pid" => $l11ll111111l1ll111l1lll1l1l11ll, "thumb" => $l1l11l1ll1l11l1l111l111lll1ll11, "url" => $l1ll1ll1l11ll11l111llll1l1111ll, "created_at" => time()));
				}
			}
			$l1l1l1l1l1ll1ll1ll11llll11ll11l = "";
			if (intval($_GPC['goodvalue']) >= 1) {
				if ($_GPC['goodalgorithm'] == '+') {
					$l1l1l1l1l1ll1ll1ll11llll11ll11l = "`good` = good+" . intval($_GPC['goodvalue']);
				} elseif ($_GPC['goodalgorithm'] == '-') {
					$l1l1l1l1l1ll1ll1ll11llll11ll11l = "`good` = good-" . intval($_GPC['goodvalue']);
				}
			}
			if (intval($_GPC['sharevalue']) >= 1) {
				if ($_GPC['sharealgorithm'] == '+') {
					$l1l1l1l1l1ll1ll1ll11llll11ll11l != "" && ($l1l1l1l1l1ll1ll1ll11llll11ll11l .= " , ");
					$l1l1l1l1l1ll1ll1ll11llll11ll11l .= "`share` = share+" . intval($_GPC['sharevalue']);
				} elseif ($_GPC['sharealgorithm'] == '-') {
					$l1l1l1l1l1ll1ll1ll11llll11ll11l != "" && ($l1l1l1l1l1ll1ll1ll11llll11ll11l .= " , ");
					$l1l1l1l1l1ll1ll1ll11llll11ll11l .= "`share` = share-" . intval($_GPC['sharevalue']);
				}
			}
			if (intval($_GPC['clickvalue']) >= 1) {
				if ($_GPC['clickalgorithm'] == '+') {
					$l1l1l1l1l1ll1ll1ll11llll11ll11l != "" && ($l1l1l1l1l1ll1ll1ll11llll11ll11l .= " , ");
					$l1l1l1l1l1ll1ll1ll11llll11ll11l .= "`click` = click+" . intval($_GPC['clickvalue']);
				} elseif ($_GPC['clickalgorithm'] == '-') {
					$l1l1l1l1l1ll1ll1ll11llll11ll11l != "" && ($l1l1l1l1l1ll1ll1ll11llll11ll11l .= " , ");
					$l1l1l1l1l1ll1ll1ll11llll11ll11l .= "`click` = click-" . intval($_GPC['clickvalue']);
				}
			}
			if ($l1l1l1l1l1ll1ll1ll11llll11ll11l != "") {
				pdo_query("UPDATE " . tablename("xiaof_toupiao") . " SET " . $l1l1l1l1l1ll1ll1ll11llll11ll11l . " WHERE `id` = '" . $l11ll111111l1ll111l1lll1l1l11ll . "'");
			}
			if (intval($l1lll1l1l11l11lllllll1lll11111l['openposter']) == 1 && ($ll1l1ll1ll111lllll11l111l1l11ll = pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao") . " WHERE `id` = :id LIMIT 1", array(":id" => intval($l11ll111111l1ll111l1lll1l1l11ll))))) {
				$l111l11111l11lll1lllll1l1ll1ll1 = $this->l1ll11l1l11111lll1l11111l111l1l($ll1l1ll1ll111lllll11l111l1l11ll['name'], $ll1l1ll1ll111lllll11l111l1l11ll['uid'], tomedia(reset($_GPC['pics'])), urlencode($this->ll11ll1l1l11l11ll11llll1l1ll11l('show', 'xiaof_toupiao', '&id=' . $ll1l1ll1ll111lllll11l111l1l11ll['id'] . '')));
				pdo_update("xiaof_toupiao", array("poster" => $l111l11111l11lll1lllll1l1ll1ll1), array("id" => $ll1l1ll1ll111lllll11l111l1l11ll['id']));
			}
			message('信息编辑成功', referer(), 'success');
		}
		include $this->template("edit");
	}
	public function doWebVotelog()
	{
		global $_W, $_GPC;
		//$this->ll1111l1ll11l11l1lll11llll11ll1();
		$l1111l11l1llll1l11l1lll11l11lll = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_setting') . " WHERE `uniacid` = :uniacid", array(":uniacid" => $_W['uniacid']));
		$ll1l1ll1l111lllll111111l111111l = max(1, intval($_GPC['page']));
		$lll1111llllll111l111lllll1l1l1l = 10;
		$l1l11l1llll1llllll11l1llll1ll1l = array();
		if (!empty($_GPC['sid'])) {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l = ' WHERE `sid`=:sid ';
			$l1l11l1llll1llllll11l1llll1ll1l[':sid'] = intval($_GPC['sid']);
		} else {
			$ll1l1l111ll1l1111l11ll111l1111l = array();
			foreach ($l1111l11l1llll1l11l1lll11l11lll as $l1ll1ll1l11ll11l111llll1l1111ll) {
				$ll1l1l111ll1l1111l11ll111l1111l[] = intval($l1ll1ll1l11ll11l111llll1l1111ll['id']);
			}
			$l1l1l1l1l1ll1ll1ll11llll11ll11l = " WHERE `sid` in ('" . implode("','", $ll1l1l111ll1l1111l11ll111l1111l) . "')";
		}
		if (!empty($_GPC['uid'])) {
			if ($l1l1ll11l1l1ll111ll1l111111l1ll = pdo_fetchall("SELECT * FROM " . tablename("xiaof_toupiao") . $l1l1l1l1l1ll1ll1ll11llll11ll11l . " AND `uid` = '" . intval($_GPC['uid']) . "'", $l1l11l1llll1llllll11l1llll1ll1l)) {
				$l11l1l1l1l1l111ll1l1l11ll1l1111 = array();
				foreach ($l1l1ll11l1l1ll111ll1l111111l1ll as $l1ll1ll1l11ll11l111llll1l1111ll) {
					$l11l1l1l1l1l111ll1l1l11ll1l1111[] = $l1ll1ll1l11ll11l111llll1l1111ll['id'];
				}
				$l1l1l1l1l1ll1ll1ll11llll11ll11l = " WHERE `pid` in ('" . implode("','", $l11l1l1l1l1l111ll1l1l11ll1l1111) . "')";
			}
		} elseif (!empty($_GPC['pid'])) {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l .= ' AND `pid`=:pid ';
			$l1l11l1llll1llllll11l1llll1ll1l[':pid'] = intval($_GPC['pid']);
		} elseif (!empty($_GPC['ip'])) {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l .= ' AND `ip`=:ip ';
			$l1l11l1llll1llllll11l1llll1ll1l[':ip'] = $_GPC['ip'];
		}
		if (!empty($_GPC['vopenid'])) {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l .= ' AND `openid`=:openid ';
			$l1l11l1llll1llllll11l1llll1ll1l[':openid'] = $_GPC['vopenid'];
		}
		if (!empty($_GPC['valid']) or $_GPC['valid'] == '0') {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l .= ' AND `valid`=:valid ';
			$l1l11l1llll1llllll11l1llll1ll1l[':valid'] = $_GPC['valid'];
		}
		$ll1l1ll1111l11111l11111ll1ll11l = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xiaof_toupiao_log') . $l1l1l1l1l1ll1ll1ll11llll11ll11l . "", $l1l11l1llll1llllll11l1llll1ll1l);
		$llll1l11ll1l1lll1l1l1llll1ll111 = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_log') . $l1l1l1l1l1ll1ll1ll11llll11ll11l . " order by `created_at` desc LIMIT " . ($ll1l1ll1l111lllll111111l111111l - 1) * $lll1111llllll111l111lllll1l1l1l . ',' . $lll1111llllll111l111lllll1l1l1l, $l1l11l1llll1llllll11l1llll1ll1l);
		$l11111l11ll11llll111ll111l1ll11 = array();
		foreach ($llll1l11ll1l1lll1l1l1llll1ll111 as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
			$l11lll1l1llll11lll1l1l1111l111l = pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao") . " WHERE `id` = :id", array(":id" => $l1ll1ll1l11ll11l111llll1l1111ll['pid']));
			if (empty($l1ll1ll1l11ll11l111llll1l1111ll['nickname'])) {
				if (!empty($l1ll1ll1l11ll11l111llll1l1111ll['fanid'])) {
					if ($l1l11l11ll11l1l1111l1ll11ll1ll1 = pdo_fetch("SELECT * FROM " . tablename("mc_mapping_fans") . " WHERE `fanid` = :fanid limit 1", array(":fanid" => $l1ll1ll1l11ll11l111llll1l1111ll['fanid']))) {
						$l11lll1l1llll11lll1l1l1111l111l['nickname'] = $l1l11l11ll11l1l1111l1ll11ll1ll1['nickname'];
					}
				} else {
					if ($l1l11l11ll11l1l1111l1ll11ll1ll1 = pdo_fetch("SELECT * FROM " . tablename("mc_mapping_fans") . " WHERE `openid` = :openid limit 1", array(":openid" => $l1ll1ll1l11ll11l111llll1l1111ll['openid']))) {
						$l11lll1l1llll11lll1l1l1111l111l['nickname'] = $l1l11l11ll11l1l1111l1ll11ll1ll1['nickname'];
					}
				}
			}
			$l11lll1l1llll11lll1l1l1111l111l['ocount'] = pdo_fetchcolumn("SELECT COUNT(1) FROM (SELECT COUNT(*) FROM " . tablename('xiaof_toupiao_log') . " where `sid` = '" . $l1ll1ll1l11ll11l111llll1l1111ll['sid'] . "' AND `ip` = '" . $l1ll1ll1l11ll11l111llll1l1111ll['ip'] . "'  group by `openid`) T");
			$l11lll1l1llll11lll1l1l1111l111l['count'] = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xiaof_toupiao_log') . " where `sid` = '" . $l1ll1ll1l11ll11l111llll1l1111ll['sid'] . "' AND `ip` = '" . $l1ll1ll1l11ll11l111llll1l1111ll['ip'] . "'");
			$l11lll1l1llll11lll1l1l1111l111l['hide'] = 0;
			if ($l111ll111l1lll1lll1lll11ll11lll = pdo_fetch("SELECT `id` FROM " . tablename("xiaof_toupiao_safe") . " WHERE `sid` = '" . $l1ll1ll1l11ll11l111llll1l1111ll['sid'] . "' AND `ip` = :ip ", array(":ip" => $l1ll1ll1l11ll11l111llll1l1111ll['ip']))) {
				$l11lll1l1llll11lll1l1l1111l111l['hide'] = 1;
				$l11lll1l1llll11lll1l1l1111l111l['safeid'] = $l111ll111l1lll1lll1lll11ll11lll['id'];
			}
			if (!($l1l1ll11lll11l1ll111l1lll1l1l11 = cache_read('iplongregion:' . md5($l1ll1ll1l11ll11l111llll1l1111ll['ip'])))) {
				$lll11ll11ll1l11l111ll11l111ll11 = file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=" . long2ip($l1ll1ll1l11ll11l111llll1l1111ll['ip']));
				$ll1l1l111l1111llllll1l11lll1l1l = json_decode($lll11ll11ll1l11l111ll11l111ll11);
				if (!empty($ll1l1l111l1111llllll1l11lll1l1l->code) or $l1ll1ll1l11ll11l111llll1l1111ll['ip'] == '2147483647') {
					cache_write('iplongregion:' . md5($l1ll1ll1l11ll11l111llll1l1111ll['ip']), '未知');
				} else {
					$l1l1ll11lll11l1ll111l1lll1l1l11 = $ll1l1l111l1111llllll1l11lll1l1l->data->region . $ll1l1l111l1111llllll1l11lll1l1l->data->city . $ll1l1l111l1111llllll1l11lll1l1l->data->isp . $ll1l1l111l1111llllll1l11lll1l1l->data->county;
					if (empty($l1l1ll11lll11l1ll111l1lll1l1l11)) {
						cache_write('iplongregion:' . md5($l1ll1ll1l11ll11l111llll1l1111ll['ip']), '未知');
					} else {
						cache_write('iplongregion:' . md5($l1ll1ll1l11ll11l111llll1l1111ll['ip']), $l1l1ll11lll11l1ll111l1lll1l1l11);
					}
				}
			}
			$l11lll1l1llll11lll1l1l1111l111l['created_at'] = $l1ll1ll1l11ll11l111llll1l1111ll['created_at'];
			$l11lll1l1llll11lll1l1l1111l111l['ip'] = $l1ll1ll1l11ll11l111llll1l1111ll['ip'];
			$l11lll1l1llll11lll1l1l1111l111l['openid'] = $l1ll1ll1l11ll11l111llll1l1111ll['openid'];
			$l11lll1l1llll11lll1l1l1111l111l['nickname'] = $l1ll1ll1l11ll11l111llll1l1111ll['nickname'];
			$l11lll1l1llll11lll1l1l1111l111l['avatar'] = $l1ll1ll1l11ll11l111llll1l1111ll['avatar'];
			$l11lll1l1llll11lll1l1l1111l111l['dz'] = $l1l1ll11lll11l1ll111l1lll1l1l11;
			$l11111l11ll11llll111ll111l1ll11[] = array_merge($l1ll1ll1l11ll11l111llll1l1111ll, $l11lll1l1llll11lll1l1l1111l111l);
		}
		$ll11l1111l1llll1llll1l1l1l111l1 = pagination($ll1l1ll1111l11111l11111ll1ll11l, $ll1l1ll1l111lllll111111l111111l, $lll1111llllll111l111lllll1l1l1l);
		include $this->template("votelog");
	}
	public function doWebExcle()
	{
		set_time_limit(0);
		global $_W, $_GPC;
		header("Content-type:text/csv");
		header("Content-Disposition:attachment; filename=投票日志-" . date('Y-m-d') . ".csv");
		$l1111l11l1llll1l11l1lll11l11lll = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_setting') . " WHERE `uniacid` = :uniacid", array(":uniacid" => $_W['uniacid']));
		if (!empty($_GPC['sid'])) {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l = ' WHERE `sid`=:sid ';
			$l1l11l1llll1llllll11l1llll1ll1l[':sid'] = intval($_GPC['sid']);
		} else {
			$ll1l1l111ll1l1111l11ll111l1111l = array();
			foreach ($l1111l11l1llll1l11l1lll11l11lll as $l1ll1ll1l11ll11l111llll1l1111ll) {
				$ll1l1l111ll1l1111l11ll111l1111l[] = intval($l1ll1ll1l11ll11l111llll1l1111ll['id']);
			}
			$l1l1l1l1l1ll1ll1ll11llll11ll11l = " WHERE `sid` in ('" . implode("','", $ll1l1l111ll1l1111l11ll111l1111l) . "')";
		}
		if (!empty($_GPC['uid'])) {
			if ($l1l1ll11l1l1ll111ll1l111111l1ll = pdo_fetchall("SELECT * FROM " . tablename("xiaof_toupiao") . $l1l1l1l1l1ll1ll1ll11llll11ll11l . " AND `uid` = '" . intval($_GPC['uid']) . "'", $l1l11l1llll1llllll11l1llll1ll1l)) {
				$l11l1l1l1l1l111ll1l1l11ll1l1111 = array();
				foreach ($l1l1ll11l1l1ll111ll1l111111l1ll as $l1ll1ll1l11ll11l111llll1l1111ll) {
					$l11l1l1l1l1l111ll1l1l11ll1l1111[] = $l1ll1ll1l11ll11l111llll1l1111ll['id'];
				}
				$l1l1l1l1l1ll1ll1ll11llll11ll11l = " WHERE `pid` in ('" . implode("','", $l11l1l1l1l1l111ll1l1l11ll1l1111) . "')";
			}
		} elseif (!empty($_GPC['pid'])) {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l .= ' AND `pid`=:pid ';
			$l1l11l1llll1llllll11l1llll1ll1l[':pid'] = intval($_GPC['pid']);
		} elseif (!empty($_GPC['ip'])) {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l .= ' AND `ip`=:ip ';
			$l1l11l1llll1llllll11l1llll1ll1l[':ip'] = $_GPC['ip'];
		}
		if (!empty($_GPC['vopenid'])) {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l .= ' AND `openid`=:openid ';
			$l1l11l1llll1llllll11l1llll1ll1l[':openid'] = $_GPC['vopenid'];
		}
		if (!empty($_GPC['valid']) or $_GPC['valid'] == '0') {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l .= ' AND `valid`=:valid ';
			$l1l11l1llll1llllll11l1llll1ll1l[':valid'] = $_GPC['valid'];
		}
		$l11l1l111lll11ll1l111l1l1111l11 = fopen('php://output', 'a');
		$l1111l1l11l11l11l111l11l1111lll = array('uid' => '选手编号', 'name' => '投票昵称', 'phone' => '投票openid', 'type' => '投票ip', 'num' => '同ip投票数', 'store_cn' => '同ip登陆微信数', 'clerk_cn' => 'ip地区', 'createtime' => '投票时间');
		fputcsv($l11l1l111lll11ll1l111l1l1111l11, $l1111l1l11l11l11l111l11l1111lll);
		$ll1l1ll1111l11111l11111ll1ll11l = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xiaof_toupiao_log') . $l1l1l1l1l1ll1ll1ll11llll11ll11l . "", $l1l11l1llll1llllll11l1llll1ll1l);
		$lll1111llllll111l111lllll1l1l1l = 10000;
		for ($ll1l11l1l1l11l1l111l1l1l11l1111 = 0; $ll1l11l1l1l11l1l111l1l1l11l1111 < intval($ll1l1ll1111l11111l11111ll1ll11l / $lll1111llllll111l111lllll1l1l1l) + 1; $ll1l11l1l1l11l1l111l1l1l11l1111++) {
			$llll1l11ll1l1lll1l1l1llll1ll111 = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_log') . $l1l1l1l1l1ll1ll1ll11llll11ll11l . " order by `id` desc  LIMIT " . $ll1l11l1l1l11l1l111l1l1l11l1111 * $lll1111llllll111l111lllll1l1l1l . ',' . $lll1111llllll111l111lllll1l1l1l, $l1l11l1llll1llllll11l1llll1ll1l);
			foreach ($llll1l11ll1l1lll1l1l1llll1ll111 as $l1ll1ll1l11ll11l111llll1l1111ll) {
				$l11lll1l1llll11lll1l1l1111l111l = pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao") . " WHERE `id` = :id", array(":id" => $l1ll1ll1l11ll11l111llll1l1111ll['pid']));
				if (empty($l1ll1ll1l11ll11l111llll1l1111ll['nickname'])) {
					if (!empty($l1ll1ll1l11ll11l111llll1l1111ll['fanid'])) {
						if ($l1l11l11ll11l1l1111l1ll11ll1ll1 = pdo_fetch("SELECT * FROM " . tablename("mc_mapping_fans") . " WHERE `fanid` = :fanid limit 1", array(":fanid" => $l1ll1ll1l11ll11l111llll1l1111ll['fanid']))) {
							$l11lll1l1llll11lll1l1l1111l111l['nickname'] = $l1l11l11ll11l1l1111l1ll11ll1ll1['nickname'];
						}
					} else {
						if ($l1l11l11ll11l1l1111l1ll11ll1ll1 = pdo_fetch("SELECT * FROM " . tablename("mc_mapping_fans") . " WHERE `openid` = :openid limit 1", array(":openid" => $l1ll1ll1l11ll11l111llll1l1111ll['openid']))) {
							$l11lll1l1llll11lll1l1l1111l111l['nickname'] = $l1l11l11ll11l1l1111l1ll11ll1ll1['nickname'];
						}
					}
				}
				$l11lll1l1llll11lll1l1l1111l111l['ocount'] = pdo_fetchcolumn("SELECT COUNT(1) FROM (SELECT COUNT(*) FROM " . tablename('xiaof_toupiao_log') . " where `sid` = '" . $l1ll1ll1l11ll11l111llll1l1111ll['sid'] . "' AND `ip` = '" . $l1ll1ll1l11ll11l111llll1l1111ll['ip'] . "'  group by `openid`) T");
				$l11lll1l1llll11lll1l1l1111l111l['count'] = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xiaof_toupiao_log') . " where `sid` = '" . $l1ll1ll1l11ll11l111llll1l1111ll['sid'] . "' AND `ip` = '" . $l1ll1ll1l11ll11l111llll1l1111ll['ip'] . "'");
				if (!($l1l1ll11lll11l1ll111l1lll1l1l11 = cache_read('iplongregion:' . md5($l1ll1ll1l11ll11l111llll1l1111ll['ip'])))) {
					$lll11ll11ll1l11l111ll11l111ll11 = file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=" . long2ip($l1ll1ll1l11ll11l111llll1l1111ll['ip']));
					$ll1l1l111l1111llllll1l11lll1l1l = json_decode($lll11ll11ll1l11l111ll11l111ll11);
					if (!empty($ll1l1l111l1111llllll1l11lll1l1l->code) or $l1ll1ll1l11ll11l111llll1l1111ll['ip'] == '2147483647') {
						cache_write('iplongregion:' . md5($l1ll1ll1l11ll11l111llll1l1111ll['ip']), '未知');
					} else {
						$l1l1ll11lll11l1ll111l1lll1l1l11 = $ll1l1l111l1111llllll1l11lll1l1l->data->region . $ll1l1l111l1111llllll1l11lll1l1l->data->city . $ll1l1l111l1111llllll1l11lll1l1l->data->isp . $ll1l1l111l1111llllll1l11lll1l1l->data->county;
						if (empty($l1l1ll11lll11l1ll111l1lll1l1l11)) {
							cache_write('iplongregion:' . md5($l1ll1ll1l11ll11l111llll1l1111ll['ip']), '未知');
						} else {
							cache_write('iplongregion:' . md5($l1ll1ll1l11ll11l111llll1l1111ll['ip']), $l1l1ll11lll11l1ll111l1lll1l1l11);
						}
					}
				}
				$ll1l1ll1ll111lllll11l111l1l11ll = array('uid' => $l11lll1l1llll11lll1l1l1111l111l['uid'], 'name' => $l1ll1ll1l11ll11l111llll1l1111ll['nickname'], 'phone' => $l1ll1ll1l11ll11l111llll1l1111ll['openid'], 'type' => long2ip($l1ll1ll1l11ll11l111llll1l1111ll['ip']), 'num' => $l11lll1l1llll11lll1l1l1111l111l['count'], 'store_cn' => $l11lll1l1llll11lll1l1l1111l111l['ocount'], 'clerk_cn' => $l1l1ll11lll11l1ll111l1lll1l1l11, 'createtime' => date('Y-m-d H:i:s', $l1ll1ll1l11ll11l111llll1l1111ll['created_at']));
				fputcsv($l11l1l111lll11ll1l111l1l1111l11, $ll1l1ll1ll111lllll11l111l1l11ll);
			}
			unset($llll1l11ll1l1lll1l1l1llll1ll111);
			ob_flush();
			flush();
		}
		die;
	}
	public function doWebExcletop()
	{
		set_time_limit(0);
		global $_W, $_GPC;
		if (empty($_GPC['sid'])) {
			message('没有选择要导出排名的活动', referer(), 'error');
		}
		$l1lll1l1l11l11lllllll1lll11111l = $this->l1l11ll11ll1l1111lll11lllll1l11();
		$l1l1l1l1l1ll1ll1ll11llll11ll11l = ' WHERE `sid`=:sid ';
		$l1l11l1llll1llllll11l1llll1ll1l[':sid'] = intval($_GPC['sid']);
		$ll11l11l1111l1ll1llll11111l11ll = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao') . $l1l1l1l1l1ll1ll1ll11llll11ll11l . " AND `verify`!='2' order by `good` desc", $l1l11l1llll1llllll11l1llll1ll1l);
		$l1111l1111ll1llll11l1ll1111llll = array();
		foreach ($ll11l11l1111l1ll1llll11111l11ll as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
			if ($l1l11l11ll11l1l1111l1ll11ll1ll1 = pdo_fetch("SELECT * FROM " . tablename("mc_mapping_fans") . " WHERE `openid` = :openid limit 1", array(":openid" => $l1ll1ll1l11ll11l111llll1l1111ll['openid']))) {
				$l1ll1ll1l11ll11l111llll1l1111ll['nickname'] = $l1l11l11ll11l1l1111l1ll11ll1ll1['nickname'];
			}
			$l1ll1ll1l11ll11l111llll1l1111ll['data'] = iunserializer($l1ll1ll1l11ll11l111llll1l1111ll['data']);
			$l1111l1111ll1llll11l1ll1111llll[$l1l1l11l11l11111l1l11lll11l1ll1] = $l1ll1ll1l11ll11l111llll1l1111ll;
		}
		$ll111l1llll1l1l1ll1l1l1ll1l1ll1 = "\xEF\xBB\xBF";
		$l1111l1l11l11l11l111l11l1111lll = array('top' => '排名', 'groups' => '分组', 'uid' => '选手编号', 'name' => '姓名', 'phone' => '手机号', 'openid' => 'openid', 'nickname' => '微信昵称', 'good' => '得票数', 'share' => '分享数', 'click' => '点击量');
		foreach ($l1lll1l1l11l11lllllll1lll11111l['joinfield'] as $l1ll1ll1l11ll11l111llll1l1111ll) {
			$l1111l1l11l11l11l111l11l1111lll[$l1ll1ll1l11ll11l111llll1l1111ll['sign']] = $l1ll1ll1l11ll11l111llll1l1111ll['name'];
		}
		foreach ($l1111l1l11l11l11l111l11l1111lll as $ll111l1ll11l11lll1llllllll11l11) {
			$ll111l1llll1l1l1ll1l1l1ll1l1ll1 .= $ll111l1ll11l11lll1llllllll11l11 . "\t,";
		}
		$ll111l1llll1l1l1ll1l1l1ll1l1ll1 .= "\n";
		$lll11l1l1ll1lllllll11llll111lll = 1;
		foreach ($ll11l11l1111l1ll1llll11111l11ll as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
			if ($l1l11l11ll11l1l1111l1ll11ll1ll1 = pdo_fetch("SELECT * FROM " . tablename("mc_mapping_fans") . " WHERE `openid` = :openid limit 1", array(":openid" => $l1ll1ll1l11ll11l111llll1l1111ll['openid']))) {
				$l1ll1ll1l11ll11l111llll1l1111ll['nickname'] = $l1l11l11ll11l1l1111l1ll11ll1ll1['nickname'];
			}
			$ll1ll11llll1l11l11llll1ll11ll1l = iunserializer($l1ll1ll1l11ll11l111llll1l1111ll['data']);
			empty($ll1ll11llll1l11l11llll1ll11ll1l) or $l1ll1ll1l11ll11l111llll1l1111ll = array_merge($l1ll1ll1l11ll11l111llll1l1111ll, $ll1ll11llll1l11l11llll1ll11ll1l);
			foreach ($l1111l1l11l11l11l111l11l1111lll as $l1l1ll111l11ll1llll111l11lllll1 => $ll111l1ll11l11lll1llllllll11l11) {
				if ($l1l1ll111l11ll1llll111l11lllll1 == 'top') {
					$ll111l1llll1l1l1ll1l1l1ll1l1ll1 .= $lll11l1l1ll1lllllll11llll111lll++ . "\t, ";
				} elseif ($l1l1ll111l11ll1llll111l11lllll1 == 'groups') {
					$ll111l1llll1l1l1ll1l1l1ll1l1ll1 .= empty($l1ll1ll1l11ll11l111llll1l1111ll[$l1l1ll111l11ll1llll111l11lllll1]) ? '未分组' . "\t, " : $l1lll1l1l11l11lllllll1lll11111l['groups'][$l1ll1ll1l11ll11l111llll1l1111ll[$l1l1ll111l11ll1llll111l11lllll1]]['name'] . " \t, ";
				} else {
					$ll111l1llll1l1l1ll1l1l1ll1l1ll1 .= isset($l1ll1ll1l11ll11l111llll1l1111ll[$l1l1ll111l11ll1llll111l11lllll1]) ? $l1ll1ll1l11ll11l111llll1l1111ll[$l1l1ll111l11ll1llll111l11lllll1] . "\t, " : " \t, ";
				}
			}
			$ll111l1llll1l1l1ll1l1l1ll1l1ll1 .= "\n";
		}
		header("Content-type:text/csv");
		header("Content-Disposition:attachment; filename=排名-" . date('Y-m-d') . ".csv");
		echo $ll111l1llll1l1l1ll1l1l1ll1l1ll1;
		die;
	}
	public function doWebExcledraw()
	{
		set_time_limit(0);
		global $_W, $_GPC;
		$l1111l11l1llll1l11l1lll11l11lll = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_setting') . " WHERE `uniacid` = :uniacid", array(":uniacid" => $_W['uniacid']));
		if (!empty($_GPC['sid'])) {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l = ' WHERE `sid`=:sid';
			$l1l11l1llll1llllll11l1llll1ll1l[':sid'] = intval($_GPC['sid']);
		} else {
			$ll1l1l111ll1l1111l11ll111l1111l = array();
			foreach ($l1111l11l1llll1l11l1lll11l11lll as $l1ll1ll1l11ll11l111llll1l1111ll) {
				$ll1l1l111ll1l1111l11ll111l1111l[] = intval($l1ll1ll1l11ll11l111llll1l1111ll['id']);
			}
			$l1l1l1l1l1ll1ll1ll11llll11ll11l = " WHERE `sid` in ('" . implode("','", $ll1l1l111ll1l1111l11ll111l1111l) . "')";
			$l1l11l1llll1llllll11l1llll1ll1l = array();
		}
		if (!empty($_GPC['key'])) {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l .= ' AND (`uid`=:uid or `uname`=:uname)';
			$l1l11l1llll1llllll11l1llll1ll1l[':uid'] = $_GPC['key'];
			$l1l11l1llll1llllll11l1llll1ll1l[':uname'] = $_GPC['key'];
			$l1l1ll111l11ll1llll111l11lllll1 = $_GPC['key'];
		}
		if (!empty($_GPC['uses'])) {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l .= ' AND `uses`=:uses';
			$l1l11l1llll1llllll11l1llll1ll1l[':uses'] = intval($_GPC['uses']);
		}
		if (!empty($_GPC['attr'])) {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l .= ' AND `attr`=:attr';
			$l1l11l1llll1llllll11l1llll1ll1l[':attr'] = intval($_GPC['attr']);
		}
		$ll11l11l1111l1ll1llll11111l11ll = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_draw') . $l1l1l1l1l1ll1ll1ll11llll11ll11l . " ORDER BY `id` DESC", $l1l11l1llll1llllll11l1llll1ll1l);
		foreach ($ll11l11l1111l1ll1llll11111l11ll as &$ll1lll11llll11lllllll11ll1l11l1) {
			$ll111lll1lll1111ll1l11l1111l1l1 = $this->lllll111lllll1l111111ll1l11lll1();
			$l111l1l1l1lll1lll1lllll1ll1ll1l = pdo_fetchcolumn("SELECT `address` FROM " . tablename('xiaof_relation') . " WHERE `uniacid` IN ('" . implode("','", $ll111lll1lll1111ll1l11l1111l1l1) . "') AND `openid` = '" . $ll1lll11llll11lllllll11ll1l11l1['openid'] . "' AND `address` != '' ORDER BY `id` DESC limit 1");
			$l111111lllll1l111111l1l11l11ll1 = iunserializer($l111l1l1l1lll1lll1lllll1ll1ll1l);
			$ll1lll11llll11lllllll11ll1l11l1['names'] = $l111111lllll1l111111l1l11l11ll1['name'];
			$ll1lll11llll11lllllll11ll1l11l1['phone'] = $l111111lllll1l111111l1l11l11ll1['phone'];
			$ll1lll11llll11lllllll11ll1l11l1['addrs'] = $l111111lllll1l111111l1l11l11ll1['addrs'];
		}
		$ll111l1llll1l1l1ll1l1l1ll1l1ll1 = "\xEF\xBB\xBF";
		$l1111l1l11l11l11l111l11l1111lll = array('uid' => '用户UID', 'uname' => '用户昵称', 'openid' => 'openid', 'sid' => '活动ID', 'name' => '奖品名称', 'uses' => '状态', 'names' => '姓名', 'phone' => '手机号', 'addrs' => '地址', 'created_at' => '抽取时间');
		foreach ($l1111l1l11l11l11l111l11l1111lll as $ll111l1ll11l11lll1llllllll11l11) {
			$ll111l1llll1l1l1ll1l1l1ll1l1ll1 .= $ll111l1ll11l11lll1llllllll11l11 . "\t,";
		}
		$ll111l1llll1l1l1ll1l1l1ll1l1ll1 .= "\n";
		$lll11l1l1ll1lllllll11llll111lll = 1;
		foreach ($ll11l11l1111l1ll1llll11111l11ll as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
			foreach ($l1111l1l11l11l11l111l11l1111lll as $l1l1ll111l11ll1llll111l11lllll1 => $ll111l1ll11l11lll1llllllll11l11) {
				if ($l1l1ll111l11ll1llll111l11lllll1 == 'uses') {
					$ll111l1llll1l1l1ll1l1l1ll1l1ll1 .= $l1ll1ll1l11ll11l111llll1l1111ll['uses'] == '1' ? "已核销\t, " : "未核销\t, ";
				} elseif ($l1l1ll111l11ll1llll111l11lllll1 == 'created_at') {
					$ll111l1llll1l1l1ll1l1l1ll1l1ll1 .= date('Y-m-d H:i:s', $l1ll1ll1l11ll11l111llll1l1111ll['created_at']) . " \t, ";
				} else {
					$ll111l1llll1l1l1ll1l1l1ll1l1ll1 .= isset($l1ll1ll1l11ll11l111llll1l1111ll[$l1l1ll111l11ll1llll111l11lllll1]) ? $l1ll1ll1l11ll11l111llll1l1111ll[$l1l1ll111l11ll1llll111l11lllll1] . "\t, " : " \t, ";
				}
			}
			$ll111l1llll1l1l1ll1l1l1ll1l1ll1 .= "\n";
		}
		header("Content-type:text/csv");
		header("Content-Disposition:attachment; filename=抽奖记录-" . date('Y-m-d') . ".csv");
		echo $ll111l1llll1l1l1ll1l1l1ll1l1ll1;
		die;
	}
	public function doWebDisableip()
	{
		global $_W, $_GPC;
		//$this->ll1111l1ll11l11l1lll11llll11ll1();
		if (!empty($_GPC['del'])) {
			$l1l11lll1l1llll1ll1ll111ll1l111 = array();
			foreach ($_GPC['delete'] as $l1ll1ll1l11ll11l111llll1l1111ll) {
				$l1l11lll1l1llll1ll1ll111ll1l111[] = intval($l1ll1ll1l11ll11l111llll1l1111ll);
			}
			pdo_query("DELETE FROM " . tablename('xiaof_toupiao_safe') . " WHERE `id` IN ('" . implode("','", $l1l11lll1l1llll1ll1ll111ll1l111) . "')");
		}
		$l1111l11l1llll1l11l1lll11l11lll = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_setting') . " WHERE `uniacid` = :uniacid", array(":uniacid" => $_W['uniacid']));
		if (!empty($_GPC['sid'])) {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l = ' WHERE `sid`=:sid ';
			$l1l11l1llll1llllll11l1llll1ll1l[':sid'] = intval($_GPC['sid']);
		} else {
			$ll1l1l111ll1l1111l11ll111l1111l = array();
			foreach ($l1111l11l1llll1l11l1lll11l11lll as $l1ll1ll1l11ll11l111llll1l1111ll) {
				$ll1l1l111ll1l1111l11ll111l1111l[] = intval($l1ll1ll1l11ll11l111llll1l1111ll['id']);
			}
			$l1l1l1l1l1ll1ll1ll11llll11ll11l = " WHERE `sid` in ('" . implode("','", $ll1l1l111ll1l1111l11ll111l1111l) . "')";
		}
		if (!($ll1l11l11ll1111ll11l1ll1lll1l11 = cache_read('xiaof:wxserviceip'))) {
			load()->classs('weixin.account');
			$l11l1l11lllll11ll111l1ll1l1ll11 = WeixinAccount::create($_W['acid']);
			$llll11lll1111lll1111l11ll11ll1l = $l11l1l11lllll11ll111l1ll1l1ll11->fetch_token();
			$l1l1lll111ll111l1ll11l111l1ll1l = file_get_contents('https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=' . $llll11lll1111lll1111l11ll11ll1l);
			$ll1l11ll11l1ll1l11llll1ll1ll111 = @json_decode($l1l1lll111ll111l1ll11l111l1ll1l, true);
			if (isset($ll1l11ll11l1ll1l11llll1ll1ll111['errcode'])) {
				$ll1l11l11ll1111ll11l1ll1lll1l11 = array();
			} else {
				$ll1l11l11ll1111ll11l1ll1lll1l11 = $ll1l11ll11l1ll1l11llll1ll1ll111['ip_list'];
			}
			cache_write('xiaof:wxserviceip', iserializer($ll1l11l11ll1111ll11l1ll1lll1l11));
		}
		$l1l11lll1ll111111ll1ll1l1l11l11 = iunserializer($ll1l11l11ll1111ll11l1ll1lll1l11);
		$ll1l1ll1l111lllll111111l111111l = max(1, intval($_GPC['page']));
		$lll1111llllll111l111lllll1l1l1l = 20;
		$ll1l1ll1111l11111l11111ll1ll11l = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xiaof_toupiao_safe') . $l1l1l1l1l1ll1ll1ll11llll11ll11l, $l1l11l1llll1llllll11l1llll1ll1l);
		$l11111l11ll11llll111ll111l1ll11 = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_safe') . $l1l1l1l1l1ll1ll1ll11llll11ll11l . " ORDER BY `id` DESC LIMIT " . ($ll1l1ll1l111lllll111111l111111l - 1) * $lll1111llllll111l111lllll1l1l1l . ',' . $lll1111llllll111l111lllll1l1l1l, $l1l11l1llll1llllll11l1llll1ll1l);
		foreach ($l11111l11ll11llll111ll111l1ll11 as &$l1ll1ll1l11ll11l111llll1l1111ll) {
			if (!($l1l1ll11lll11l1ll111l1lll1l1l11 = cache_read('iplongregion:' . md5($l1ll1ll1l11ll11l111llll1l1111ll['ip'])))) {
				$lll11ll11ll1l11l111ll11l111ll11 = file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=" . long2ip($l1ll1ll1l11ll11l111llll1l1111ll['ip']));
				$ll1l1l111l1111llllll1l11lll1l1l = json_decode($lll11ll11ll1l11l111ll11l111ll11);
				if (!empty($ll1l1l111l1111llllll1l11lll1l1l->code) or $l1ll1ll1l11ll11l111llll1l1111ll['ip'] == '2147483647') {
					cache_write('iplongregion:' . md5($l1ll1ll1l11ll11l111llll1l1111ll['ip']), '未知');
				} else {
					if (in_array(long2ip($l1ll1ll1l11ll11l111llll1l1111ll['ip']), $l1l11lll1ll111111ll1ll1l1l11l11)) {
						$l1l1ll11lll11l1ll111l1lll1l1l11 = '微信服务器';
					} else {
						$l1l1ll11lll11l1ll111l1lll1l1l11 = $ll1l1l111l1111llllll1l11lll1l1l->data->region . $ll1l1l111l1111llllll1l11lll1l1l->data->city . $ll1l1l111l1111llllll1l11lll1l1l->data->isp . $ll1l1l111l1111llllll1l11lll1l1l->data->county;
					}
					if (empty($l1l1ll11lll11l1ll111l1lll1l1l11)) {
						cache_write('iplongregion:' . md5($l1ll1ll1l11ll11l111llll1l1111ll['ip']), '未知');
					} else {
						cache_write('iplongregion:' . md5($l1ll1ll1l11ll11l111llll1l1111ll['ip']), $l1l1ll11lll11l1ll111l1lll1l1l11);
					}
				}
			}
			$l1ll1ll1l11ll11l111llll1l1111ll['dz'] = $l1l1ll11lll11l1ll111l1lll1l1l11;
		}
		$ll11l1111l1llll1llll1l1l1l111l1 = pagination($ll1l1ll1111l11111l11111ll1ll11l, $ll1l1ll1l111lllll111111l111111l, $lll1111llllll111l111lllll1l1l1l);
		include $this->template("disableip");
	}
	public function doWebSafe()
	{
		global $_W, $_GPC;
		//$this->ll1111l1ll11l11l1lll11llll11ll1();
		$l1111l11l1llll1l11l1lll11l11lll = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_setting') . " WHERE `uniacid` = :uniacid", array(":uniacid" => $_W['uniacid']));
		if ($_GPC['hide'] == 'y') {
			if (empty($_GPC['ip'])) {
				die('参数错误');
			}
			if (pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao_safe") . " WHERE `sid` = :sid AND `ip` = :ip ", array(":sid" => $_GPC['sid'], ":ip" => $_GPC['ip']))) {
				message('该ip已经在黑名单中', referer(), 'success');
			}
			pdo_insert("xiaof_toupiao_safe", array("sid" => $_GPC['sid'], "ip" => $_GPC['ip'], "created_at" => time()));
			message('操作成功', referer(), 'success');
		} elseif ($_GPC['hide'] == 'n') {
			if (empty($_GPC['safeid'])) {
				die('参数错误');
			}
			pdo_delete('xiaof_toupiao_safe', array('id' => $_GPC['safeid']));
			message('操作成功', referer(), 'success');
		}
		$ll1l1ll1l111lllll111111l111111l = max(1, intval($_GPC['page']));
		$lll1111llllll111l111lllll1l1l1l = 10;
		$l1l11l1llll1llllll11l1llll1ll1l = array();
		if (!empty($_GPC['sid'])) {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l = ' WHERE `sid`=:sid ';
			$l1l11l1llll1llllll11l1llll1ll1l[':sid'] = intval($_GPC['sid']);
		} else {
			$ll1l1l111ll1l1111l11ll111l1111l = array();
			foreach ($l1111l11l1llll1l11l1lll11l11lll as $l1ll1ll1l11ll11l111llll1l1111ll) {
				$ll1l1l111ll1l1111l11ll111l1111l[] = intval($l1ll1ll1l11ll11l111llll1l1111ll['id']);
			}
			$l1l1l1l1l1ll1ll1ll11llll11ll11l = " WHERE `sid` in ('" . implode("','", $ll1l1l111ll1l1111l11ll111l1111l) . "')";
		}
		if ($_GPC['unum'] == 'y') {
			if (empty($_GPC['ip'])) {
				die('参数错误');
			}
			$l1l1l1l1l1ll1ll1ll11llll11ll11l .= " AND `ip`=:ip AND `valid` = '1'";
			$l1l11l1llll1llllll11l1llll1ll1l[':ip'] = $_GPC['ip'];
			$l1l11l1111l1l111111l1111ll11lll = pdo_fetchall("SELECT *,COUNT(pid) as nums FROM " . tablename('xiaof_toupiao_log') . $l1l1l1l1l1ll1ll1ll11llll11ll11l . " group by `pid`", $l1l11l1llll1llllll11l1llll1ll1l);
			foreach ($l1l11l1111l1l111111l1111ll11lll as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
				if ($ll11l11lll1llll1l1111l11ll1l1ll = pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao_manage") . " WHERE `pid` = :pid AND `ip` = :ip ", array(":pid" => $l1ll1ll1l11ll11l111llll1l1111ll['pid'], ":ip" => $l1ll1ll1l11ll11l111llll1l1111ll['ip']))) {
					pdo_query("UPDATE " . tablename("xiaof_toupiao_manage") . " SET `num` = num+" . $l1ll1ll1l11ll11l111llll1l1111ll['nums'] . " WHERE `id` = '" . $ll11l11lll1llll1l1111l11ll1l1ll['id'] . "'");
				} else {
					pdo_insert("xiaof_toupiao_manage", array("sid" => $l1ll1ll1l11ll11l111llll1l1111ll['sid'], "ip" => $l1ll1ll1l11ll11l111llll1l1111ll['ip'], "pid" => $l1ll1ll1l11ll11l111llll1l1111ll['pid'], "num" => $l1ll1ll1l11ll11l111llll1l1111ll['nums'], "operation" => '剔除票数', "created_at" => time()));
				}
				pdo_query("UPDATE " . tablename("xiaof_toupiao") . " SET `good` = good-" . $l1ll1ll1l11ll11l111llll1l1111ll['nums'] . " WHERE `id` = '" . $l1ll1ll1l11ll11l111llll1l1111ll['pid'] . "'");
				pdo_query("UPDATE " . tablename("xiaof_toupiao_log") . " SET `valid` = '0' WHERE `ip` = '" . $l1ll1ll1l11ll11l111llll1l1111ll['ip'] . "'");
			}
			message('操作成功', referer(), 'success');
		} elseif ($_GPC['unum'] == 'n') {
			if (empty($_GPC['ip'])) {
				die('参数错误');
			}
			$l1l1l1l1l1ll1ll1ll11llll11ll11l .= ' AND `ip`=:ip ';
			$l1l11l1llll1llllll11l1llll1ll1l[':ip'] = $_GPC['ip'];
			$l1l11l1111l1l111111l1111ll11lll = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_manage') . $l1l1l1l1l1ll1ll1ll11llll11ll11l . "", $l1l11l1llll1llllll11l1llll1ll1l);
			$lll1111ll1l1l1lll11111ll111111l = array();
			foreach ($l1l11l1111l1l111111l1111ll11lll as $l1ll1ll1l11ll11l111llll1l1111ll) {
				$lll1111ll1l1l1lll11111ll111111l[] = intval($l1ll1ll1l11ll11l111llll1l1111ll['id']);
				pdo_query("UPDATE " . tablename("xiaof_toupiao") . " SET `good` = good+" . $l1ll1ll1l11ll11l111llll1l1111ll['num'] . " WHERE `id` = '" . $l1ll1ll1l11ll11l111llll1l1111ll['pid'] . "'");
			}
			pdo_query("UPDATE " . tablename("xiaof_toupiao_log") . " SET `valid` = '1' WHERE `ip` = '" . $_GPC['ip'] . "'");
			pdo_query("DELETE FROM " . tablename('xiaof_toupiao_manage') . " WHERE `id` IN ('" . implode("','", $lll1111ll1l1l1lll11111ll111111l) . "')");
			message('操作成功', referer(), 'success');
		}
		$ll1l1ll1111l11111l11111ll1ll11l = pdo_fetchcolumn("SELECT COUNT(1) FROM (SELECT COUNT(*) FROM " . tablename('xiaof_toupiao_log') . $l1l1l1l1l1ll1ll1ll11llll11ll11l . " group by `ip`) T", $l1l11l1llll1llllll11l1llll1ll1l);
		$llll1l11ll1l1lll1l1l1llll1ll111 = pdo_fetchall("SELECT *,COUNT(ip) as counts,MAX(created_at) as created_at FROM " . tablename('xiaof_toupiao_log') . $l1l1l1l1l1ll1ll1ll11llll11ll11l . " group by `ip` order by counts desc LIMIT " . ($ll1l1ll1l111lllll111111l111111l - 1) * $lll1111llllll111l111lllll1l1l1l . ',' . $lll1111llllll111l111lllll1l1l1l, $l1l11l1llll1llllll11l1llll1ll1l);
		if (!($ll1l11l11ll1111ll11l1ll1lll1l11 = cache_read('xiaof:wxserviceip'))) {
			load()->classs('weixin.account');
			$l11l1l11lllll11ll111l1ll1l1ll11 = WeixinAccount::create($_W['acid']);
			$llll11lll1111lll1111l11ll11ll1l = $l11l1l11lllll11ll111l1ll1l1ll11->fetch_token();
			$l1l1lll111ll111l1ll11l111l1ll1l = file_get_contents('https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=' . $llll11lll1111lll1111l11ll11ll1l);
			$ll1l11ll11l1ll1l11llll1ll1ll111 = @json_decode($l1l1lll111ll111l1ll11l111l1ll1l, true);
			if (isset($ll1l11ll11l1ll1l11llll1ll1ll111['errcode'])) {
				$ll1l11l11ll1111ll11l1ll1lll1l11 = array();
			} else {
				$ll1l11l11ll1111ll11l1ll1lll1l11 = $ll1l11ll11l1ll1l11llll1ll1ll111['ip_list'];
			}
			cache_write('xiaof:wxserviceip', iserializer($ll1l11l11ll1111ll11l1ll1lll1l11));
		}
		$l1l11lll1ll111111ll1ll1l1l11l11 = iunserializer($ll1l11l11ll1111ll11l1ll1lll1l11);
		$l11111l11ll11llll111ll111l1ll11 = array();
		foreach ($llll1l11ll1l1lll1l1l1llll1ll111 as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
			$l11lll1l1llll11lll1l1l1111l111l = array();
			if (empty($l1ll1ll1l11ll11l111llll1l1111ll['nickname'])) {
				if (!empty($l1ll1ll1l11ll11l111llll1l1111ll['fanid'])) {
					$l11lll1l1llll11lll1l1l1111l111l['nickname'] = pdo_fetchcolumn("SELECT `nickname` FROM " . tablename("mc_mapping_fans") . " WHERE `fanid` = :fanid limit 1", array(":fanid" => $l1ll1ll1l11ll11l111llll1l1111ll['fanid']));
				} else {
					$l11lll1l1llll11lll1l1l1111l111l['nickname'] = pdo_fetchcolumn("SELECT `nickname` FROM " . tablename("mc_mapping_fans") . " WHERE `openid` = :openid limit 1", array(":openid" => $l1ll1ll1l11ll11l111llll1l1111ll['openid']));
				}
			}
			$l11lll1l1llll11lll1l1l1111l111l['ocount'] = pdo_fetchcolumn("SELECT COUNT(1) FROM (SELECT COUNT(*) FROM " . tablename('xiaof_toupiao_log') . " where `sid` = '" . $l1ll1ll1l11ll11l111llll1l1111ll['sid'] . "' AND `ip` = '" . $l1ll1ll1l11ll11l111llll1l1111ll['ip'] . "'  group by `openid`) T");
			$l11lll1l1llll11lll1l1l1111l111l['unum'] = $l11lll1l1llll11lll1l1l1111l111l['hide'] = 0;
			if ($l111ll111l1lll1lll1lll11ll11lll = pdo_fetch("SELECT `id` FROM " . tablename("xiaof_toupiao_safe") . " WHERE `sid` = '" . $l1ll1ll1l11ll11l111llll1l1111ll['sid'] . "' AND `ip` = :ip ", array(":ip" => $l1ll1ll1l11ll11l111llll1l1111ll['ip']))) {
				$l11lll1l1llll11lll1l1l1111l111l['hide'] = 1;
				$l11lll1l1llll11lll1l1l1111l111l['safeid'] = $l111ll111l1lll1lll1lll11ll11lll['id'];
			}
			$ll11l11lll1llll1l1111l11ll1l1ll = pdo_fetch("SELECT SUM(num) as nums FROM " . tablename("xiaof_toupiao_manage") . " WHERE `sid` = '" . $l1ll1ll1l11ll11l111llll1l1111ll['sid'] . "' AND `ip` = :ip ", array(":ip" => $l1ll1ll1l11ll11l111llll1l1111ll['ip']));
			if (!empty($ll11l11lll1llll1l1111l11ll1l1ll['nums'])) {
				$l11lll1l1llll11lll1l1l1111l111l['unum'] = 1;
				$l11lll1l1llll11lll1l1l1111l111l['unnum'] = $ll11l11lll1llll1l1111l11ll1l1ll['nums'];
			}
			if (!($l1l1ll11lll11l1ll111l1lll1l1l11 = cache_read('iplongregion:' . md5($l1ll1ll1l11ll11l111llll1l1111ll['ip'])))) {
				$lll11ll11ll1l11l111ll11l111ll11 = file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=" . long2ip($l1ll1ll1l11ll11l111llll1l1111ll['ip']));
				$ll1l1l111l1111llllll1l11lll1l1l = json_decode($lll11ll11ll1l11l111ll11l111ll11);
				if (!empty($ll1l1l111l1111llllll1l11lll1l1l->code) or $l1ll1ll1l11ll11l111llll1l1111ll['ip'] == '2147483647') {
					cache_write('iplongregion:' . md5($l1ll1ll1l11ll11l111llll1l1111ll['ip']), '未知');
				} else {
					if (in_array(long2ip($l1ll1ll1l11ll11l111llll1l1111ll['ip']), $l1l11lll1ll111111ll1ll1l1l11l11)) {
						$l1l1ll11lll11l1ll111l1lll1l1l11 = '微信服务器';
					} else {
						$l1l1ll11lll11l1ll111l1lll1l1l11 = $ll1l1l111l1111llllll1l11lll1l1l->data->region . $ll1l1l111l1111llllll1l11lll1l1l->data->city . $ll1l1l111l1111llllll1l11lll1l1l->data->isp . $ll1l1l111l1111llllll1l11lll1l1l->data->county;
					}
					if (empty($l1l1ll11lll11l1ll111l1lll1l1l11)) {
						cache_write('iplongregion:' . md5($l1ll1ll1l11ll11l111llll1l1111ll['ip']), '未知');
					} else {
						cache_write('iplongregion:' . md5($l1ll1ll1l11ll11l111llll1l1111ll['ip']), $l1l1ll11lll11l1ll111l1lll1l1l11);
					}
				}
			}
			$l11lll1l1llll11lll1l1l1111l111l['dz'] = $l1l1ll11lll11l1ll111l1lll1l1l11;
			$l11111l11ll11llll111ll111l1ll11[] = array_merge($l1ll1ll1l11ll11l111llll1l1111ll, $l11lll1l1llll11lll1l1l1111l111l);
		}
		$ll11l1111l1llll1llll1l1l1l111l1 = pagination($ll1l1ll1111l11111l11111ll1ll11l, $ll1l1ll1l111lllll111111l111111l, $lll1111llllll111l111lllll1l1l1l);
		include $this->template("safe");
	}
	public function doMobileIndex()
	{
		global $_W, $_GPC;
		$this->lllll1l111lll11l111lllll11ll11l();
		$l1lll1l1l11l11lllllll1lll11111l = $this->l1l11ll11ll1l1111lll11lllll1l11();
		$l1l1l1l1l1ll1ll1ll11llll11ll11l = ' WHERE `sid`=:sid';
		$l1l11l1llll1llllll11l1llll1ll1l = array(':sid' => $l1lll1l1l11l11lllllll1lll11111l['id']);
		if (!empty($_GPC['groups'])) {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l .= ' AND `groups`=:groups';
			$l1l11l1llll1llllll11l1llll1ll1l[':groups'] = intval($_GPC['groups']);
		}
		if ($l1lll1l1l11l11lllllll1lll11111l['verify'] == 1) {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l .= ' AND `verify`=:verify';
			$l1l11l1llll1llllll11l1llll1ll1l[':verify'] = 1;
		} else {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l .= ' AND `verify`!=:verify';
			$l1l11l1llll1llllll11l1llll1ll1l[':verify'] = 2;
		}
		if (!empty($_GPC['key'])) {
			if ($this->module['config']['fuzzysearch'] == 1) {
				$l1l1l1l1l1ll1ll1ll11llll11ll11l .= ' AND (`uid`=:uid OR `name`=:name) ';
				$l1l11l1llll1llllll11l1llll1ll1l[':name'] = $_GPC['key'];
			} else {
				$l1l1l1l1l1ll1ll1ll11llll11ll11l .= ' AND (`uid`=:uid OR `name` like :name) ';
				$l1l11l1llll1llllll11l1llll1ll1l[':name'] = "%" . $_GPC['key'] . "%";
			}
			$l1l11l1llll1llllll11l1llll1ll1l[':uid'] = $_GPC['key'];
			$l1l1ll111l11ll1llll111l11lllll1 = $_GPC['key'];
		}
		switch ($_GPC['type']) {
			case 'hot':
				$l1l1lll1lll11l111ll111l1llll1ll = 'updated_at';
				break;
			case 'new':
				$l1l1lll1lll11l111ll111l1llll1ll = 'created_at';
				break;
			case 'top':
				$l1l1lll1lll11l111ll111l1llll1ll = 'good';
				break;
			default:
				$l1l1lll1lll11l111ll111l1llll1ll = 'updated_at';
				break;
		}
		$ll1l1ll1l111lllll111111l111111l = max(1, intval($_GPC['page']));
		$lll1111llllll111l111lllll1l1l1l = isset($l1lll1l1l11l11lllllll1lll11111l['indexloadnum']) ? $l1lll1l1l11l11lllllll1lll11111l['indexloadnum'] : 12;
		$ll11l11l1111l1ll1llll11111l11ll = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao') . $l1l1l1l1l1ll1ll1ll11llll11ll11l . " ORDER BY `" . $l1l1lll1lll11l111ll111l1llll1ll . "` DESC LIMIT " . ($ll1l1ll1l111lllll111111l111111l - 1) * $lll1111llllll111l111lllll1l1l1l . ',' . $lll1111llllll111l111lllll1l1l1l, $l1l11l1llll1llllll11l1llll1ll1l);
		if ($_W['isajax']) {
			include $this->template($l1lll1l1l11l11lllllll1lll11111l['template'] . "ajaxload");
			die;
		}
		if (!($ll1l1ll1l1l11ll11ll1111ll1111l1 = $this->l1l1lllllll111llll111l1ll111lll('indexcount' . $l1lll1l1l11l11lllllll1lll11111l['id']))) {
			$l1l1lllllllllllll1l1111l1ll111l = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xiaof_toupiao') . " WHERE `sid` = :sid", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id']));
			$l1l111ll1l11llllll11lllll1ll1l1 = pdo_fetchcolumn("SELECT SUM(click) FROM " . tablename('xiaof_toupiao') . " WHERE `sid` = :sid", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id']));
			$l1l111ll1l11llllll11lllll1ll1l1 = $l1lll1l1l11l11lllllll1lll11111l['click'] + $l1l111ll1l11llllll11lllll1ll1l1;
			empty($l1l111ll1l11llllll11lllll1ll1l1) && ($l1l111ll1l11llllll11lllll1ll1l1 = 0);
			$llllll11l1lll1l1l11111ll1lllll1 = pdo_fetchcolumn("SELECT SUM(good) FROM " . tablename('xiaof_toupiao') . " WHERE `sid` = :sid", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id']));
			empty($llllll11l1lll1l1l11111ll1lllll1) && ($llllll11l1lll1l1l11111ll1lllll1 = 0);
			$ll1l1ll1l1l11ll11ll1111ll1111l1 = array('good' => $l1l1lllllllllllll1l1111l1ll111l, 'click' => $l1l111ll1l11llllll11lllll1ll1l1, 'shares' => $llllll11l1lll1l1l11111ll1lllll1);
			$this->l11lll11ll1l1111llll11ll1l1l111('indexcount' . $l1lll1l1l11l11lllllll1lll11111l['id'], $ll1l1ll1l1l11ll11ll1111ll1111l1, 3);
		}
		$l1l1lllllllllllll1l1111l1ll111l = $ll1l1ll1l1l11ll11ll1111ll1111l1['good'];
		$l1l111ll1l11llllll11lllll1ll1l1 = $ll1l1ll1l1l11ll11ll1111ll1111l1['click'];
		$llllll11l1lll1l1l11111ll1lllll1 = $ll1l1ll1l1l11ll11ll1111ll1111l1['shares'];
		$ll1l1ll11ll1l1ll11ll1ll111l1111 = strtotime($l1lll1l1l11l11lllllll1lll11111l['pend']) - time();
		include $this->template($l1lll1l1l11l11lllllll1lll11111l['template'] . 'index');
	}
	public function doMobileTop()
	{
		global $_W, $_GPC;
		$this->lllll1l111lll11l111lllll11ll11l();
		$l1lll1l1l11l11lllllll1lll11111l = $this->l1l11ll11ll1l1111lll11lllll1l11();
		if (!($ll1l1ll1l1l11ll11ll1111ll1111l1 = $this->l1l1lllllll111llll111l1ll111lll('indexcount' . $l1lll1l1l11l11lllllll1lll11111l['id']))) {
			$l1l1lllllllllllll1l1111l1ll111l = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xiaof_toupiao') . " WHERE `sid` = :sid", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id']));
			$l1l111ll1l11llllll11lllll1ll1l1 = pdo_fetchcolumn("SELECT SUM(click) FROM " . tablename('xiaof_toupiao') . " WHERE `sid` = :sid", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id']));
			$l1l111ll1l11llllll11lllll1ll1l1 = $l1lll1l1l11l11lllllll1lll11111l['click'] + $l1l111ll1l11llllll11lllll1ll1l1;
			empty($l1l111ll1l11llllll11lllll1ll1l1) && ($l1l111ll1l11llllll11lllll1ll1l1 = 0);
			$llllll11l1lll1l1l11111ll1lllll1 = pdo_fetchcolumn("SELECT SUM(good) FROM " . tablename('xiaof_toupiao') . " WHERE `sid` = :sid", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id']));
			empty($llllll11l1lll1l1l11111ll1lllll1) && ($llllll11l1lll1l1l11111ll1lllll1 = 0);
			$ll1l1ll1l1l11ll11ll1111ll1111l1 = array('good' => $l1l1lllllllllllll1l1111l1ll111l, 'click' => $l1l111ll1l11llllll11lllll1ll1l1, 'shares' => $llllll11l1lll1l1l11111ll1lllll1);
			$this->l11lll11ll1l1111llll11ll1l1l111('indexcount' . $l1lll1l1l11l11lllllll1lll11111l['id'], $ll1l1ll1l1l11ll11ll1111ll1111l1, 3);
		}
		$l1l1lllllllllllll1l1111l1ll111l = $ll1l1ll1l1l11ll11ll1111ll1111l1['good'];
		$l1l111ll1l11llllll11lllll1ll1l1 = $ll1l1ll1l1l11ll11ll1111ll1111l1['click'];
		$llllll11l1lll1l1l11111ll1lllll1 = $ll1l1ll1l1l11ll11ll1111ll1111l1['shares'];
		$ll1l1ll11ll1l1ll11ll1ll111l1111 = strtotime($l1lll1l1l11l11lllllll1lll11111l['pend']) - time();
		$l1l1l1l1l1ll1ll1ll11llll11ll11l = ' WHERE `sid`=:sid ';
		$l1l11l1llll1llllll11l1llll1ll1l[':sid'] = intval($_GPC['sid']);
		if ($l1lll1l1l11l11lllllll1lll11111l['verify'] == 1) {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l .= ' AND `verify`=:verify';
			$l1l11l1llll1llllll11l1llll1ll1l[':verify'] = 1;
		} else {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l .= ' AND `verify`!=:verify';
			$l1l11l1llll1llllll11l1llll1ll1l[':verify'] = 2;
		}
		$l1l1l11lllll111ll111ll1111l11ll = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao') . $l1l1l1l1l1ll1ll1ll11llll11ll11l . " order by `good` desc limit 100", $l1l11l1llll1llllll11l1llll1ll1l);
		include $this->template($l1lll1l1l11l11lllllll1lll11111l['template'] . "top");
	}
	public function doMobileShow()
	{
		global $_W, $_GPC;
		$this->lllll1l111lll11l111lllll11ll11l();
		$l1lll1l1l11l11lllllll1lll11111l = $this->l1l11ll11ll1l1111lll11lllll1l11();
		if (!isset($_GPC['id'])) {
			$l111l111ll1l1111l1l1l11111l1lll = $this->l11l111l11l111l11l1ll1l1l11l1l1();
		} else {
			$l111l111ll1l1111l1l1l11111l1lll = pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao") . " WHERE `sid` = :sid AND `id` = :id", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id'], ":id" => intval($_GPC['id'])));
		}
		$l11ll1l1111lll1lll1l11ll11l1ll1 = pdo_fetch("SELECT (SELECT COUNT(*) FROM " . tablename("xiaof_toupiao") . " WHERE `sid`=k.sid AND `verify`!='2' AND k.good<good ) as top FROM " . tablename("xiaof_toupiao") . " as k WHERE `id` = :id", array(":id" => $l111l111ll1l1111l1l1l11111l1lll['id']));
		$l11ll1111l1111ll1l1lll11111ll1l = pdo_fetchcolumn("SELECT good FROM " . tablename("xiaof_toupiao") . " WHERE `sid` = :sid AND `verify`!='2' AND `good` > :good ORDER BY `good` ASC limit 1", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id'], ":good" => $l111l111ll1l1111l1l1l11111l1lll['good']));
		$lllll1lllll111111l1ll1ll111ll1l = pdo_fetchcolumn("SELECT good FROM " . tablename("xiaof_toupiao") . " WHERE `sid` = :sid AND `verify`!='2' AND `good` < :good ORDER BY `good` DESC limit 1", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id'], ":good" => $l111l111ll1l1111l1l1l11111l1lll['good']));
		$ll1llllll1l111ll111l111l111111l = pdo_fetch("SELECT (SELECT COUNT(*) FROM " . tablename("xiaof_toupiao") . " WHERE `sid`=k.sid AND `verify`!='2' AND `good`=k.good AND `id`<k.id) as top FROM " . tablename("xiaof_toupiao") . " as k WHERE `id` = :id", array(":id" => $l111l111ll1l1111l1l1l11111l1lll['id']));
		$llll11111l111llll1llll111lll11l = $l11ll1l1111lll1lll1l11ll11l1ll1['top'] + 1 + $ll1llllll1l111ll111l111l111111l['top'];
		$llll1l11ll1111l11l111ll1lll1111 = $l111l111ll1l1111l1l1l11111l1lll['good'] - $lllll1lllll111111l1ll1ll111ll1l;
		$ll11lll11l1l11l11llll11ll1111ll = $l11ll1111l1111ll1l1lll11111ll1l - $l111l111ll1l1111l1l1l11111l1lll['good'];
		if (!$l11ll1111l1111ll1l1lll11111ll1l) {
			$ll11lll11l1l11l11llll11ll1111ll = 0;
		}
		$ll11l11l1111l1ll1llll11111l11ll = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_pic') . " WHERE `pid` = :pid", array(":pid" => $l111l111ll1l1111l1l1l11111l1lll['id']));
		if (intval($l1lll1l1l11l11lllllll1lll11111l['openposter']) == 1 && empty($l111l111ll1l1111l1l1l11111l1lll['poster'])) {
			$l111l111ll1l1111l1l1l11111l1lll['poster'] = $l111l11111l11lll1lllll1l1ll1ll1 = $this->l1ll11l1l11111lll1l11111l111l1l($l111l111ll1l1111l1l1l11111l1lll['name'], $l111l111ll1l1111l1l1l11111l1lll['uid'], tomedia($ll11l11l1111l1ll1llll11111l11ll[0]['url']), urlencode($this->ll11ll1l1l11l11ll11llll1l1ll11l('show', 'xiaof_toupiao', '&id=' . $l111l111ll1l1111l1l1l11111l1lll['id'] . '')));
			pdo_update("xiaof_toupiao", array("poster" => $l111l11111l11lll1lllll1l1ll1ll1), array("id" => $l111l111ll1l1111l1l1l11111l1lll['id']));
		}
		if ($l1lll1l1l11l11lllllll1lll11111l['openvoteuser'] == 1) {
			$l111lllll11ll111ll1ll111lll1lll = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_log') . " WHERE `pid` = '" . $l111l111ll1l1111l1l1l11111l1lll['id'] . "' AND `avatar` != '' order by `id` desc LIMIT 6");
		}
		if (intval($l1lll1l1l11l11lllllll1lll11111l['opendraw']) == 1) {
			load()->model('mc');
			if ($l11l1l1l1l1111l1l1lllll1111l11l = $this->l111l111111lllll1111l11ll1l111l()) {
				$l1l1111lll1l111l11l1l11llll1111 = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_drawlog') . " WHERE `sid` = :sid AND `pid` = :pid ORDER BY `id` DESC limit 10", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id'], ":pid" => $l111l111ll1l1111l1l1l11111l1lll['id']));
				$l11llll1lll111l1lll1l1ll1l11lll = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('xiaof_toupiao_draw') . " WHERE `sid`=:sid AND `uid`=:uid AND `uses`='2' AND `attr`=:attr", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id'], ":uid" => $l11l1l1l1l1111l1l1lllll1111l11l, ":attr" => 3));
				$ll1111l1ll11ll1l1ll111l11ll1ll1 = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('xiaof_toupiao_draw') . " WHERE `sid`=:sid AND `uid`=:uid AND `uses`='2' AND `attr`=:attr", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id'], ":uid" => $l11l1l1l1l1111l1l1lllll1111l11l, ":attr" => 4));
				$l1llllll1lll1llll1ll111111l11l1 = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('xiaof_toupiao_draw') . " WHERE `sid`=:sid AND `uid`=:uid AND `uses`='2' AND `attr`=:attr", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id'], ":uid" => $l11l1l1l1l1111l1l1lllll1111l11l, ":attr" => 5));
				$ll1ll1ll1l111llllll11lllll1llll = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('xiaof_toupiao_draw') . " WHERE `sid`=:sid AND `uid`=:uid AND `uses`='2' AND `attr`=:attr", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id'], ":uid" => $l11l1l1l1l1111l1l1lllll1111l11l, ":attr" => 6));
			}
		}
		if (empty($l1lll1l1l11l11lllllll1lll11111l['mysharetitle'])) {
			$llll111ll11l11lll1111111ll1111l = '我参加了' . $l1lll1l1l11l11lllllll1lll11111l['title'] . '-' . $l111l111ll1l1111l1l1l11111l1lll['uid'] . '号-' . $l111l111ll1l1111l1l1l11111l1lll['name'] . '，请大家多多支持';
		} else {
			$l1ll11111l1ll11l11l1ll1ll111111 = isset($l1lll1l1l11l11lllllll1lll11111l['groups'][$l111l111ll1l1111l1l1l11111l1lll['groups']]) ? $l1ll11111l1ll11l11l1ll1ll111111 = $l1lll1l1l11l11lllllll1lll11111l['groups'][$l111l111ll1l1111l1l1l11111l1lll['groups']]['name'] : '';
			$llll111ll11l11lll1111111ll1111l = str_replace(array('{title}', '{group}', '{uid}', '{name}'), array($l1lll1l1l11l11lllllll1lll11111l['title'], $l1ll11111l1ll11l11l1ll1ll111111, $l111l111ll1l1111l1l1l11111l1lll['uid'], $l111l111ll1l1111l1l1l11111l1lll['name']), $l1lll1l1l11l11lllllll1lll11111l['mysharetitle']);
		}
		$l111l111ll1l1111l1l1l11111l1lll['data'] = iunserializer($l111l111ll1l1111l1l1l11111l1lll['data']);
		$lllllllllll11l11lllll111l1llll1 = array();
		if (is_array($l1lll1l1l11l11lllllll1lll11111l['joinfield'])) {
			foreach ($l1lll1l1l11l11lllllll1lll11111l['joinfield'] as $l1ll1ll1l11ll11l111llll1l1111ll) {
				if ($l1ll1ll1l11ll11l111llll1l1111ll['isshow'] == 1) {
					$lllllllllll11l11lllll111l1llll1[] = array('name' => $l1ll1ll1l11ll11l111llll1l1111ll['name'], 'data' => $l111l111ll1l1111l1l1l11111l1lll['data'][$l1ll1ll1l11ll11l111llll1l1111ll['sign']]);
				}
			}
		}
		include $this->template($l1lll1l1l11l11lllllll1lll11111l['template'] . "show");
	}
	public function doMobileDetail()
	{
		global $_W, $_GPC;
		$this->lllll1l111lll11l111lllll11ll11l();
		$l1lll1l1l11l11lllllll1lll11111l = $this->l1l11ll11ll1l1111lll11lllll1l11();
		if (!($ll1l1ll1l1l11ll11ll1111ll1111l1 = $this->l1l1lllllll111llll111l1ll111lll('indexcount' . $l1lll1l1l11l11lllllll1lll11111l['id']))) {
			$l1l1lllllllllllll1l1111l1ll111l = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xiaof_toupiao') . " WHERE `sid` = :sid", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id']));
			$l1l111ll1l11llllll11lllll1ll1l1 = pdo_fetchcolumn("SELECT SUM(click) FROM " . tablename('xiaof_toupiao') . " WHERE `sid` = :sid", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id']));
			$l1l111ll1l11llllll11lllll1ll1l1 = $l1lll1l1l11l11lllllll1lll11111l['click'] + $l1l111ll1l11llllll11lllll1ll1l1;
			empty($l1l111ll1l11llllll11lllll1ll1l1) && ($l1l111ll1l11llllll11lllll1ll1l1 = 0);
			$llllll11l1lll1l1l11111ll1lllll1 = pdo_fetchcolumn("SELECT SUM(good) FROM " . tablename('xiaof_toupiao') . " WHERE `sid` = :sid", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id']));
			empty($llllll11l1lll1l1l11111ll1lllll1) && ($llllll11l1lll1l1l11111ll1lllll1 = 0);
			$ll1l1ll1l1l11ll11ll1111ll1111l1 = array('good' => $l1l1lllllllllllll1l1111l1ll111l, 'click' => $l1l111ll1l11llllll11lllll1ll1l1, 'shares' => $llllll11l1lll1l1l11111ll1lllll1);
			$this->l11lll11ll1l1111llll11ll1l1l111('indexcount' . $l1lll1l1l11l11lllllll1lll11111l['id'], $ll1l1ll1l1l11ll11ll1111ll1111l1, 3);
		}
		$l1l1lllllllllllll1l1111l1ll111l = $ll1l1ll1l1l11ll11ll1111ll1111l1['good'];
		$l1l111ll1l11llllll11lllll1ll1l1 = $ll1l1ll1l1l11ll11ll1111ll1111l1['click'];
		$llllll11l1lll1l1l11111ll1lllll1 = $ll1l1ll1l1l11ll11ll1111ll1111l1['shares'];
		$ll1l1ll11ll1l1ll11ll1ll111l1111 = strtotime($l1lll1l1l11l11lllllll1lll11111l['pend']) - time();
		$ll1ll1lll1ll11ll1ll1l1l1l111111 = pdo_fetchcolumn("SELECT `detail` FROM " . tablename("xiaof_toupiao_setting") . " WHERE `id` = :id", array(":id" => $l1lll1l1l11l11lllllll1lll11111l['id']));
		$ll1ll1lll1ll11ll1ll1l1l1l111111 = iunserializer($ll1ll1lll1ll11ll1ll1l1l1l111111);
		empty($l1lll1l1l11l11lllllll1lll11111l['noticecontent']) or $ll1ll1lll1ll11ll1ll1l1l1l111111['noticecontent'] = $l1lll1l1l11l11lllllll1lll11111l['noticecontent'];
		empty($l1lll1l1l11l11lllllll1lll11111l['detail']) or $ll1ll1lll1ll11ll1ll1l1l1l111111['detail'] = $l1lll1l1l11l11lllllll1lll11111l['detail'];
		empty($l1lll1l1l11l11lllllll1lll11111l['rules']) or $ll1ll1lll1ll11ll1ll1l1l1l111111['rules'] = $l1lll1l1l11l11lllllll1lll11111l['rules'];
		include $this->template($l1lll1l1l11l11lllllll1lll11111l['template'] . "detail");
	}
	public function doMobileJoin()
	{
		global $_W, $_GPC;
		$this->lllll1l111lll11l111lllll11ll11l();
		$l1lll1l1l11l11lllllll1lll11111l = $this->l1l11ll11ll1l1111lll11lllll1l11();
		$l11lll1l1llll11lll1l1l1111l111l = $this->l11l111l11l111l11l1ll1l1l11l1l1();
		if (isset($l11lll1l1llll11lll1l1l1111l111l['id'])) {
			$ll11l11l1111l1ll1llll11111l11ll = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_pic') . " WHERE `pid` = :pid", array(":pid" => $l11lll1l1llll11lll1l1l1111l111l['id']));
			$l11lll1l1llll11lll1l1l1111l111l['data'] = iunserializer($l11lll1l1llll11lll1l1l1111l111l['data']);
		}
		include $this->template($l1lll1l1l11l11lllllll1lll11111l['template'] . "join");
	}
	public function doMobileCreditdraw()
	{
		global $_W, $_GPC;
		$this->lllll1l111lll11l111lllll11ll11l();
		$l1lll1l1l11l11lllllll1lll11111l = $this->l1l11ll11ll1l1111lll11lllll1l11();
		load()->model('mc');
		$l11l1l1l1l1111l1l1lllll1111l11l = $this->l111l111111lllll1111l11ll1l111l();
		$lllll1l1l111l111111l1111lll11l1['credit1'] = 0;
		if (!($ll1l1ll1l1l11ll11ll1111ll1111l1 = $this->l1l1lllllll111llll111l1ll111lll('indexcount' . $l1lll1l1l11l11lllllll1lll11111l['id']))) {
			$l1l1lllllllllllll1l1111l1ll111l = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xiaof_toupiao') . " WHERE `sid` = :sid", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id']));
			$l1l111ll1l11llllll11lllll1ll1l1 = pdo_fetchcolumn("SELECT SUM(click) FROM " . tablename('xiaof_toupiao') . " WHERE `sid` = :sid", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id']));
			$l1l111ll1l11llllll11lllll1ll1l1 = $l1lll1l1l11l11lllllll1lll11111l['click'] + $l1l111ll1l11llllll11lllll1ll1l1;
			empty($l1l111ll1l11llllll11lllll1ll1l1) && ($l1l111ll1l11llllll11lllll1ll1l1 = 0);
			$llllll11l1lll1l1l11111ll1lllll1 = pdo_fetchcolumn("SELECT SUM(good) FROM " . tablename('xiaof_toupiao') . " WHERE `sid` = :sid", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id']));
			empty($llllll11l1lll1l1l11111ll1lllll1) && ($llllll11l1lll1l1l11111ll1lllll1 = 0);
			$ll1l1ll1l1l11ll11ll1111ll1111l1 = array('good' => $l1l1lllllllllllll1l1111l1ll111l, 'click' => $l1l111ll1l11llllll11lllll1ll1l1, 'shares' => $llllll11l1lll1l1l11111ll1lllll1);
			$this->l11lll11ll1l1111llll11ll1l1l111('indexcount' . $l1lll1l1l11l11lllllll1lll11111l['id'], $ll1l1ll1l1l11ll11ll1111ll1111l1, 3);
		}
		$l1l1lllllllllllll1l1111l1ll111l = $ll1l1ll1l1l11ll11ll1111ll1111l1['good'];
		$l1l111ll1l11llllll11lllll1ll1l1 = $ll1l1ll1l1l11ll11ll1111ll1111l1['click'];
		$llllll11l1lll1l1l11111ll1lllll1 = $ll1l1ll1l1l11ll11ll1111ll1111l1['shares'];
		$ll1l1ll11ll1l1ll11ll1ll111l1111 = strtotime($l1lll1l1l11l11lllllll1lll11111l['pend']) - time();
		$llll11l111lllllllllll1l1l111l11 = $l1lll1l1l11l11lllllll1lll11111l['prize'];
		if (!empty($l11l1l1l1l1111l1l1lllll1111l11l)) {
			$lllll1l1l111l111111l1111lll11l1 = mc_credit_fetch($l11l1l1l1l1111l1l1lllll1111l11l);
			$ll11l11l1111l1ll1llll11111l11ll = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_draw') . " WHERE `sid` = :sid AND `uid` = :uid ORDER BY `id` DESC limit 10", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id'], ":uid" => $l11l1l1l1l1111l1l1lllll1111l11l));
		}
		include $this->template($l1lll1l1l11l11lllllll1lll11111l['template'] . "credit");
	}
	public function doMobileDrawlist()
	{
		global $_W, $_GPC;
		$this->lllll1l111lll11l111lllll11ll11l();
		$l1lll1l1l11l11lllllll1lll11111l = $this->l1l11ll11ll1l1111lll11lllll1l11();
		load()->model('mc');
		$l11l1l1l1l1111l1l1lllll1111l11l = $this->l111l111111lllll1111l11ll1l111l();
		if ($l11l11lll1l1l111ll1ll11lll1l11l = $this->l1l11l1111l111ll11l111ll1l1lll1('rid')) {
			$l111l1l1l1lll1lll1lllll1ll1ll1l = pdo_fetchcolumn("SELECT `address` FROM " . tablename('xiaof_relation') . " WHERE `id` = :id", array(":id" => $l11l11lll1l1l111ll1ll11lll1l11l));
			$l111l1l1l1lll1lll1lllll1ll1ll1l = iunserializer($l111l1l1l1lll1lll1lllll1ll1ll1l);
		}
		if ($_W['isajax']) {
			if ($_W['ispost'] && (empty($l111l1l1l1lll1lll1lllll1ll1ll1l['phone']) or empty($l111l1l1l1lll1lll1lllll1ll1ll1l['addrs']))) {
				$l1lll1111ll11ll1lll1l11lll11lll = istrlen($_GPC['addrs']);
				$l1l1lll1llll1l11lllll1ll11l1ll1 = istrlen($_GPC['name']);
				if ($l1lll1111ll11ll1lll1l11lll11lll < 5 or $l1lll1111ll11ll1lll1l11lll11lll >= 150) {
					die(json_encode(error(102, '收货地址长度为5-150字')));
				} elseif ($l1l1lll1llll1l11lllll1ll11l1ll1 < 1 or $l1l1lll1llll1l11lllll1ll11l1ll1 >= 5) {
					die(json_encode(error(103, '收货姓名长度为1-5字')));
				} elseif (!preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $_GPC['phone'])) {
					die(json_encode(error(101, '不是正确手机号')));
				} elseif ($l11l11lll1l1l111ll1ll11lll1l11l) {
					$l111l1l1l1lll1lll1lllll1ll1ll1l = array('name' => $_GPC['name'], 'phone' => $_GPC['phone'], 'addrs' => $_GPC['addrs']);
					$lll1111l1l1l1ll11111111l1lll11l = array('address' => iserializer($l111l1l1l1lll1lll1lllll1ll1ll1l));
					pdo_update("xiaof_relation", $lll1111l1l1l1ll11111111l1lll11l, array("id" => $l11l11lll1l1l111ll1ll11lll1l11l));
				}
				die(json_encode(error(0, '成功')));
			}
		}
		$l1l1l1l1l1ll1ll1ll11llll11ll11l = '';
		if (!empty($_GPC['type'])) {
			$l1l1l1l1l1ll1ll1ll11llll11ll11l = "AND `uses` = '" . intval($_GPC['type']) . "'";
		}
		$ll1l1ll1l111lllll111111l111111l = max(1, intval($_GPC['page']));
		$lll1111llllll111l111lllll1l1l1l = 12;
		$ll1l1ll1111l11111l11111ll1ll11l = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xiaof_toupiao_draw') . " WHERE `uid` = '" . $l11l1l1l1l1111l1l1lllll1111l11l . "' AND `attr` = '1' " . $l1l1l1l1l1ll1ll1ll11llll11ll11l . "");
		$l11111l11ll11llll111ll111l1ll11 = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_draw') . " WHERE `uid` = '" . $l11l1l1l1l1111l1l1lllll1111l11l . "' AND `attr` = '1' " . $l1l1l1l1l1ll1ll1ll11llll11ll11l . " ORDER BY `id` DESC LIMIT " . ($ll1l1ll1l111lllll111111l111111l - 1) * $lll1111llllll111l111lllll1l1l1l . ',' . $lll1111llllll111l111lllll1l1l1l);
		foreach ($l11111l11ll11llll111ll111l1ll11 as &$ll1lll11llll11lllllll11ll1l11l1) {
			$ll1lll11llll11lllllll11ll1l11l1['pic'] = $l1lll1l1l11l11lllllll1lll11111l['prize'][$ll1lll11llll11lllllll11ll1l11l1['prizeid']]['pic'];
			$ll1lll11llll11lllllll11ll1l11l1['pic'] = empty($ll1lll11llll11lllllll11ll1l11l1['pic']) ? MODULE_URL . "template/mobile/picture/tpzq.jpg" : tomedia($ll1lll11llll11lllllll11ll1l11l1['pic']);
		}
		$ll11l1111l1llll1llll1l1l1l111l1 = pagination($ll1l1ll1111l11111l11111ll1ll11l, $ll1l1ll1l111lllll111111l111111l, $lll1111llllll111l111lllll1l1l1l);
		include $this->template($l1lll1l1l11l11lllllll1lll11111l['template'] . "drawlist");
	}
	public function doMobileSave()
	{
		global $_W, $_GPC;
		if ($_W['container'] !== "wechat") {
			die(json_encode(error(101, '请在您的微信里打开本页面参与报名')));
		}
		if (!($l1lll1l1l11l11lllllll1lll11111l = $this->l1l11ll11ll1l1111lll11lllll1l11())) {
			die(json_encode(error(101, '报名失败,没有找到要参与的活动')));
		}
		if (time() <= strtotime($l1lll1l1l11l11lllllll1lll11111l['joinstart'])) {
			die(json_encode(error(101, '活动报名未开始，请开始后再参加，开始时间' . $l1lll1l1l11l11lllllll1lll11111l['joinstart'] . '')));
		}
		if (time() >= strtotime($l1lll1l1l11l11lllllll1lll11111l['joinend'])) {
			die(json_encode(error(101, '活动报名已结束，敬请期待下次活动')));
		}
		if ($l1lll1l1l11l11lllllll1lll11111l['joinfollow'] == 1 && !$this->l1ll111l1lll1l1lll11l1l1ll1111l()) {
			$lll1lll111llll1l1ll1ll1l1l111ll = empty($l1lll1l1l11l11lllllll1lll11111l['followjointext']) ? '' : '<p style="text-align:center;">' . $l1lll1l1l11l11lllllll1lll11111l['followjointext'] . '</p>';
			$lll1ll111l1l111ll11ll1llllllll1 = empty($l1lll1l1l11l11lllllll1lll11111l['template']) ? 'playVoice("' . tomedia($l1lll1l1l11l11lllllll1lll11111l['followvoice']) . '");' : 'require(["main"], function(xiaoftoupiao){xiaoftoupiao.playVoice("' . tomedia($l1lll1l1l11l11lllllll1lll11111l['followvoice']) . '")})';
			$l1111111l111l11llll111l1l1lll11 = empty($l1lll1l1l11l11lllllll1lll11111l['followtipstype']) ? '<img width="100%" src="' . tomedia($l1lll1l1l11l11lllllll1lll11111l['accountqrcode']) . '"/>' : '<div class="play-voice"><img class="voice-on" src="' . MODULE_URL . 'template/mobile/xiaofweui/picture/ms.png"/><img class="voice-off" src="' . MODULE_URL . 'template/mobile/xiaofweui/picture/mp.png"/></div><script type="text/javascript">' . $lll1ll111l1l111ll11ll1llllllll1 . '</script>';
			die(json_encode(error(101, $lll1lll111llll1l1ll1ll1l1l111ll . $l1111111l111l11llll111l1l1lll11)));
		}
		if (empty($_W['openid'])) {
			die(json_encode(error(101, '错误，没有获取到微信信息')));
		}
		if ($_W['isajax']) {
			$l111l111llll1lll11111111lll1l11 = count($_GPC['pics']);
			$ll1lll1lllll1ll1ll11l11lllllll1 = empty($l1lll1l1l11l11lllllll1lll11111l['limitpic']) ? 5 : intval($l1lll1l1l11l11lllllll1lll11111l['limitpic']);
			if ($l111l111llll1lll11111111lll1l11 <= 0) {
				die(json_encode(error(102, '报名失败,没有收到照片')));
			} elseif ($l111l111llll1lll11111111lll1l11 > $ll1lll1lllll1ll1ll11l11lllllll1) {
				die(json_encode(error(102, '报名失败,照片只允许1-' . $ll1lll1lllll1ll1ll11l11lllllll1 . '张')));
			}
			load()->func('file');
			$ll11lll1ll1lll11l1l1l11ll1lll11 = array();
			foreach ($l1lll1l1l11l11lllllll1lll11111l['joinfield'] as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
				if (empty($_GPC[$l1ll1ll1l11ll11l111llll1l1111ll['sign']])) {
					if (empty($l1ll1ll1l11ll11l111llll1l1111ll['isnull'])) {
						die(json_encode(error(103, $l1ll1ll1l11ll11l111llll1l1111ll['name'] . '项不能为空')));
					}
					continue;
				}
				$ll11lll1ll1lll11l1l1l11ll1lll11[$l1ll1ll1l11ll11l111llll1l1111ll['sign']] = $_GPC[$l1ll1ll1l11ll11l111llll1l1111ll['sign']];
			}
			if (empty($_GPC['pid'])) {
				if ($_GPC['name'] == "") {
					die(json_encode(error(103, '名称不能为空！')));
				}
				$l1l1lll1llll1l11lllll1ll11l1ll1 = istrlen($_GPC['name']);
				if ($l1l1lll1llll1l11lllll1ll11l1ll1 >= 10 or $l1l1lll1llll1l11lllll1ll11l1ll1 < 1) {
					die(json_encode(error(103, '名称长度不合法')));
				}
				if (pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao") . " WHERE `sid` = :sid AND `phone` = :phone", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id'], ":phone" => $_GPC['phone']))) {
					die(json_encode(error(104, '报名失败,一个手机号只能参加一次')));
				}
				if ($this->l11l111l11l111l11l1ll1l1l11l1l1() != false) {
					die(json_encode(error(104, '报名失败,一个微信号只能参加一次')));
				}
				krsort($_GPC['pics']);
				$l1lll1111l1l1l1ll1lll1ll1l111l1 = 0;
				$l1ll1lll1lll1l1l111ll11llll11l1 = '';
				if (!empty($l1lll1l1l11l11lllllll1lll11111l['newjoindouble'])) {
					$lll1ll111l1l1l111ll1111l1llll11 = intval($l1lll1l1l11l11lllllll1lll11111l['newjoindouble']) * 60;
					$l1lll1111l1l1l1ll1lll1ll1l111l1 = strtotime("+" . $lll1ll111l1l1l111ll1111l1llll11 . " minute");
					$l1ll1lll1lll1l1l111ll11llll11l1 = '。当前新报名享双倍投票时间' . intval($l1lll1l1l11l11lllllll1lll11111l['newjoindouble']) . '小时，双倍期间被投票1票等于2票！';
				}
				$l1l1l1l1ll111l11l1l1l1111ll1lll = $this->lllll1l1lll1l1l1111lll1l1ll11ll(reset($_GPC['pics']), 240);
				$ll11lll1111l11l1ll1ll1ll111l11l = array("sid" => $l1lll1l1l11l11lllllll1lll11111l['id'], "ip" => ip2long(CLIENT_IP), "nickname" => $this->l1l11l1111l111ll11l111ll1l1lll1('nickname'), "avatar" => $this->l1l11l1111l111ll11l111ll1l1lll1('avatar'), "pic" => $l1l1l1l1ll111l11l1l1l1111ll1lll, "sound" => $_GPC['sound'], "phone" => $_GPC['phone'], "name" => $_GPC['name'], "describe" => preg_replace("#\s#is", '', $_GPC['describe']), "created_at" => time(), "double_at" => $l1lll1111l1l1l1ll1lll1ll1l111l1, "updated_at" => time());
				$ll11lll1111l11l1ll1ll1ll111l11l['data'] = iserializer($ll11lll1ll1lll11l1l1l11ll1lll11);
				if ($l1lll1l1l11l11lllllll1lll11111l['opengroups'] >= 1) {
					$ll11lll1111l11l1ll1ll1ll111l11l['groups'] = intval($_GPC['groups']);
				}
				$l1ll11llll111lllll1ll1ll1l1l111 = $this->l1l11l1111l111ll11l111ll1l1lll1('openid');
				$ll11lll1111l11l1ll1ll1ll111l11l['openid'] = $l1ll11llll111lllll1ll1ll1l1l111;
				if (empty($l1lll1l1l11l11lllllll1lll11111l['joinfollow']) && empty($l1ll11llll111lllll1ll1ll1l1l111)) {
					$ll11lll1111l11l1ll1ll1ll111l11l['openid'] = $_W['openid'];
				}
				pdo_query("LOCK TABLES " . tablename("xiaof_toupiao") . " WRITE");
				if (!($l1l111l1l1l1l1l11l111lllllll1l1 = pdo_fetchcolumn("SELECT `uid` FROM " . tablename("xiaof_toupiao") . " WHERE `sid` = :sid ORDER BY `id` DESC limit 1", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id'])))) {
					$l1l111l1l1l1l1l11l111lllllll1l1 = 0;
				}
				$ll11lll1111l11l1ll1ll1ll111l11l['uid'] = $l1l111l1l1l1l1l11l111lllllll1l1 + 1;
				pdo_insert("xiaof_toupiao", $ll11lll1111l11l1ll1ll1ll111l11l);
				$l11ll111111l1ll111l1lll1l1l11ll = pdo_insertid();
				pdo_query("UNLOCK TABLES");
				foreach ($_GPC['pics'] as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
					$l1l11l1ll1l11l1l111l111lll1ll11 = $this->lllll1l1lll1l1l1111lll1l1ll11ll($l1ll1ll1l11ll11l111llll1l1111ll);
					pdo_insert("xiaof_toupiao_pic", array("sid" => $l1lll1l1l11l11lllllll1lll11111l['id'], "pid" => $l11ll111111l1ll111l1lll1l1l11ll, "url" => $l1ll1ll1l11ll11l111llll1l1111ll, "thumb" => $l1l11l1ll1l11l1l111l111lll1ll11, "created_at" => time()));
				}
				if (intval($l1lll1l1l11l11lllllll1lll11111l['opencredit']) >= 1 && intval($l1lll1l1l11l11lllllll1lll11111l['joincredit']) >= 1) {
					load()->model('mc');
					if ($l11l1l1l1l1111l1l1lllll1111l11l = $this->l111l111111lllll1111l11ll1l111l()) {
						$ll1l1ll1ll11l1l1l11llllllll1l11 = mc_credit_update($l11l1l1l1l1111l1l1lllll1111l11l, 'credit1', intval($l1lll1l1l11l11lllllll1lll11111l['joincredit']), array(1, $l1lll1l1l11l11lllllll1lll11111l['title'] . '报名赠送积分', 'system'));
						if (!is_error($ll1l1ll1ll11l1l1l11llllllll1l11) && intval($l1lll1l1l11l11lllllll1lll11111l['creditnotice']) >= 1) {
							if ($_W['account']['level'] >= 3) {
								mc_notice_credit1($this->l1l11l1111l111ll11l111ll1l1lll1('openid'), $l11l1l1l1l1111l1l1lllll1111l11l, intval($l1lll1l1l11l11lllllll1lll11111l['joincredit']), $l1lll1l1l11l11lllllll1lll11111l['title'] . '报名赠送积分', '', '谢谢参与');
							}
						}
					}
				}
				if (!empty($l1lll1l1l11l11lllllll1lll11111l['adminopenid'])) {
					$this->ll11l1l111ll11l11llll111l1l1ll1($l1lll1l1l11l11lllllll1lll11111l['adminopenid'], "有新用户报名了，名称：" . $_GPC['name'] . "。<a href='" . $this->ll11ll1l1l11l11ll11llll1l1ll11l('show', 'xiaof_toupiao', '&id=' . $l11ll111111l1ll111l1lll1l1l11ll . '') . "'>点击查看</a>", $l1lll1l1l11l11lllllll1lll11111l['uniacid']);
				}
				if ($l1lll1l1l11l11lllllll1lll11111l['verify'] == 1) {
					$lll1l1l11l1l11l1lllllllll1ll11l = '报名资料已上传，请等待审核';
				} else {
					$lll1l1l11l1l11l1lllllllll1ll11l = '报名成功' . $l1ll1lll1lll1l1l111ll11llll11l1;
				}
			} else {
				$l11ll111111l1ll111l1lll1l1l11ll = intval($_GPC['pid']);
				if ($llll1lllll1l1l1111ll1ll1ll11ll1 = pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao") . " WHERE `id` = :id", array(":id" => $l11ll111111l1ll111l1lll1l1l11ll))) {
					if ($llll1lllll1l1l1111ll1ll1ll11ll1['verify'] == 2) {
						die(json_encode(error(105, '之前报名资料审核未通过，如需修改资料请联系客服')));
					}
				} else {
					die(json_encode(error(104, '修改失败，没有找到您的报名信息')));
				}
				$l11l1llll1ll1l11l11111ll1111l1l = 0;
				if ($l1lll1l1l11l11lllllll1lll11111l['opengroups'] >= 1) {
					$l11l1llll1ll1l11l11111ll1111l1l = intval($_GPC['groups']);
				}
				pdo_update("xiaof_toupiao", array("verify" => 0, "groups" => $l11l1llll1ll1l11l11111ll1111l1l, "sound" => $_GPC['sound'], "pic" => $this->lllll1l1lll1l1l1111lll1l1ll11ll(reset($_GPC['pics']), 240), "describe" => preg_replace("#\s#is", '', $_GPC['describe']), "data" => iserializer($ll11lll1ll1lll11l1l1l11ll1lll11)), array("id" => $l11ll111111l1ll111l1lll1l1l11ll));
				$ll11l11l1111l1ll1llll11111l11ll = pdo_fetchall("SELECT `url` FROM " . tablename('xiaof_toupiao_pic') . " WHERE `pid` = :pid", array(":pid" => $l11ll111111l1ll111l1lll1l1l11ll));
				$l11lll1l1llll11lll1l1l1111l111l = array();
				foreach ($ll11l11l1111l1ll1llll11111l11ll as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
					$l11lll1l1llll11lll1l1l1111l111l['pics'][] = $l1ll1ll1l11ll11l111llll1l1111ll['url'];
				}
				if ($_GPC['pics'] !== $l11lll1l1llll11lll1l1l1111l111l['pics']) {
					pdo_delete('xiaof_toupiao_pic', array('pid' => $l11ll111111l1ll111l1lll1l1l11ll));
					foreach ($_GPC['pics'] as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
						$l1l11l1ll1l11l1l111l111lll1ll11 = $this->lllll1l1lll1l1l1111lll1l1ll11ll($l1ll1ll1l11ll11l111llll1l1111ll);
						pdo_insert("xiaof_toupiao_pic", array("sid" => $l1lll1l1l11l11lllllll1lll11111l['id'], "pid" => $l11ll111111l1ll111l1lll1l1l11ll, "url" => $l1ll1ll1l11ll11l111llll1l1111ll, "thumb" => $l1l11l1ll1l11l1l111l111lll1ll11, "created_at" => time()));
					}
				}
				if ($l1lll1l1l11l11lllllll1lll11111l['verify'] == 1) {
					$lll1l1l11l1l11l1lllllllll1ll11l = '资料已上传，请等待审核';
				} else {
					$lll1l1l11l1l11l1lllllllll1ll11l = '资料修改成功';
				}
			}
			if (intval($l1lll1l1l11l11lllllll1lll11111l['openposter']) == 1 && ($ll1l1ll1ll111lllll11l111l1l11ll = pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao") . " WHERE `id` = :id LIMIT 1", array(":id" => intval($l11ll111111l1ll111l1lll1l1l11ll))))) {
				$l111l11111l11lll1lllll1l1ll1ll1 = $this->l1ll11l1l11111lll1l11111l111l1l($ll1l1ll1ll111lllll11l111l1l11ll['name'], $ll1l1ll1ll111lllll11l111l1l11ll['uid'], tomedia(reset($_GPC['pics'])), urlencode($this->ll11ll1l1l11l11ll11llll1l1ll11l('show', 'xiaof_toupiao', '&id=' . $ll1l1ll1ll111lllll11l111l1l11ll['id'] . '')));
				pdo_update("xiaof_toupiao", array("poster" => $l111l11111l11lll1lllll1l1ll1ll1), array("id" => $ll1l1ll1ll111lllll11l111l1l11ll['id']));
			}
			die(json_encode(error(0, $lll1l1l11l1l11l1lllllllll1ll11l)));
		}
	}
	public function doMobileVote()
	{
		global $_W, $_GPC;
		if (!($l1lll1l1l11l11lllllll1lll11111l = $this->l1l11ll11ll1l1111lll11lllll1l11())) {
			die(json_encode(error(101, '投票失败,没有找到要参与的活动')));
		}
		if (time() <= strtotime($l1lll1l1l11l11lllllll1lll11111l['start'])) {
			die(json_encode(error(101, '活动未开始，请开始后再投票，开始时间' . $l1lll1l1l11l11lllllll1lll11111l['start'] . '')));
		}
		if (time() >= strtotime($l1lll1l1l11l11lllllll1lll11111l['end'])) {
			die(json_encode(error(101, '活动已结束，敬请期待下次活动')));
		}
		if (empty($_GPC['id']) or empty($_GPC['type'])) {
			die(json_encode(error(102, '参数错误')));
		}
		if (!($l11lll1l1llll11lll1l1l1111l111l = pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao") . " WHERE `sid` = :sid AND `id` = :id limit 1", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id'], ":id" => intval($_GPC['id']))))) {
			die(json_encode(error(108, '没有找到选手')));
		}
		switch ($_GPC['type']) {
			case 'good':
				$l1lll11ll1l11l1llllllll1l111ll1 = '';
				if (count($l1lll1l1l11l11lllllll1lll11111l['advotepic']) >= 1) {
					$l1lll11ll1l11l1llllllll1l111ll1 = '<br/><div class="acid-lists"><ul class="swiper-wrapper">';
					foreach ($l1lll1l1l11l11lllllll1lll11111l['advotepic'] as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
						if (isset($l1lll1l1l11l11lllllll1lll11111l['advotelinkarr'][$l1l1l11l11l11111l1l11lll11l1ll1])) {
							$l1lll11ll1l11l1llllllll1l111ll1 .= '<li class="acid-swiper-slide swiper-slide"><a href="' . $l1lll1l1l11l11lllllll1lll11111l['advotelinkarr'][$l1l1l11l11l11111l1l11lll11l1ll1] . '"><img class="acid-qrcode" src="' . tomedia($l1ll1ll1l11ll11l111llll1l1111ll) . '"/></a></li>';
						} else {
							$l1lll11ll1l11l1llllllll1l111ll1 .= '<li class="acid-swiper-slide swiper-slide"><img class="acid-qrcode" src="' . tomedia($l1ll1ll1l11ll11l111llll1l1111ll) . '"/></li>';
						}
					}
					$l1lll11ll1l11l1llllllll1l111ll1 .= '</ul><div class="swiper-scrollbar"></div></div>';
				}
				if ($_W['container'] != "wechat") {
					die(json_encode(error(102, '请在您微信里打开本页面参与投票' . $l1lll11ll1l11l1llllllll1l111ll1)));
				}
				if ($l1lll1l1l11l11lllllll1lll11111l['verify'] == 1 && $l11lll1l1llll11lll1l1l1111l111l['verify'] != 1) {
					if ($l11lll1l1llll11lll1l1l1111l111l['verify'] == 0) {
						die(json_encode(error(109, '该选手作品正在审核，暂不接受投票' . $l1lll11ll1l11l1llllllll1l111ll1)));
					}
				}
				if ($l11lll1l1llll11lll1l1l1111l111l['verify'] == 2) {
					die(json_encode(error(110, '该选手作品审核未通过，不接受投票' . $l1lll11ll1l11l1llllllll1l111ll1)));
				}
				if (empty($_W['openid'])) {
					die(json_encode(error(101, '错误，没有获取到微信信息' . $l1lll11ll1l11l1llllllll1l111ll1)));
				}
				if ($l1lll1l1l11l11lllllll1lll11111l['joinendtime'] >= 1) {
					$l11llll111l1lll111lll11ll11ll11 = strtotime('+' . $l1lll1l1l11l11lllllll1lll11111l['joinendtime'] . ' day', $l11lll1l1llll11lll1l1l1111l111l['created_at']);
					if ($l11llll111l1lll111lll11ll11ll11 <= time()) {
						die(json_encode(error(101, '每位选手只有' . $l1lll1l1l11l11lllllll1lll11111l['joinendtime'] . '天投票时间,当前选手于' . date("Y-m-d H:i", $l11llll111l1lll111lll11ll11ll11) . '已截止投票。' . $l1lll11ll1l11l1llllllll1l111ll1)));
					}
				}
				if ($l1lll1l1l11l11lllllll1lll11111l['votefollow'] == 1 && !$this->l1ll111l1lll1l1lll11l1l1ll1111l()) {
					$ll1ll111lll1ll1111l11l1lll1l111 = empty($l1lll1l1l11l11lllllll1lll11111l['followvotetext']) ? '' : '<p style="text-align:center;">' . $l1lll1l1l11l11lllllll1lll11111l['followvotetext'] . '</p>';
					$lll1ll111l1l111ll11ll1llllllll1 = empty($l1lll1l1l11l11lllllll1lll11111l['template']) ? 'playVoice("' . tomedia($l1lll1l1l11l11lllllll1lll11111l['followvoice']) . '");' : 'require(["main"], function(xiaoftoupiao){xiaoftoupiao.playVoice("' . tomedia($l1lll1l1l11l11lllllll1lll11111l['followvoice']) . '")})';
					$lll111ll11111l1ll1l1l1l1llll111 = empty($l1lll1l1l11l11lllllll1lll11111l['followtipstype']) ? '<img width="100%" src="' . tomedia($l1lll1l1l11l11lllllll1lll11111l['accountqrcode']) . '"/>' : '<div class="play-voice"><img class="voice-on" src="' . MODULE_URL . 'template/mobile/xiaofweui/picture/ms.png"/><img class="voice-off" src="' . MODULE_URL . 'template/mobile/xiaofweui/picture/mp.png"/></div><script type="text/javascript">' . $lll1ll111l1l111ll11ll1llllllll1 . '</script>';
					die(json_encode(error(103, $ll1ll111lll1ll1111l11l1lll1l111 . $lll111ll11111l1ll1l1l1l1llll111)));
				}
				if ($l11lll1l1llll11lll1l1l1111l111l['locking'] == 1) {
					if ($l11lll1l1llll11lll1l1l1111l111l['locking_at'] >= time() or intval($l1lll1l1l11l11lllllll1lll11111l['releasetime']) == 0) {
						die(json_encode(error(110, '系统检测该选手投票数据异常，已自动锁定，不再接受投票。' . $l1lll11ll1l11l1llllllll1l111ll1)));
					} else {
						pdo_update("xiaof_toupiao", array('locking' => '0', 'locking_at' => '0'), array("id" => $l11lll1l1llll11lll1l1l1111l111l['id']));
					}
				}
				if (count($l1lll1l1l11l11lllllll1lll11111l['city']) >= 1) {
					if (in_array('ip', $l1lll1l1l11l11lllllll1lll11111l['veriftype'])) {
						if (!($l11l1llll11ll11lllll1l1lllll11l = cache_read('ipaddr:' . md5(CLIENT_IP)))) {
							$lll11ll11ll1l11l111ll11l111ll11 = file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=" . CLIENT_IP);
							$l11l1llll11ll11lllll1l1lllll11l = json_decode($lll11ll11ll1l11l111ll11l111ll11, true);
							cache_write('ipaddr:' . md5(CLIENT_IP), $l11l1llll11ll11lllll1l1lllll11l);
						}
						$lll1111llllll1llllll11l1ll111l1 = intval($l1lll1l1l11l11lllllll1lll11111l['citylevel']);
						switch ($lll1111llllll1llllll11l1ll111l1) {
							case '0':
								$ll11l1ll1lllll1l1ll11ll1lll1111 = $l11l1llll11ll11lllll1l1lllll11l['data']['region'];
								break;
							case '1':
								$ll11l1ll1lllll1l1ll11ll1lll1111 = $l11l1llll11ll11lllll1l1lllll11l['data']['city'];
								break;
							case '2':
								$ll11l1ll1lllll1l1ll11ll1lll1111 = $l11l1llll11ll11lllll1l1lllll11l['data']['city'];
								break;
							default:
								$ll11l1ll1lllll1l1ll11ll1lll1111 = $l11l1llll11ll11lllll1l1lllll11l['data']['region'];
								break;
						}
						$llllll1llllll1l11ll1llll11lll1l = false;
						foreach ($l1lll1l1l11l11lllllll1lll11111l['city'] as $l1ll1ll1l11ll11l111llll1l1111ll) {
							if (strexists($l1ll1ll1l11ll11l111llll1l1111ll, $ll11l1ll1lllll1l1ll11ll1lll1111) or strexists($ll11l1ll1lllll1l1ll11ll1lll1111, $l1ll1ll1l11ll11l111llll1l1111ll)) {
								$llllll1llllll1l11ll1llll11lll1l = true;
								break;
							}
						}
						if (!$llllll1llllll1l11ll1llll11lll1l) {
							die(json_encode(error(104, '活动仅限本地区参与投票' . $l1lll11ll1l11l1llllllll1l111ll1)));
						}
					}
					if (in_array('gps', $l1lll1l1l11l11lllllll1lll11111l['veriftype'])) {
						$l1ll111ll1l11llll111lllll1l1l11 = $this->l1l11l1111l111ll11l111ll1l1lll1('gps_city');
						if (empty($l1ll111ll1l11llll111lllll1l1l11)) {
							die(json_encode(error(115, '未进行GPS定位')));
						}
						$lll1111llllll1llllll11l1ll111l1 = intval($l1lll1l1l11l11lllllll1lll11111l['citylevel']);
						switch ($lll1111llllll1llllll11l1ll111l1) {
							case '0':
								$ll11l1ll1lllll1l1ll11ll1lll1111 = $l1ll111ll1l11llll111lllll1l1l11['province'];
								break;
							case '1':
								$ll11l1ll1lllll1l1ll11ll1lll1111 = $l1ll111ll1l11llll111lllll1l1l11['city'];
								break;
							case '2':
								$ll11l1ll1lllll1l1ll11ll1lll1111 = $l1ll111ll1l11llll111lllll1l1l11['county'];
								break;
							default:
								$ll11l1ll1lllll1l1ll11ll1lll1111 = $l1ll111ll1l11llll111lllll1l1l11['province'];
								break;
						}
						$llllll1llllll1l11ll1llll11lll1l = false;
						foreach ($l1lll1l1l11l11lllllll1lll11111l['city'] as $l1ll1ll1l11ll11l111llll1l1111ll) {
							if (strexists($l1ll1ll1l11ll11l111llll1l1111ll, $ll11l1ll1lllll1l1ll11ll1lll1111) or strexists($ll11l1ll1lllll1l1ll11ll1lll1111, $l1ll1ll1l11ll11l111llll1l1111ll)) {
								$llllll1llllll1l11ll1llll11lll1l = true;
								break;
							}
						}
						if (!$llllll1llllll1l11ll1llll11lll1l) {
							die(json_encode(error(104, '活动仅限本地区参与投票' . $l1lll11ll1l11l1llllllll1l111ll1)));
						}
					}
					if (in_array('fans', $l1lll1l1l11l11lllllll1lll11111l['veriftype'])) {
						$l1ll111ll1l11llll111lllll1l1l11 = $this->l1l11l1111l111ll11l111ll1l1lll1('fans_city');
						if (empty($l1ll111ll1l11llll111lllll1l1l11)) {
							die(json_encode(error(116, '未获取到资料地址')));
						}
						$lll1111llllll1llllll11l1ll111l1 = intval($l1lll1l1l11l11lllllll1lll11111l['citylevel']);
						switch ($lll1111llllll1llllll11l1ll111l1) {
							case '0':
								$ll11l1ll1lllll1l1ll11ll1lll1111 = $l1ll111ll1l11llll111lllll1l1l11['province'];
								break;
							case '1':
								$ll11l1ll1lllll1l1ll11ll1lll1111 = $l1ll111ll1l11llll111lllll1l1l11['city'];
								break;
							case '2':
								$ll11l1ll1lllll1l1ll11ll1lll1111 = $l1ll111ll1l11llll111lllll1l1l11['city'];
								break;
							default:
								$ll11l1ll1lllll1l1ll11ll1lll1111 = $l1ll111ll1l11llll111lllll1l1l11['province'];
								break;
						}
						$llllll1llllll1l11ll1llll11lll1l = false;
						foreach ($l1lll1l1l11l11lllllll1lll11111l['city'] as $l1ll1ll1l11ll11l111llll1l1111ll) {
							if (strexists($l1ll1ll1l11ll11l111llll1l1111ll, $ll11l1ll1lllll1l1ll11ll1lll1111) or strexists($ll11l1ll1lllll1l1ll11ll1lll1111, $l1ll1ll1l11ll11l111llll1l1111ll)) {
								$llllll1llllll1l11ll1llll11lll1l = true;
								break;
							}
						}
						if (!$llllll1llllll1l11ll1llll11lll1l) {
							die(json_encode(error(104, '活动仅限本地区参与投票' . $l1lll11ll1l11l1llllllll1l111ll1)));
						}
					}
				}
				if (intval($l1lll1l1l11l11lllllll1lll11111l['minutenum']) >= 1 or intval($l1lll1l1l11l11lllllll1lll11111l['hournum']) >= 1 or intval($l1lll1l1l11l11lllllll1lll11111l['daynum']) >= 1) {
					$l1l1l1l1l111l1l1lll1lll1llll1l1 = strtotime('-1 day');
					$lll1111l11l1ll1l111l1ll1111l111 = strtotime('-1 hour');
					$l1l1lll1l11l1lll1llllll11ll1lll = strtotime('-1 minute');
					$lll1l111l1lll1l11111111lll111ll = pdo_fetchall("SELECT `created_at` FROM " . tablename('xiaof_toupiao_log') . " where `sid` = '" . $l1lll1l1l11l11lllllll1lll11111l['id'] . "' AND `pid` = '" . $l11lll1l1llll11lll1l1l1111l111l['id'] . "' AND `created_at` >= '" . $l1l1l1l1l111l1l1lll1lll1llll1l1 . "'");
					$l1ll1lll1l11ll11lll1ll1l111l1l1 = count($lll1l111l1lll1l11111111lll111ll);
					$l1lll1111ll11l1ll11111ll111llll = $l11l1lll1l1111lll1l1ll11l11l11l = 0;
					foreach ($lll1l111l1lll1l11111111lll111ll as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
						if ($l1ll1ll1l11ll11l111llll1l1111ll['created_at'] >= $lll1111l11l1ll1l111l1ll1111l111) {
							$l1lll1111ll11l1ll11111ll111llll++;
						}
						if ($l1ll1ll1l11ll11l111llll1l1111ll['created_at'] >= $l1l1lll1l11l1lll1llllll11ll1lll) {
							$l11l1lll1l1111lll1l1ll11l11l11l++;
						}
					}
					$l11l11l1111l11ll1l1l111l1ll1ll1 = intval($l1lll1l1l11l11lllllll1lll11111l['releasetime']);
					if (intval($l1lll1l1l11l11lllllll1lll11111l['minutenum']) >= 1 && $l11l1lll1l1111lll1l1ll11l11l11l >= $l1lll1l1l11l11lllllll1lll11111l['minutenum']) {
						pdo_update("xiaof_toupiao", array('locking' => '1', 'locking_count' => $l11lll1l1llll11lll1l1l1111l111l['locking_count'] + 1, 'locking_at' => strtotime('' . $l11l11l1111l11ll1l1l111l1ll1ll1 . ' minute')), array("id" => $l11lll1l1llll11lll1l1l1111l111l['id']));
						die(json_encode(error(105, '系统检测该选手投票数据异常，已自动锁定，不再接受投票。' . $l1lll11ll1l11l1llllllll1l111ll1)));
					}
					if (intval($l1lll1l1l11l11lllllll1lll11111l['hournum']) >= 1 && $l1lll1111ll11l1ll11111ll111llll >= $l1lll1l1l11l11lllllll1lll11111l['hournum']) {
						pdo_update("xiaof_toupiao", array('locking' => '1', 'locking_count' => $l11lll1l1llll11lll1l1l1111l111l['locking_count'] + 1, 'locking_at' => strtotime('' . $l11l11l1111l11ll1l1l111l1ll1ll1 . ' minute')), array("id" => $l11lll1l1llll11lll1l1l1111l111l['id']));
						die(json_encode(error(105, '系统检测该选手投票数据异常，已自动锁定，不再接受投票。' . $l1lll11ll1l11l1llllllll1l111ll1)));
					}
					if (intval($l1lll1l1l11l11lllllll1lll11111l['daynum']) >= 1 && $l1ll1lll1l11ll11lll1ll1l111l1l1 >= $l1lll1l1l11l11lllllll1lll11111l['daynum']) {
						pdo_update("xiaof_toupiao", array('locking' => '1', 'locking_count' => $l11lll1l1llll11lll1l1l1111l111l['locking_count'] + 1, 'locking_at' => strtotime('' . $l11l11l1111l11ll1l1l111l1ll1ll1 . ' minute')), array("id" => $l11lll1l1llll11lll1l1l1111l111l['id']));
						die(json_encode(error(105, '系统检测该选手投票数据异常，已自动锁定，不再接受投票。' . $l1lll11ll1l11l1llllllll1l111ll1)));
					}
				}
				if ($l1lll1l1l11l11lllllll1lll11111l['verifysms'] == 1) {
					if (isset($_GPC['verifycode']) && isset($_GPC['phone'])) {
						if (isset($_SESSION['verifycode'])) {
							$lll1l11111l1l1ll1llll11ll111lll = iunserializer($_SESSION['verifycode']);
							if ($lll1l11111l1l1ll1llll11ll111lll['phone'] != $_GPC['phone'] or $lll1l11111l1l1ll1llll11ll111lll['randcode'] != $_GPC['verifycode']) {
								die(json_encode(error(113, '验证码不正确')));
							} else {
								if ($l11l11lll1l1l111ll1ll11lll1l11l = $this->l1l11l1111l111ll11l111ll1l1lll1('rid')) {
									$lll1111l1l1l1ll11111111l1lll11l = array('phone' => $lll1l11111l1l1ll1llll11ll111lll['phone'], 'city' => iserializer($lll1l11111l1l1ll1llll11ll111lll['addrs']));
									pdo_update("xiaof_relation", $lll1111l1l1l1ll11111111l1lll11l, array("id" => $l11l11lll1l1l111ll1ll11lll1l11l));
								}
							}
						} else {
							die(json_encode(error(112, '验证出现错误,请刷新重试')));
						}
					} else {
						$l1ll111ll1l11llll111lllll1l1l11 = $this->l1l11l1111l111ll11l111ll1l1lll1('city');
						if (empty($l1ll111ll1l11llll111lllll1l1l11)) {
							die(json_encode(error(111, '手机号验证')));
						}
						if (in_array('sms', $l1lll1l1l11l11lllllll1lll11111l['veriftype'])) {
							$lll1111llllll1llllll11l1ll111l1 = intval($l1lll1l1l11l11lllllll1lll11111l['citylevel']);
							switch ($lll1111llllll1llllll11l1ll111l1) {
								case '0':
									$ll11l1ll1lllll1l1ll11ll1lll1111 = $l1ll111ll1l11llll111lllll1l1l11['province'];
									break;
								case '1':
									$ll11l1ll1lllll1l1ll11ll1lll1111 = $l1ll111ll1l11llll111lllll1l1l11['city'];
									break;
								case '2':
									$ll11l1ll1lllll1l1ll11ll1lll1111 = $l1ll111ll1l11llll111lllll1l1l11['city'];
									break;
								default:
									$ll11l1ll1lllll1l1ll11ll1lll1111 = $l1ll111ll1l11llll111lllll1l1l11['province'];
									break;
							}
							$ll11l1ll1lllll1l1ll11ll1lll1111 = trim($ll11l1ll1lllll1l1ll11ll1lll1111);
							if (empty($ll11l1ll1lllll1l1ll11ll1lll1111)) {
								die(json_encode(error(111, '手机号验证')));
							}
							if (count($l1lll1l1l11l11lllllll1lll11111l['city']) >= 1) {
								$llllll1llllll1l11ll1llll11lll1l = false;
								foreach ($l1lll1l1l11l11lllllll1lll11111l['city'] as $l1ll1ll1l11ll11l111llll1l1111ll) {
									if (strexists($l1ll1ll1l11ll11l111llll1l1111ll, $ll11l1ll1lllll1l1ll11ll1lll1111)) {
										$llllll1llllll1l11ll1llll11lll1l = true;
										break;
									}
								}
								if (!$llllll1llllll1l11ll1llll11lll1l) {
									die(json_encode(error(114, '活动仅限本地区参与投票，您的手机归属地不在本地区' . $l1lll11ll1l11l1llllllll1l111ll1)));
								}
							}
						}
					}
				}
				$l1ll11llll111lllll1ll1ll1l1l111 = $this->l1l11l1111l111ll11l111ll1l1lll1('openid');
				if (empty($l1lll1l1l11l11lllllll1lll11111l['votefollow']) && empty($l1ll11llll111lllll1ll1ll1l1l111)) {
					$l1ll11llll111lllll1ll1ll1l1l111 = $_W['openid'];
				}
				if (intval($l1lll1l1l11l11lllllll1lll11111l['limitone']) >= 1) {
					$lll1l111l1lll1l11111111lll111ll = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename("xiaof_toupiao_log") . " WHERE `sid` = :sid AND `pid` = :pid AND `openid` = :openid", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id'], ":pid" => $l11lll1l1llll11lll1l1l1111l111l['id'], ":openid" => $l1ll11llll111lllll1ll1ll1l1l111));
					if ($lll1l111l1lll1l11111111lll111ll >= intval($l1lll1l1l11l11lllllll1lll11111l['limitone'])) {
						die(json_encode(error(107, '本次活动期间您对选手编号' . $l11lll1l1llll11lll1l1l1111l111l['uid'] . '允许最大投票数达到上限，不能再继续给Ta投票' . $l1lll11ll1l11l1llllllll1l111ll1)));
					}
				}
				if ($l1lll1l1l11l11lllllll1lll11111l['vnum'] >= 1) {
					$lll1l111l1lll1l11111111lll111ll = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xiaof_toupiao_log') . " where `sid` = '" . $l1lll1l1l11l11lllllll1lll11111l['id'] . "' AND `openid` = '" . $l1ll11llll111lllll1ll1ll1l1l111 . "' AND `unique_at` = '" . date(Ymd) . "'");
					if ($lll1l111l1lll1l11111111lll111ll >= $l1lll1l1l11l11lllllll1lll11111l['vnum']) {
						die(json_encode(error(105, '一个微信号每天只能给' . $l1lll1l1l11l11lllllll1lll11111l['vnum'] . '个选手投票' . $l1lll11ll1l11l1llllllll1l111ll1)));
					}
				}
				if (pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao_safe") . " WHERE `sid` = :sid AND `ip` = :ip ", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id'], ":ip" => ip2long(CLIENT_IP)))) {
					die(json_encode(error(106, '抱歉，系统检测到您非正常投票，投票失败。还绿色公平环境，拒绝刷票。如有疑问联系我们的公众号申诉解封' . $l1lll11ll1l11l1llllllll1l111ll1)));
				}
				if (pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao_log") . " WHERE `sid` = :sid AND `pid` = :pid AND `openid` = :openid AND `unique_at` = :unique_at limit 1", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id'], ":pid" => $l11lll1l1llll11lll1l1l1111l111l['id'], ":openid" => $l1ll11llll111lllll1ll1ll1l1l111, ":unique_at" => date("Ymd")))) {
					die(json_encode(error(107, '您今天已经给编号' . $l11lll1l1llll11lll1l1l1111l111l['uid'] . '投过票了，明天再来吧' . $l1lll11ll1l11l1llllllll1l111ll1)));
				}
				if (intval($l1lll1l1l11l11lllllll1lll11111l['ipmaxvote']) >= 2) {
					$lll1l111l1lll1l11111111lll111ll = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xiaof_toupiao_log') . " where `sid` = '" . $l1lll1l1l11l11lllllll1lll11111l['id'] . "' AND `ip` = '" . ip2long(CLIENT_IP) . "' AND `unique_at` = '" . date("Ymd") . "'");
					if ($lll1l111l1lll1l11111111lll111ll >= $l1lll1l1l11l11lllllll1lll11111l['ipmaxvote']) {
						die(json_encode(error(108, '同一个IP每天只能投' . $l1lll1l1l11l11lllllll1lll11111l['ipmaxvote'] . '票' . $l1lll11ll1l11l1llllllll1l111ll1)));
					}
				}
				if (intval($l1lll1l1l11l11lllllll1lll11111l['maxvotenum']) >= 1) {
					$lll1l111l1lll1l11111111lll111ll = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xiaof_toupiao_log') . " where `sid` = '" . $l1lll1l1l11l11lllllll1lll11111l['id'] . "' AND `openid` = '" . $l1ll11llll111lllll1ll1ll1l1l111 . "'");
					if ($lll1l111l1lll1l11111111lll111ll >= $l1lll1l1l11l11lllllll1lll11111l['maxvotenum']) {
						die(json_encode(error(109, '本次活动您共有' . $l1lll1l1l11l11lllllll1lll11111l['maxvotenum'] . '票，已经用完，不能再投。' . $l1lll11ll1l11l1llllllll1l111ll1)));
					}
				}
				if (intval($l1lll1l1l11l11lllllll1lll11111l['maxgoodnum']) >= 1) {
					if (time() <= strtotime($l1lll1l1l11l11lllllll1lll11111l['maxgoodtime']) && $l11lll1l1llll11lll1l1l1111l111l['good'] >= $l1lll1l1l11l11lllllll1lll11111l['maxgoodnum']) {
						die(json_encode(error(109, '本次活动' . $l1lll1l1l11l11lllllll1lll11111l['maxgoodtime'] . '之前，每位选手最多允许被投' . $l1lll1l1l11l11lllllll1lll11111l['maxgoodnum'] . '票，超出无效。' . $l1lll11ll1l11l1llllllll1l111ll1)));
					}
				}
				if ($l1lll1l1l11l11lllllll1lll11111l['limitonevote'] >= 1) {
					$ll11llllll11l1llll11111ll1llll1 = $this->l1ll1l1lllllll1ll111l1lll1llll1();
					$lll1l111l1lll1l11111111lll111ll = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xiaof_toupiao_log') . " where `sid` = '" . $l1lll1l1l11l11lllllll1lll11111l['id'] . "' AND `pid` = '" . $l11lll1l1llll11lll1l1l1111l111l['id'] . "' AND `unique_at` = '" . date("Ymd") . "' AND `openid` IN ('" . implode("','", $ll11llllll11l1llll11111ll1llll1) . "')");
					if ($lll1l111l1lll1l11111111lll111ll >= $l1lll1l1l11l11lllllll1lll11111l['limitonevote']) {
						die(json_encode(error(105, '同一选手每天最多只能给他投' . $l1lll1l1l11l11lllllll1lll11111l['limitonevote'] . '票' . $l1lll11ll1l11l1llllllll1l111ll1)));
					}
				}
				$l111l11l1l1l1l1lll111l11111l11l = 1;
				$lllll11l1l1l11l11l1lll111l1l1ll = intval($l1lll1l1l11l11lllllll1lll11111l['double']);
				if ($lllll11l1l1l11l11l1lll111l1l1ll >= 2 && time() >= strtotime($l1lll1l1l11l11lllllll1lll11111l['doublestart']) && time() <= strtotime($l1lll1l1l11l11lllllll1lll11111l['doubleend'])) {
					$l111l11l1l1l1l1lll111l11111l11l = $lllll11l1l1l11l11l1lll111l1l1ll;
				} elseif ($l11lll1l1llll11lll1l1l1111l111l['double_at'] > time()) {
					$l111l11l1l1l1l1lll111l11111l11l = 2;
				}
				$l111111l111l1ll1l1llll1l11lllll = empty($_W['fans']['fanid']) ? 0 : $_W['fans']['fanid'];
				pdo_insert("xiaof_toupiao_log", array("sid" => $l1lll1l1l11l11lllllll1lll11111l['id'], "pid" => $l11lll1l1llll11lll1l1l1111l111l['id'], "fanid" => $l111111l111l1ll1l1llll1l11lllll, "nickname" => $this->l1l11l1111l111ll11l111ll1l1lll1('nickname'), "avatar" => $this->l1l11l1111l111ll11l111ll1l1lll1('avatar'), "num" => $l111l11l1l1l1l1lll111l11111l11l, "openid" => $l1ll11llll111lllll1ll1ll1l1l111, "ip" => ip2long(CLIENT_IP), "unique_at" => date("Ymd"), "created_at" => time()));
				$llll1ll1111l1l1l1llll11ll11l1ll = 1;
				if (intval($l1lll1l1l11l11lllllll1lll11111l['openvirtualclick']) >= 1) {
					$l111lll11l111l1ll111111ll11l11l = rand(1, 10);
					$llll1ll1111l1l1l1llll11ll11l1ll = $llll1ll1111l1l1l1llll11ll11l1ll + $l111lll11l111l1ll111111ll11l11l;
				}
				pdo_query("UPDATE " . tablename("xiaof_toupiao") . " SET `good` = good+" . $l111l11l1l1l1l1lll111l11111l11l . ", `click` = click+" . $llll1ll1111l1l1l1llll11ll11l1ll . ", `updated_at` = '" . time() . "' WHERE `sid` = '" . $l1lll1l1l11l11lllllll1lll11111l['id'] . "' AND `id` = '" . $l11lll1l1llll11lll1l1l1111l111l['id'] . "'");
				if (intval($l1lll1l1l11l11lllllll1lll11111l['opencredit']) >= 1 && intval($l1lll1l1l11l11lllllll1lll11111l['votecredit']) >= 1) {
					load()->model('mc');
					if ($l11l1l1l1l1111l1l1lllll1111l11l = $this->l111l111111lllll1111l11ll1l111l()) {
						$ll1l1ll1ll11l1l1l11llllllll1l11 = mc_credit_update($l11l1l1l1l1111l1l1lllll1111l11l, 'credit1', intval($l1lll1l1l11l11lllllll1lll11111l['votecredit']), array(1, $l1lll1l1l11l11lllllll1lll11111l['title'] . '投票赠送积分', 'system'));
						if (!is_error($ll1l1ll1ll11l1l1l11llllllll1l11) && intval($l1lll1l1l11l11lllllll1lll11111l['creditnotice']) >= 1) {
							if ($_W['account']['level'] >= 3) {
								mc_notice_credit1($this->l1l11l1111l111ll11l111ll1l1lll1('openid'), $l11l1l1l1l1111l1l1lllll1111l11l, intval($l1lll1l1l11l11lllllll1lll11111l['votecredit']), $l1lll1l1l11l11lllllll1lll11111l['title'] . '投票赠送积分', '', '谢谢参与');
							}
						}
					}
				}
				if (intval($l1lll1l1l11l11lllllll1lll11111l['dynamicnotice']) >= 1) {
					if ($ll111111l1ll111l1ll111ll1111111 = pdo_fetch("SELECT * FROM " . tablename("xiaof_relation") . " WHERE `oauth_uniacid` = :oauth_uniacid AND `openid` = :openid limit 1", array(":oauth_uniacid" => $_SESSION['oauth_acid'], ":openid" => $l11lll1l1llll11lll1l1l1111l111l['openid']))) {
						$l11ll1l1111lll1lll1l11ll11l1ll1 = pdo_fetch("SELECT (SELECT COUNT(*) FROM " . tablename("xiaof_toupiao") . " WHERE `sid`=k.sid AND `verify`!='2' AND k.good<good ) as top FROM " . tablename("xiaof_toupiao") . " as k WHERE `id` = :id", array(":id" => $l11lll1l1llll11lll1l1l1111l111l['id']));
						$l11ll1111l1111ll1l1lll11111ll1l = pdo_fetchcolumn("SELECT `good` FROM " . tablename("xiaof_toupiao") . " WHERE `sid` = :sid AND `verify`!='2' AND `good` > :good ORDER BY `good` ASC limit 1", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id'], ":good" => $l11lll1l1llll11lll1l1l1111l111l['good'] + $l111l11l1l1l1l1lll111l11111l11l));
						$lllll1lllll111111l1ll1ll111ll1l = pdo_fetchcolumn("SELECT `good` FROM " . tablename("xiaof_toupiao") . " WHERE `sid` = :sid AND `verify`!='2' AND `good` < :good ORDER BY `good` DESC limit 1", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id'], ":good" => $l11lll1l1llll11lll1l1l1111l111l['good'] + $l111l11l1l1l1l1lll111l11111l11l));
						$ll1llllll1l111ll111l111l111111l = pdo_fetch("SELECT (SELECT COUNT(*) FROM " . tablename("xiaof_toupiao") . " WHERE `sid`=k.sid AND `verify`!='2' AND `good`=k.good AND `id`<k.id) as top FROM " . tablename("xiaof_toupiao") . " as k WHERE `id` = :id", array(":id" => $l11lll1l1llll11lll1l1l1111l111l['id']));
						$llll11111l111llll1llll111lll11l = $l11ll1l1111lll1lll1l11ll11l1ll1['top'] + 1 + $ll1llllll1l111ll111l111l111111l['top'];
						$llll1l11ll1111l11l111ll1lll1111 = $l11lll1l1llll11lll1l1l1111l111l['good'] - $lllll1lllll111111l1ll1ll111ll1l;
						$ll11lll11l1l11l11llll11ll1111ll = $l11ll1111l1111ll1l1lll11111ll1l - $l11lll1l1llll11lll1l1l1111l111l['good'];
						if (!$l11ll1111l1111ll1l1lll11111ll1l) {
							$ll11lll11l1l11l11llll11ll1111ll = 0;
						}
						$this->ll11l1l111ll11l11llll111l1l1ll1($l11lll1l1llll11lll1l1l1111l111l['openid'], '微信好友：' . $this->l1l11l1111l111ll11l111ll1l1lll1('nickname') . '刚刚为您《' . $l11lll1l1llll11lll1l1l1111l111l['name'] . '》投了' . $l111l11l1l1l1l1lll111l11111l11l . '票。当前票数为' . ($l11lll1l1llll11lll1l1l1111l111l['good'] + $l111l11l1l1l1l1lll111l11111l11l) . ' 排名' . $llll11111l111llll1llll111lll11l . ',距前一名差' . $ll11lll11l1l11l11llll11ll1111ll . '票 后一名差' . $llll1l11ll1111l11l111ll1lll1111 . '票', $ll111111l1ll111l1ll111ll1111111['uniacid']);
					}
				}
				if ($l1lll1l1l11l11lllllll1lll11111l['advotetype'] == 1) {
					$l111llll111l1l11l11111l111111l1 = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_acid') . " WHERE `sid` = :sid", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id']));
					$l1lll11ll1l11l1llllllll1l111ll1 = '<br/><div class="acid-lists"><ul class="swiper-wrapper">';
					foreach ($l111llll111l1l11l11111l111111l1 as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
						$l1lll11ll1l11l1llllllll1l111ll1 .= '<li class="acid-swiper-slide swiper-slide"><img class="acid-qrcode" src="' . tomedia($l1ll1ll1l11ll11l111llll1l1111ll['qrcode']) . '"/></li>';
					}
					$l1lll11ll1l11l1llllllll1l111ll1 .= '</ul><div class="swiper-scrollbar"></div></div>';
					if ($l11llllllll1l11l11lll1l1111111l = pdo_fetch("SELECT * FROM " . tablename('xiaof_toupiao_rule') . " WHERE `sid` = '" . $l1lll1l1l11l11lllllll1lll11111l['id'] . "' AND `action` = '3' limit 1")) {
						$llll1ll11llll111111111l11l1l11l = str_replace(array('^', '$', '*'), '', $l11llllllll1l11l11lll1l1111111l['keyword']);
						$llll1ll11llll111111111l11l1l11l = str_replace('[0-9]', $l11lll1l1llll11lll1l1l1111l111l['uid'], $llll1ll11llll111111111l11l1l11l);
						$l1lll11ll1l11l1llllllll1l111ll1 .= "<span style='text-align: center;'><font color='#FBA02D'>长按上面二维码进入<br/>发送" . $llll1ll11llll111111111l11l1l11l . "即可为Ta多投一票</font></span>";
					} else {
						$l1lll11ll1l11l1llllllll1l111ll1 .= "<font color='#FBA02D'>tips：长按二维码进入其他公众号可为Ta多投一票哦</font>";
					}
				}
				if ($l111l11l1l1l1l1lll111l11111l11l >= 2) {
					die(json_encode(error(0, '您成功给编号' . $l11lll1l1llll11lll1l1l1111l111l['uid'] . '投了' . $l111l11l1l1l1l1lll111l11111l11l . '票<br/>当前选手多倍投票时间1票等于' . $l111l11l1l1l1l1lll111l11111l11l . '票' . $l1lll11ll1l11l1llllllll1l111ll1)));
				}
				die(json_encode(error(0, '您成功给编号' . $l11lll1l1llll11lll1l1l1111l111l['uid'] . '投了1票，谢谢支持' . $l1lll11ll1l11l1llllllll1l111ll1)));
				break;
			case 'click':
				pdo_update("xiaof_toupiao", array("click" => $l11lll1l1llll11lll1l1l1111l111l['click'] + 1), array("id" => intval($_GPC['id'])));
				break;
			case 'share':
				pdo_update("xiaof_toupiao", array("share" => $l11lll1l1llll11lll1l1l1111l111l['share'] + 1), array("id" => intval($_GPC['id'])));
				break;
		}
	}
	public function doMobileUseprop()
	{
		global $_W, $_GPC;
		$this->lllll1l111lll11l111lllll11ll11l();
		$l1lll1l1l11l11lllllll1lll11111l = $this->l1l11ll11ll1l1111lll11lllll1l11();
		load()->model('mc');
		$l11l1l1l1l1111l1l1lllll1111l11l = $this->l111l111111lllll1111l11ll1l111l();
		if (empty($l11l1l1l1l1111l1l1lllll1111l11l)) {
			die(json_encode(error(999, '没有获取到用户信息')));
		}
		$ll1l1ll11l11ll11lllll1ll1111l11 = pdo_fetch("SELECT * FROM " . tablename('xiaof_toupiao_draw') . " WHERE `sid`=:sid AND `uid`=:uid AND `uses`='2' AND `attr`=:attr", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id'], ":uid" => $l11l1l1l1l1111l1l1lllll1111l11l, ":attr" => intval($_GPC['type'])));
		if ($ll1l1ll11l11ll11lllll1ll1111l11) {
			if ($l11lll1l1llll11lll1l1l1111l111l = pdo_fetch("SELECT * FROM " . tablename('xiaof_toupiao') . " WHERE `id`=:id", array(":id" => intval($_GPC['pid'])))) {
				if ($l11lll1l1llll11lll1l1l1111l111l['double_at'] < time()) {
					$l1lll1111l1l1l1ll1lll1ll1l111l1 = strtotime("+" . $ll1l1ll11l11ll11lllll1ll1111l11['num'] . " minute");
				} else {
					$l1lll1111l1l1l1ll1lll1ll1l111l1 = strtotime("+" . $ll1l1ll11l11ll11lllll1ll1111l11['num'] . " minute", $l11lll1l1llll11lll1l1l1111l111l['double_at']);
				}
				pdo_insert("xiaof_toupiao_drawlog", array("sid" => $l1lll1l1l11l11lllllll1lll11111l['id'], "uid" => $l11l1l1l1l1111l1l1lllll1111l11l, "uname" => $this->l1l11l1111l111ll11l111ll1l1lll1('nickname'), "avatar" => $this->l1l11l1111l111ll11l111ll1l1lll1('avatar'), "pid" => intval($_GPC['pid']), "attr" => $ll1l1ll11l11ll11lllll1ll1111l11['attr'], "data" => $ll1l1ll11l11ll11lllll1ll1111l11['num'], "created_at" => time()));
				pdo_update("xiaof_toupiao", array("double_at" => $l1lll1111l1l1l1ll1lll1ll1l111l1), array("id" => $l11lll1l1llll11lll1l1l1111l111l['id']));
				pdo_update("xiaof_toupiao_draw", array("uses" => 1, "bdelete_at" => time()), array("id" => $ll1l1ll11l11ll11lllll1ll1111l11['id']));
				if (intval($l1lll1l1l11l11lllllll1lll11111l['dynamicnotice']) >= 1) {
					if ($ll111111l1ll111l1ll111ll1111111 = pdo_fetch("SELECT * FROM " . tablename("xiaof_relation") . " WHERE `oauth_uniacid` = :oauth_uniacid AND `openid` = :openid limit 1", array(":oauth_uniacid" => $_SESSION['oauth_acid'], ":openid" => $l11lll1l1llll11lll1l1l1111l111l['openid']))) {
						$this->ll11l1l111ll11l11llll111l1l1ll1($l11lll1l1llll11lll1l1l1111l111l['openid'], '微信好友：' . $this->l1l11l1111l111ll11l111ll1l1lll1('nickname') . '刚刚为您《' . $l11lll1l1llll11lll1l1l1111l111l['name'] . '》使用了双倍投票券' . $ll1l1ll11l11ll11lllll1ll1111l11['num'] . '分钟。当前双倍时间至' . date("Y-m-d H:i", $l1lll1111l1l1l1ll1lll1ll1l111l1), $ll111111l1ll111l1ll111ll1111111['uniacid']);
					}
				}
				die(json_encode(error(0, '您成功给编号' . intval($_GPC['uid']) . '使用双倍投票道具<br/>Ta现在投票双倍至' . date("Y-m-d H:i", $l1lll1111l1l1l1ll1lll1ll1l111l1) . '结束。</br/>2秒后刷新页面')));
			}
		}
		die(json_encode(error(999, '您还没有该道具')));
	}
	public function doMobileDraw()
	{
		global $_W, $_GPC;
		$l1lll1l1l11l11lllllll1lll11111l = $this->l1l11ll11ll1l1111lll11lllll1l11();
		if ($l1lll1l1l11l11lllllll1lll11111l['opendraw'] != 1) {
			die(json_encode(error(999, '积分抽奖功能未开启')));
		}
		if (time() <= strtotime($l1lll1l1l11l11lllllll1lll11111l['start'])) {
			die(json_encode(error(999, "活动未开始，请开始后再抽奖，开始时间" . $l1lll1l1l11l11lllllll1lll11111l['start'] . "")));
		}
		if (time() >= strtotime($l1lll1l1l11l11lllllll1lll11111l['end'])) {
			die(json_encode(error(999, "抽奖活动已结束，敬请期待下次活动")));
		}
		if (!$this->l1ll111l1lll1l1lll11l1l1ll1111l()) {
			$llll1l1111llll1l11l111lll1l1l1l = empty($l1lll1l1l11l11lllllll1lll11111l['followdrawtext']) ? '' : '<p style="text-align:center;">' . $l1lll1l1l11l11lllllll1lll11111l['followdrawtext'] . '</p>';
			$lll1ll111l1l111ll11ll1llllllll1 = empty($l1lll1l1l11l11lllllll1lll11111l['template']) ? 'playVoice("' . tomedia($l1lll1l1l11l11lllllll1lll11111l['followvoice']) . '");' : 'require(["main"], function(xiaoftoupiao){xiaoftoupiao.playVoice("' . tomedia($l1lll1l1l11l11lllllll1lll11111l['followvoice']) . '")})';
			$l11ll1l1ll11l111l1111llllll1ll1 = empty($l1lll1l1l11l11lllllll1lll11111l['followtipstype']) ? '<img width="100%" src="' . tomedia($l1lll1l1l11l11lllllll1lll11111l['accountqrcode']) . '"/>' : '<div class="play-voice"><img class="voice-on" src="' . MODULE_URL . 'template/mobile/xiaofweui/picture/ms.png"/><img class="voice-off" src="' . MODULE_URL . 'template/mobile/xiaofweui/picture/mp.png"/></div><script type="text/javascript">' . $lll1ll111l1l111ll11ll1llllllll1 . '</script>';
			die(json_encode(error(999, $llll1l1111llll1l11l111lll1l1l1l . $l11ll1l1ll11l111l1111llllll1ll1)));
		}
		load()->model('mc');
		$l11l1l1l1l1111l1l1lllll1111l11l = $this->l111l111111lllll1111l11ll1l111l();
		if (empty($l11l1l1l1l1111l1l1lllll1111l11l)) {
			die(json_encode(error(999, '失败，您的积分不足。<br/>抽奖一次需消耗' . intval($l1lll1l1l11l11lllllll1lll11111l['drawcredit']) . '积分。加油获取积分吧！')));
		}
		$l1lllllll1l1ll1l1ll11111l11lll1 = strtotime(date('Ymd'));
		$lll1ll1l111l11111111l11l111lll1 = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xiaof_toupiao_draw') . " WHERE `uid` = :uid AND `created_at` BETWEEN " . $l1lllllll1l1ll1l1ll11111l11lll1 . " AND " . ($l1lllllll1l1ll1l1ll11111l11lll1 + 86400) . "", array(":uid" => $l11l1l1l1l1111l1l1lllll1111l11l));
		if (intval($l1lll1l1l11l11lllllll1lll11111l['drawlimit']) >= 1) {
			if ($l1lll1l1l11l11lllllll1lll11111l['drawlimit'] <= $lll1ll1l111l11111111l11l111lll1) {
				die(json_encode(error(999, '您今日抽奖次数已经达到上限')));
			}
		}
		$lllll1l1l111l111111l1111lll11l1 = mc_credit_fetch($l11l1l1l1l1111l1l1lllll1111l11l);
		if ($lllll1l1l111l111111l1111lll11l1['credit1'] < intval($l1lll1l1l11l11lllllll1lll11111l['drawcredit'])) {
			die(json_encode(error(999, '失败，您的积分不足。<br/>抽奖一次需消耗' . intval($l1lll1l1l11l11lllllll1lll11111l['drawcredit']) . '积分。加油获取积分吧！')));
		}
		$llll11l111lllllllllll1l1l111l11 = $l1lll1l1l11l11lllllll1lll11111l['prize'];
		$ll1l1lllllllll1lll1lll1lll1llll = $this->l11llllll1llll11ll1lllll11l11ll($llll11l111lllllllllll1l1l111l11, $l1lll1l1l11l11lllllll1lll11111l['id']);
		$l1ll1ll1llll1111l111111l11l1l1l = $llll11l111lllllllllll1l1l111l11[$ll1l1lllllllll1lll1lll1lll1llll];
		if (!isset($l1ll1ll1llll1111l111111l11l1l1l['attr'])) {
			die(json_encode(error(999, '系统错误,抽奖失败。您的积分没有扣除，请稍后再试或联系我们')));
		}
		$l11lll1ll1ll1lll11lllllll11ll11 = mc_credit_update($l11l1l1l1l1111l1l1lllll1111l11l, 'credit1', -intval($l1lll1l1l11l11lllllll1lll11111l['drawcredit']), array(1, $l1lll1l1l11l11lllllll1lll11111l['title'] . '抽奖使用积分', 'system'));
		if (!is_error($l11lll1ll1ll1lll11lllllll11ll11) && intval($l1lll1l1l11l11lllllll1lll11111l['creditnotice']) >= 1) {
			if ($_W['account']['level'] >= 3) {
				mc_notice_credit1($this->l1l11l1111l111ll11l111ll1l1lll1('openid'), $l11l1l1l1l1111l1l1lllll1111l11l, -intval($l1lll1l1l11l11lllllll1lll11111l['drawcredit']), $l1lll1l1l11l11lllllll1lll11111l['title'] . '抽奖使用积分', '', '谢谢参与');
			}
		}
		$lll1l111l11ll1111lll1ll11ll1lll = 2;
		$llll1lll1lll1ll1l11l1l1ll1ll1ll = 0;
		switch ($l1ll1ll1llll1111l111111l11l1l1l['attr']) {
			case '0':
				$l1ll1l1111l11l1l11llll111l111ll = '谢谢参与，本次没有抽中任何奖品。';
				$lll1l111l11ll1111lll1ll11ll1lll = 1;
				$l111l11l1l1l1l1lll111l11111l11l = 1;
				$llll1lll1lll1ll1l11l1l1ll1ll1ll = time();
				break;
			case '1':
				$l1ll1l1111l11l1l11llll111l111ll = '恭喜您抽中了实物奖品' . $l1ll1ll1llll1111l111111l11l1l1l['name'] . '';
				$l111l11l1l1l1l1lll111l11111l11l = $ll1l1lllllllll1lll1lll1lll1llll;
				break;
			case '2':
				$l1ll1l1111l11l1l11llll111l111ll = '恭喜您抽中了积分赠送，系统赠送您' . intval($l1ll1ll1llll1111l111111l11l1l1l['num']) . '积分';
				$ll1l1ll1ll11l1l1l11llllllll1l11 = mc_credit_update($l11l1l1l1l1111l1l1lllll1111l11l, 'credit1', intval($l1ll1ll1llll1111l111111l11l1l1l['num']), array(1, $l1lll1l1l11l11lllllll1lll11111l['title'] . '抽中了积分奖励', 'system'));
				$lll1l111l11ll1111lll1ll11ll1lll = 1;
				$llll1lll1lll1ll1l11l1l1ll1ll1ll = time();
				if (!is_error($ll1l1ll1ll11l1l1l11llllllll1l11) && intval($l1lll1l1l11l11lllllll1lll11111l['creditnotice']) >= 1) {
					if ($_W['account']['level'] >= 3) {
						mc_notice_credit1($this->l1l11l1111l111ll11l111ll1l1lll1('openid'), $l11l1l1l1l1111l1l1lllll1111l11l, intval($l1ll1ll1llll1111l111111l11l1l1l['num']), $l1lll1l1l11l11lllllll1lll11111l['title'] . '抽中了积分奖励', '', '谢谢参与');
					}
				}
				$l111l11l1l1l1l1lll111l11111l11l = intval($l1ll1ll1llll1111l111111l11l1l1l['num']);
				break;
			case '3':
				$l1ll1l1111l11l1l11llll111l111ll = '恭喜您抽中了双倍投票券半小时，赶紧去使用吧。';
				$l111l11l1l1l1l1lll111l11111l11l = 30;
				break;
			case '4':
				$l1ll1l1111l11l1l11llll111l111ll = '恭喜您抽中了双倍投票券一小时，赶紧去使用吧。';
				$l111l11l1l1l1l1lll111l11111l11l = 60;
				break;
			case '5':
				$l1ll1l1111l11l1l11llll111l111ll = '恭喜您抽中了双倍投票券二小时，赶紧去使用吧。';
				$l111l11l1l1l1l1lll111l11111l11l = 120;
				break;
			case '6':
				$l1ll1l1111l11l1l11llll111l111ll = '恭喜您抽中了双倍投票券八小时，赶紧去使用吧。';
				$l111l11l1l1l1l1lll111l11111l11l = 480;
				break;
		}
		pdo_insert("xiaof_toupiao_draw", array("sid" => $l1lll1l1l11l11lllllll1lll11111l['id'], "prizeid" => $ll1l1lllllllll1lll1lll1lll1llll, "uid" => $l11l1l1l1l1111l1l1lllll1111l11l, "uname" => $this->l1l11l1111l111ll11l111ll1l1lll1('nickname'), "avatar" => $this->l1l11l1111l111ll11l111ll1l1lll1('avatar'), "attr" => $l1ll1ll1llll1111l111111l11l1l1l['attr'], "uses" => $lll1l111l11ll1111lll1ll11ll1lll, "credit" => $l1lll1l1l11l11lllllll1lll11111l['drawcredit'], "name" => $l1ll1ll1llll1111l111111l11l1l1l['name'], "num" => $l111l11l1l1l1l1lll111l11111l11l, "openid" => $this->l1l11l1111l111ll11l111ll1l1lll1('openid'), "ip" => ip2long(CLIENT_IP), "bdelete_at" => time(), "created_at" => time()));
		die(json_encode(error($ll1l1lllllllll1lll1lll1lll1llll, $l1ll1l1111l11l1l11llll111l111ll)));
	}
	private function l1ll11l1l11111lll1l11111l111l1l($l1l11l1l1l1111lll1lll1ll111l111, $l11l1l1l1l1111l1l1lllll1111l11l, $lll1l1l111111ll11l1l1l11111l1ll, $l11ll1111lll111lll11ll11ll111l1, $l1111ll1l1l1l11l11l1lll11l1l1ll = false)
	{
		global $_GPC, $_W;
		$l1lll1l1l11l11lllllll1lll11111l = $this->l1l11ll11ll1l1111lll11lllll1l11();
		load()->func('file');
		$l1111ll1l1l1l11l11l1lll11l1l1ll && header("Content-type: image/jpeg");
		$lllll11lllll11lll1ll1lll1llll11 = MODULE_ROOT . '/resources/font/simhei.ttf';
		$l1l1llllll1l1ll11lll1ll1l11ll11 = empty($l1lll1l1l11l11lllllll1lll11111l['posterbg']) ? MODULE_ROOT . '/resources/image/posterbg.jpg' : tomedia($l1lll1l1l11l11lllllll1lll11111l['posterbg']);
		$lll1l11llllll111l11ll1l11ll11l1 = ImageCreateFromJPEG($l1l1llllll1l1ll11lll1ll1l11ll11);
		$l11ll111l1ll1llll111l1l1111l1ll = ImageColorAllocate($lll1l11llllll111l11ll1l11ll11l1, 0, 0, 0);
		$l111lll1l11lll1l11l1ll1ll1l11l1 = getimagesize($lll1l1l111111ll11l1l1l11111l1ll);
		$lll111l1lll1111lll1l11l11111111 = ImageCreateFromJPEG($lll1l1l111111ll11l1l1l11111l1ll);
		imagecopyresized($lll1l11llllll111l11ll1l11ll11l1, $lll111l1lll1111lll1l11l11111111, 5, 39, 0, 0, 310, 413, $l111lll1l11lll1l11l1ll1ll1l11l1[0], $l111lll1l11lll1l11l1ll1ll1l11l1[1]);
		if (!empty($l1lll1l1l11l11lllllll1lll11111l['posterqrcode'])) {
			$ll1l11l1lllll1llll111111l1111ll = tomedia($l1lll1l1l11l11lllllll1lll11111l['posterqrcode']);
			$l1ll11l111l11l1ll1ll1ll11l11111 = ImageCreateFromJPEG(tomedia($l1lll1l1l11l11lllllll1lll11111l['posterqrcode']));
		} elseif (intval($l1lll1l1l11l11lllllll1lll11111l['qrcodetype']) == 1 && $_W['account']['level'] == 4 && $l11l1l1l1l1111l1l1lllll1111l11l != 0 && ($l11llllllll1l11l11lll1l1111111l = pdo_fetch("SELECT * FROM " . tablename('xiaof_toupiao_rule') . " WHERE `sid` = '" . $l1lll1l1l11l11lllllll1lll11111l['id'] . "' AND `action` = '3' limit 1"))) {
			$llll1ll11llll111111111l11l1l11l = str_replace(array('^', '$', '*'), '', $l11llllllll1l11l11lll1l1111111l['keyword']);
			$llll1ll11llll111111111l11l1l11l = str_replace('[0-9]', $l11l1l1l1l1111l1l1lllll1111l11l, $llll1ll11llll111111111l11l1l11l);
			$ll1l11l1lllll1llll111111l1111ll = $this->l111l111lllll11ll1l11lll1111ll1($llll1ll11llll111111111l11l1l11l);
			$l1ll11l111l11l1ll1ll1ll11l11111 = ImageCreateFromJPEG($ll1l11l1lllll1llll111111l1111ll);
		} else {
			$ll1l11l1lllll1llll111111l1111ll = $this->ll11ll1l1l11l11ll11llll1l1ll11l('getqrcode', 'xiaof_toupiao', '&url=' . urlencode($l11ll1111lll111lll11ll11ll111l1) . '');
			$l1ll11l111l11l1ll1ll1ll11l11111 = ImageCreateFromPNG($ll1l11l1lllll1llll111111l1111ll);
		}
		$llll11lllll1l1l1llll1l11ll1ll1l = getimagesize($ll1l11l1lllll1llll111111l1111ll);
		imagecopyresized($lll1l11llllll111l11ll1l11ll11l1, $l1ll11l111l11l1ll1ll1ll11l11111, 17, 400, 0, 0, 126, 126, $llll11lllll1l1l1llll1l11ll1ll1l[0], $llll11lllll1l1l1llll1l11ll1ll1l[1]);
		$l1l11l1l1l1111lll1lll1ll111l111 = mb_convert_encoding($l1l11l1l1l1111lll1lll1ll111l111, 'html-entities', 'UTF-8');
		imagettftext($lll1l11llllll111l11ll1l11ll11l1, 14, 0, 198, 488, $l11ll111l1ll1llll111l1l1111l1ll, $lllll11lllll11lll1ll1lll1llll11, $l1l11l1l1l1111lll1lll1ll111l111);
		imagettftext($lll1l11llllll111l11ll1l11ll11l1, 14, 0, 198, 516, $l11ll111l1ll1llll111l1l1111l1ll, $lllll11lllll11lll1ll1lll1llll11, $l11l1l1l1l1111l1l1lllll1111l11l);
		if ($l1111ll1l1l1l11l11l1lll11l1l1ll) {
			ImageJPEG($lll1l11llllll111l11ll1l11ll11l1);
			ImageDestroy($l1ll11l111l11l1ll1ll1ll11l11111);
			ImageDestroy($lll111l1lll1111lll1l11l11111111);
			ImageDestroy($lll1l11llllll111l11ll1l11ll11l1);
		} else {
			$l111ll1llll1l1l1ll11l1llll11111 = 'images/xiaof/' . $l1lll1l1l11l11lllllll1lll11111l['id'] . '/' . date('Y/m/');
			$l1111l111l1l1llll1l1l1l111l1ll1 = random(30) . '.jpg';
			is_dir(ATTACHMENT_ROOT . '/' . $l111ll1llll1l1l1ll11l1llll11111) or mkdirs(ATTACHMENT_ROOT . '/' . $l111ll1llll1l1l1ll11l1llll11111);
			ImageJPEG($lll1l11llllll111l11ll1l11ll11l1, ATTACHMENT_ROOT . '/' . $l111ll1llll1l1l1ll11l1llll11111 . $l1111l111l1l1llll1l1l1l111l1ll1);
			ImageDestroy($l1ll11l111l11l1ll1ll1ll11l11111);
			ImageDestroy($lll111l1lll1111lll1l11l11111111);
			ImageDestroy($lll1l11llllll111l11ll1l11ll11l1);
			return $l111ll1llll1l1l1ll11l1llll11111 . $l1111l111l1l1llll1l1l1l111l1ll1;
		}
	}
	public function doMobileGetPoster()
	{
		$this->l1ll11l1l11111lll1l11111l111l1l('演示', 0, MODULE_ROOT . '/resources/image/posterpic.jpg', urlencode($this->ll11ll1l1l11l11ll11llll1l1ll11l('index')), true);
	}
	public function doMobileGetqrcode()
	{
		global $_GPC;
		$l11ll1111lll111lll11ll11ll111l1 = urldecode($_GPC['url']);
		require IA_ROOT . '/framework/library/qrcode/phpqrcode.php';
		$l1l11ll11l11111ll111l1lllll111l = "L";
		$llll11lll1ll1ll11lll111l1l1l1l1 = "4";
		QRcode::png($l11ll1111lll111lll11ll11ll111l1, false, $l1l11ll11l11111ll111l1lllll111l, $llll11lll1ll1ll11lll111l1l1l1l1, 2);
		die;
	}
	private function l111l111lllll11ll1l11lll1111ll1($l1l1ll111l11ll1llll111l11lllll1)
	{
		global $_GPC, $_W;
		$l1111llll1l1lll1lll11111ll111ll = array('expire_seconds' => '2592000', 'action_name' => 'QR_SCENE', 'action_info' => array('scene' => array()));
		$ll1ll1111ll1ll11l1l1ll11l11lll1 = intval($_W['acid']);
		$lll111llll111111111111l111l1l1l = WeAccount::create($ll1ll1111ll1ll11l1l1ll11l11lll1);
		$ll1ll111llll1l111llll11ll1111ll = pdo_fetchcolumn("SELECT qrcid FROM " . tablename('qrcode') . " WHERE acid = :acid AND model = '1' ORDER BY qrcid DESC LIMIT 1", array(':acid' => $ll1ll1111ll1ll11l1l1ll11l11lll1));
		$l1111llll1l1lll1lll11111ll111ll['action_info']['scene']['scene_id'] = !empty($ll1ll111llll1l111llll11ll1111ll) ? $ll1ll111llll1l111llll11ll1111ll + 1 : 100001;
		$l1111llll1l1lll1lll11111ll111ll['expire_seconds'] = 2592000;
		$l1111llll1l1lll1lll11111ll111ll['action_name'] = 'QR_SCENE';
		$lll1ll1l1l1l1llll11l1lll11111l1 = $lll111llll111111111111l111l1l1l->barCodeCreateDisposable($l1111llll1l1lll1lll11111ll111ll);
		if (!is_error($lll1ll1l1l1l1llll11l1lll11111l1)) {
			$lll11l111l11lll1l11ll1llll11lll = array('uniacid' => $_W['uniacid'], 'acid' => $ll1ll1111ll1ll11l1l1ll11l11lll1, 'qrcid' => $l1111llll1l1lll1lll11111ll111ll['action_info']['scene']['scene_id'], 'scene_str' => '', 'keyword' => $l1l1ll111l11ll1llll111l11lllll1, 'name' => '投票海报二维码', 'model' => 1, 'ticket' => $lll1ll1l1l1l1llll11l1lll11111l1['ticket'], 'url' => $lll1ll1l1l1l1llll11l1lll11111l1['url'], 'expire' => $lll1ll1l1l1l1llll11l1lll11111l1['expire_seconds'], 'createtime' => TIMESTAMP, 'status' => '1', 'type' => 'scene');
			pdo_insert('qrcode', $lll11l111l11lll1l11ll1llll11lll);
		}
		return 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($lll1ll1l1l1l1llll11l1lll11111l1['ticket']);
	}
	public function doMobileUploadImg()
	{
		global $_W, $_GPC;
		if (empty($_GPC['serverid'])) {
			die;
		}
		load()->classs('weixin.account');
		$l11l1l11lllll11ll111l1ll1l1ll11 = WeiXinAccount::create($_W['account']['jsauth_acid']);
		$l1l11ll11l111ll1lll1ll1lll1ll11 = isset($_GPC['type']) ? $_GPC['type'] : 'image';
		$l111l1l11ll1l111l1l1ll11l11lll1 = $l11l1l11lllll11ll111l1ll1l1ll11->downloadMedia(array('type' => $l1l11ll11l111ll1lll1ll1lll1ll11, 'media_id' => $_GPC['serverid']));
		if (!is_error($l111l1l11ll1l111l1l1ll11l11lll1)) {
			if ($l1l11ll11l111ll1lll1ll1lll1ll11 == 'voice') {
				if (!empty($_W['setting']['remote']['type'])) {
					$lll1111111ll111l1l1l1ll1ll1l1ll = pathinfo($l111l1l11ll1l111l1l1ll11l11lll1);
					$l1111l111l1l1llll1l1l1l111l1ll1 = $lll1111111ll111l1l1l1ll1ll1l1ll['filename'] . '.' . $lll1111111ll111l1l1l1ll1ll1l1ll['extension'];
					$l1ll11l11l1l1l111ll11l1lllll111 = ihttp_get(tomedia($l111l1l11ll1l111l1l1ll11l11lll1));
					file_write($l1111l111l1l1llll1l1l1l111l1ll1, $l1ll11l11l1l1l111ll11l1lllll111['content']);
				} else {
					$l1111l111l1l1llll1l1l1l111l1ll1 = $l111l1l11ll1l111l1l1ll11l11lll1;
				}
				$ll1l1l1llll11ll1ll1111l11ll1lll = $this->ll11ll1ll11l1l1l11l1l111l1l1lll($l1111l111l1l1llll1l1l1l111l1ll1);
				if (is_error($ll1l1l1llll11ll1ll1111l11ll1lll)) {
					die(json_encode(error(102, $ll1l1l1llll11ll1ll1111l11ll1lll['message'])));
				} else {
					$l111l1l11ll1l111l1l1ll11l11lll1 = $ll1l1l1llll11ll1ll1111l11ll1lll;
				}
			}
			echo json_encode(error(0, $l111l1l11ll1l111l1l1ll11l11lll1));
		} else {
			echo json_encode(error(102, $l111l1l11ll1l111l1l1ll11l11lll1['message']));
		}
	}
	public function doMobileQiniuCallback()
	{
		echo true;
	}
	private function l11llllll1llll11ll1lllll11l11ll($llll11l111lllllllllll1l1l111l11, $lll1lll111l111l11l1l11111ll11l1)
	{
		$lll1ll1l1l1l1llll11l1lll11111l1 = '';
		$lll111111ll1l1l1l111lll1lll1l1l = array();
		foreach ($llll11l111lllllllllll1l1l111l11 as $l1l1ll111l11ll1llll111l11lllll1 => $l1l11ll111ll11l1111111lll1l11ll) {
			$lll111111ll1l1l1l111lll1lll1l1l[$l1l1ll111l11ll1llll111l11lllll1] = $l1l11ll111ll11l1111111lll1l11ll['probability'];
		}
		$l1l11ll111l1l1lll11llll11l1lll1 = array_sum($lll111111ll1l1l1l111lll1lll1l1l);
		foreach ($lll111111ll1l1l1l111lll1lll1l1l as $l1l1ll111l11ll1llll111l11lllll1 => $ll11l11ll1111llll11ll1llll1llll) {
			$l1l1111ll1ll11ll1ll1l1ll1l111l1 = mt_rand(1, $l1l11ll111l1l1lll11llll11l1lll1);
			if ($l1l1111ll1ll11ll1ll1l1ll1l111l1 <= $ll11l11ll1111llll11ll1llll1llll) {
				$lll1ll1l1l1l1llll11l1lll11111l1 = $l1l1ll111l11ll1llll111l11lllll1;
				break;
			} else {
				$l1l11ll111l1l1lll11llll11l1lll1 -= $ll11l11ll1111llll11ll1llll1llll;
			}
		}
		if ($llll11l111lllllllllll1l1l111l11[$lll1ll1l1l1l1llll11l1lll11111l1]['attr'] == '1') {
			$l11111ll11l1111llll111llll1lll1 = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xiaof_toupiao_draw') . " WHERE `sid` = :sid AND `attr` = :attr AND `num` = :num", array(":sid" => $lll1lll111l111l11l1l11111ll11l1, ":attr" => 1, ":num" => $lll1ll1l1l1l1llll11l1lll11111l1));
			if ($l11111ll11l1111llll111llll1lll1 >= $llll11l111lllllllllll1l1l111l11[$lll1ll1l1l1l1llll11l1lll11111l1]['num']) {
				$lll1ll1l1l1l1llll11l1lll11111l1 = $this->l11llllll1llll11ll1lllll11l11ll($llll11l111lllllllllll1l1l111l11, $lll1lll111l111l11l1l11111ll11l1);
			}
		}
		return $lll1ll1l1l1l1llll11l1lll11111l1;
	}
	private function ll11ll1ll11l1l1l11l1l111l1l1lll($ll1l11l111ll1111l1111ll1l1ll1l1, $l1l11ll11l111ll1lll1ll1lll1ll11 = 'mp3', $l1ll11ll1l11l11l11l1l111l1l11l1 = '')
	{
		global $_W, $_GPC;
		require_once IA_ROOT . '/framework/library/qiniu/autoload.php';
		$ll11ll111l1lll11l1l11lll1ll1l11 = $this->module['config']['qiniuak'];
		$l1ll11111l1l1llll11111111l11l1l = $this->module['config']['qiniusk'];
		$ll11l1l1ll1l11ll1ll1l1l11111l11 = new Qiniu\Auth($ll11ll111l1lll11l1l11lll1ll1l11, $l1ll11111l1l1llll11111111l11l1l);
		$lllll1l1ll111111l1l1l11lll1ll11 = array();
		if ($l1l11ll11l111ll1lll1ll1lll1ll11 == 'mp3') {
			$l11l11l1llll1l1l1ll11llllll11l1 = random(30) . '.mp3';
			$ll11l11l11lllll11ll1lllll1ll1l1 = Qiniu\base64_urlSafeEncode($this->module['config']['qiniuzone'] . ':' . $l11l11l1llll1l1l1ll11llllll11l1);
			$lllll1l1ll111111l1l1l11lll1ll11 = array('persistentOps' => 'avthumb/mp3/ab/128k|saveas/' . $ll11l11l11lllll11ll1lllll1ll1l1, 'persistentNotifyUrl' => $_W['siteroot'] . "app/index.php?c=entry&do=qiniuCallback&m=xiaof_toupiao&i={$_W['uniacid']}");
			empty($this->module['config']['qiniupipeline']) or $lllll1l1ll111111l1l1l11lll1ll11['persistentPipeline'] = $this->module['config']['qiniupipeline'];
		} elseif ($l1l11ll11l111ll1lll1ll1lll1ll11 == 'img') {
			$lllll1l1ll111111l1l1l11lll1ll11 = array('persistentOps' => $l1ll11ll1l11l11l11l1l111l1l11l1 . '', 'persistentNotifyUrl' => $_W['siteroot'] . "app/index.php?c=entry&do=qiniuCallback&m=xiaof_toupiao&i={$_W['uniacid']}");
			empty($this->module['config']['qiniupipeline']) or $lllll1l1ll111111l1l1l11lll1ll11['persistentPipeline'] = $this->module['config']['qiniupipeline'];
		}
		$ll111ll1l11llllll1l1lllllll1l1l = $ll11l1l1ll1l11ll1ll1l1l11111l11->uploadToken($this->module['config']['qiniuzone'], null, 3600, $lllll1l1ll111111l1l1l11lll1ll11);
		$llll11lll1l11l111111llll1l1ll11 = new Qiniu\Storage\UploadManager();
		$l111ll1llll1l1l1ll11l1llll11111 = ATTACHMENT_ROOT . $ll1l11l111ll1111l1111ll1l1ll1l1;
		list($l1lll111l11lllll11lll11111ll11l, $l11lll1111llllll1111l11lllll11l) = $llll11lll1l11l111111llll1l1ll11->putFile($ll111ll1l11llllll1l1lllllll1l1l, $ll1l11l111ll1111l1111ll1l1ll1l1, $l111ll1llll1l1l1ll11l1llll11111);
		if (empty($l11lll1111llllll1111l11lllll11l)) {
			load()->func('file');
			file_delete($ll1l11l111ll1111l1111ll1l1ll1l1);
			isset($l11l11l1llll1l1l1ll11llllll11l1) && ($ll1l11l111ll1111l1111ll1l1ll1l1 = $l11l11l1llll1l1l1ll11llllll11l1);
			return "http://{$this->module['config']['qiniudomain']}/{$ll1l11l111ll1111l1111ll1l1ll1l1}";
		} else {
			return error(-1, '七牛参数配置错误');
		}
	}
	private function lllll1l1lll1l1l1111lll1l1ll11ll($l1l11l1lllll11lll11l11l1ll111l1, $l1ll11l1lll1l1111l1l1l1l1llll11 = 500)
	{
		global $_W;
		$l111lll1l1ll1l1111l1llllll11111 = '/-(240|500)/is';
		if (strexists($l1l11l1lllll11lll11l11l1ll111l1, 'http://') || strexists($l1l11l1lllll11lll11l11l1ll111l1, 'https://')) {
			$l1l1l11l11l1lll1ll11l1l11ll11ll = parse_url($l1l11l1lllll11lll11l11l1ll111l1);
			$l1l11l1lllll11lll11l11l1ll111l1 = $l1l1l11l11l1lll1ll11l1l11ll11ll['path'];
		}
		$ll1l11l111ll1111l1111ll1l1ll1l1 = preg_replace($l111lll1l1ll1l1111l1llllll11111, '', $l1l11l1lllll11lll11l11l1ll111l1);
		$lll1111111ll111l1l1l1ll1ll1l1ll = pathinfo($ll1l11l111ll1111l1111ll1l1ll1l1);
		$l1l11111l1111111ll11llllll111l1 = $lll1111111ll111l1l1l1ll1ll1l1ll['dirname'] == '/' ? '' : $lll1111111ll111l1l1l1ll1ll1l1ll['dirname'] . '/';
		$l1l11111l1111111ll11llllll111l1 .= $lll1111111ll111l1l1l1ll1ll1l1ll['filename'] . '-' . $l1ll11l1lll1l1111l1l1l1l1llll11 . '.' . $lll1111111ll111l1l1l1ll1ll1l1ll['extension'];
		$l1l11111l1111111ll11llllll111l1 = trim($l1l11111l1111111ll11llllll111l1, '/');
		$l111111l11l1l1lllllll1l1lll1111 = ATTACHMENT_ROOT . '/' . $l1l11111l1111111ll11llllll111l1;
		if ($l1l11l1lllll11lll11l11l1ll111l1 != $l1l11111l1111111ll11llllll111l1) {
			$this->l111lllll1l11111lll1l1ll1lllll1(tomedia($l1l11l1lllll11lll11l11l1ll111l1), $l111111l11l1l1lllllll1l1lll1111, $l1ll11l1lll1l1111l1l1l1l1llll11);
		}
		if ($this->module['config']['imagesaveqiniu'] >= 1) {
			if (!$this->ll11ll1ll11111111llll1l1111l11l("http://{$this->module['config']['qiniudomain']}/{$l1l11111l1111111ll11llllll111l1}")) {
				return $this->ll11ll1ll11l1l1l11l1l111l1l1lll($l1l11111l1111111ll11llllll111l1, 'img', 'imageView2/2/w/' . $l1ll11l1lll1l1111l1l1l1l1llll11);
			} else {
				return "http://{$this->module['config']['qiniudomain']}/{$l1l11111l1111111ll11llllll111l1}";
			}
		} else {
			if (!empty($_W['setting']['remote']['type']) && !$this->ll11ll1ll11111111llll1l1111l11l($_W['attachurl_remote'] . $l1l11111l1111111ll11llllll111l1)) {
				load()->func('file');
				file_remote_upload($l1l11111l1111111ll11llllll111l1);
			}
		}
		return $l1l11111l1111111ll11llllll111l1;
	}
	private function ll11ll1ll11111111llll1l1111l11l($l1l11l1lllll11lll11l11l1ll111l1)
	{
		load()->func('communication');
		$l1l11ll11ll1l11l1111l1ll111ll11 = ihttp_get($l1l11l1lllll11lll11l11l1ll111l1);
		return $l1l11ll11ll1l11l1111l1ll111ll11['code'] == 200 ? true : false;
	}
	private function l111lllll1l11111lll1l1ll1lllll1($l11ll11ll11ll1l11llll11l111lll1, $ll1lll1l11lll1lllll1l1ll111l11l = '', $l1ll11l1lll1l1111l1l1l1l1llll11 = 0)
	{
        global $_W;
        if (empty($ll1lll1l11lll1lllll1l1ll111l11l)) {
            $l11l1ll11l11l1ll1l1111l11l1l11l = pathinfo($l11ll11ll11ll1l11llll11l111lll1, PATHINFO_EXTENSION);
            $l1lll11ll1l11l11llll1lll1l11l1l = dirname($l11ll11ll11ll1l11llll11l111lll1);
            do {
                $ll1lll1l11lll1lllll1l1ll111l11l = $l1lll11ll1l11l11llll1lll1l11l1l . '/' . random(30) . ".{$l11l1ll11l11l1ll1l1111l11l1l11l}";
            } while (file_exists($ll1lll1l11lll1lllll1l1ll111l11l));
        }
        $l1lll11l1111l1111l1111111l1ll1l = dirname($ll1lll1l11lll1lllll1l1ll111l11l);
        if (!file_exists($l1lll11l1111l1111l1111111l1ll1l)) {
            if (!mkdirs($l1lll11l1111l1111l1111111l1ll1l)) {
                return error('-1', '创建目录失败');
            }
        }
        $llll11ll1l1ll1l1ll11ll111l11lll = @getimagesize($l11ll11ll11ll1l11llll11l111lll1);
        if ($llll11ll1l1ll1l1ll11ll111l11lll) {
            if ($l1ll11l1lll1l1111l1l1l1l1llll11 == 0 || $l1ll11l1lll1l1111l1l1l1l1llll11 > $llll11ll1l1ll1l1ll11ll111l11lll[0]) {
                copy($l11ll11ll11ll1l11llll11l111lll1, $ll1lll1l11lll1lllll1l1ll111l11l);
                return str_replace(ATTACHMENT_ROOT . '/', '', $ll1lll1l11lll1lllll1l1ll111l11l);
            }
            if ($llll11ll1l1ll1l1ll11ll111l11lll[2] == 1) {
                if (function_exists("imagecreatefromgif")) {
                    $l1l1l111ll1l1l1ll11111l11l11lll = imagecreatefromgif($l11ll11ll11ll1l11llll11l111lll1);
                }
            } elseif ($llll11ll1l1ll1l1ll11ll111l11lll[2] == 2) {
                if (function_exists("imagecreatefromjpeg")) {
                    $l1l1l111ll1l1l1ll11111l11l11lll = imagecreatefromjpeg($l11ll11ll11ll1l11llll11l111lll1);
                }
            } elseif ($llll11ll1l1ll1l1ll11ll111l11lll[2] == 3) {
                if (function_exists("imagecreatefrompng")) {
                    $l1l1l111ll1l1l1ll11111l11l11lll = imagecreatefrompng($l11ll11ll11ll1l11llll11l111lll1);
                    imagesavealpha($l1l1l111ll1l1l1ll11111l11l11lll, true);
                }
            }
        } else {
            return error('-1', '获取原始图像信息失败');
        }
        $l111l1l11lll111ll1l1l111lll1ll1 = $llll11ll1l1ll1l1ll11ll111l11lll[0] / $llll11ll1l1ll1l1ll11ll111l11lll[1];
        $llll11llll1llll11l1ll111111ll1l = $l1ll11l1lll1l1111l1l1l1l1llll11 / $l111l1l11lll111ll1l1l111lll1ll1;
        if (function_exists("imagecreatetruecolor") && function_exists("imagecopyresampled") && @($l11ll1111l111lllll11ll11ll1111l = imagecreatetruecolor($l1ll11l1lll1l1111l1l1l1l1llll11, $llll11llll1llll11l1ll111111ll1l))) {
            imagealphablending($l11ll1111l111lllll11ll11ll1111l, false);
            imagesavealpha($l11ll1111l111lllll11ll11ll1111l, true);
            imagecopyresampled($l11ll1111l111lllll11ll11ll1111l, $l1l1l111ll1l1l1ll11111l11l11lll, 0, 0, 0, 0, $l1ll11l1lll1l1111l1l1l1l1llll11, $llll11llll1llll11l1ll111111ll1l, $llll11ll1l1ll1l1ll11ll111l11lll[0], $llll11ll1l1ll1l1ll11ll111l11lll[1]);
            $l1lll1l1l11l11lllllll1lll11111l = $this->l1l11ll11ll1l1111lll11lllll1l11();
            if (!empty($l1lll1l1l11l11lllllll1lll11111l['watermark'])) {
                imagealphablending($l11ll1111l111lllll11ll11ll1111l, true);
                $l111l11l1111ll1ll11lll1l11l11l1 = tomedia($l1lll1l1l11l11lllllll1lll11111l['watermark']);
                $llll1l11l11l11l11l11ll1l1l111l1 = ImageCreateFromPNG($l111l11l1111ll1ll11lll1l11l11l1);
                $ll1l11l1ll1ll1ll1ll11l11l1l1ll1 = @getimagesize($l111l11l1111ll1ll11lll1l11l11l1);
                imagecopyresampled($l11ll1111l111lllll11ll11ll1111l, $llll1l11l11l11l11l11ll1l1l111l1, $l1ll11l1lll1l1111l1l1l1l1llll11 - $ll1l11l1ll1ll1ll1ll11l11l1l1ll1[0] - 8, $llll11llll1llll11l1ll111111ll1l - $ll1l11l1ll1ll1ll1ll11l11l1l1ll1[1] - 8, 0, 0, $ll1l11l1ll1ll1ll1ll11l11l1l1ll1[0], $ll1l11l1ll1ll1ll1ll11l11l1l1ll1[1], $ll1l11l1ll1ll1ll1ll11l11l1l1ll1[0], $ll1l11l1ll1ll1ll1ll11l11l1l1ll1[1]);
            }
        } else {
            return error('-1', 'PHP环境不支持图片处理');
        }


        //$l11ll1111l111lllll11ll11ll1111l
        $bg = imagecreatefromjpeg(MODULE_ROOT . '/resources/image/bg.jpg');

        $left=87;
        $top=61;
        $width=330;
        $height=581;


        $src_left=0;
        $src_top=0;
        $src_width=imagesx($l11ll1111l111lllll11ll11ll1111l);
        $src_height=imagesy($l11ll1111l111lllll11ll11ll1111l);

        $prop=$width/$height;

        $src_prop=$src_width/$src_height;

        if($src_prop>$prop){
            $d= $src_width-($src_height*$prop);
            $src_left=$d/2;
            $src_width=$src_width-($d/2);
        }


        if($src_prop<$prop){
            $d=$src_height-($src_width/$prop);
            $src_top=$d/2;
            $src_height=$src_height-($d/2);
        }


        imagecopyresized($bg,$l11ll1111l111lllll11ll11ll1111l,$left,$top,$src_left,$src_top,$width,$height,$src_width,$src_height);

        if ($llll11ll1l1ll1l1ll11ll111l11lll[2] == 2) {
            if (function_exists('imagejpeg')) {
                imagejpeg($bg, $ll1lll1l11lll1lllll1l1ll111l11l);
            }
        } else {
            if (function_exists('imagepng')) {
                imagepng($bg, $ll1lll1l11lll1lllll1l1ll111l11l);
            }
        }
        imagedestroy($l11ll1111l111lllll11ll11ll1111l);
        imagedestroy($l1l1l111ll1l1l1ll11111l11l11lll);
        return str_replace(ATTACHMENT_ROOT . '/', '', $ll1lll1l11lll1lllll1l1ll111l11l);
	}
	public function doMobileVerifyLocation()
	{
		global $_W, $_GPC;
		if ($_W['container'] !== 'wechat' or empty($_W['openid'])) {
			die(json_encode(error(1, '错误')));
		}
		$l1lll1l1l11l11lllllll1lll11111l = $this->l1l11ll11ll1l1111lll11lllll1l11();
		if (!$l1lll1l1l11l11lllllll1lll11111l) {
			die(json_encode(error(2, '没有获取到活动信息')));
		}
		$lllll1l111l1l111ll1llll1l1l1lll = $_GPC['latitude'];
		$ll11l111l1ll1l1111l1ll1l111l1ll = $_GPC['longitude'];
		$l11ll1111lll111lll11ll11ll111l1 = "http://api.map.baidu.com/geocoder/v2/?ak=" . $this->module['config']['baidumapak'] . "&location=" . $lllll1l111l1l111ll1llll1l1l1lll . "," . $ll11l111l1ll1l1111l1ll1l111l1ll . "&output=json&pois=0";
		load()->func('communication');
		$l1ll11l11l1l1l111ll11l1lllll111 = ihttp_get($l11ll1111lll111lll11ll11ll111l1);
		if (!is_error($l1ll11l11l1l1l111ll11l1lllll111)) {
			if ($l11l11lll1l1l111ll1ll11lll1l11l = $this->l1l11l1111l111ll11l111ll1l1lll1('rid')) {
				$ll1ll11llll1l11l11llll1ll11ll1l = json_decode($l1ll11l11l1l1l111ll11l1lllll111['content'], true);
				if ($ll1ll11llll1l11l11llll1ll11ll1l['status'] == 0) {
					$l111111l1ll111l1lllll11l1l11l1l = iserializer(array('province' => trim($ll1ll11llll1l11l11llll1ll11ll1l['result']['addressComponent']['province']), 'city' => trim($ll1ll11llll1l11l11llll1ll11ll1l['result']['addressComponent']['city']), 'county' => trim($ll1ll11llll1l11l11llll1ll11ll1l['result']['addressComponent']['district'])));
					pdo_update("xiaof_relation", array('gps_city' => $l111111l1ll111l1lllll11l1l11l1l), array("id" => $l11l11lll1l1l111ll1ll11lll1l11l));
					die(json_encode(error(0, '成功')));
				} else {
					die(json_encode(error(5, 'GPS获取地址信息失败')));
				}
			} else {
				die(json_encode(error(3, '没有获取到用户信息')));
			}
		} else {
			die(json_encode(error(4, 'GPS获取地址信息失败')));
		}
	}
	public function doMobileGetsms()
	{
		global $_W, $_GPC;
		if ($_W['container'] !== 'wechat' or empty($_GPC['phone']) or empty($_W['openid'])) {
			die(json_encode(error(1, '错误')));
		}
		$l1lll1l1l11l11lllllll1lll11111l = $this->l1l11ll11ll1l1111lll11lllll1l11();
		if (!$l1lll1l1l11l11lllllll1lll11111l) {
			die(json_encode(error(2, '没有获取到活动信息')));
		}
		if ($l1lll1l1l11l11lllllll1lll11111l['verifysms'] != 1) {
			die(json_encode(error(10, '关闭')));
		}
		if (isset($_SESSION['verifycode'])) {
			$lllll11l1ll11llll1ll1llll1l1lll = iunserializer($_SESSION['verifycode']);
			if (isset($lllll11l1ll11llll1ll1llll1l1lll['created_at']) && $lllll11l1ll11llll1ll1llll1l1lll['created_at'] + 60 >= time()) {
				die(json_encode(error(9, '请60秒后再发送')));
			}
		}
		$ll1llllll11lllllll11l1l11llllll = $_GPC['phone'];
		$lll1l111l1lll1l11111111lll111ll = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xiaof_toupiao_smslog') . " where `phone` = '" . $ll1llllll11lllllll11l1l11llllll . "' AND `unique_at` = '" . date("Ymd") . "'");
		if ($lll1l111l1lll1l11111111lll111ll >= $this->module['config']['smsphonenum']) {
			die(json_encode(error(6, '该手机号今天允许的短信条数已经发完')));
		}
		$lll1l111l1lll1l11111111lll111ll = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xiaof_toupiao_smslog') . " where `ip` = '" . ip2long(CLIENT_IP) . "' AND `unique_at` = '" . date("Ymd") . "'");
		if ($lll1l111l1lll1l11111111lll111ll >= $this->module['config']['smsipnum']) {
			die(json_encode(error(7, '该IP今天允许的短信条数已经发完')));
		}
		if (pdo_fetch("SELECT * FROM " . tablename("xiaof_relation") . " WHERE `uniacid` = :uniacid AND `phone` = :phone limit 1", array(":uniacid" => $_W['uniacid'], ":phone" => $ll1llllll11lllllll11l1l11llllll))) {
			die(json_encode(error(8, '该手机号已在其他微信号验证')));
		}
		$l1lll1llll1l11lll11llll1l1ll11l = mt_rand(1000, 9999);
		load()->func('communication');
		$l1l1lll111ll111l1ll11l111l1ll1l = ihttp_get('http://life.tenpay.com/cgi-bin/mobile/MobileQueryAttribution.cgi?chgmobile=' . $ll1llllll11lllllll11l1l11llllll);
		$l1l1lll111ll111l1ll11l111l1ll1l = @simplexml_load_string($l1l1lll111ll111l1ll11l111l1ll1l['content'], NULL, LIBXML_NOCDATA);
		$ll1ll11llll1l11l11llll1ll11ll1l = json_decode(json_encode($l1l1lll111ll111l1ll11l111l1ll1l), true);
		if (in_array('sms', $l1lll1l1l11l11lllllll1lll11111l['veriftype'])) {
			$lll1111llllll1llllll11l1ll111l1 = intval($l1lll1l1l11l11lllllll1lll11111l['citylevel']);
			switch ($lll1111llllll1llllll11l1ll111l1) {
				case '0':
					$ll11l1ll1lllll1l1ll11ll1lll1111 = $ll1ll11llll1l11l11llll1ll11ll1l['province'];
					break;
				case '1':
					$ll11l1ll1lllll1l1ll11ll1lll1111 = $ll1ll11llll1l11l11llll1ll11ll1l['city'];
					break;
				case '2':
					$ll11l1ll1lllll1l1ll11ll1lll1111 = $ll1ll11llll1l11l11llll1ll11ll1l['city'];
					break;
				default:
					$ll11l1ll1lllll1l1ll11ll1lll1111 = $ll1ll11llll1l11l11llll1ll11ll1l['province'];
					break;
			}
			$ll11l1ll1lllll1l1ll11ll1lll1111 = trim($ll11l1ll1lllll1l1ll11ll1lll1111);
			if (empty($ll11l1ll1lllll1l1ll11ll1lll1111)) {
				die(json_encode(error(3, '没有获取到手机号归属地')));
			}
			if (count($l1lll1l1l11l11lllllll1lll11111l['city']) >= 1) {
				$llllll1llllll1l11ll1llll11lll1l = false;
				foreach ($l1lll1l1l11l11lllllll1lll11111l['city'] as $l1ll1ll1l11ll11l111llll1l1111ll) {
					if (strexists($l1ll1ll1l11ll11l111llll1l1111ll, $ll11l1ll1lllll1l1ll11ll1lll1111)) {
						$llllll1llllll1l11ll1llll11lll1l = true;
						break;
					}
				}
			} else {
				$llllll1llllll1l11ll1llll11lll1l = true;
			}
			if (!$llllll1llllll1l11ll1llll11lll1l) {
				die(json_encode(error(4, '活动仅限本地区参与投票，您的手机归属地不在本地区')));
			}
		}
		$lll1ll1l1l1l1llll11l1lll11111l1 = $this->l111l1l1l1l1ll1llllllll1l111ll1($l1lll1llll1l11lll11llll1l1ll11l, (string) $ll1llllll11lllllll11l1l11llllll, $l1lll1l1l11l11lllllll1lll11111l['title']);
		if (isset($lll1ll1l1l1l1llll11l1lll11111l1->result->err_code) && $lll1ll1l1l1l1llll11l1lll11111l1->result->err_code == 0) {
			pdo_insert("xiaof_toupiao_smslog", array("phone" => $ll1llllll11lllllll11l1l11llllll, "ip" => ip2long(CLIENT_IP), "unique_at" => date("Ymd"), "created_at" => time()));
			$ll1lll11llll11lllllll11ll1l11l1 = array('created_at' => time(), 'phone' => $ll1llllll11lllllll11l1l11llllll, 'randcode' => $l1lll1llll1l11lll11llll1l1ll11l, 'addrs' => array('province' => trim($ll1ll11llll1l11l11llll1ll11ll1l['province']), 'city' => trim($ll1ll11llll1l11l11llll1ll11ll1l['city'])));
			$_SESSION['verifycode'] = iserializer($ll1lll11llll11lllllll11ll1l11l1);
			die(json_encode(error(0, '短信已发送成功')));
		} else {
			die(json_encode(error(5, '短信发送失败，请稍后再试')));
		}
	}
	private function l111l1l1l1l1ll1llllllll1l111ll1($ll1l11ll11l1ll111111l1ll1llll1l, $ll1llllll11lllllll11l1l11llllll, $ll111l1ll11l11lll1llllllll11l11)
	{
		define("TOP_SDK_WORK_DIR", MODULE_ROOT . '/library/Alidayu/');
		define("TOP_AUTOLOADER_PATH", MODULE_ROOT . '/library/Alidayu/');
		require_once MODULE_ROOT . '/library/Alidayu/Autoloader.php';
		$ll11l11lllll1l1l11ll111l11l1l11 = new TopClient();
		$ll11l11lllll1l1l11ll111l11l1l11->appkey = $this->module['config']['dayuak'];
		$ll11l11lllll1l1l11ll111l11l1l11->secretKey = $this->module['config']['dayusk'];
		$l1ll1l1111l1l1l11111ll1lllll1l1 = new AlibabaAliqinFcSmsNumSendRequest();
		$l1ll1l1111l1l1l11111ll1lllll1l1->setSmsType("normal");
		$l1ll1l1111l1l1l11111ll1lllll1l1->setSmsFreeSignName($this->module['config']['dayusign']);
		$l1ll1l1111l1l1l11111ll1lllll1l1->setSmsParam(json_encode(array('code' => (string) $ll1l11ll11l1ll111111l1ll1llll1l, 'product' => $this->module['config']['dayuname'], 'item' => $ll111l1ll11l11lll1llllllll11l11)));
		$l1ll1l1111l1l1l11111ll1lllll1l1->setRecNum($ll1llllll11lllllll11l1l11llllll);
		$l1ll1l1111l1l1l11111ll1lllll1l1->setSmsTemplateCode($this->module['config']['dayumoduleid']);
		return $ll11l11lllll1l1l11ll111l11l1l11->execute($l1ll1l1111l1l1l11111ll1lllll1l1);
	}
	private function ll11ll1l1l11l11ll11llll1l1ll11l($l1l11ll11lll11111llll11l11lll1l, $ll11l11l11l1l111l1l1ll11ll1llll = 'xiaof_toupiao', $lll1l1111lll1l1l1111l1l1ll11111 = '')
	{
		global $_W, $_GPC;
		if (empty($_GPC['sid'])) {
			isset($_SESSION) or session_start();
			isset($_SESSION['sid']) && ($_GPC['sid'] = $_SESSION['sid']);
		}
		return $_W['siteroot'] . "app/index.php?c=entry&do={$l1l11ll11lll11111llll11l11lll1l}&m={$ll11l11l11l1l111l1l1ll11ll1llll}&i={$_W['uniacid']}&sid={$_GPC['sid']}{$lll1l1111lll1l1l1111l1l1ll11111}&wxref=mp.weixin.qq.com#wechat_redirect";
	}
	private function l11llll11ll11111ll11111ll1l11ll()
	{
		global $_W, $_GPC;
		if (empty($_GPC['sid'])) {
			isset($_SESSION) or session_start();
			isset($_SESSION['sid']) && ($_GPC['sid'] = $_SESSION['sid']);
		}
		$l1lll1l1l11l11lllllll1lll11111l = $this->l1l11ll11ll1l1111lll11lllll1l11();
		$lll1l1l1ll11l1111111111llllllll = array();
		foreach ($l1lll1l1l11l11lllllll1lll11111l['menu'] as $l1ll1ll1l11ll11l111llll1l1111ll) {
			if ($l1ll1ll1l11ll11l111llll1l1111ll['isshow'] == 1) {
				$l1ll1ll1l11ll11l111llll1l1111ll['url'] = str_replace(array('{sid}', '{i}'), array($_GPC['sid'], $_W['uniacid']), $l1ll1ll1l11ll11l111llll1l1111ll['url']);
				$lll1l1l1ll11l1111111111llllllll[] = $l1ll1ll1l11ll11l111llll1l1111ll;
			}
		}
		return $this->lll1ll1lll1111ll11ll1lll1llll11($lll1l1l1ll11l1111111111llllllll, 'sort');
	}
	private function ll11l1l111lll11ll1l11llll11l1ll()
	{
		$l1lll1l1l11l11lllllll1lll11111l = $this->l1l11ll11ll1l1111lll11lllll1l11();
		if (!($lll11ll11l1l11l1lll111111lll1ll = $this->l1l1lllllll111llll111l1ll111lll('mypopularity' . $l1lll1l1l11l11lllllll1lll11111l['id']))) {
			$l1l11l1llll1llllll11l1llll1ll1l = array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id']);
			if ($l1lll1l1l11l11lllllll1lll11111l['verify'] == 1) {
				$l1l1l1l1l1ll1ll1ll11llll11ll11l = ' AND `verify`=:verify';
				$l1l11l1llll1llllll11l1llll1ll1l[':verify'] = 1;
			} else {
				$l1l1l1l1l1ll1ll1ll11llll11ll11l = ' AND `verify`!=:verify';
				$l1l11l1llll1llllll11l1llll1ll1l[':verify'] = 2;
			}
			$lll11ll11l1l11l1lll111111lll1ll = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao') . " WHERE `sid` = :sid " . $l1l1l1l1l1ll1ll1ll11llll11ll11l . " ORDER BY `share` DESC LIMIT 0,6", $l1l11l1llll1llllll11l1llll1ll1l);
			$this->l11lll11ll1l1111llll11ll1l1l111('mypopularity' . $l1lll1l1l11l11lllllll1lll11111l['id'], $lll11ll11l1l11l1lll111111lll1ll, 360);
		}
		return $lll11ll11l1l11l1lll111111lll1ll;
	}
	private function l1l11111ll1l111llll111ll1111l11($l1l1l11l11l11111l1l11lll11l1ll1)
	{
		$l1lll1l1l11l11lllllll1lll11111l = $this->l1l11ll11ll1l1111lll11lllll1l11();
		$ll11lll1111llllllllll11l1111111 = trim($l1lll1l1l11l11lllllll1lll11111l['thumblink']);
		$l11l11l11llllll1l11l1ll111111ll = explode(PHP_EOL, $ll11lll1111llllllllll11l1111111);
		return isset($l11l11l11llllll1l11l1ll111111ll[$l1l1l11l11l11111l1l11lll11l1ll1]) ? $l11l11l11llllll1l11l1ll111111ll[$l1l1l11l11l11111l1l11lll11l1ll1] : '';
	}
	private function l1l11ll11ll1l1111lll11lllll1l11()
	{
		if ($this->setting) {
			return $this->setting;
		}
		global $_GPC, $_W;
		isset($_SESSION) or session_start();
		$lll1lll111l111l11l1l11111ll11l1 = intval($_GPC['sid']);
		if (empty($lll1lll111l111l11l1l11111ll11l1) && !empty($_SESSION['sid'])) {
			$lll1lll111l111l11l1l11111ll11l1 = $_SESSION['sid'];
		} elseif (!empty($lll1lll111l111l11l1l11111ll11l1) && $lll1lll111l111l11l1l11111ll11l1 != $_SESSION['sid']) {
			$_SESSION['sid'] = $lll1lll111l111l11l1l11111ll11l1;
		}
		if ($ll1l1ll1ll111lllll11l111l1l11ll = pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao_setting") . " WHERE `id` = :id", array(":id" => intval($lll1lll111l111l11l1l11111ll11l1)))) {
			$ll1ll11llll1l11l11llll1ll11ll1l = iunserializer($ll1l1ll1ll111lllll11l111l1l11ll['data']);
			$l11lll1l1llll11lll1l1l1111l111l['id'] = $ll1l1ll1ll111lllll11l111l1l11ll['id'];
			$l11lll1l1llll11lll1l1l1111l111l['uniacid'] = $ll1l1ll1ll111lllll11l111l1l11ll['uniacid'];
			$l11lll1l1llll11lll1l1l1111l111l['click'] = $ll1l1ll1ll111lllll11l111l1l11ll['click'];
			$l11lll1l1llll11lll1l1l1111l111l['groups'] = iunserializer($ll1l1ll1ll111lllll11l111l1l11ll['groups']);
			$l11lll1l1llll11lll1l1l1111l111l['unfollow'] = $ll1l1ll1ll111lllll11l111l1l11ll['unfollow'];
			$l11lll1l1llll11lll1l1l1111l111l['bottom'] = !empty($ll1ll11llll1l11l11llll1ll11ll1l['bottom']) ? $ll1ll11llll1l11l11llll1ll11ll1l['bottom'] : $ll1l1ll1ll111lllll11l111l1l11ll['bottom'];
			$l11lll1l1llll11lll1l1l1111l111l['created_at'] = $ll1l1ll1ll111lllll11l111l1l11ll['created_at'];
			if ($ll1l1111llll1111ll1l1111l1111l1 = pdo_fetch("SELECT `qrcode` FROM " . tablename("xiaof_toupiao_acid") . " WHERE `sid` = :sid AND `acid` = :acid", array(":sid" => $ll1l1ll1ll111lllll11l111l1l11ll['id'], ":acid" => $_W['uniacid']))) {
				$l11lll1l1llll11lll1l1l1111l111l['accountqrcode'] = $ll1l1111llll1111ll1l1111l1111l1['qrcode'];
			}
			is_array($ll1ll11llll1l11l11llll1ll11ll1l['advotepic']) or $l11lll1l1llll11lll1l1l1111l111l['advotepic'] = array(0 => $ll1ll11llll1l11l11llll1ll11ll1l['advotepic']);
			$l11lll1l1llll11lll1l1l1111l111l['thumblinkarr'] = explode(PHP_EOL, trim($ll1ll11llll1l11l11llll1ll11ll1l['thumblink']));
			$l11lll1l1llll11lll1l1l1111l111l['advotelinkarr'] = explode(PHP_EOL, trim($ll1ll11llll1l11l11llll1ll11ll1l['advotelink']));
			$l1l1ll111l11ll1llll111l11lllll1 = md5($_SERVER['HTTP_HOST'] . $this->module['name'] . 'globalsetting');
			$l1ll11ll1lll1l1l111llll1l1111ll = cache_read("ipaddrr:" . $l1l1ll111l11ll1llll111l11lllll1);
			$l1ll11ll1lll1l1l111llll1l1111ll or $l1ll11ll1lll1l1l111llll1l1111ll = array('openmusic' => 1, 'openshare' => 1, 'openfollow' => 1);
			$l11lll1l1llll11lll1l1l1111l111l['globalsetting'] = $l1ll11ll1lll1l1l111llll1l1111ll;
			$this->setting = array_merge($ll1ll11llll1l11l11llll1ll11ll1l, $l11lll1l1llll11lll1l1l1111l111l);
			if (!isset($_SESSION['xiaofuserinfo']) or isset($_GET['xiaofopenid'])) {
				$this->l1l11l1111l111ll11l111ll1l1lll1();
			}
			return $this->setting;
		}
		return $this->setting = false;
	}
	private function l111l111111lllll1111l11ll1l111l()
	{
		global $_W;
		if (isset($_SESSION['xiaofuid']) && !empty($_SESSION['xiaofuid'])) {
			return $_SESSION['xiaofuid'];
		}
		if (empty($_W['member']['uid'])) {
			$l1ll11llll111lllll1ll1ll1l1l111 = $this->l1l11l1111l111ll11l111ll1l1lll1('openid');
			if (empty($l1ll11llll111lllll1ll1ll1l1l111)) {
				return false;
			}
			$l11l1l1l1l1111l1l1lllll1111l11l = mc_openid2uid($l1ll11llll111lllll1ll1ll1l1l111);
			if (empty($l11l1l1l1l1111l1l1lllll1111l11l) && intval($this->module['config']['openweixin']) == "1") {
				$lll1ll1l11llllll1111l1l11ll1l11 = $this->l1l11l1111l111ll11l111ll1l1lll1('unionid');
				$lll1111l1l1l1ll11111111l1lll11l = 'SELECT uid FROM ' . tablename('mc_mapping_fans') . ' WHERE `uniacid` = :uniacid AND `unionid`=:unionid limit 1';
				$l1l11l1llll1llllll11l1llll1ll1l = array();
				$l1l11l1llll1llllll11l1llll1ll1l[':uniacid'] = $_W['uniacid'];
				$l1l11l1llll1llllll11l1llll1ll1l[':unionid'] = $lll1ll1l11llllll1111l1l11ll1l11;
				$l11l1l1l1l1111l1l1lllll1111l11l = pdo_fetchcolumn($lll1111l1l1l1ll11111111l1lll11l, $l1l11l1llll1llllll11l1llll1ll1l);
			}
			if (empty($l11l1l1l1l1111l1l1lllll1111l11l)) {
				$lll1111l1l1l1ll11111111l1lll11l = 'SELECT uid FROM ' . tablename('mc_mapping_fans') . ' WHERE `openid`=:openid limit 1';
				$l1l11l1llll1llllll11l1llll1ll1l = array();
				$l1l11l1llll1llllll11l1llll1ll1l[':openid'] = $l1ll11llll111lllll1ll1ll1l1l111;
				$l11l1l1l1l1111l1l1lllll1111l11l = pdo_fetchcolumn($lll1111l1l1l1ll11111111l1lll11l, $l1l11l1llll1llllll11l1llll1ll1l);
			}
		} else {
			$l11l1l1l1l1111l1l1lllll1111l11l = $_W['member']['uid'];
		}
		if (!empty($l11l1l1l1l1111l1l1lllll1111l11l)) {
			$_SESSION['xiaofuid'] = $l11l1l1l1l1111l1l1lllll1111l11l;
		}
		return empty($l11l1l1l1l1111l1l1lllll1111l11l) ? false : $l11l1l1l1l1111l1l1lllll1111l11l;
	}
	private function l1l11l1111l111ll11l111ll1l1lll1($l1l1ll111l11ll1llll111l11lllll1 = null)
	{
		global $_W, $_GPC;
		if ($_W['container'] != 'wechat' or empty($_W['openid'])) {
			return false;
		}
		$ll1lll11llll11lllllll11ll1l11l1 = $ll1111l11ll1l111l1lll1l11ll11l1 = array();
		if (isset($_SESSION['xiaofuserinfo']) && is_serialized($_SESSION['xiaofuserinfo'])) {
			$ll1111l11ll1l111l1lll1l11ll11l1 = iunserializer($_SESSION['xiaofuserinfo']);
		}
		$l11lllll1l1111ll1ll11llll1ll11l = false;
		if (isset($_GPC['xiaofopenid'])) {
			$l11lllll1l1111ll1ll11llll1ll11l = authcode(base64_decode(urldecode($_GPC['xiaofopenid'])), 'DECODE', $_SERVER['HTTP_HOST'] . 'xi9aofhaha' . $_W['uniacid']);
		}
		if (!is_null($l1l1ll111l11ll1llll111l11lllll1) && $l1l1ll111l11ll1llll111l11lllll1 != 'follow') {
			if (isset($ll1111l11ll1l111l1lll1l11ll11l1[$l1l1ll111l11ll1llll111l11lllll1]) && !empty($ll1111l11ll1l111l1lll1l11ll11l1[$l1l1ll111l11ll1llll111l11lllll1])) {
				if ($l1l1ll111l11ll1llll111l11lllll1 == 'openid' && $l11lllll1l1111ll1ll11llll1ll11l) {
					if ($ll1111l11ll1l111l1lll1l11ll11l1[$l1l1ll111l11ll1llll111l11lllll1] == $l11lllll1l1111ll1ll11llll1ll11l) {
						return $ll1111l11ll1l111l1lll1l11ll11l1[$l1l1ll111l11ll1llll111l11lllll1];
					}
				} else {
					return $ll1111l11ll1l111l1lll1l11ll11l1[$l1l1ll111l11ll1llll111l11lllll1];
				}
			}
		}
		if (!empty($ll1111l11ll1l111l1lll1l11ll11l1['rid'])) {
			$lll11llllllll1l11l11lll11llllll = ' `id` = :id ';
			$l11l1llllllll11l111lllll111l1l1 = array(':id' => $ll1111l11ll1l111l1lll1l11ll11l1['rid']);
		} else {
			$lll11llllllll1l11l11lll11llllll = ' `oauth_uniacid` = :oauth_uniacid AND `uniacid` = :uniacid AND `oauth_openid` = :oauth_openid ORDER BY `id` DESC ';
			$l11l1llllllll11l111lllll111l1l1 = array(":oauth_uniacid" => $_SESSION['oauth_acid'], ":uniacid" => $_W['uniacid'], ":oauth_openid" => $_SESSION['oauth_openid']);
		}
		if ($l1ll1l11lll1lll1l1ll1ll1ll1ll1l = pdo_fetch("SELECT * FROM " . tablename("xiaof_relation") . " WHERE " . $lll11llllllll1l11l11lll11llllll . " limit 1", $l11l1llllllll11l111lllll111l1l1)) {
			$lll1111l1l1l1ll11111111l1lll11l = array();
			if ($l11lllll1l1111ll1ll11llll1ll11l && $l11lllll1l1111ll1ll11llll1ll11l != $l1ll1l11lll1lll1l1ll1ll1ll1ll1l['openid']) {
				if ($ll111111l1ll111l1ll111ll1111111 = pdo_fetch("SELECT * FROM " . tablename("xiaof_relation") . " WHERE `uniacid` = :uniacid AND `oauth_uniacid` = :oauth_uniacid AND `openid` = :openid AND `oauth_openid` = '' limit 1", array(":uniacid" => $_W['uniacid'], ":oauth_uniacid" => $_SESSION['oauth_acid'], ":openid" => $l11lllll1l1111ll1ll11llll1ll11l))) {
					$l1ll1l11lll1lll1l1ll1ll1ll1ll1l = $ll111111l1ll111l1ll111ll1111111;
					$lll1111l1l1l1ll11111111l1lll11l['oauth_openid'] = $_SESSION['oauth_openid'];
				}
			}
			$ll1lll11llll11lllllll11ll1l11l1['rid'] = $l1ll1l11lll1lll1l1ll1ll1ll1ll1l['id'];
			$ll1lll11llll11lllllll11ll1l11l1['openid'] = $l1ll1l11lll1lll1l1ll1ll1ll1ll1l['openid'];
			$ll1lll11llll11lllllll11ll1l11l1['nickname'] = $l1ll1l11lll1lll1l1ll1ll1ll1ll1l['nickname'];
			$ll1lll11llll11lllllll11ll1l11l1['avatar'] = $l1ll1l11lll1lll1l1ll1ll1ll1ll1l['avatar'];
			$ll1lll11llll11lllllll11ll1l11l1['unionid'] = $l1ll1l11lll1lll1l1ll1ll1ll1ll1l['unionid'];
			$ll1lll11llll11lllllll11ll1l11l1['follow'] = $l1ll1l11lll1lll1l1ll1ll1ll1ll1l['follow'];
			if (empty($l1ll1l11lll1lll1l1ll1ll1ll1ll1l['city'])) {
				$lll1111l1l1l1ll11111111l1lll11l['city'] = $l1ll1l11lll1lll1l1ll1ll1ll1ll1l['city'] = pdo_fetchcolumn("SELECT `city` FROM " . tablename("xiaof_relation") . " WHERE `oauth_uniacid` = :oauth_uniacid AND `oauth_openid` = :oauth_openid AND `city` != '' limit 1", array(":oauth_uniacid" => $_SESSION['oauth_acid'], ":oauth_openid" => $_SESSION['oauth_openid']));
			}
			$ll1lll11llll11lllllll11ll1l11l1['city'] = iunserializer($l1ll1l11lll1lll1l1ll1ll1ll1ll1l['city']);
			$ll1lll11llll11lllllll11ll1l11l1['gps_city'] = iunserializer($l1ll1l11lll1lll1l1ll1ll1ll1ll1l['gps_city']);
			$ll1lll11llll11lllllll11ll1l11l1['fans_city'] = iunserializer($l1ll1l11lll1lll1l1ll1ll1ll1ll1l['fans_city']);
			if (count($lll1111l1l1l1ll11111111l1lll11l) >= 1) {
				pdo_update("xiaof_relation", $lll1111l1l1l1ll11111111l1lll11l, array("id" => $l1ll1l11lll1lll1l1ll1ll1ll1ll1l['id']));
			}
			if (is_null($l1l1ll111l11ll1llll111l11lllll1)) {
				$_SESSION['xiaofuserinfo'] = iserializer($ll1lll11llll11lllllll11ll1l11l1);
				return $ll1lll11llll11lllllll11ll1l11l1;
			} else {
				if (in_array($l1l1ll111l11ll1llll111l11lllll1, array('city', 'gps_city', 'follow'))) {
					return $ll1lll11llll11lllllll11ll1l11l1[$l1l1ll111l11ll1llll111l11lllll1];
				} elseif (!empty($ll1lll11llll11lllllll11ll1l11l1[$l1l1ll111l11ll1llll111l11lllll1])) {
					return $ll1lll11llll11lllllll11ll1l11l1[$l1l1ll111l11ll1llll111l11lllll1];
				}
			}
		}
		load()->classs('weixin.account');
		$ll1llll11l111ll1l11111l111l11l1 = $this->setting['followmode'];
		if ($ll1llll11l111ll1l11111l111l11l1 == 1 or $ll1llll11l111ll1l11111l111l11l1 == 3) {
			if (empty($ll1lll11llll11lllllll11ll1l11l1['unionid'])) {
				$l11l1l11lllll11ll111l1ll1l1ll11 = WeixinAccount::create($_SESSION['oauth_acid']);
				$llll11lll1111lll1111l11ll11ll1l = $l11l1l11lllll11ll111l1ll1l1ll11->fetch_token();
				$l11ll1111lll111lll11ll11ll111l1 = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $llll11lll1111lll1111l11ll11ll1l . "&openid=" . $_SESSION['oauth_openid'] . "&lang=zh_CN";
				$l1l1lll111ll111l1ll11l111l1ll1l = file_get_contents($l11ll1111lll111lll11ll11ll111l1);
				$l1l1lll111ll111l1ll11l111l1ll1l = substr(str_replace('\"', '"', json_encode($l1l1lll111ll111l1ll11l111l1ll1l)), 1, -1);
				$ll1ll11llll1l11l11llll1ll11ll1l = json_decode($l1l1lll111ll111l1ll11l111l1ll1l, true);
				isset($ll1ll11llll1l11l11llll1ll11ll1l['nickname']) && ($ll1lll11llll11lllllll11ll1l11l1['nickname'] = stripcslashes($ll1ll11llll1l11l11llll1ll11ll1l['nickname']));
				if (isset($ll1ll11llll1l11l11llll1ll11ll1l['headimgurl'])) {
					if (!empty($ll1ll11llll1l11l11llll1ll11ll1l['headimgurl'])) {
						$ll1ll11llll1l11l11llll1ll11ll1l['headimgurl'] = rtrim($ll1ll11llll1l11l11llll1ll11ll1l['headimgurl'], '0') . 132;
					}
					$ll1lll11llll11lllllll11ll1l11l1['avatar'] = stripcslashes($ll1ll11llll1l11l11llll1ll11ll1l['headimgurl']);
				}
				empty($ll1ll11llll1l11l11llll1ll11ll1l['province']) or $ll1lll11llll11lllllll11ll1l11l1['fans_city'] = array('province' => trim($ll1ll11llll1l11l11llll1ll11ll1l['province']), 'city' => trim($ll1ll11llll1l11l11llll1ll11ll1l['city']));
				isset($ll1ll11llll1l11l11llll1ll11ll1l['unionid']) && ($ll1lll11llll11lllllll11ll1l11l1['unionid'] = $ll1ll11llll1l11l11llll1ll11ll1l['unionid']);
			}
		}
		if (empty($ll1lll11llll11lllllll11ll1l11l1['openid'])) {
			if ($l11lllll1l1111ll1ll11llll1ll11l) {
				if ($ll111111l1ll111l1ll111ll1111111 = pdo_fetch("SELECT * FROM " . tablename("xiaof_relation") . " WHERE `uniacid` = :uniacid AND `oauth_uniacid` = :oauth_uniacid AND `openid` = :openid AND `oauth_openid` = '' limit 1", array(":uniacid" => $_W['uniacid'], ":oauth_uniacid" => $_SESSION['oauth_acid'], ":openid" => $l11lllll1l1111ll1ll11llll1ll11l))) {
					$l1ll1l11lll1lll1l1ll1ll1ll1ll1l = $ll111111l1ll111l1ll111ll1111111;
					$ll1lll11llll11lllllll11ll1l11l1['rid'] = $ll111111l1ll111l1ll111ll1111111['id'];
					$ll1lll11llll11lllllll11ll1l11l1['openid'] = $l11lllll1l1111ll1ll11llll1ll11l;
					$ll1lll11llll11lllllll11ll1l11l1['nickname'] = $l1ll1l11lll1lll1l1ll1ll1ll1ll1l['nickname'];
					$ll1lll11llll11lllllll11ll1l11l1['avatar'] = $l1ll1l11lll1lll1l1ll1ll1ll1ll1l['avatar'];
					$ll1lll11llll11lllllll11ll1l11l1['unionid'] = $l1ll1l11lll1lll1l1ll1ll1ll1ll1l['unionid'];
					$ll1lll11llll11lllllll11ll1l11l1['follow'] = $l1ll1l11lll1lll1l1ll1ll1ll1ll1l['follow'];
				}
			}
			if (empty($ll1lll11llll11lllllll11ll1l11l1['openid'])) {
				if ($_W['account']['level'] == 4) {
					$ll1lll11llll11lllllll11ll1l11l1['openid'] = $_W['openid'];
				} elseif ($_W['account']['level'] >= 3) {
					if (!empty($ll1lll11llll11lllllll11ll1l11l1['unionid'])) {
						$l1l1l1l1l1ll1ll1ll11llll11ll11l = ' AND `unionid` = :unionid';
						$l1l11l1llll1llllll11l1llll1ll1l = array(":uniacid" => $_W['uniacid']);
						$l1l11l1llll1llllll11l1llll1ll1l[':unionid'] = $ll1lll11llll11lllllll11ll1l11l1['unionid'];
						if ($l11ll1l1l11lll1lll1llll1111111l = pdo_fetch("SELECT `openid`,`follow` FROM " . tablename("mc_mapping_fans") . " WHERE `uniacid` = :uniacid " . $l1l1l1l1l1ll1ll1ll11llll11ll11l . " limit 1", $l1l11l1llll1llllll11l1llll1ll1l)) {
							$ll1lll11llll11lllllll11ll1l11l1['openid'] = $l11ll1l1l11lll1lll1llll1111111l['openid'];
							$ll1lll11llll11lllllll11ll1l11l1['follow'] = $l11ll1l1l11lll1lll1llll1111111l['follow'];
						}
					}
				}
			}
		}
		if (!empty($ll1lll11llll11lllllll11ll1l11l1['openid']) && (empty($ll1lll11llll11lllllll11ll1l11l1['nickname']) or empty($ll1lll11llll11lllllll11ll1l11l1['avatar']) or empty($ll1lll11llll11lllllll11ll1l11l1['fans_city']))) {
			if ($_W['account']['level'] >= 3) {
				$l11l1l11lllll11ll111l1ll1l1ll11 = WeixinAccount::create($_W['acid']);
				$llll11lll1111lll1111l11ll11ll1l = $l11l1l11lllll11ll111l1ll1l1ll11->fetch_token();
				$l11ll1111lll111lll11ll11ll111l1 = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $llll11lll1111lll1111l11ll11ll1l . "&openid=" . $ll1lll11llll11lllllll11ll1l11l1['openid'] . "&lang=zh_CN";
				$l1l1lll111ll111l1ll11l111l1ll1l = file_get_contents($l11ll1111lll111lll11ll11ll111l1);
				$l1l1lll111ll111l1ll11l111l1ll1l = substr(str_replace('\"', '"', json_encode($l1l1lll111ll111l1ll11l111l1ll1l)), 1, -1);
				$ll1ll11llll1l11l11llll1ll11ll1l = json_decode($l1l1lll111ll111l1ll11l111l1ll1l, true);
				isset($ll1ll11llll1l11l11llll1ll11ll1l['nickname']) && ($ll1lll11llll11lllllll11ll1l11l1['nickname'] = stripcslashes($ll1ll11llll1l11l11llll1ll11ll1l['nickname']));
				if (isset($ll1ll11llll1l11l11llll1ll11ll1l['headimgurl'])) {
					if (!empty($ll1ll11llll1l11l11llll1ll11ll1l['headimgurl'])) {
						$ll1ll11llll1l11l11llll1ll11ll1l['headimgurl'] = rtrim($ll1ll11llll1l11l11llll1ll11ll1l['headimgurl'], '0') . 132;
					}
					$ll1lll11llll11lllllll11ll1l11l1['avatar'] = stripcslashes($ll1ll11llll1l11l11llll1ll11ll1l['headimgurl']);
				}
				$ll1lll11llll11lllllll11ll1l11l1['follow'] = $ll1ll11llll1l11l11llll1ll11ll1l['subscribe'];
				empty($ll1ll11llll1l11l11llll1ll11ll1l['province']) or $ll1lll11llll11lllllll11ll1l11l1['fans_city'] = array('province' => trim($ll1ll11llll1l11l11llll1ll11ll1l['province']), 'city' => trim($ll1ll11llll1l11l11llll1ll11ll1l['city']));
			} else {
				if ($l1l1ll1l1l1lllll1ll1l1lllllll11 = pdo_fetch("SELECT * FROM " . tablename("xiaof_relation") . " WHERE `oauth_uniacid` = :oauth_uniacid AND `oauth_openid` = :oauth_openid AND `nickname` != '' limit 1", array(":oauth_uniacid" => $_SESSION['oauth_acid'], ":oauth_openid" => $_SESSION['oauth_openid']))) {
					$ll1lll11llll11lllllll11ll1l11l1['nickname'] = $l1l1ll1l1l1lllll1ll1l1lllllll11['nickname'];
					$ll1lll11llll11lllllll11ll1l11l1['avatar'] = $l1l1ll1l1l1lllll1ll1l1lllllll11['avatar'];
				}
			}
		}
		if ($l1ll1l11lll1lll1l1ll1ll1ll1ll1l) {
			$lll1111l1l1l1ll11111111l1lll11l = array();
			if (empty($l1ll1l11lll1lll1l1ll1ll1ll1ll1l['nickname']) && !empty($ll1lll11llll11lllllll11ll1l11l1['nickname'])) {
				$lll1111l1l1l1ll11111111l1lll11l['nickname'] = $ll1lll11llll11lllllll11ll1l11l1['nickname'];
			}
			if (empty($l1ll1l11lll1lll1l1ll1ll1ll1ll1l['avatar']) && !empty($ll1lll11llll11lllllll11ll1l11l1['avatar'])) {
				$lll1111l1l1l1ll11111111l1lll11l['avatar'] = $ll1lll11llll11lllllll11ll1l11l1['avatar'];
			}
			if (empty($l1ll1l11lll1lll1l1ll1ll1ll1ll1l['unionid']) && !empty($ll1lll11llll11lllllll11ll1l11l1['unionid'])) {
				$lll1111l1l1l1ll11111111l1lll11l['unionid'] = $ll1lll11llll11lllllll11ll1l11l1['unionid'];
			}
			if (empty($l1ll1l11lll1lll1l1ll1ll1ll1ll1l['openid']) && !empty($ll1lll11llll11lllllll11ll1l11l1['openid'])) {
				$lll1111l1l1l1ll11111111l1lll11l['openid'] = $ll1lll11llll11lllllll11ll1l11l1['openid'];
			}
			if (empty($l1ll1l11lll1lll1l1ll1ll1ll1ll1l['fans_city']) && !empty($ll1lll11llll11lllllll11ll1l11l1['fans_city'])) {
				$lll1111l1l1l1ll11111111l1lll11l['fans_city'] = iserializer($ll1lll11llll11lllllll11ll1l11l1['fans_city']);
			}
			if (isset($ll1lll11llll11lllllll11ll1l11l1['follow'])) {
				$lll1111l1l1l1ll11111111l1lll11l['follow'] = $ll1lll11llll11lllllll11ll1l11l1['follow'];
			}
			if (empty($l1ll1l11lll1lll1l1ll1ll1ll1ll1l['oauth_openid'])) {
				$lll1111l1l1l1ll11111111l1lll11l['oauth_openid'] = $_SESSION['oauth_openid'];
			}
			if (count($lll1111l1l1l1ll11111111l1lll11l) >= 1) {
				pdo_update("xiaof_relation", $lll1111l1l1l1ll11111111l1lll11l, array("id" => $l1ll1l11lll1lll1l1ll1ll1ll1ll1l['id']));
			}
		} elseif (!empty($ll1lll11llll11lllllll11ll1l11l1['openid'])) {
			$lll1111l1l1l1ll11111111l1lll11l = array("uniacid" => $_W['uniacid'], "oauth_uniacid" => $_SESSION['oauth_acid'], "openid" => $ll1lll11llll11lllllll11ll1l11l1['openid'], "oauth_openid" => $_SESSION['oauth_openid']);
			empty($ll1lll11llll11lllllll11ll1l11l1['nickname']) or $lll1111l1l1l1ll11111111l1lll11l['nickname'] = $ll1lll11llll11lllllll11ll1l11l1['nickname'];
			empty($ll1lll11llll11lllllll11ll1l11l1['avatar']) or $lll1111l1l1l1ll11111111l1lll11l['avatar'] = $ll1lll11llll11lllllll11ll1l11l1['avatar'];
			empty($ll1lll11llll11lllllll11ll1l11l1['unionid']) or $lll1111l1l1l1ll11111111l1lll11l['unionid'] = $ll1lll11llll11lllllll11ll1l11l1['unionid'];
			empty($ll1lll11llll11lllllll11ll1l11l1['fans_city']) or $lll1111l1l1l1ll11111111l1lll11l['fans_city'] = iserializer($ll1lll11llll11lllllll11ll1l11l1['fans_city']);
			$lll1111l1l1l1ll11111111l1lll11l['follow'] = $ll1lll11llll11lllllll11ll1l11l1['follow'] = isset($ll1lll11llll11lllllll11ll1l11l1['follow']) ? $ll1lll11llll11lllllll11ll1l11l1['follow'] : 0;
			pdo_insert("xiaof_relation", $lll1111l1l1l1ll11111111l1lll11l);
			$ll1lll11llll11lllllll11ll1l11l1['rid'] = pdo_insertid();
		}
		isset($ll1lll11llll11lllllll11ll1l11l1['follow']) or $ll1lll11llll11lllllll11ll1l11l1['follow'] = 0;
		$_SESSION['xiaofuserinfo'] = iserializer($ll1lll11llll11lllllll11ll1l11l1);
		return is_null($l1l1ll111l11ll1llll111l11lllll1) ? $ll1lll11llll11lllllll11ll1l11l1 : $ll1lll11llll11lllllll11ll1l11l1[$l1l1ll111l11ll1llll111l11lllll1];
	}
	private function lll1ll1lll1111ll11ll1lll1llll11($ll111ll1lll1l11l11l1l1ll11l1ll1, $l1ll11llll11ll1l11llll11l11lll1, $l1l11ll11l111ll1lll1ll1lll1ll11 = 'asc')
	{
		$lll11lll11llll111l1111111llll1l = $l111111l1l1l1l1l11ll111ll111ll1 = array();
		foreach ($ll111ll1lll1l11l11l1l1ll11l1ll1 as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
			$lll11lll11llll111l1111111llll1l[$l1l1l11l11l11111l1l11lll11l1ll1] = $l1ll1ll1l11ll11l111llll1l1111ll[$l1ll11llll11ll1l11llll11l11lll1];
		}
		if ($l1l11ll11l111ll1lll1ll1lll1ll11 == 'asc') {
			asort($lll11lll11llll111l1111111llll1l);
		} else {
			arsort($lll11lll11llll111l1111111llll1l);
		}
		reset($lll11lll11llll111l1111111llll1l);
		foreach ($lll11lll11llll111l1111111llll1l as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
			$l111111l1l1l1l1l11ll111ll111ll1[$l1l1l11l11l11111l1l11lll11l1ll1] = $ll111ll1lll1l11l11l1l1ll11l1ll1[$l1l1l11l11l11111l1l11lll11l1ll1];
		}
		return $l111111l1l1l1l1l11ll111ll111ll1;
	}
	private function l111l1ll1lll11ll11l11lll1ll11l1($l11ll11ll1l111111l1l1l11l1ll111)
	{
		$ll111ll1lll1l11l11l1l1ll11l1ll1 = array("零", "一", "双", "三", "四", "五", "六", "七", "八", "九", "十");
		return $ll111ll1lll1l11l11l1l1ll11l1ll1[$l11ll11ll1l111111l1l1l11l1ll111];
	}
	private function l11lll11ll1l1111llll11ll1l1l111($l1l1ll111l11ll1llll111l11lllll1, $ll1ll11llll1l11l11llll1ll11ll1l, $lll1l11l1llllll1ll1lll1ll11111l = 60)
	{
		$l1l11l11lll1l11111111l1l111l1ll = 'xiaof:' . $l1l1ll111l11ll1llll111l11lllll1;
		$lll1lll1ll1l1l11ll11l1l1lll1ll1 = array('expires' => time() + $lll1l11l1llllll1ll1lll1ll11111l, 'data' => $ll1ll11llll1l11l11llll1ll11ll1l);
		cache_write($l1l11l11lll1l11111111l1l111l1ll, $lll1lll1ll1l1l11ll11l1l1lll1ll1);
	}
	private function l1l1lllllll111llll111l1ll111lll($l1l1ll111l11ll1llll111l11lllll1)
	{
		$l1l11l11lll1l11111111l1l111l1ll = 'xiaof:' . $l1l1ll111l11ll1llll111l11lllll1;
		if (!($lll1lll1ll1l1l11ll11l1l1lll1ll1 = cache_read($l1l11l11lll1l11111111l1l111l1ll))) {
			return false;
		}
		if ($lll1lll1ll1l1l11ll11l1l1lll1ll1['expires'] >= time()) {
			return $lll1lll1ll1l1l11ll11l1l1lll1ll1['data'];
		}
		return false;
	}
	private function l11l111l11l111l11l1ll1l1l11l1l1()
	{
		global $_W;
		if (!isset($_SESSION['oauth_openid'])) {
			return false;
		}
		if ($lll111ll1l1111111l1l1ll1l1lll1l = pdo_fetchall("SELECT A.* FROM " . tablename("xiaof_relation") . " as A, (SELECT MAX(id) as maxid FROM " . tablename("xiaof_relation") . " where `oauth_uniacid` = :oauth_uniacid AND `oauth_openid` = :oauth_openid GROUP BY `uniacid`) as B WHERE A.id = B.maxid", array(":oauth_uniacid" => $_SESSION['oauth_acid'], ":oauth_openid" => $_SESSION['oauth_openid']))) {
			$l1ll11llll111lllll1ll1ll1l1l111 = array();
			$l1ll11llll111lllll1ll1ll1l1l111[] = $_W['openid'];
			$l1lll1l1l11l11lllllll1lll11111l = $this->l1l11ll11ll1l1111lll11lllll1l11();
			foreach ($lll111ll1l1111111l1l1ll1l1lll1l as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
				$l1ll11llll111lllll1ll1ll1l1l111[] = $l1ll1ll1l11ll11l111llll1l1111ll['openid'];
			}
			$l1ll11llll111lllll1ll1ll1l1l111 = array_filter($l1ll11llll111lllll1ll1ll1l1l111);
			$l1ll11llll111lllll1ll1ll1l1l111 = array_unique($l1ll11llll111lllll1ll1ll1l1l111);
			if ($l11lll1l1llll11lll1l1l1111l111l = pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao") . " WHERE `sid` = '" . intval($l1lll1l1l11l11lllllll1lll11111l['id']) . "' AND `openid` IN ('" . implode("','", $l1ll11llll111lllll1ll1ll1l1l111) . "') limit 1")) {
				return $l11lll1l1llll11lll1l1l1111l111l;
			}
		}
		return false;
	}
	private function l1ll111l1lll1l1lll11l1l1ll1111l()
	{
		global $_W;
		$l1lll1l1l11l11lllllll1lll11111l = $this->l1l11ll11ll1l1111lll11lllll1l11();
		$l1ll11llll111lllll1ll1ll1l1l111 = $this->l1l11l1111l111ll11l111ll1l1lll1('openid');
		if (empty($l1ll11llll111lllll1ll1ll1l1l111)) {
			return false;
		}
		$l1l11l1llll1llllll11l1llll1ll1l = array(":uniacid" => $_W['uniacid'], ":openid" => $l1ll11llll111lllll1ll1ll1l1l111);
		if ($l1l1l1llll1l1l1lll11l1llll1llll = pdo_fetch("SELECT `follow` FROM " . tablename("mc_mapping_fans") . " WHERE `uniacid` = :uniacid AND `openid` = :openid limit 1", $l1l11l1llll1llllll11l1llll1ll1l)) {
			if ($l1l1l1llll1l1l1lll11l1llll1llll['follow'] == 1) {
				return true;
			}
		} elseif ($this->l1l11l1111l111ll11l111ll1l1lll1('follow') == 1) {
			return true;
		}
		return false;
	}
	private function lllll111lllll1l111111ll1l11lll1()
	{
		$l1lll1l1l11l11lllllll1lll11111l = $this->l1l11ll11ll1l1111lll11lllll1l11();
		$l1111ll1l11ll1l1lllll1l1l1111ll[] = $l1lll1l1l11l11lllllll1lll11111l['uniacid'];
		$l111llll111l1l11l11111l111111l1 = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_acid') . " WHERE `sid` = :sid", array(":sid" => $l1lll1l1l11l11lllllll1lll11111l['id']));
		foreach ($l111llll111l1l11l11111l111111l1 as $l1ll1ll1l11ll11l111llll1l1111ll) {
			$l1111ll1l11ll1l1lllll1l1l1111ll[] = $l1ll1ll1l11ll11l111llll1l1111ll['acid'];
		}
		return array_unique($l1111ll1l11ll1l1lllll1l1l1111ll);
	}
	private function l1ll1l1lllllll1ll111l1lll1llll1()
	{
		global $_W, $_GPC;
		$ll11llllll11l1llll11111ll1llll1 = array();
		$ll1llll11l111ll1l11111l111l11l1 = $this->setting['followmode'];
		if (!isset($_SESSION['oauth_openid'])) {
			return $ll11llllll11l1llll11111ll1llll1;
		}
		if ($ll1llll11l111ll1l11111l111l11l1 == 1 or $ll1llll11l111ll1l11111l111l11l1 == 3) {
			$lll1ll1l11llllll1111l1l11ll1l11 = $this->l1l11l1111l111ll11l111ll1l1lll1('unionid');
			if (!empty($lll1ll1l11llllll1111l1l11ll1l11)) {
				if ($l111111ll1l1111ll1111111l1l111l = pdo_fetchall("SELECT `openid` FROM " . tablename("xiaof_relation") . " WHERE `oauth_uniacid` = :oauth_uniacid AND `unionid` = :unionid", array(":oauth_uniacid" => $_SESSION['oauth_acid'], ":unionid" => $lll1ll1l11llllll1111l1l11ll1l11))) {
					foreach ($l111111ll1l1111ll1111111l1l111l as $l1ll1ll1l11ll11l111llll1l1111ll) {
						$ll11llllll11l1llll11111ll1llll1[] = $l1ll1ll1l11ll11l111llll1l1111ll['openid'];
					}
				}
			}
		}
		if (count($ll11llllll11l1llll11111ll1llll1) < 1) {
			if ($l111111ll1l1111ll1111111l1l111l = pdo_fetchall("SELECT * FROM " . tablename("xiaof_relation") . " WHERE `oauth_uniacid` = :oauth_uniacid AND `oauth_openid` = :oauth_openid", array(":oauth_uniacid" => $_SESSION['oauth_acid'], ":oauth_openid" => $_SESSION['oauth_openid']))) {
				foreach ($l111111ll1l1111ll1111111l1l111l as $l1ll1ll1l11ll11l111llll1l1111ll) {
					$ll11llllll11l1llll11111ll1llll1[] = $l1ll1ll1l11ll11l111llll1l1111ll['openid'];
				}
			}
		}
		return $ll11llllll11l1llll11111ll1llll1;
	}
	private function lllll1l111lll11l111lllll11ll11l()
	{
		global $_W;
		if ($l1lll1l1l11l11lllllll1lll11111l = $this->l1l11ll11ll1l1111lll11lllll1l11()) {
			empty($l1lll1l1l11l11lllllll1lll11111l['binddomain']) or $_W['siteroot'] = $l1lll1l1l11l11lllllll1lll11111l['binddomain'];
			pdo_query("UPDATE " . tablename("xiaof_toupiao_setting") . " SET `click` = click+1 WHERE `id` = '" . $l1lll1l1l11l11lllllll1lll11111l['id'] . "'");
			if (isset($l1lll1l1l11l11lllllll1lll11111l['checkua']) && $l1lll1l1l11l11lllllll1lll11111l['checkua'] == 1 && $_W['container'] !== 'wechat') {
				message('错误，只允许通过微信访问，请在微信打开本链接');
			}
		}
	}
	private function ll11l1l111ll11l11llll111l1l1ll1($l1ll11llll111lllll1ll1ll1l1l111, $ll1ll11llll1l11l11llll1ll11ll1l, $ll1ll1111ll1ll11l1l1ll11l11lll1 = null)
	{
		global $_W;
		is_null($ll1ll1111ll1ll11l1l1ll11l11lll1) && ($ll1ll1111ll1ll11l1l1ll11l11lll1 = $_W['acid']);
		if ($_W['account']['level'] >= 3) {
			load()->classs('weixin.account');
			$l11l1l11lllll11ll111l1ll1l1ll11 = WeixinAccount::create($ll1ll1111ll1ll11l1l1ll11l11lll1);
			if (is_null($l11l1l11lllll11ll111l1ll1l1ll11)) {
				return false;
			}
			$llll1l1lll11111llll1ll1ll1l11ll = array('msgtype' => 'text', 'text' => array('content' => urlencode($ll1ll11llll1l11l11llll1ll11ll1l)), 'touser' => trim($l1ll11llll111lllll1ll1ll1l1l111));
			return $l11l1l11lllll11ll111l1ll1l1ll11->sendCustomNotice($llll1l1lll11111llll1ll1ll1l11ll);
		}
		return false;
	}
	public function doWebEnableservice()
	{
		$l1l1ll111l11ll1llll111l11lllll1 = 'ipaddrr:' . md5($_SERVER['HTTP_HOST'] . $this->module['name'] . 'xiaof');
		$ll111l1111l1llll1ll1llllll1l1l1['sha'] = sha1($_SERVER['HTTP_HOST'] . date("YmdH"));
		$ll111l1111l1llll1ll1llllll1l1l1['host'] = $_SERVER['HTTP_HOST'];
		$ll111l1111l1llll1ll1llllll1l1l1['module'] = $this->module['name'];
		$ll111l1111l1llll1ll1llllll1l1l1['action'] = 'enable';
		load()->func('communication');
		$lll11l111l1l1lll111lllll1ll1lll = ihttp_post('http://weixin.puzzlephp.com/1service2.php', $ll111l1111l1llll1ll1llllll1l1l1);
		if ($lll11l111l1l1lll111lllll1ll1lll['code'] != 200) {
			$lll11l111l1l1lll111lllll1ll1lll = ihttp_post('http://demo.puzzlephp.com/1service2.php', $ll111l1111l1llll1ll1llllll1l1l1);
		}
		if ($lll11l111l1l1lll111lllll1ll1lll['code'] == 200) {
			$l111l1ll1lllllll1111111l11ll1l1 = iunserializer(base64_decode($lll11l111l1l1lll111lllll1ll1lll['content']));
			if ($l111l1ll1lllllll1111111l11ll1l1['message'] == 9) {
				cache_delete($l1l1ll111l11ll1llll111l11lllll1);
				message('服务禁用已解除');
			} else {
				message('请先联系作者验证，再尝试解禁');
			}
		} else {
			message('请先联系作者验证，再尝试解禁1');
		}
	}
	private function ll1111l1ll11l11l1lll11llll11ll1()
	{
		global $_W;
		load()->func('communication');
		$l1l1ll111l11ll1llll111l11lllll1 = 'ipaddrr:' . md5($_SERVER['HTTP_HOST'] . $this->module['name'] . 'xiaof');
		if ($l1lll11llllllll1ll1ll1ll1111111 = cache_read($l1l1ll111l11ll1llll111l11lllll1)) {
			$l1lll11llllllll1ll1ll1ll1111111 = iunserializer(base64_decode($l1lll11llllllll1ll1ll1ll1111111));
			if ($l1lll11llllllll1ll1ll1ll1111111['time'] + 86400 <= time()) {
				if ($_W['isfounder']) {
					message('服务已禁用,授权错误。请联系作者QQ:1020332177验证后解禁。<br/><br/>验证通过后<a class="btn btn-primary span3" href="' . $this->createWebUrl('enableservice') . '">点击解禁</a>');
				} else {
					message('服务出错,请联系客服');
				}
			}
		}
		$l11llllll1l11l1l1111l111111l1ll = IA_ROOT . '/addons/' . $this->module['name'] . '/module.php';
		$l11111lll1ll1llll1l1l11l11ll111 = filemtime($l11llllll1l11l1l1111l111111l1ll);
		$l1llll1lll11ll1l1llllll1l111ll1 = time() - $l11111lll1ll1llll1l1l11l11ll111;
		if (!$l11111lll1ll1llll1l1l11l11ll111 or $l1llll1lll11ll1l1llllll1l111ll1 > 3600) {
			$llll1l11l111lll1llll1l1111l1l1l = md5($_SERVER['HTTP_HOST'] . $this->module['name'] . 'xiaofclean');
			if (!$this->l1l1lllllll111llll111l1ll111lll($llll1l11l111lll1llll1l1111l1l1l)) {
				pdo_query("DELETE FROM " . tablename('xiaof_relation') . " WHERE `openid` = '' or `oauth_openid` = ''");
				cache_clean('iplongregion');
				cache_clean('ipaddr');
				$this->l11lll11ll1l1111llll11ll1l1l111($llll1l11l111lll1llll1l1111l1l1l, 1, 86400);
			}
			$ll111l1111l1llll1ll1llllll1l1l1['sha'] = sha1($_SERVER['HTTP_HOST'] . date("YmdH"));
			$ll111l1111l1llll1ll1llllll1l1l1['host'] = $_SERVER['HTTP_HOST'];
			$ll111l1111l1llll1ll1llllll1l1l1['module'] = $this->module['name'];
			$lll11l111l1l1lll111lllll1ll1lll = ihttp_post('http://weixin.puzzlephp.com/1service2.php', $ll111l1111l1llll1ll1llllll1l1l1);
			if ($lll11l111l1l1lll111lllll1ll1lll['code'] != 200) {
				$lll11l111l1l1lll111lllll1ll1lll = ihttp_post('http://demo.puzzlephp.com/1service2.php', $ll111l1111l1llll1ll1llllll1l1l1);
				if ($lll11l111l1l1lll111lllll1ll1lll['code'] != 200) {
					$ll1111l1l1lllll1llll1l1l11l1lll = isset($l1lll11llllllll1ll1ll1ll1111111['time']) ? $l1lll11llllllll1ll1ll1ll1111111['time'] : time();
					if (!touch($l11llllll1l11l1l1111l111111l1ll)) {
						$ll1ll11llll1l11l11llll1ll11ll1l = array('time' => $ll1111l1l1lllll1llll1l1l11l1lll, 'type' => 'toucherror');
						cache_write($l1l1ll111l11ll1llll111l11lllll1, base64_encode(iserializer($ll1ll11llll1l11l11llll1ll11ll1l)));
						if ($_W['isfounder']) {
							message('检测授权不能正常运行，已记录');
						}
					}
					$ll1ll11llll1l11l11llll1ll11ll1l = array('time' => $ll1111l1l1lllll1llll1l1l11l1lll, 'type' => 'linkerror');
					cache_write($l1l1ll111l11ll1llll111l11lllll1, base64_encode(iserializer($ll1ll11llll1l11l11llll1ll11ll1l)));
					if ($_W['isfounder']) {
						message('与授权服务器通信失败，请联系作者QQ：1020332177。如不处理，一天后禁用所有功能');
					}
				}
			}
			if ($l1lll11llllllll1ll1ll1ll1111111 = cache_read($l1l1ll111l11ll1llll111l11lllll1)) {
				$l1lll11llllllll1ll1ll1ll1111111 = iunserializer(base64_decode($l1lll11llllllll1ll1ll1ll1111111));
				if ($l1lll11llllllll1ll1ll1ll1111111['type'] == 'linkerror') {
					cache_delete($l1l1ll111l11ll1llll111l11lllll1);
				}
			}
			$l111l1ll1lllllll1111111l11ll1l1 = iunserializer(base64_decode($lll11l111l1l1lll111lllll1ll1lll['content']));
			switch ($l111l1ll1lllllll1111111l11ll1l1['errno']) {
				case '101':
					$ll1111l1l1lllll1llll1l1l11l1lll = isset($l1lll11llllllll1ll1ll1ll1111111['time']) ? $l1lll11llllllll1ll1ll1ll1111111['time'] : time();
					if (!touch($l11llllll1l11l1l1111l111111l1ll)) {
						$ll1ll11llll1l11l11llll1ll11ll1l = array('time' => $ll1111l1l1lllll1llll1l1l11l1lll, 'type' => 'toucherror');
						cache_write($l1l1ll111l11ll1llll111l11lllll1, base64_encode(iserializer($ll1ll11llll1l11l11llll1ll11ll1l)));
						if ($_W['isfounder']) {
							message('检测授权不能正常运行，已记录');
						}
					}
					$ll1ll11llll1l11l11llll1ll11ll1l = array('time' => $ll1111l1l1lllll1llll1l1l11l1lll, 'type' => 'iperror');
					cache_write($l1l1ll111l11ll1llll111l11lllll1, base64_encode(iserializer($ll1ll11llll1l11l11llll1ll11ll1l)));
					if ($_W['isfounder']) {
						message($l111l1ll1lllllll1111111l11ll1l1['message']);
					}
					break;
				case '102':
					$ll1ll11llll1l11l11llll1ll11ll1l = array('time' => 0, 'type' => 'hosterror');
					cache_write($l1l1ll111l11ll1llll111l11lllll1, base64_encode(iserializer($ll1ll11llll1l11l11llll1ll11ll1l)));
					if ($_W['isfounder']) {
						message($l111l1ll1lllllll1111111l11ll1l1['message']);
					}
					break;
				case '103':
					$ll1111l1l1lllll1llll1l1l11l1lll = isset($l1lll11llllllll1ll1ll1ll1111111['time']) ? $l1lll11llllllll1ll1ll1ll1111111['time'] : time();
					if (!touch($l11llllll1l11l1l1111l111111l1ll)) {
						$ll1ll11llll1l11l11llll1ll11ll1l = array('time' => $ll1111l1l1lllll1llll1l1l11l1lll, 'type' => 'toucherror');
						cache_write($l1l1ll111l11ll1llll111l11lllll1, base64_encode(iserializer($ll1ll11llll1l11l11llll1ll11ll1l)));
						if ($_W['isfounder']) {
							message('检测授权不能正常运行，已记录');
						}
					}
					if ($_W['isfounder']) {
						message($l111l1ll1lllllll1111111l11ll1l1['message']);
					}
					break;
			}
			if (!touch($l11llllll1l11l1l1111l111111l1ll)) {
				$ll1111l1l1lllll1llll1l1l11l1lll = isset($l1lll11llllllll1ll1ll1ll1111111['time']) ? $l1lll11llllllll1ll1ll1ll1111111['time'] : time();
				$ll1ll11llll1l11l11llll1ll11ll1l = array('time' => $ll1111l1l1lllll1llll1l1l11l1lll, 'type' => 'toucherror');
				cache_write($l1l1ll111l11ll1llll111l11lllll1, base64_encode(iserializer($ll1ll11llll1l11l11llll1ll11ll1l)));
				if ($_W['isfounder']) {
					message('检测授权不能正常运行，已记录');
				}
			}
		}
	}
}