<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
/**
 * 插件访问日志表
 **/
class table_mlogin_log extends discuz_table
{
	public function __construct() {
		$this->_table = 'mlogin_log';
		$this->_pk = 'logid';
		parent::__construct();
	}

	public function get_by_pk($id) 
	{
        $sql = "SELECT * FROM ".DB::table($this->_table)." WHERE ".$this->_pk."='$id'";
        return DB::fetch_first($sql);
    }

	// 管理后台查询接口
	public function query()
	{/*{{{*/
		$return = array(
            "totalProperty" => 0,
            "root" => array(),
        ); 
		$sday  = mlogin_validate::getNCParameter('sday','sday','string'); 
		$eday  = mlogin_validate::getNCParameter('eday','eday','string'); 
		$key   = mlogin_validate::getNCParameter('key','key','string'); 
        $sort  = mlogin_validate::getOPParameter('sort','sort','string',1024,'logtime');
        $dir   = mlogin_validate::getOPParameter('dir','dir','string',1024,'DESC');
        $start = mlogin_validate::getOPParameter('start','start','integer',1024,0);
        $limit = mlogin_validate::getOPParameter('limit','limit','integer',1024,20);
        $where = "date(logtime) BETWEEN date('$sday') AND date('$eday')";
		if ($key!="") $where.=" AND (log_content like '%$key%' OR b.username='$key')";
		$table_mlogin_log = DB::table($this->_table);
		$table_common_member = DB::table('common_member');
		$sql = <<<EOF
SELECT SQL_CALC_FOUND_ROWS a.*,b.username,b.email
FROM $table_mlogin_log as a LEFT JOIN $table_common_member as b ON a.uid=b.uid
WHERE $where ORDER BY $sort $dir LIMIT $start,$limit
EOF;
        $return["root"] = DB::fetch_all($sql);
        $row = DB::fetch_first("SELECT FOUND_ROWS() AS total");
        $return["totalProperty"] = $row["total"];
        return $return;
	}/*}}}*/

	// 趋势统计
	public function stat() 
	{/*{{{*/
		$series = array (
			array('text'=>'访问次数','data'=>array()),
			array('text'=>'访问人数','data'=>array()),
		);
		$weekmap = array('日','一','二','三','四','五','六');
		//1. x轴
		$sday  = mlogin_validate::getNCParameter('sday','sday','string');
		$eday  = mlogin_validate::getNCParameter('eday','eday','string');
		$stm = strtotime($sday);
		$etm = strtotime($eday);
		$xdata = array();
		$xmap = array();
		$i=0;
		for ($tm=$stm;$tm<=$etm;$tm+=86400) {
			$day = date('Y-m-d',$tm);
			$xmap[$day] = $i++;
			$xdata[] = date('m月d日',$tm)."\n(周".$weekmap[date('w',$tm)].")";
			$series[0]['data'][] = 0;
			$series[1]['data'][] = 0;
		}
		//2. series
		$where = "date(logtime) BETWEEN date('$sday') AND date('$eday')";
		$table_mlogin_log = DB::table($this->_table);
		$sql = <<<EOF
SELECT date(logtime) as vday,count(1) as pv,count(distinct uid) as uv
FROM $table_mlogin_log WHERE $where GROUP BY vday ORDER BY logtime ASC
EOF;
		$list = DB::fetch_all($sql);
		foreach ($list as $row) {
			$vday = $row['vday'];
			$xidx = $xmap[$vday];
			$series[0]['data'][$xidx] = intval($row['pv']);
			$series[1]['data'][$xidx] = intval($row['uv']);
		}
		//3. return
		$res = array (
			'x' => array('data'=>&$xdata),
			'series' => &$series,
		);
		return $res;
	}/*}}}*/

	// 写日志
	public function write($log)
	{/*{{{*/
		global $_G;
		$data = array(
			'uid' => $_G['uid'],
			'client_ip' => $_G['clientip'],
			'log_content' => $log,
		);
		return $this->insert($data);
	}/*}}}*/
}

// vim600: sw=4 ts=4 fdm=marker syn=php
?>
