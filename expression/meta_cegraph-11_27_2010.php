<?php 
$host = 'localhost';
$dbname = 'test';
$username = 'root';
$password = 'JustD01t!';
// include function files for this application
require_once('../RAD_fns.php'); 
require_once('jpgraph/jpgraph.php');
require_once('jpgraph/jpgraph_line.php');
$conn = mysqli_connect($host, $username, $password, $dbname);  
$width_cell = 14;

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

$query = "select $sam_ids_combined from $type
		 where
		 probeid in($probe_ids_combined)
		 order by probeid";

$result = @$conn->query($query);

$data = array();

for ($count=0; $row = $result->fetch_row(); $count++){
	$data[$count] = $row;
}

for ($i=0;$i<$num_probes;$i++){
	$probe_ids[$i] = preg_replace ("/'/", '', $probe_ids[$i]);
}

$result->free();
$conn->close();

$num_row = count ($data);
$num_col = count ($data[0]);

$width_graph = 15*$num_col+350;
$height_graph =  250+250;

// Create the graph and set a scale
$graph = new Graph($width_graph,$height_graph);
$graph->SetScale('textint');

$graph->yaxis->title->Set('Log2 Intensity');

$graph->SetMargin(50, 300, 30, 220);

$graph->xaxis->SetTickSide(SIDE_BOTTOM);
$graph->yaxis->SetTickSide(SIDE_LEFT);

$graph->xaxis->SetTickLabels($sam_titles);
$graph->xaxis->SetLabelAngle(90);

for ($i=0;$i<$num_row;$i++){
	$line_name='lineplot'.$i;
	$$line_name = new LinePlot($data[$i]);
	$$line_name->SetLegend("$probe_ids[$i]");
	$graph->Add($$line_name);
}

$graph->legend->SetPos(0.05, 0.5, 'right', 'center');
#$graph->legend->SetColumns(2);

$graph->Stroke();

?>
