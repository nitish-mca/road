<?php 
$host = 'localhost';
$dbname = 'test';
$username = 'root';
$password = 'JustD01t!';

// include function files for this application
require_once('../RAD_fns.php'); 
require_once('jpgraph/jpgraph.php');
require_once('jpgraph/jpgraph_matrix.php');
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

$width_graph = $width_cell*$num_col+250;
$height_graph =  11*$num_row+280;


// Setup a bsic matrix graph and title
$graph = new MatrixGraph($width_graph,$height_graph);
//$graph->title->Set('Basic matrix example');
//$graph->title->SetFont(FF_ARIAL,FS_BOLD,14);

// Create a ,atrix plot using all default values
$mp = new MatrixPlot($data);

$map = array('blue', 'black', 'yellow');

$mp->colormap->SetMap($map);

$mp->colormap->SetRange(7, 13);

$mp->SetModuleSize($width_cell, 11);

$pox_x_mp = ($width_cell*$num_col)/2+155;
$pos_y_mp = 5.5*$num_row+70;
$mp->SetCenterPos($pox_x_mp, $pos_y_mp);

$mp->yedgelabel->SetSide('left');
$mp->yedgelabel->Set($probe_ids);

$mp->xedgelabel->SetSide('bottom');
$mp->xedgelabel->Set($sam_titles);

$graph->Add($mp);
$graph->Stroke();

?>
