<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" href="<%plugin_path%>/template/libs/mwt/4.0/mwt.min.css" type="text/css">
  <link rel="stylesheet" href="<%plugin_path%>/template/views/misadmin.css" type="text/css">
  <script src="<%plugin_path%>/template/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="<%plugin_path%>/template/libs/mwt/4.0/mwt.min.js"></script>
  <script src="<%plugin_path%>/template/libs/requirejs/2.1.9/require.js"></script>
  <%js_script%>
  <script>
    var jq=jQuery.noConflict();
    jq(document).ready(function($) {
		require.config({
            baseUrl: "<%plugin_path%>/template/views/src/"
        });
		require(["account/page"],function(mainpage){
            mainpage.execute(); 
        });
    });
  </script>
</head>
<body>
  <div id="grid-div" style="position:absolute;top:40px;left:10px;right:10px;bottom:10px;"></div>
</body>
</html>
