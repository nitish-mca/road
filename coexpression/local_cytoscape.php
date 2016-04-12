<?php
$host = 'localhost';
$dbname = 'test';
$username = 'root';
$password = 'JustD01t!';
// include function files for this application
require_once('../RAD_fns.php');
$conn = mysqli_connect($host, $username, $password, $dbname); 

//create short variable names
$genelist = $_POST['genelist'];
$cutoff = $_POST['cutoff'];
$depth = $_POST['depth'];
$type = $_POST['type'];

$genelist=trim($genelist);

if ($genelist == ""){
	do_html_header($doc_path);
	echo "No query gene. Please go back and try again!\n";
	do_html_footer($doc_path); 
	exit;
}

if ($type == 'general'){
	$database='network';
}elseif ($type == 'abiotic'){
	$database='network_abiotic';
}elseif ($type == 'biotic'){
	$database='network_biotic';
}

$genearray = explode ("\n", $genelist);
$interactors =  array();
$ppi = array();

foreach ($genearray as $gene){
	$gene=trim($gene);
	$gene = Strtolower($gene);
	$gene= preg_replace ('/\.\d+$/', '', $gene);
	if ( preg_match ('/^os\d{2}g\d{5}$/', $gene) ) {
    	$gene='loc_'.$gene;
    }
	$gene= preg_replace ('/^loc_os/', 'LOC_Os', $gene);
	$interactors[$gene]=1;
}

$conn = db_connect();

for ($i=0;$i<$depth;$i++){

	$num_interactors = count ($interactors);
	if ($num_interactors==0){
		break;
	}
	
	$search_terms = array();
	foreach ($interactors as $key=>$value ){
		$key = "'$key'";
		array_push ($search_terms, $key);
	}
	$geneids = join(",", $search_terms);
	$query = "select * from $database where geneid in ($geneids)";

	$result = @$conn->query($query);
		
	if (!$result) {
		do_html_header($doc_path);
		echo 'Can not access the server now. Please try again later. <br />';
		do_html_footer($doc_path); 
		exit;
	}

	$num_results = @$result->num_rows;
	if ($num_results ==0) {
		do_html_header($doc_path);
		echo "There is no gene coexpressed with the query gene(s) under the correlation coefficient cutoff (>$cutoff)".'.<br /><br />';
		do_html_footer($doc_path); 
		exit;
	}
	
	$interactors_tmp =  array();
	$ppi_tmp = array();
	while ($row = $result->fetch_assoc()) {
		$bait = $row['geneid'];
		$preys = explode (';', $row['interactor']);

		foreach ($preys as $prey){
			$values = explode (':', $prey);
			if ($values[1]>$cutoff) {
				$interactors_tmp[$bait]=1;
				$interactors_tmp[$values[0]]=1;
				if ( strcmp($bait, $values[0])<0){
					$tmp="$bait;$values[0]";
				}else {
					$tmp="$values[0];$bait";
				}
				$ppi_tmp[$tmp]=$values[1];
			}
		}
	}

	$interactors = $interactors_tmp;
	$ppi = $ppi_tmp;
}

$result->free();
$conn->close();

$num_interactors = count ($interactors);
$num_ppi = count ($ppi);

if ($num_interactors==0 or $num_ppi==0){
	do_html_header($doc_path);
	echo "There is no gene coexpressed with the query gene(s) under the correlation coefficient cutoff (>$cutoff)".'.<br /><br />';
	do_html_footer($doc_path); 
	exit;
}else {
	//header("Content-type: text/plain");
	header("Content-Type: application/octet-stream ; charset=UTF-8");
	Header("Content-Disposition: attachment; filename=cytoscape.sif");

	foreach ($ppi as $key=>$value){
		$tmp = explode (';', $key);
		echo "$tmp[0]\tcoex\t$tmp[1]\n";
	}
}

?>
