<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
require_once dirname(__FILE__).'/class/env.class.php';
$params = C::m('#mlogin#mlogin_setting')->get();
$params['ajaxapi'] = mlogin_env::get_plugin_path()."/index.php?version=4&module=";
$tplVars = array(
    'siteurl' => mlogin_env::get_siteurl(),
    'plugin_path' => mlogin_env::get_plugin_path(),
);
mlogin_utils::loadtpl(dirname(__FILE__).'/template/views/z_account.tpl', $params, $tplVars);
mlogin_env::getlog()->trace("show admin page [z_account] success");
