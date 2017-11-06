<?php
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
require_once 'utils.class.php';
require_once 'log.class.php';
require_once 'validate.class.php';
class mlogin_env
{
    private static $_log_obj = null;

	// get discuz site's url(discuz root)
    public static function get_siteurl()
    {/*{{{*/
        global $_G;
		$_G['siteurl'] = preg_replace("/source\/plugin\/mlogin/i","", $_G['siteurl']);
		return rtrim($_G['siteurl'], '/');
    }/*}}}*/

	// get sitename(utf-8)
    public static function get_sitename()
    {/*{{{*/
        global $_G;
        $sitename = $_G["setting"]["sitename"];
        $charset = strtolower($_G['charset']);
        if ($charset=='gbk') {
            $sitename = mlogin_utils::toutf8($sitename);
        }
        return $sitename;
    }/*}}}*/

    // get admin-email
    public static function get_admin_email()
    {/*{{{*/
        global $_G;
        return $_G["setting"]["adminemail"];
    }/*}}}*/

    // get current plugin path
    public static function get_plugin_path()
    {/*{{{*/
        return self::get_siteurl().'/source/plugin/mlogin';
    }/*}}}*/

    // api output
    public static function result(array $result,$json_header=true)
    {/*{{{*/
        header("Content-type: application/json");
        if (!isset($result['retcode'])) {
            $result['retcode'] = 0;
        }
        if (!isset($result['retmsg'])) {
            $result['retmsg'] = 'succ';
        }
		if ($json_header) {
            header("Content-type: application/json");
		}
        echo json_encode($result);
        exit;
    }/*}}}*/

    // get request param
    public static function get_param($key, $dv=null, $field='request')
    {/*{{{*/
        if ($field=='GET') {
            return isset($_GET[$key]) ? $_GET[$key] : $dv;
        }
        else if ($field=='POST') {
            return isset($_POST[$key]) ? $_POST[$key] : $dv;
        }
        else {
            return isset($_REQUEST[$key]) ? $_REQUEST[$key] : $dv;
        }
    }/*}}}*/
    
    // get log object
    public static function getlog()
    {/*{{{*/
        if (!self::$_log_obj) {
            $logcfg = array('log_level'=>16);
            self::$_log_obj = new mlogin_log($logcfg);
        }   
        return self::$_log_obj;
    }/*}}}*/
}
// vim600: sw=4 ts=4 fdm=marker syn=php
?>
