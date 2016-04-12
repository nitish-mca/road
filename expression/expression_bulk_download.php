<?php 
$host = 'localhost';
$dbname = 'test';
$username = 'root';
$password = 'JustD01t!';

// include function files for this application
require_once('../RAD_fns.php'); 
$conn = mysqli_connect($host, $username, $password, $dbname);  
$platform = Strtolower ($_REQUEST['platform']);
$exp = $_REQUEST["exp"];
$ave = $_REQUEST['ave'];


$conn = db_connect();

if ($ave == 'Y'){
	$query_sam = "select sam_id, short_title from sample_ave where exp_id='$exp' order by id";
}else{
	$query_sam = "select sam_id, short_title from sample where exp_id='$exp' order by id";
}

$result = @$conn->query($query_sam);

$sam_ids=array();
$sam_titles=array();

for ($count=0; $row = $result->fetch_assoc(); $count++){
	$sam_ids[$count] = $row['sam_id'];
	$sam_titles[$count] = $row['short_title'];
}

$num_sams = count ($sam_ids);

$sam_ids_combined = join (",", $sam_ids);

if ($ave == 'Y'){
	$query = "select probeid,$sam_ids_combined from $platform"."_ave
			 order by probeid";
}else{
	if ($platform == 'affymetrix'){
		$query = "select affymetrix1.probeid,$sam_ids_combined from affymetrix1, affymetrix2
				where
				affymetrix1.probeid=affymetrix2.probeid
				order by affymetrix1.probeid";
	}else {
		$query = "select probeid,$sam_ids_combined from $platform
				order by probeid";
	}
}

$result = @$conn->query($query);

$expression = array();

for ($count=0; $row = $result->fetch_row(); $count++){
	$expression[$count] = $row;
}

$num_exprs = count ($expression);

$result->free();
$conn->close();


//header("Content-type: text/plain");
header("Content-Type: application/octet-stream ; charset=UTF-8");
if ($ave == 'Y'){
	Header("Content-Disposition: attachment; filename=$exp\_average.txt");
}else{
	Header("Content-Disposition: attachment; filename=$exp.txt");
}

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
