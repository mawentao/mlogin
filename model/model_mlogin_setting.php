<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
/**
 * 插件设置 
 * C::m('#mlogin#mlogin_setting')->get()
 **/
class model_mlogin_setting
{
	// 获取默认配置
    public function getDefault()
    {
		$setting = array (
            // 屏蔽discuz原生登录
            'disable_discuz' => 1,
			// 版权信息
			'page_copyright' => 'mlogin.com 2017',
		);
		return $setting;
    }

    // 获取配置
	public function get()
	{
		$setting = $this->getDefault();
		global $_G;
		if (isset($_G['setting']['mlogin_config'])){
			$config = unserialize($_G['setting']['mlogin_config']);
			foreach ($setting as $key => &$item) {
				if (isset($config[$key])) $item = $config[$key];
			}
		}
		return $setting;
	}
}
// vim600: sw=4 ts=4 fdm=marker syn=php
?>
