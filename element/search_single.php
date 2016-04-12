<?php
$host = 'localhost';
$dbname = 'road';
$username = 'root';
$password = 'root';
// include function files for this application
require_once('../RAD_fns.php');
$conn = mysqli_connect($host, $username, $password, $dbname);  

$MAX_IDS = 1000;

$search_text = $_POST["search_text"];
$identifier_type = $_POST['identifier_type'];
$search_against = Strtolower ($_POST['search_against']);
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


if ($identifier_type=='elementid'){
	for ($i=0;$i<$num_post_terms;$i++){
		$search_terms[$i] = preg_replace ('/\'/', "''", $search_terms[$i]);
		$search_terms[$i] = "'$search_terms[$i]'";
	}
	$probe_ids = join(",", $search_terms);
	$query = "select * from probe
			 where
			 lower(probeid) in($probe_ids)
			 and lower(platform) = '$search_against'
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
	$query = "select * from probe
			 where
			 ($search_sentences)
			 and lower(platform) = '$search_against'
			 order by probeid
			 ";
}

$conn = db_connect();
$result = @$conn->query($query);

if ($result_type == "result_html") {
	do_html_header($doc_path);
	$num=$result->num_rows;
	if ($num>0){
		echo "<center><h2>Microarray Element Search Results</h2><center><br/>\n";
		echo "<table width='100%' cellspacing='1' cellpadding='1' rules='cols' border='1'>\n";

		echo "<tr align=center bgcolor=Orange>\n";
		echo "<td>&nbsp;<b>Array Element ID</b>&nbsp;</td>\n";
		echo "<td>&nbsp;<b>Array Platform</b>&nbsp;</td>\n";
		echo "<td>&nbsp;<b>Matched MSU/TIGR Gene ID</b>&nbsp;</td>\n";
		echo "<td>&nbsp;<b>Matched RAP3 Gene ID</b>&nbsp;</td>\n";
		echo "<td>&nbsp;<b>Matched KOME cDNA ID</b>&nbsp;</td>\n";
		echo "<td>&nbsp;<b>Probe Type</b>&nbsp;</td>\n";
		echo "<td>&nbsp;<b>Probe Sequence</b>&nbsp;</td>\n";
		echo "<td>&nbsp;<b>Is Control</b>&nbsp;</td>\n";
		echo "</tr>\n";
		
		$i=0;
		while ($row = $result->fetch_assoc()) {

			$i++;
			$rowbgcolor=($i%2==0?'LightYellow':'LightBlue');

			echo "<tr bgcolor=$rowbgcolor>\n";

			echo "<td>&nbsp;";
			echo $row['probeid'];
			echo "&nbsp;</td>\n";

			echo "<td>&nbsp;";
			echo $row['platform'];
			echo "&nbsp;</td>\n";

			echo "<td>";
			$ids= explode(";", $row['MSU6_id']);
			sort($ids);
			foreach ($ids as $id){
				if ($id != 'N/A'){
					echo "&nbsp;<a href=http://rice.plantbiology.msu.edu/cgi-bin/ORF_infopage.cgi?db=osa1r6&orf=$id target=_blank>$id</a>&nbsp;<br/>\n";
				}else {
					echo "$id<br/>\n";
				}
			}
			echo "</td>\n";

			echo "<td nowrap>";
			$ids= explode(";", $row['RAP3_id']);
			sort($ids);
			foreach ($ids as $id){
				if ($id != 'N/A'){
					echo "&nbsp;<a href=http://rapdb.dna.affrc.go.jp/viewer/gbrowse_details/build5?name=$id target=_blank>$id</a>&nbsp;<br/>\n";
				}else {
					echo "$id<br/>\n";
				}
			}
			echo "</td>\n";

			echo "<td>";
			$ids= explode(";", $row['cDNA_id']);
			sort($ids);
			foreach ($ids as $id){
				echo "&nbsp;$id&nbsp;<br/>\n";
			}
			echo "</td>\n";

			echo "<td>&nbsp;";
			echo $row['probetype'];
			echo "&nbsp;</td>\n";

			echo "<td>&nbsp;";
			echo $row['sequence'];
			echo "&nbsp;</td>\n";

			echo "<td>&nbsp;";
			echo $row['control'];
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
		echo "Array Element ID\tArray Platform\tMatched MSU/TIGR Gene ID\tMatched RAP3 Gene ID\tMatched KOME cDNA ID\tProbe Type\tProbe Sequence\tIs Control\n";
		while ($row = $result->fetch_assoc()) {
			
			echo $row['probeid'];
			echo "\t";

			echo $row['platform'];
			echo "\t";

			echo $row['MSU6_id'];
			echo "\t";

			echo $row['RAP3_id'];
			echo "\t";

			echo $row['cDNA_id'];
			echo "\t";

			echo $row['probetype'];
			echo "\t";

			echo $row['sequence'];
			echo "\t";

			echo $row['control'];
			echo "\n";
		}
    
	}else{
		echo "No array element found!\n";
	}
}

$result->free();
$conn->close();
?>
