<?php
$host = 'localhost';
$dbname = 'test';
$username = 'root';
$password = 'JustD01t!';

// include function files for this application
require_once('../RAD_fns.php');
$conn = mysqli_connect($host, $username, $password, $dbname);  

$MAX_IDS = 5000;

$search_text = $_POST["search_text"];
$go_type = $_POST["go_type"];
$identifier_type = $_REQUEST["identifier_type"];

if (is_uploaded_file($_FILES['search_file']['tmp_name'])){
	$input_file = $_FILES['search_file']['tmp_name'];
	$fp=fopen($input_file, 'r');
	$input_file_line=fread($fp, filesize($input_file));
	$input_file_line=trim($input_file_line);
	fclose($fp);

	if ($input_file_line != "") {
		$search_text = $input_file_line;
	}
}

$search_text = trim($search_text);
$post_terms = explode("\n", $search_text);
$num_post_terms = count($post_terms);

if ($search_text == ""){
	do_html_header($doc_path);
	echo "No search terms. Please go back and try again!\n";
	do_html_footer($doc_path); 
	exit;
}

if ($num_post_terms > $MAX_IDS){
	do_html_header($doc_path);
	echo "Your search terms have exceeded the max limitation ($MAX_IDs terms). Please go back to exclude some terms and try again!\n";
	do_html_footer($doc_path); 
	exit;
}

$search_terms=array();

for ($i=0;$i<$num_post_terms;$i++){
	$post_terms[$i] = preg_replace ('/\s+/', '', $post_terms[$i]);
    $search_terms[$i] = Strtolower($post_terms[$i]);
	$search_terms[$i] = preg_replace ('/\.\d+$/', '', $search_terms[$i]);
	if (preg_match ('/^os/', $search_terms[$i])){
		$search_terms[$i] = preg_replace ('/^os/', 'loc_os', $search_terms[$i]);
	}
}

for ($i=0;$i<$num_post_terms;$i++){
	$search_terms[$i] = "'$search_terms[$i]'";
}

if ($identifier_type=='geneid'){
	$locus_ids = join(",", $search_terms);
	$query = "select * from go
			 where
			 lower(locusid) in($locus_ids)
			 and lower(gotype) = '$go_type'
			 order by locusid
			 ";
}elseif ($identifier_type=='goid'){
	$go_ids = join(",", $search_terms);
	$query = "select * from go
			 where
			 lower(goid) in($go_ids)
			 and lower(gotype) = '$go_type'
			 order by locusid
			 ";
}

$conn = db_connect();

$query_annotation = "select * from annotation";
$result = @$conn->query($query_annotation);

$annotation=array();

while ($row = $result->fetch_assoc()) {
	$annotation[$row['geneid']]=$row['annotation'];
}

$result = @$conn->query($query);


do_html_header($doc_path);
$num=$result->num_rows;

$mapped = array();

