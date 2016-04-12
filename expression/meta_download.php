<?php 
$host = 'localhost';
$dbname = 'test';
$username = 'root';
$password = 'JustD01t!';

// include function files for this application
require_once('../RAD_fns.php'); 
$conn = mysqli_connect($host, $username, $password, $dbname);  
$ids = $_REQUEST["ids"];
$type = $_REQUEST['type'];
$platform = $_REQUEST["platform"];

$probe_database = 'gene_probe_'.$platform;
$expression_database =  $type.'_'.$platform;

$genes = explode(",", $ids);
$num_genes = count($genes);

$conn = db_connect();

$query_sam = "select sam_id, sam_title from metadata where type='$type' and platform = '$platform' order by id";

$result = @$conn->query($query_sam);

$sam_ids=array();
$sam_titles=array();

for ($count=0; $row = $result->fetch_assoc(); $count++){
	$sam_ids[$count] = $row['sam_id'];
	$sam_ids[$count] = '`'.$sam_ids[$count].'`';
	$sam_titles[$count] = $row['sam_title'];
}

$sam_ids_combined = join (",", $sam_ids);

$probe_ids = array();
$data = array();

for ($i=0;$i<$num_genes;$i++){
	$query_probe = "select * from $probe_database where geneid='$genes[$i]' ";
	$result = @$conn->query($query_probe);
	$row = $result->fetch_assoc();
	$probe = $row{'main'};
	$probe_ids[$i] = $row{'main'};
	$probe = preg_replace ('/\'/', "''", $probe);
	
	$query = "select $sam_ids_combined from $expression_database where probeid = '$probe'";

	$result = @$conn->query($query);
	$row = $result->fetch_row();
	$data[$i] = $row;
}

$result->free();
$conn->close();

//header("Content-type: text/plain");
header("Content-Type: application/octet-stream ; charset=UTF-8");
Header("Content-Disposition: attachment; filename=$type\_$platform.txt");

if ($platform=='affymetrix'){
	echo "Gene\tProbeSet ID";
}else {
	echo "Gene\tProbe ID";
}

$num_sams = count ($sam_ids);

for ($i=0; $i<$num_sams; $i++){
	echo "\t$sam_titles[$i]";
}
echo "\n";

for ($i = 0; $i < $num_genes; $i++) {
	echo "$genes[$i]\t$probe_ids[$i]\t";

	$tmp = $data[$i];
	
	$n=count($tmp);

	for ($j=0;$j<$n;$j++){
		echo "$tmp[$j]\t";
	}
	echo "\n";
}

?>
