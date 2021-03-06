<?php 
$host = 'localhost';
$dbname = 'test';
$username = 'root';
$password = 'JustD01t!';

// include function files for this application
require_once('../RAD_fns.php'); 
require_once('jpgraph/jpgraph.php');
require_once('jpgraph/jpgraph_matrix.php');
require_once('jpgraph/jpgraph_iconplot.php');
$conn = mysqli_connect($host, $username, $password, $dbname);  
$width_cell = 60;
$height_cell = 60;

$ids = $_REQUEST["ids"];

$conn = db_connect();

$query_sam = "select sam_id, sam_title from metadata where type='anatomy' and platform = 'affymetrix' order by id";

$result = @$conn->query($query_sam);

$sam_ids=array();
$sam_titles=array();

for ($count=0; $row = $result->fetch_assoc(); $count++){
	$sam_ids[$count] = $row['sam_id'];
	$sam_ids[$count] = '`'.$sam_ids[$count].'`';
	$sam_titles[$count] = $row['sam_title'];
}

$sam_ids_combined = join (",", $sam_ids);

$probe_ids = explode(",", $ids);
$num_probes = count($probe_ids);
$data = array();

for ($i=0;$i<$num_probes;$i++){
	$probe = $probe_ids[$i];

	$query = "select $sam_ids_combined from anatomy_affymetrix where probeid = '$probe'";

	$result = @$conn->query($query);
	$row = $result->fetch_row();
	$data[$i] = $row;
}

$result->free();
$conn->close();

$num_row = count ($data);
$num_col = count ($data[0]);

$width_graph = $width_cell*$num_col+750;

$height_graph =  $height_cell*$num_row+840;

header("Content-Type: application/octet-stream");
Header("Content-Disposition: attachment; filename=heatmap.png");

// Setup a bsic matrix graph and title
$graph = new MatrixGraph($width_graph,$height_graph);
//$graph->title->Set('Basic matrix example');
//$graph->title->SetFont(FF_ARIAL,FS_BOLD,14);

// Create a ,atrix plot using all default values
$mp = new MatrixPlot($data);

$map = array('blue', 'black', 'yellow');

$mp->colormap->SetMap($map);

$mp->colormap->SetRange(5, 13);

$mp->legend->SetFont(FF_ARIAL,FS_NORMAL,24);

$mp->SetModuleSize($width_cell, $height_cell);

$pox_x_mp = ($width_cell*$num_col)/2+450;

$pos_y_mp = ($height_cell*$num_row)/2+660;

$mp->SetCenterPos($pox_x_mp, $pos_y_mp);

$mp->yedgelabel->SetSide('left');
$mp->yedgelabel->Set($probe_ids);
$mp->yedgelabel->SetFont(FF_ARIAL,FS_NORMAL,24);

$icon = new IconPlot('anatomy_affymetrix_high.png',450,85,1,100);
$graph->Add($icon);

$graph->Add($mp);
$graph->Stroke();

?>
