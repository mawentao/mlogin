<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
require_once dirname(__FILE__)."/class/env.class.php";

if(!$_G['uid']){
	$login = mlogin_env::get_siteurl()."/member.php?mod=logging&action=login";
    header("Location: $login");
    exit();
}
$setting = C::m('#mlogin#mlogin_setting')->get();
$plugin_path = mlogin_env::get_plugin_path();
include template("mlogin:resetpass");
