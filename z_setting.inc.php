<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
require_once dirname(__FILE__).'/class/env.class.php';

// 插件设置
$params = C::m('#mlogin#mlogin_setting')->get();

// 保存设置
if (isset($_POST["reset"])) {
	if ($_POST["reset"]==1) {
		$params = array();
	} else {
		foreach ($params as $k => &$v) {
			if (isset($_POST[$k])) $v=$_POST[$k];
		}
	}
    C::t('common_setting')->update("mlogin_config",$params);
    updatecache('setting');
    $landurl = 'action=plugins&operation=config&do='.$pluginid.'&identifier=mlogin&pmod=z_setting';
	cpmsg('plugins_edit_succeed', $landurl, 'succeed');
}

$params['ajaxapi'] = mlogin_env::get_plugin_path()."/index.php?version=4&module=";
$tplVars = array(
    'siteurl' => mlogin_env::get_siteurl(),
    'plugin_path' => mlogin_env::get_plugin_path(),
);
mlogin_utils::loadtpl(dirname(__FILE__).'/template/views/z_setting.tpl', $params, $tplVars);
mlogin_env::getlog()->trace("show admin page [z_setting] success");
