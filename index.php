<?php
/**
 * api入口
 **/
define("IN_MLOGIN_API", 1);
define("MLOGIN_PLUGIN_PATH", dirname(__FILE__));
chdir("../../../");

$modules = array (
    'seccode','uc',
    'admin',
);

if(!in_array($_GET['module'], $modules)) {
    module_not_exists();
}
$module  = $_GET['module'];
$version = !empty($_GET['version']) ? intval($_GET['version']) : 1;
if($version>4) $version=4;
while ($version>=1) {
    $apifile = MLOGIN_PLUGIN_PATH."/api/$version/$module.php";
    if(file_exists($apifile)) {
        require_once $apifile;
        exit(0);
    }
    --$version;    
}
module_not_exists();

function module_not_exists()
{
	header("Content-type: application/json");
    echo json_encode(array('error' => 'module_not_exists'));
    exit;
}
?>
