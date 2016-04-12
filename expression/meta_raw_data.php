<?php 
$host = 'localhost';
$dbname = 'test';
$username = 'root';
$password = 'JustD01t!';

// include function files for this application
require_once('../RAD_fns.php'); 
$conn = mysqli_connect($host, $username, $password, $dbname);  
$type = $_GET["type"];
$term = $_GET["term"];
$ids = $_REQUEST["ids"];

$q_meta = "select * from meta_profile where type = '$type' and title = '$term' order by id";

$conn = db_connect();
$result = @$conn->query($q_meta);
$n_meta = $result->num_rows;

$sam_ids = array();

for ($i = 0; $i < $n_meta; $i++) {
	$row=$result->fetch_assoc();
	$sam_ids[$i]=$row['sam_id'];
}

$sam_ids_combined = join(",", $sam_ids);

$probes = explode(",", $ids);
$num_probes = count($probes);

for ($i = 0; $i < $num_probes; $i++) {
	$probes[$i]="'$probes[$i]'";
}

$probe_ids_combined = join(",", $probes);

$query = "select affymetrix1.probeid,$sam_ids_combined from affymetrix1, affymetrix2
		where
		affymetrix1.probeid=affymetrix2.probeid
		and
		affymetrix1.probeid in($probe_ids_combined)
		order by affymetrix1.probeid";

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
Header("Content-Disposition: attachment; filename=$type\_$term.txt");

echo "Probe ID";
for ($i=0; $i<$n_meta; $i++){
	echo "\t$sam_ids[$i]";
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