if ($num>0){
	echo "<center><h2>GO Enrichment Analysis Results</h2></center><br/>\n";
	echo "<b>GO terms mapped onto the query.</b><br/>\n";
	echo "<table width='100%' cellspacing='1' cellpadding='1' rules='cols' border='1'>\n";

	echo "<tr align=center bgcolor=Orange>\n";
	echo "<td><b>Locus ID</b></td>\n";
	echo "<td><b>RGAP Ver 6 Annotation</b></td>\n";
	echo "<td><b>GO ID</b></td>\n";
	echo "<td><b>GO Name</b></td>\n";
	echo "<td><b>GO Type</b></td>\n";
	echo "<td><b>Evidence Type</b></td>\n";

	echo "</tr>\n";
	$go_query=array();
	$total_query=0;
	$i=0;
	while ($row = $result->fetch_assoc()) {

		$i++;
		$rowbgcolor=($i%2==0?'LightYellow':'LightBlue');
		echo "<tr bgcolor=$rowbgcolor>\n";

		echo "<td>&nbsp;";
		echo $row['locusid'];
		echo "&nbsp;</td>\n";

		$mapped[$row['locusid']]=1;

		echo "<td nowrap='nowrap'>&nbsp;";
		echo $annotation[$row['locusid']];
		echo "&nbsp;</td>\n";

		echo "<td>&nbsp;";
		echo $row['goid'];
		echo "&nbsp;</td>\n";

		echo "<td nowrap='nowrap'>&nbsp;";
		echo $row['goname'];
		echo "&nbsp;</td>\n";

		echo "<td>&nbsp;";
		echo $row['gotype'];
		echo "&nbsp;</td>\n";

		echo "<td>&nbsp;";
		echo $row['evidence_type'];
		echo "&nbsp;</td>\n";

		echo "</tr>\n";
		
		$total_query++;
		if (isset($go_query[$row['goid']])){
			$go_query[$row['goid']]++;
		}else {
			$go_query[$row['goid']]=1;
		}
	}
	echo "</table>\n";
	echo '<br/><br/>';

	if ($identifier_type=='geneid'){
		$unmapped=array();
		for ($i=0;$i<$num_post_terms;$i++){
			$search_terms[$i] = preg_replace ('/\'/', '', $search_terms[$i]);
			$search_terms[$i] = preg_replace ('/^loc_os/', 'LOC_Os', $search_terms[$i]);
			if (! isset($mapped[$search_terms[$i]])){
				array_push ($unmapped, $search_terms[$i]);
			}
		}
		$num_unmapped = count($unmapped);
		
		if ($num_unmapped>0){
			echo "<b>Genes unmapped by GO annotation.</b><br/>\n";
			echo "<table width='100%' cellspacing='1' cellpadding='1' rules='cols' border='1'>\n";

			echo "<tr align=center bgcolor=Orange>\n";
			echo "<td><b>Locus ID</b></td>\n";
			echo "<td><b>RGAP Ver 6 Annotation</b></td>\n";
			echo "</tr>\n";

			for ($i=0;$i<$num_unmapped;$i++){

				$rowbgcolor=($i%2==0?'LightYellow':'LightBlue');
				echo "<tr bgcolor=$rowbgcolor>\n";

				echo "<td>&nbsp;";
				echo $unmapped[$i];
				echo "&nbsp;</td>\n";

				echo "<td nowrap='nowrap'>&nbsp;";
				echo $annotation[$unmapped[$i]];
				echo "&nbsp;</td>\n";

			}
			echo "</table>\n";
			echo '<br/><br/>';
		}
	}

	if ($identifier_type=='geneid'){
	
		$query_all = "select * from go
					 where
					 lower(gotype) = '$go_type'
					 ";

		$result = @$conn->query($query_all);
		
		$go_ref=array();
		$go_name=array();
		$go_level=array();
		$total_ref=0;
		while ($row = $result->fetch_assoc()) {
			$total_ref++;		
			if (isset($go_ref[$row['goid']])){
				$go_ref[$row['goid']]++;
			}else {
				$go_ref[$row['goid']]=1;
			}
			$go_name[$row['goid']]=$row['goname'];
			$go_level[$row['goid']]=$row['level'];
		}

		ksort ($go_query);

		echo "<b>GO enrichment analysis results.</b><br/>\n";
		echo "<table width='100%' cellspacing='1' cellpadding='1' rules='cols' border='1'>\n";

		echo "<tr align=center bgcolor=Orange>\n";
		echo "<td><b>GO ID</b></td>\n";
		echo "<td><b>GO Name</b></td>\n";
		echo "<td><b>GO Level</b></td>\n";
		echo "<td><b>Ref Total</b></td>\n";
		echo "<td><b>Ref Number</b></td>\n";
		echo "<td><b>Query Total</b></td>\n";
		echo "<td><b>Query Number</b></td>\n";
		echo "<td><b>Query Exp</b></td>\n";
		echo "<td><b>Hyper p value</b></td>\n";
		echo "</tr>\n";
		$i=0;
		foreach ($go_query as $go => $num_query){
			
			$i++;
			$rowbgcolor=($i%2==0?'LightYellow':'LightBlue');
			echo "<tr bgcolor=$rowbgcolor>\n";

			$num_ref = $go_ref[$go];

			echo "<td>&nbsp;";
			echo $go;
			echo "&nbsp;</td>\n";

			echo "<td>&nbsp;";
			echo $go_name[$go];
			echo "&nbsp;</td>\n";
			
			echo "<td>&nbsp;";
			echo $go_level[$go];
			echo "&nbsp;</td>\n";

			echo "<td>&nbsp;";
			echo $total_ref;
			echo "&nbsp;</td>\n";

			echo "<td>&nbsp;";
			echo $num_ref;
			echo "&nbsp;</td>\n";

			echo "<td>&nbsp;";
			echo $total_query;
			echo "&nbsp;</td>\n";

			echo "<td>&nbsp;";
			echo $num_query;
			echo "&nbsp;</td>\n";

			$exp=$total_query*$num_ref/$total_ref;

			echo "<td>&nbsp;";
			printf ("%.4f", $exp);
			echo "&nbsp;</td>\n";
			
			$p_hyper = hyper($num_query, $total_query, $num_ref, $total_ref);
			
			if ($p_hyper <= 0.05){
				echo "<td style='background-color:red'>&nbsp;";
			}else {
				echo "<td>&nbsp;";
			}
			printf ("%.4f", $p_hyper);
			echo "&nbsp;</td>\n";

			echo "</tr>\n";
			
		}
		echo "</table>\n";
	}
}else {
	echo "No GO terms found!<br/>\n";
}

do_html_footer($doc_path); 


$result->free();
$conn->close();
?>
