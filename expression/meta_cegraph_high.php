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
$width_cell = 60;

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

$num_row = count ($data);
$num_col = count ($data[0]);

$width_graph = $width_cell*$num_col+1050;
$height_graph =  750+750;

header("Content-Type: application/octet-stream");
Header("Content-Disposition: attachment; filename=cegraph.png");

// Create the graph and set a scale
$graph = new Graph($width_graph,$height_graph);
$graph->SetScale('textint');

$graph->yaxis->title->Set('Log2 Intensity');
$graph->yaxis->title->SetFont(FF_ARIAL,FS_NORMAL,24);

$graph->SetMargin(150, 900, 90, 660);

$graph->xaxis->SetTickSide(SIDE_BOTTOM);
$graph->yaxis->SetTickSide(SIDE_LEFT);

$graph->xaxis->SetTickLabels($sam_titles);
$graph->xaxis->SetLabelAngle(90);

$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,24);
$graph->yaxis->SetFont(FF_ARIAL,FS_NORMAL,24);

for ($i=0;$i<$num_row;$i++){
	$line_name='lineplot'.$i;
	$$line_name = new LinePlot($data[$i]);
	$$line_name->SetLegend("$genes[$i]");
	$graph->Add($$line_name);
}

$graph->legend->SetPos(0.05, 0.5, 'right', 'center');
$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,24);
#$graph->legend->SetColumns(2);

$graph->Stroke();

?>
