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
	$query = "select * from ko
			 where
			 lower(locusid) in($locus_ids)
			 order by locusid
			 ";
}elseif ($identifier_type=='koid'){
	$ko_ids = join(",", $search_terms);
	$query = "select * from ko
			 where
			 lower(koid) in($ko_ids)
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


if ($num>0){
	echo "<center><h2>KO Enrichment Analysis Results</h2></center><br/>\n";
	echo "<b>KO terms mapped onto the query.</b><br/>\n";
	echo "<table width='100%' cellspacing='1' cellpadding='1' rules='cols' border='1'>\n";

	echo "<tr align=center bgcolor=Orange>\n";
	echo "<td><b>Locus ID</b></td>\n";
	echo "<td><b>RGAP Ver 6 Annotation</b></td>\n";
	echo "<td><b>KO ID</b></td>\n";
	echo "<td><b>KO Name</b></td>\n";
	echo "<td><b>KO Definition</b></td>\n";

	echo "</tr>\n";
	$ko_query=array();
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
		echo '<a href=http://www.genome.jp/dbget-bin/www_bget?ko+'.$row['koid'].' target=_blank>'.$row['koid'].'</a>';
		echo "&nbsp;</td>\n";

		echo "<td nowrap='nowrap'>&nbsp;";
		echo $row['koname'];
		echo "&nbsp;</td>\n";

		echo "<td nowrap='nowrap'>&nbsp;";
		echo $row['kodef'];
		echo "&nbsp;</td>\n";

		echo "</tr>\n";
		
		$total_query++;
		if (isset($ko_query[$row['koid']])){
			$ko_query[$row['koid']]++;
		}else {
			$ko_query[$row['koid']]=1;
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
			echo "<b>Genes unmapped by KO annotation.</b><br/>\n";
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
	
		$query_all = "select * from ko";

		$result = @$conn->query($query_all);
		
		$ko_ref=array();
		$ko_name=array();
		$total_ref=0;
		while ($row = $result->fetch_assoc()) {
			$total_ref++;		
			if (isset($ko_ref[$row['koid']])){
				$ko_ref[$row['koid']]++;
			}else {
				$ko_ref[$row['koid']]=1;
			}
			$ko_name[$row['koid']]=$row['koname'];
		}

		ksort ($ko_query);

		echo "<b>KO enrichment analysis results.</b><br/>\n";
		echo "<table width='100%' cellspacing='1' cellpadding='1' rules='cols' border='1'>\n";

		echo "<tr align=center bgcolor=Orange>\n";
		echo "<td><b>KO ID</b></td>\n";
		echo "<td><b>KO Name</b></td>\n";
		echo "<td><b>Ref Total</b></td>\n";
		echo "<td><b>Ref Number</b></td>\n";
		echo "<td><b>Query Total</b></td>\n";
		echo "<td><b>Query Number</b></td>\n";
		echo "<td><b>Query Exp</b></td>\n";
		echo "<td><b>Hyper p value</b></td>\n";
		echo "</tr>\n";
		$i=0;
		foreach ($ko_query as $ko => $num_query){
			
			$i++;
			$rowbgcolor=($i%2==0?'LightYellow':'LightBlue');
			echo "<tr bgcolor=$rowbgcolor>\n";

			$num_ref = $ko_ref[$ko];

			echo "<td>&nbsp;";
			echo '<a href=http://www.genome.jp/dbget-bin/www_bget?ko+'.$ko.' target=_blank>'.$ko.'</a>';
			echo "&nbsp;</td>\n";

			echo "<td>&nbsp;";
			echo $ko_name[$ko];
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
	echo "No KO terms found!<br/>\n";
}

do_html_footer($doc_path); 


$result->free();
$conn->close();
?>
