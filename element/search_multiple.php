<?php
$host = 'localhost';
$dbname = 'test';
$username = 'root';
$password = 'JustD01t!';

// include function files for this application
require_once('../RAD_fns.php'); 
$conn = mysqli_connect($host, $username, $password, $dbname); 
$MAX_IDS = 1000;

$search_text = $_POST["search_text"];
$result_type = $_POST["result_type"];

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
	echo "Your search terms have exceeded the max limitation (1000 terms). Please go back to exclude some terms and try again!\n";
	do_html_footer($doc_path); 
	exit;
}

$search_terms=array();

for ($i=0;$i<$num_post_terms;$i++){
	$post_terms[$i] = trim($post_terms[$i]);
    $search_terms[$i] = Strtolower($post_terms[$i]);
    if ( preg_match ('/^os\d{2}g\d{7}$/', $search_terms[$i]) ) {
    	$search_terms[$i] = preg_replace ('/g/', 't', $search_terms[$i]);
    }
}


$search_sentences=array();
foreach ($search_terms as $id){
	#$id = preg_replace ('/\'/', "''", $id);
	array_push ($search_sentences, "lower(target) like '%$id%'");
	#array_push ($search_sentences, "lower(affymetrix) like '%$id%'");
	#array_push ($search_sentences, "lower(agilent22k) like '%$id%'");
	#array_push ($search_sentences, "lower(agilent44k) like '%$id%'");
	#array_push ($search_sentences, "lower(bgiyale) like '%$id%'");
	#array_push ($search_sentences, "lower(nsf20k) like '%$id%'");
	#array_push ($search_sentences, "lower(nsf45k) like '%$id%'");
}
$search_sentences = join(" or ", $search_sentences);
$query = "select * from probe_matrix
		 where
		 ($search_sentences)
		 order by target
		 ";


$conn = db_connect();
$result = @$conn->query($query);

if ($result_type == "result_html") {
	do_html_header($doc_path);
	$num=$result->num_rows;
	if ($num>0){
		echo "<center><h2>Microarray Element Search Results</h2><center><br/>\n";
		echo "<table width='100%' cellspacing='1' cellpadding='1' rules='cols' border='1'>\n";

		echo "<tr align=center bgcolor=Orange>\n";
		echo "<td>&nbsp;<b>Target ID</b>&nbsp;</td>\n";
		echo "<td>&nbsp;<b>Affymetrix Probe Set</b>&nbsp;</td>\n";
		echo "<td>&nbsp;<b>Agilent 22K Probe</b>&nbsp;</td>\n";
		echo "<td>&nbsp;<b>Agilent 44K Probe</b>&nbsp;</td>\n";
		echo "<td>&nbsp;<b>BGI/Yale Probe</b>&nbsp;</td>\n";
		echo "<td>&nbsp;<b>NSF 20K Probe</b>&nbsp;</td>\n";
		echo "<td>&nbsp;<b>NSF 45K Probe</b>&nbsp;</td>\n";
		echo "</tr>\n";
		
		$i=0;
		while ($row = $result->fetch_assoc()) {
			
			$i++;
			$rowbgcolor=($i%2==0?'LightYellow':'LightBlue');

			echo "<tr bgcolor=$rowbgcolor>\n";


			echo "<td nowrap>&nbsp;";
			echo $row['target'];
			echo "&nbsp;</td>\n";

			echo "<td>&nbsp;";
			echo $row['affymetrix'];
			echo "&nbsp;</td>\n";

			echo "<td>&nbsp;";
			echo $row['agilent22k'];
			echo "&nbsp;</td>\n";

			echo "<td>&nbsp;";
			echo $row['agilent44k'];
			echo "&nbsp;</td>\n";

			echo "<td>&nbsp;";
			echo $row['bgiyale'];
			echo "&nbsp;</td>\n";

			echo "<td>&nbsp;";
			echo $row['nsf20k'];
			echo "&nbsp;</td>\n";

			echo "<td>&nbsp;";
			echo $row['nsf45k'];
			echo "&nbsp;</td>\n";

			echo "</tr>\n";
		}
		echo "</table>\n";
	}else {
		echo "No array element found!<br/>\n";
	}
	do_html_footer($doc_path); 
}elseif ($result_type == "result_text") {
	
    header("Content-type: text/plain");

	$num=$result->num_rows;
	if ($num>0){
		echo "Target ID\tAffymetrix Probe Set\tAgilent 22K Probe\tAgilent 44K Probe\tBGI/Yale Probe\tNSF 20K Probe\tNSF 45K Probe\n";
		while ($row = $result->fetch_assoc()) {
			
			echo $row['target'];
			echo "\t";

			echo $row['affymetrix'];
			echo "\t";

			echo $row['agilent22k'];
			echo "\t";

			echo $row['agilent44k'];
			echo "\t";

			echo $row['bgiyale'];
			echo "\t";

			echo $row['nsf20k'];
			echo "\t";

			echo $row['nsf45k'];
			echo "\n";
		}
    
	}else{
		echo "No array element found!\n";
	}
}

$result->free();
$conn->close();
?>
