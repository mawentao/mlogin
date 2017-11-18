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
	'ucQuery' => array(1),   	//!< 账号管理查询接口
    'ucResetPass' => array(1),  //!< 重置账号密码接口
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

function ucQuery()
{/*{{{*/
	$return = array(
		"totalProperty" => 0,
        "root" => array(),
    );  
	$key   = mlogin_validate::getNCParameter('key','key','string',128);
	$sort  = mlogin_validate::getOPParameter('sort','sort','string',1024,'uid');
	$dir   = mlogin_validate::getOPParameter('dir','dir','string',1024,'ASC');
	$start = mlogin_validate::getOPParameter('start','start','integer',1024,0);
	$limit = mlogin_validate::getOPParameter('limit','limit','integer',1024,20);
	$where = "1";
	if ($key!="") $where.=" AND (username like '%$key%' OR email like '%$key%')";
	$table_common_member = DB::table("common_member");
	$sql = <<<EOF
SELECT SQL_CALC_FOUND_ROWS a.uid,a.username,a.email,a.regdate,a.groupid
FROM $table_common_member as a
WHERE $where 
ORDER BY `$sort` $dir 
LIMIT $start,$limit
EOF;
	$return["root"] = DB::fetch_all($sql);
	$row = DB::fetch_first("SELECT FOUND_ROWS() AS total");
	$return["totalProperty"] = $row["total"];
	///////////////////////////////////////////////
	$mug = C::m('#mlogin#mlogin_usergroup');
	foreach ($return["root"] as &$row) {
		$row['groupname'] = $mug->grouptitle($row['groupid']);
		//if (!$row['auth']) $row['auth']=0;
	}
	///////////////////////////////////////////////
	return $return;
}/*}}}*/

function ucResetPass()
{/*{{{*/
	$uid = mlogin_validate::getNCParameter('uid','uid','integer');
    $sql = "SELECT username FROM ".DB::table('common_member')." WHERE uid='$uid'";
    $uinfo = DB::fetch_first($sql);
    if (empty($uinfo)) {
        throw new Exception('用户不存在或已删除');
    }   
    $username = $uinfo['username'];
    $newpass = '888888';
    if (!C::m('#mlogin#mlogin_uc')->update_user_password($username,$newpass)) {
        throw new Exception('密码重置失败，请稍候再试');
    }   
    return "用户 <b>$username</b> 的密码已重置为 <b style='color:red;'>$newpass</b>";
}/*}}}*/


// vim600: sw=4 ts=4 fdm=marker syn=php
?>
