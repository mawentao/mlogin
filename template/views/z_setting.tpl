<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" href="<%plugin_path%>/template/libs/mwt/4.0/mwt.min.css" type="text/css">
  <link rel="stylesheet" href="<%plugin_path%>/template/views/misadmin.css" type="text/css">
  <script src="<%plugin_path%>/template/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="<%plugin_path%>/template/libs/mwt/4.0/mwt.min.js"></script>
  <%js_script%>
  <script>
    var jq=jQuery.noConflict();
    jq(document).ready(function($) {
        jQuery("input[name=disable_discuz][value="+v.disable_discuz+"]").attr("checked",true);
        jQuery('#page_copyright').val(v.page_copyright);
    });
  </script>
</head>
<body>
  <form method="post" action="admin.php?action=plugins&operation=config&identifier=mlogin&pmod=z_setting">
  <!-- 使用提示 -->
  <table class="tb tb2">
    <tr><th colspan="15" class="partition">使用提示</th></tr>
    <tr><td class="tipsblock" s="1">
      <ul id="lis">
        <li>启用本插件将替换discuz原生的登录界面和退出登录页面</li>
        <li>原生登录地址：<a href="<%siteurl%>/member.php?mod=logging&action=login" target="_blank"><%siteurl%>/member.php?mod=logging&action=login</a></li>
        <li>原生退出地址：<a href="<%siteurl%>/member.php?mod=logging&action=logout" target="_blank"><%siteurl%>/member.php?mod=logging&action=logout</a></li>
        <li>原生重置密码：<a href="<%siteurl%>/home.php?mod=spacecp&ac=profile&op=password" target="_blank"><%siteurl%>/home.php?mod=spacecp&ac=profile&op=password</a></li>
      </ul>
    </td></tr>
  </table>
  <!-- 全局设置 -->
  <table class="tb tb2">
    <tr><th colspan="15" class="partition">全局设置</th></tr>
    <tr>
      <td width='90'>启用：</td>
      <td width='300'>
	    <label><input name="disable_discuz" type="radio" value="1"> 是</label>
        &nbsp;&nbsp;
	    <label><input name="disable_discuz" type="radio" value="0"> 否</label>
      </td>
      <td class='tips2'>选'是'将启用本插件的登录页面</td>
    </tr>
	<tr>
	  <td>版权信息：</td>
      <td><input type="text" id="page_copyright" name="page_copyright" class="txt" style="width:96%"></td>
	  <td>版权信息</td>
	</tr>
    <tr>
      <td colspan="3">
		<input type="hidden" id="reset" name="reset" value="0"/>
        <input type="submit" id='subbtn' class='btn' value="保存设置"/>
        &nbsp;&nbsp;
		<input type="submit" class='btn' onclick="jQuery('#reset').val(1);" value="恢复默认设置"/>
      </td>
    </tr>
  </table>
  </form>
</body>
</html>
