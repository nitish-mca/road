<?php 
$host = 'localhost';
$dbname = 'test';
$username = 'root';
$password = 'JustD01t!';

// include function files for this application
require_once('../RAD_fns.php'); 
$conn = mysqli_connect($host, $username, $password, $dbname);  
$id = $_REQUEST["id"];
$type = $_REQUEST['type'];
$platform = $_REQUEST["platform"];

$id = preg_replace ('/\s{1}/', '+', $id);

$types = explode (",", $type);
 
do_html_header($doc_path);

if ($platform == 'affymetrix'){
	$platform_display = 'Affymetrix';
}elseif($platform == 'agilent44k'){
	$platform_display = 'Agilent 44K';
}

echo "<h2>$platform_display Expression Data for $id</h2><br/><br/>\n";
 
foreach ($types as $type) {
	echo '<img src="meta_type.php?type='.$type.'&platform='.$platform.'&id='.$id.'" border=0 align=top>';
	echo '<br /><br />';
	echo '<a href="meta_type_high.php?type='.$type.'&platform='.$platform.'&id='.$id.'">Download High Resolution Image</a>';
	echo '<br /><br />';
}

do_html_footer($doc_path); 

?>
