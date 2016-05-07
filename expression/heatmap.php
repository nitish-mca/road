<?php 
ob_start();
ob_flush();
ini_set('display_errors', '2');     # don't show any errors...
error_reporting(E_ALL | E_STRICT);  # ...but do log them
$host = 'localhost';
$dbname = 'road';
$username = 'root';
$password = 'root';
// include function files for this application

require_once('../RAD_fns.php'); 
if(file_exists('jpgraph/jpgraph.php')){
    require_once('jpgraph/jpgraph.php');
}
else{
    echo 'yy';
}

if(file_exists('jpgraph/jpgraph_line.php')){
    require_once('jpgraph/jpgraph_line.php');
}
else{
    echo 'yy';
}
//require_once('jpgraph/jpgraph_matrix.php') or die('ddd');
$conn = mysqli_connect($host, $username, $password, $dbname);  
$width_cell = 20;
$height_cell = 20;

$search_text = $_REQUEST["search_text"];
$identifier_type = $_REQUEST["identifier_type"];
$platform = Strtolower ($_REQUEST['platform']);
$exp = $_REQUEST["exp"];
$ave = $_REQUEST['ave'];
$scale = $_REQUEST['scale'];

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

if ($identifier_type=='probe_id'){
	for ($i=0;$i<$num_post_terms;$i++){
		$search_terms[$i] = preg_replace ('/\'/', "''", $search_terms[$i]);
		$search_terms[$i] = "'$search_terms[$i]'";
	}
	$probe_ids = join(",", $search_terms);
	$query_probe = "select * from test2
			 where
			 lower(probe_id) in($probe_ids)
			 and lower(platform) = '$platform'
			 order by probe_id
			 ";
}elseif ($identifier_type=='loci_id'){
    $search_term_str = 'FR000120';
    $query_probe = "SELECT * FROM  `test2` WHERE  `loci_id` IN ('".$search_term_str."') AND lower(platform) = '".$platform."'";
//	$search_sentences=array();
//	foreach ($search_terms as $id){
//		array_push ($search_sentences, "lower(MSU6_id) like '%$id%'");
//		array_push ($search_sentences, "lower(RAP3_id) like '%$id%'");
//		array_push ($search_sentences, "lower(cDNA_id) like '%$id%'");
//	}
//	$search_sentences = join(" or ", $search_sentences);
//	$query_probe = "select * from probe
//			 where
//			 ($search_sentences)
//			 and lower(platform) = '$platform'
//			 order by probeid
//			 ";
}

$conn = db_connect();
$result = @$conn->query($query_probe);
$num_probes = $result->num_rows;

$probe_ids = array();

for ($count=0; $row = $result->fetch_assoc(); $count++){
	$row{'probe_id'} = preg_replace ('/\'/', "''", $row{'probe_id'});
	$probe_ids[$count] = "'".$row{'probe_id'}."'";
}

if ($ave == 'Y'){
	$query_sam = "select sample_id, sample_title from sample_avg where exp_id='$exp' order by id";
}else{
	$query_sam = "select sample_id, sample_title from sample3 where accession_no='$exp' order by id";
}

$result = @$conn->query($query_sam);

$sam_ids=array();
$sam_titles=array();

for ($count=0; $row = $result->fetch_assoc(); $count++){
	$sam_ids[$count] = $row['sample_id'];
	$sam_titles[$count] = $row['sample_title'];
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
		$query = "select $sam_ids_combined from test5
				where
				lower(test5.probe_id) in($probe_ids_combined)
				order by test5.probe_id";
	}else {
		$query = "select $sam_ids_combined from $platform
				where
				lower(probeid) in($probe_ids_combined)
				order by probeid";
	}
}
//echo $query;
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

$width_graph = $width_cell*$num_col+330;
$height_graph =  $height_cell*$num_row+300;


// Setup a bsic matrix graph and title
$graph = new Graph($width_graph,$height_graph);
//$graph->title->Set('Basic matrix example');
//$graph->title->SetFont(FF_ARIAL,FS_BOLD,14);
$graph->title->Set("Expression in $exp");
$graph->title->SetFont(FF_ARIAL,FS_BOLD,12);
$graph->SetScale('intlin');
 
// Create a ,atrix plot using all default values
$mp = new LinePlot($data);

if ($platform == 'affymetrix'){
	$map = array('blue', 'black', 'yellow');
}else{
	$map = array('green', 'black', 'red');
}

//$mp->colormap->SetMap($map);
//
//if ($platform == 'affymetrix'){
//	if ($scale=='S1'){
//		$mp->colormap->SetRange(5, 13);
//	}elseif ($scale=='S2'){
//		$mp->colormap->SetRange(5, 15);
//	}elseif ($scale=='S3'){
//		$mp->colormap->SetRange(7, 17);
//	}
//}else{
//	if ($scale=='T1'){
//		$mp->colormap->SetRange(-1, 1);
//	}elseif ($scale=='T2'){
//		$mp->colormap->SetRange(-2, 2);
//	}elseif ($scale=='T3'){
//		$mp->colormap->SetRange(-3, 3);
//	}	
//}
//
//$mp->legend->SetFont(FF_ARIAL,FS_NORMAL,8);
//
//$mp->SetModuleSize($width_cell, $height_cell);
//
//$pox_x_mp = ($width_cell*$num_col)/2+235;
//$pos_y_mp = $height_cell*$num_row/2+70;
//$mp->SetCenterPos($pox_x_mp, $pos_y_mp);
//
//$mp->yedgelabel->SetSide('left');
//$mp->yedgelabel->Set($probe_ids);
//$mp->yedgelabel->SetFont(FF_ARIAL,FS_NORMAL,8);
//
//$mp->xedgelabel->SetSide('bottom');
//$mp->xedgelabel->Set($sam_titles);
//$mp->xedgelabel->SetFont(FF_ARIAL,FS_NORMAL,8);
//

$graph->Add($mp);
$graph->Stroke();

?>
