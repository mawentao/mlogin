<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once dirname(__FILE__).'/class/env.class.php';

class plugin_mlogin
{
    public function common()
    {
        // 重置密码
        if (CURMODULE=='spacecp' && $_GET['ac']=='profile' && $_GET['op']=='password') {
            global $_G;
            // 开关检查
            $setting = C::m('#mlogin#mlogin_setting')->get();
            if (!$setting['disable_discuz']) { return; }
            // 登录检查
            if ($_G['uid']==0) { 
                $loginUrl = mlogin_env::get_siteurl()."/member.php?mod=logging&action=login";
                header("Location: $loginUrl");
                exit(0);
            }
            // 重置密码页面定制
            $plugin_path = mlogin_env::get_plugin_path();
            include template("mlogin:resetpass");
            exit(0);
        }
    }
}

class plugin_mlogin_member extends plugin_mlogin
{
    function logging()
    {
        global $_G;
        // 开关检查
        $setting = C::m('#mlogin#mlogin_setting')->get();
        if (!$setting['disable_discuz']) {
            return;
        }

        // 登录页面定制
        if ($_GET['action']=='login' && $_G['uid']==0) {
            $page_title = '登录';
            $plugin_path = mlogin_env::get_plugin_path();
            include template("mlogin:login");
            exit(0);
        }

        // 退出登录
        if ($_GET["action"]=="logout" && $_G['uid']!=0)  {
            $username = $_G['username'];
            C::t('#mlogin#mlogin_log')->write("[$username]退出登录");
			C::m("#mlogin#mlogin_uc")->logout();
            die("你已退出登录");
			exit(0);
		}
    }
}

