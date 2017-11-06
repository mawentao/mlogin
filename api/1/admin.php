<?php
if (!defined('IN_MLOGIN_API')) {
    exit('Access Denied');
}
/**
 * 管理后台
 **/
require './source/class/class_core.php';
$discuz = C::app();
$discuz->init();
require_once MLOGIN_PLUGIN_PATH."/class/env.class.php";

////////////////////////////////////
// action的用户组列表（空表示全部用户组）
$actionlist = array(
	'authQuery' => array(1),   //!< 权限管理查询接口
    'authSet'   => array(1),   //!< 权限设置接口
);
////////////////////////////////////
$uid = $_G['uid'];
$username = $_G['username'];
$groupid = $_G["groupid"];
$action = isset($_GET['action']) ? $_GET['action'] : "get";

try {
    if (!isset($actionlist[$action])) {
        throw new Exception('unknow action');
    }
    $groups = $actionlist[$action];
    if (!empty($groups) && !in_array($groupid, $groups)) {
        throw new Exception('illegal request');
    }
    $res = $action();
    mlogin_env::result(array("data"=>$res));
} catch (Exception $e) {
    mlogin_env::result(array('retcode'=>100010,'retmsg'=>$e->getMessage()));
}

// 权限管理查询接口
function authQuery(){return C::t('#mlogin#mlogin_auth')->query();}
// 权限设置接口
function authSet(){return C::t('#mlogin#mlogin_auth')->set();}


// vim600: sw=4 ts=4 fdm=marker syn=php
?>
