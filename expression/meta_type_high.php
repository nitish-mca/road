<?php 
$host = 'localhost';
$dbname = 'test';
$username = 'root';
$password = 'JustD01t!';

// include function files for this application
require_once('../RAD_fns.php'); 
require_once('jpgraph/jpgraph.php');
include_once ("jpgraph/jpgraph_bar.php");
$conn = mysqli_connect($host, $username, $password, $dbname);  
$width_cell = 54;

$id = $_REQUEST["id"];
$type = $_REQUEST['type'];
$platform = $_REQUEST["platform"];

$id = preg_replace ('/\s{1}/', '+', $id);

$expression_database =  $type.'_'.$platform;

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

$id = preg_replace ('/\'/', "''", $id);
$query = "select $sam_ids_combined from $expression_database where probeid='$id'";

$result = @$conn->query($query);

$data = $result->fetch_row();

$result->free();
$conn->close();

$id = preg_replace ('/\'\'/', "'", $id);

$title='';

if ($type=='anatomy') {
	$title='Anatomy for '.$id;
}
if ($type=='developmental_stage') {
	$title='Developmental Stage for '.$id;
}

$num_col = count ($data);
$width_graph = $width_cell*$num_col+210;
$height_graph =  900+750;

if ($width_graph < 1800) {
	$width_graph = 1800;
}

header("Content-Type: application/octet-stream");
Header("Content-Disposition: attachment; filename=barplot.png");

// Create the graph. These two calls are always required
$graph = new Graph($width_graph,$height_graph);
$graph->SetScale('textint');

// Adjust the margin a bit to make more room for titles
$graph->SetMargin(150,60,90,660);

// Create a bar pot
$bplot = new BarPlot($data);
 
// Adjust fill color
$bplot->SetFillColor('blue');
$graph->Add($bplot);
 
// Setup the titles
$graph->title->Set($title);
$graph->title->SetFont(FF_ARIAL,FS_BOLD,36);
$graph->yaxis->title->Set('Log2 Intensity');
$graph->yaxis->title->SetFont(FF_ARIAL,FS_NORMAL,24);

$graph->xaxis->SetTickLabels($sam_titles);
$graph->xaxis->SetLabelAngle(90);

$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,24);
$graph->yaxis->SetFont(FF_ARIAL,FS_NORMAL,24);

// Display the graph
$graph->Stroke();

?>
