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

$search_text = $_REQUEST["search_text"];
$identifier_type = $_REQUEST["identifier_type"];
$platform = Strtolower ($_REQUEST['platform']);
$exp = $_REQUEST["exp"];
$ave = $_REQUEST['ave'];

$search_text = trim($search_text);
$post_terms = explode(",", $search_text);
$num_post_terms = count($post_terms);

$search_terms=array();

for ($i=0;$i<$num_post_terms;$i++){
	$post_terms[$i] = trim($post_terms[$i]);
    $search_terms[$i] = Strtolower($post_terms[$i]);
	$search_terms[$i] = preg_replace ('/\s{1}/', '+', $search_terms[$i]);
    if ( preg_match ('/^os\d{2}g\d{7}$/', $search_terms[$i]) ) {
    	$search_terms[$i] = preg_replace ('/g/', 't', $search_terms[$i]);
    }
}

if ($identifier_type=='elementid'){
	for ($i=0;$i<$num_post_terms;$i++){
		$search_terms[$i] = preg_replace ('/\'/', "''", $search_terms[$i]);
		$search_terms[$i] = "'$search_terms[$i]'";
	}
	$probe_ids = join(",", $search_terms);
	$query_probe = "select * from probe
			 where
			 lower(probeid) in($probe_ids)
			 and lower(platform) = '$platform'
			 order by probeid
			 ";
}elseif ($identifier_type=='geneid'){
	$search_sentences=array();
	foreach ($search_terms as $id){
		array_push ($search_sentences, "lower(MSU6_id) like '%$id%'");
		array_push ($search_sentences, "lower(RAP3_id) like '%$id%'");
		array_push ($search_sentences, "lower(cDNA_id) like '%$id%'");
	}
	$search_sentences = join(" or ", $search_sentences);
	$query_probe = "select * from probe
			 where
			 ($search_sentences)
			 and lower(platform) = '$platform'
			 order by probeid
			 ";
}

$conn = db_connect();
$result = @$conn->query($query_probe);
$num_probes = $result->num_rows;

$probe_ids = array();

for ($count=0; $row = $result->fetch_assoc(); $count++){
	$row{'probeid'} = preg_replace ('/\'/', "''", $row{'probeid'});
	$probe_ids[$count] = "'".$row{'probeid'}."'";
}

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

$sam_ids_combined = join (",", $sam_ids);
$probe_ids_combined = join(",", $probe_ids);

if ($ave == 'Y'){
	$query = "select $sam_ids_combined from $platform"."_ave
			 where
			 lower(probeid) in($probe_ids_combined)
			 order by probeid";
}else{
	if ($platform == 'affymetrix'){
		$query = "select $sam_ids_combined from affymetrix1, affymetrix2
				where
				affymetrix1.probeid=affymetrix2.probeid
				and
				lower(affymetrix1.probeid) in($probe_ids_combined)
				order by affymetrix1.probeid";
	}else {
		$query = "select $sam_ids_combined from $platform
				where
				lower(probeid) in($probe_ids_combined)
				order by probeid";
	}
}


$result = @$conn->query($query);

$data = array();

for ($count=0; $row = $result->fetch_row(); $count++){
	for ($i=0;$i<count($row);$i++){
		if ($row[$i] == 'NA'){
			$row[$i] = '';
		}
	}
	$data[$count] = $row;
}

for ($i=0;$i<$num_probes;$i++){
	$probe_ids[$i] = preg_replace ("/''/", '@', $probe_ids[$i]);
	$probe_ids[$i] = preg_replace ("/'/", '', $probe_ids[$i]);
	$probe_ids[$i] = preg_replace ("/@/", "'", $probe_ids[$i]);
}

$result->free();
$conn->close();

$num_row = count ($data);
$num_col = count ($data[0]);

$width_graph = $width_cell*$num_col+1050;
$height_graph =  750+690;

header("Content-Type: application/octet-stream");
Header("Content-Disposition: attachment; filename=$exp\_cegraph.png");

// Create the graph and set a scale
$graph = new Graph($width_graph,$height_graph);
$graph->title->Set("Expression in $exp");
$graph->title->SetFont(FF_ARIAL,FS_BOLD,36);

if ($platform == 'affymetrix'){
	$graph->SetScale('textint');
}else{
	$graph->SetScale('textlin');
}

if ($platform == 'affymetrix'){
	$graph->yaxis->title->Set('Log2 Intensity');
}else{
	$graph->yaxis->title->Set('Log2 Ratio');
}

$graph->yaxis->title->SetFont(FF_ARIAL,FS_NORMAL,24);

$graph->SetMargin(150, 900, 90, 600);

$graph->xaxis->SetTickSide(SIDE_BOTTOM);
$graph->yaxis->SetTickSide(SIDE_LEFT);

$graph->xaxis->SetTickLabels($sam_titles);
$graph->xaxis->SetLabelAngle(90);

$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,24);
$graph->yaxis->SetFont(FF_ARIAL,FS_NORMAL,24);

for ($i=0;$i<$num_row;$i++){
	$line_name='lineplot'.$i;
	$$line_name = new LinePlot($data[$i]);
	$$line_name->SetLegend("$probe_ids[$i]");
	$graph->Add($$line_name);
}

$graph->legend->SetPos(0.05, 0.5, 'right', 'center');
$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,24);
#$graph->legend->SetColumns(2);

$graph->xaxis->SetPos("min");

$graph->Stroke();

?>
