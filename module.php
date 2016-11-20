<?php

//decode by QQ:270656184 http://www.yunlu99.com/
defined('IN_IA') or die('Access Denied');
class Xiaof_toupiaoModule extends WeModule
{
	public function fieldsFormDisplay($l11l11lll1l1l111ll1ll11lll1l11l = 0)
	{
		global $_W;
		$l1111ll11111l1l111l1lll11111lll = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_acid') . " WHERE `acid` = :acid", array(":acid" => $_W['uniacid']));
		$ll1l1l111ll1l1111l11ll111l1111l = array();
		foreach ($l1111ll11111l1l111l1lll11111lll as $l1ll1ll1l11ll11l111llll1l1111ll) {
			$ll1l1l111ll1l1111l11ll111l1111l[] = intval($l1ll1ll1l11ll11l111llll1l1111ll['sid']);
		}
		$l1111l11l1llll1l11l1lll11l11lll = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_setting') . " WHERE `uniacid` = :uniacid OR `id` IN ('" . implode("','", $ll1l1l111ll1l1111l11ll111l1111l) . "')", array(":uniacid" => $_W['uniacid']));
		if ($l11l11lll1l1l111ll1ll11lll1l11l != 0) {
			$l11lll1l1llll11lll1l1l1111l111l = pdo_fetch("SELECT * FROM " . tablename('xiaof_toupiao_rule') . " WHERE `rid` = '" . $l11l11lll1l1l111ll1ll11lll1l11l . "' limit 1");
			$lll1lll111l111l11l1l11111ll11l1 = $l11lll1l1llll11lll1l1l1111l111l['sid'];
			$l1l1lllll11111ll1l11ll1l11111ll = $l11lll1l1llll11lll1l1l1111l111l['action'];
		}
		include $this->template("rule");
	}
	public function fieldsFormSubmit($l11l11lll1l1l111ll1ll11lll1l11l)
	{
		global $_W, $_GPC;
		$l111l1l1l11l1lllll111l1l11111ll = json_decode(htmlspecialchars_decode($_GPC['keywords']), true);
		$l1l1ll111l11ll1llll111l11lllll1 = $_GPC['action'] == 3 ? $l111l1l1l11l1lllll111l1l11111ll[0]['content'] : md5($l111l1l1l11l1lllll111l1l11111ll[0]['content']);
		if ($l11lll1l1llll11lll1l1l1111l111l = pdo_fetch("SELECT * FROM " . tablename('xiaof_toupiao_rule') . " WHERE `rid` = '" . $l11l11lll1l1l111ll1ll11lll1l11l . "' limit 1")) {
			pdo_update("xiaof_toupiao_rule", array("sid" => $_GPC['sid'], "uniacid" => $_W['uniacid'], "action" => $_GPC['action'], "keyword" => $l1l1ll111l11ll1llll111l11lllll1), array("rid" => $l11l11lll1l1l111ll1ll11lll1l11l));
		} else {
			pdo_insert("xiaof_toupiao_rule", array("rid" => $l11l11lll1l1l111ll1ll11lll1l11l, "sid" => $_GPC['sid'], "uniacid" => $_W['uniacid'], "action" => $_GPC['action'], "keyword" => $l1l1ll111l11ll1llll111l11lllll1));
		}
	}
	public function ruleDeleted($l11l11lll1l1l111ll1ll11lll1l11l)
	{
		pdo_query("DELETE FROM " . tablename('xiaof_toupiao_rule') . " WHERE `rid` = '" . $l11l11lll1l1l111ll1ll11lll1l11l . "'");
	}
	public function settingsDisplay($l111ll1ll1l11l1l1l11l1llll11lll)
	{
		global $_W, $_GPC;
		$l1lllllll1l1ll1ll1l1lll111ll11l = pdo_fieldexists("mc_mapping_fans", "unionid");
		if (checksubmit()) {
			$l1ll1lllll1lll111111111ll1l1111['openweixin'] = $_GPC['openweixin'];
			$l1ll1lllll1lll111111111ll1l1111['fuzzysearch'] = $_GPC['fuzzysearch'];
			if ($_W['account']['level'] < 3) {
				$l1ll1lllll1lll111111111ll1l1111['openweixin'] = 0;
			}
			$l1ll1lllll1lll111111111ll1l1111['smsipnum'] = $_GPC['smsipnum'];
			$l1ll1lllll1lll111111111ll1l1111['smsphonenum'] = $_GPC['smsphonenum'];
			$l1ll1lllll1lll111111111ll1l1111['dayuak'] = $_GPC['dayuak'];
			$l1ll1lllll1lll111111111ll1l1111['dayusk'] = $_GPC['dayusk'];
			$l1ll1lllll1lll111111111ll1l1111['dayusign'] = $_GPC['dayusign'];
			$l1ll1lllll1lll111111111ll1l1111['dayumoduleid'] = $_GPC['dayumoduleid'];
			$l1ll1lllll1lll111111111ll1l1111['dayuname'] = $_GPC['dayuname'];
			$l1ll1lllll1lll111111111ll1l1111['imagesaveqiniu'] = $_GPC['imagesaveqiniu'];
			$l1ll1lllll1lll111111111ll1l1111['qiniuak'] = $_GPC['qiniuak'];
			$l1ll1lllll1lll111111111ll1l1111['qiniusk'] = $_GPC['qiniusk'];
			$l1ll1lllll1lll111111111ll1l1111['qiniuzone'] = $_GPC['qiniuzone'];
			$l1ll1lllll1lll111111111ll1l1111['qiniudomain'] = $_GPC['qiniudomain'];
			$l1ll1lllll1lll111111111ll1l1111['qiniupipeline'] = $_GPC['qiniupipeline'];
			$l1ll1lllll1lll111111111ll1l1111['baidumapak'] = $_GPC['baidumapak'];
			if ($l1ll1lllll1lll111111111ll1l1111['openweixin'] === 1 && !$l1lllllll1l1ll1ll1l1lll111ll11l) {
				pdo_query("ALTER TABLE " . tablename('mc_mapping_fans') . " ADD  `unionid` VARCHAR( 50 ) NOT NULL");
			}
			$this->saveSettings($l1ll1lllll1lll111111111ll1l1111);
			message('配置参数更新成功！', referer(), 'success');
		}
		include $this->template('setting');
	}
}