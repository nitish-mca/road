<?php 
$host = 'localhost';
$dbname = 'test';
$username = 'root';
$password = 'JustD01t!';

// include function files for this application
require_once('../RAD_fns.php'); 
$conn = mysqli_connect($host, $username, $password, $dbname);  
$ids = $_REQUEST["ids"];
$type = Strtolower ($_REQUEST['type']);

$probe_ids = explode(",", $ids);
$num_probes=count($probe_ids);
for ($i=0;$i<$num_probes;$i++){
	$probe_ids[$i] = "'".$probe_ids[$i]."'";
}

$probe_ids_combined = join(",", $probe_ids);

$conn = db_connect();

$query_sam = "select sam_id, sam_title from reclassification where type='$type' order by id";

$result = @$conn->query($query_sam);

$sam_ids=array();
$sam_titles=array();

for ($count=0; $row = $result->fetch_assoc(); $count++){
	$sam_ids[$count] = $row['sam_id'];
	$sam_titles[$count] = $row['sam_title'];
}

$sam_ids_combined = join (",", $sam_ids);
$num_sams = count ($sam_ids);

$query = "select probeid, $sam_ids_combined from $type
		 where
		 probeid in($probe_ids_combined)
		 order by probeid";

$result = @$conn->query($query);
$num_exprs = $result->num_rows;

$expression = array();

for ($count=0; $row = $result->fetch_row(); $count++){
	$expression[$count] = $row;
}

$result->free();
$conn->close();

header("Content-type: text/plain");

echo "Probe ID";
for ($i=0; $i<$num_sams; $i++){
	echo "\t$sam_titles[$i]";
}
echo "\n";

for ($i = 0; $i < $num_exprs; $i++) {

	$data = $expression[$i];
	
	$n=count($data);

	for ($j=0;$j<$n;$j++){
		echo "$data[$j]\t";
	}
	echo "\n";
}

?>