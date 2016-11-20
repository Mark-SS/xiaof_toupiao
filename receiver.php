<?php

//decode by QQ:270656184 http://www.yunlu99.com/
defined('IN_IA') or die('Access Denied');
class Xiaof_toupiaoModuleReceiver extends WeModuleReceiver
{
	public function receive()
	{
		global $_W;
		$l1l11ll11l111ll1lll1ll1lll1ll11 = $this->message['type'];
		if ($l1l11ll11l111ll1lll1ll1lll1ll11 == "unsubscribe") {
			$l1111l11l1llll1l11l1lll11l11lll = pdo_fetchall("SELECT `id` as sid FROM " . tablename('xiaof_toupiao_setting') . " WHERE `uniacid` = :uniacid", array(":uniacid" => $_W['uniacid']));
			$ll1l1l111ll1l1111l11ll111l1111l = $l11llll1ll1l1l11l1l1ll11llllll1 = array();
			foreach ($l1111l11l1llll1l11l1lll11l11lll as $l1ll1ll1l11ll11l111llll1l1111ll) {
				$ll1l1l111ll1l1111l11ll111l1111l[] = $l1ll1ll1l11ll11l111llll1l1111ll['sid'];
			}
			$l111llll111l1l11l11111l111111l1 = pdo_fetchall("SELECT `sid` FROM " . tablename('xiaof_toupiao_acid') . " WHERE `acid` = :acid", array(":acid" => $_W['uniacid']));
			foreach ($l111llll111l1l11l11111l111111l1 as $l1ll1ll1l11ll11l111llll1l1111ll) {
				$ll1l1l111ll1l1111l11ll111l1111l[] = $l1ll1ll1l11ll11l111llll1l1111ll['sid'];
			}
			$ll1l1l111ll1l1111l11ll111l1111l = array_unique($ll1l1l111ll1l1111l11ll111l1111l);
			$l11l1l111lll11l111ll1l111ll11l1 = pdo_fetchall("SELECT `id` as sid, `data` FROM " . tablename('xiaof_toupiao_setting') . " WHERE `id` in ('" . implode("','", $ll1l1l111ll1l1111l11ll111l1111l) . "') AND `unfollow` = '1'");
			foreach ($l11l1l111lll11l111ll1l111ll11l1 as $l1ll1ll1l11ll11l111llll1l1111ll) {
				$l1lll1l1l11l11lllllll1lll11111l = iunserializer($l1ll1ll1l11ll11l111llll1l1111ll['data']);
				if (strtotime($l1lll1l1l11l11lllllll1lll11111l['end']) > time()) {
					$l11llll1ll1l1l11l1l1ll11llllll1[] = $l1ll1ll1l11ll11l111llll1l1111ll['sid'];
				}
			}
			if (count($l11llll1ll1l1l11l1l1ll11llllll1) >= 1) {
				$lll1ll11l111l1l1l111ll1ll111111 = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_log') . " WHERE  `sid` in ('" . implode("','", $l11llll1ll1l1l11l1l1ll11llllll1) . "') AND `valid` = '1' AND `openid` = '" . $this->message['from'] . "'");
				$ll11l1lll11l11ll1lll1111ll1l1ll = array();
				foreach ($lll1ll11l111l1l1l111ll1ll111111 as $l1ll1ll1l11ll11l111llll1l1111ll) {
					if (!isset($ll11l1lll11l11ll1lll1111ll1l1ll[$l1ll1ll1l11ll11l111llll1l1111ll['pid']])) {
						$ll11l1lll11l11ll1lll1111ll1l1ll[$l1ll1ll1l11ll11l111llll1l1111ll['pid']] = 1;
					} else {
						$ll11l1lll11l11ll1lll1111ll1l1ll[$l1ll1ll1l11ll11l111llll1l1111ll['pid']] = $ll11l1lll11l11ll1lll1111ll1l1ll[$l1ll1ll1l11ll11l111llll1l1111ll['pid']] + 1;
					}
					pdo_query("UPDATE " . tablename("xiaof_toupiao_log") . " SET `valid` = '2' WHERE `id` = '" . $l1ll1ll1l11ll11l111llll1l1111ll['id'] . "'");
				}
				foreach ($ll11l1lll11l11ll1lll1111ll1l1ll as $l1l1l11l11l11111l1l11lll11l1ll1 => $l1ll1ll1l11ll11l111llll1l1111ll) {
					$l1l1l1l1l1ll1ll1ll11llll11ll11l = "`good` = good-" . $l1ll1ll1l11ll11l111llll1l1111ll;
					pdo_query("UPDATE " . tablename("xiaof_toupiao") . " SET " . $l1l1l1l1l1ll1ll1ll11llll11ll11l . " WHERE `id` = '" . $l1l1l11l11l11111l1l11lll11l1ll1 . "'");
				}
			}
			$lll1111l1l1l1ll11111111l1lll11l['follow'] = 0;
			pdo_update("xiaof_relation", $lll1111l1l1l1ll11111111l1lll11l, array("uniacid" => $_W['uniacid'], "openid" => $this->message['from']));
		} elseif ($l1l11ll11l111ll1lll1ll1lll1ll11 == "subscribe") {
			if (isset($this->module['config']['openweixin']) && $this->module['config']['openweixin'] == "1") {
				load()->classs('weixin.account');
				$l11l1l11lllll11ll111l1ll1l1ll11 = WeixinAccount::create($_W['acid']);
				$llll11lll1111lll1111l11ll11ll1l = $l11l1l11lllll11ll111l1ll1l1ll11->fetch_token();
				$l11ll1111lll111lll11ll11ll111l1 = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $llll11lll1111lll1111l11ll11ll1l . "&openid=" . $this->message['from'] . "&lang=zh_CN";
				$l1l1lll111ll111l1ll11l111l1ll1l = file_get_contents($l11ll1111lll111lll11ll11ll111l1);
				$l1l1lll111ll111l1ll11l111l1ll1l = substr(str_replace('\"', '"', json_encode($l1l1lll111ll111l1ll11l111l1ll1l)), 1, -1);
				$ll1ll11llll1l11l11llll1ll11ll1l = @json_decode($l1l1lll111ll111l1ll11l111l1ll1l, true);
				if (isset($ll1ll11llll1l11l11llll1ll11ll1l['unionid'])) {
					pdo_update("mc_mapping_fans", array("unionid" => $ll1ll11llll1l11l11llll1ll11ll1l['unionid']), array("openid" => $this->message['from']));
				}
			}
			$lll1111l1l1l1ll11111111l1lll11l['follow'] = 1;
			pdo_update("xiaof_relation", $lll1111l1l1l1ll11111111l1lll11l, array("uniacid" => $_W['uniacid'], "openid" => $this->message['from']));
		}
	}
}