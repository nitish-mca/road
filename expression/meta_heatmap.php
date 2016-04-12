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
$width_cell = 20;
$height_cell = 20;

$ids = $_REQUEST["ids"];
$type = $_REQUEST['type'];
$platform = $_REQUEST["platform"];
$scale = $_REQUEST['scale'];

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

$num_row = count ($data);
$num_col = count ($data[0]);

$width_graph = $width_cell*$num_col+250;
if ($platform=='affymetrix') {
	$height_graph =  $height_cell*$num_row+280;
}elseif ($platform=='agilent44k'){
	$height_graph =  $height_cell*$num_row+300;
}

// Setup a bsic matrix graph and title
$graph = new MatrixGraph($width_graph,$height_graph);
//$graph->title->Set('Basic matrix example');
//$graph->title->SetFont(FF_ARIAL,FS_BOLD,14);

// Create a ,atrix plot using all default values
$mp = new MatrixPlot($data);

$map = array('blue', 'black', 'yellow');

$mp->colormap->SetMap($map);

if ($scale=='S1'){
	$mp->colormap->SetRange(5, 13);
}elseif ($scale=='S2'){
	$mp->colormap->SetRange(5, 15);
}elseif ($scale=='S3'){
	$mp->colormap->SetRange(7, 17);
}

$mp->legend->SetFont(FF_ARIAL,FS_NORMAL,8);

$mp->SetModuleSize($width_cell, $height_cell);

$pox_x_mp = ($width_cell*$num_col)/2+100;
if ($platform=='affymetrix') {
	$pos_y_mp = ($height_cell*$num_row)/2+220;
}elseif ($platform=='agilent44k'){
	$pos_y_mp = ($height_cell*$num_row)/2+70;
}

$mp->SetCenterPos($pox_x_mp, $pos_y_mp);

$mp->yedgelabel->SetSide('left');
$mp->yedgelabel->Set($genes);
$mp->yedgelabel->SetFont(FF_ARIAL,FS_NORMAL,8);

if ($platform=='agilent44k'){
	$mp->xedgelabel->SetSide('bottom');
	$mp->xedgelabel->Set($sam_titles);
	$mp->xedgelabel->SetFont(FF_ARIAL,FS_NORMAL,8);
}

if ($platform=='affymetrix' and $type=='anatomy'){
	$icon = new IconPlot('anatomy_affymetrix.png',100,28,1,100);
	$graph->Add($icon);
}elseif ($platform=='affymetrix' and $type=='developmental_stage'){
	$icon = new IconPlot('developmental_stage_affymetrix.png',100,13,1,100);
	$graph->Add($icon);
}

$graph->Add($mp);
$graph->Stroke();

?>