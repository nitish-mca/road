<?php
$host = 'localhost';
$dbname = 'test';
$username = 'root';
$password = 'JustD01t!';

// include function files for this application
require_once('../RAD_fns.php'); 
$conn = mysqli_connect($host, $username, $password, $dbname);  
$MAX_IDS = 1000;
$MAX_TITLE = 45;

$search_text = $_REQUEST["search_text"];
$identifier_type = $_REQUEST["identifier_type"];

if ( isset($REQUEST['search_file'])){
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
		$search_terms[$i] = "'$search_terms[$i]'";
	}
	$probe_ids = join(",", $search_terms);
	$query_probe = "select * from probe
			 where
			 lower(probeid) in($probe_ids)
			 and lower(platform) = 'affymetrix'
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
			 and lower(platform) = 'affymetrix'
			 order by probeid
			 ";
}

$conn = db_connect();

$result = @$conn->query($query_probe);
$num_probes = $result->num_rows;

if ($num_probes == 0){
	do_html_header($doc_path);
	echo "No probe found. Please go back and try again!\n";
	do_html_footer($doc_path); 
	exit;
}

$probe_info = array();
$probe_ids = array();

for ($count=0; $row = $result->fetch_assoc(); $count++){
	$probe_info[$count] = $row;
	$probe_ids[$count] = $row{'probeid'};
}

$probe_ids_combined = join(",", $probe_ids);

$result->free();
$conn->close();


do_html_header($doc_path);
echo "<h2>Affymetrix Reclassification Data Search Results</h2><br/>\n";

?>
<script type="text/JavaScript">
	function TypeCheck(){
		if(document.myform.TypeCtr.checked==true){
			document.myform.anatomy.checked=true;
			document.myform.developmental_stage.checked=true;
			document.myform.biotic_stress.checked=true;
			document.myform.abiotic_stress.checked=true;
			document.myform.hormone.checked=true;
			document.myform.genetic_modification.checked=true;
			document.myform.variety.checked=true;
		}else {
			document.myform.anatomy.checked=false;
			document.myform.developmental_stage.checked=false;
			document.myform.biotic_stress.checked=false;
			document.myform.abiotic_stress.checked=false;
			document.myform.hormone.checked=false;
			document.myform.genetic_modification.checked=false;
			document.myform.variety.checked=false;
		}
	}
</script>

<form name='myform' action='reclassification_search.php' method='post'>
	<table cellpadding='4' cellspacing='3' width='600'>

		<tr>
			<td>
				Select data type:
			</td>
			<td>
				<input type="Checkbox" name="anatomy" value="1" <?php if (isset($_REQUEST['anatomy'])) echo 'checked'; ?> >Anatomy
				<input type="Checkbox" name="developmental_stage" value="1" <?php if (isset($_REQUEST['developmental_stage'])) echo 'checked'; ?> >Developmental Stage
				<input type="Checkbox" name="biotic_stress" value="1" <?php if (isset($_REQUEST['biotic_stress'])) echo 'checked'; ?> >Biotic Stress
				<input type="Checkbox" name="abiotic_stress" value="1" <?php if (isset($_REQUEST['abiotic_stress'])) echo 'checked'; ?> >Abiotic Stress
				<input type="Checkbox" name="hormone" value="1" <?php if (isset($_REQUEST['hormone'])) echo 'checked'; ?> >Hormone
				<input type="Checkbox" name="genetic_modification" value="1" <?php if (isset($_REQUEST['genetic_modification'])) echo 'checked'; ?> >Genetic Modification	
				<input type="Checkbox" name="variety" value="1" <?php if (isset($_REQUEST['variety'])) echo 'checked'; ?> >Variety
				<input type="checkbox" name="TypeCtr" value="1" onClick="TypeCheck()">Check/Uncheck All
			</td>
		</tr>

		<tr>
			<td>
					Display format:
			</td>
			<td>
				<input type="Checkbox" name="Heatmap" value="1" <?php if (isset($_REQUEST['Heatmap'])) echo 'checked'; ?> >Show Heatmap
				<input type="Checkbox" name="CEGraph" value="1" <?php if (isset($_REQUEST['CEGraph'])) echo 'checked'; ?> >Classic Expression Graph
			</td>
		</tr>


		<tr>
			<td>
			</td>
			<td>
				<input type='hidden' name='search_text' value='<?php echo $search_text;?>'>
				<input type='hidden' name='identifier_type' value='<?php echo $identifier_type;?>'>
				<input type='hidden' name='result_type' value='<?php echo $result_type;?>'>
				<input type ="submit" value="Update">&nbsp;&nbsp;	
			</td>
		</tr>
	</table>
</form>

<?php
//Table containing formation about probes matched

$type = '';

if (isset($_REQUEST['anatomy'])){
	$type .= 'anatomy,';
}
if (isset($_REQUEST['developmental_stage'])){
	$type .= 'developmental_stage,';
}
if (isset($_REQUEST['biotic_stress'])){
	$type .= 'biotic_stress,';
}
if (isset($_REQUEST['abiotic_stress'])){
	$type .= 'abiotic_stress,';
}
if (isset($_REQUEST['hormone'])){
	$type .= 'hormone,';
}
if (isset($_REQUEST['genetic_modification'])){
	$type .= 'genetic_modification,';
}
if (isset($_REQUEST['variety'])){
	$type .= 'variety,';
}

$type = preg_replace ('/,$/', '', $type);

echo "<b>Probe matched:</b>\n";
echo "<br /><br />\n";
echo "Click each probeset will direct to the detailed expression page.<br /><br />\n";

echo "<table border='1' cellpadding='1' cellspacing='1' rules='cols'>\n";

echo "<tr align=center bgcolor=Orange>\n";
echo "<td><b>Array Element ID</b></td>\n";
echo "<td><b>Array Platform</b></td>\n";
echo "<td><b>Matched MSU/TIGR Gene ID</b></td>\n";
echo "<td><b>Matched RAP3 Gene ID</b></td>\n";
echo "<td><b>Matched KOME cDNA ID</b></td>\n";
echo "</tr>\n";

for ($i = 0; $i < $num_probes; $i++) {
	
	$rowbgcolor=($i%2==0?'LightYellow':'LightBlue');
	echo "<tr bgcolor=$rowbgcolor>\n";
	
	$row = $probe_info[$i];
	
	echo "<td>";
	echo "<a href=reclassification_detail.php?type=$type&id=".$row['probeid'].' target=_blank>'.$row['probeid']."</a>\n";
	echo "</td>\n";

	echo "<td>";
	echo $row['platform'];
	echo "</td>\n";

	echo "<td>";
	$ids= explode(";", $row['MSU6_id']);
	sort($ids);
	foreach ($ids as $id){
		if ($id != 'N/A'){
			echo "<a href=http://rice.plantbiology.msu.edu/cgi-bin/ORF_infopage.cgi?db=osa1r6&orf=$id target=_blank>$id</a><br/>\n";
		}else {
			echo "$id<br/>\n";
		}
	}
	echo "</td>\n";

	echo "<td>";
	$ids= explode(";", $row['RAP3_id']);
	sort($ids);
	foreach ($ids as $id){
		if ($id != 'N/A'){
			echo "<a href=http://rapdb.dna.affrc.go.jp/viewer/gbrowse_details/build5?name=$id target=_blank>$id</a><br/>\n";
		}else {
			echo "$id<br/>\n";
		}
	}
	echo "</td>\n";

	echo "<td>";
	$ids= explode(";", $row['cDNA_id']);
	sort($ids);
	foreach ($ids as $id){
		echo "$id<br/>\n";
	}
	echo "</td>\n";

	echo "</tr>\n";

}

echo "</table>\n";

echo "<br /><br />\n";

if (isset($_REQUEST['anatomy'])){
	echo "<br /><b>Anatomy:</b>\n";
	echo "<br /><br />\n";
	if (isset($_REQUEST['Heatmap'])){
		echo '<img src="reclassification_heatmap.php?type=anatomy&ids='.$probe_ids_combined.'" border=0 align=top>';
		echo '<br /><br />';
	}
	echo "<br />\n";
	if (isset($_REQUEST['CEGraph'])){
		echo '<img src="reclassification_cegraph.php?type=anatomy&ids='.$probe_ids_combined.'" border=0 align=top>';
		echo '<br /><br />';
	}
	echo '<a href="reclassification_download.php?type=anatomy&ids='.$probe_ids_combined.'">Download Anatomy Data</a>';
	echo '<br /><br />';
}

if (isset($_REQUEST['developmental_stage'])){
	echo "<br /><b>Developmental Stage:</b>\n";
	echo "<br /><br />\n";
	if (isset($_REQUEST['Heatmap'])){
		echo '<img src="reclassification_heatmap.php?type=developmental_stage&ids='.$probe_ids_combined.'" border=0 align=top>';
		echo '<br /><br />';
	}
	echo "<br />\n";
	if (isset($_REQUEST['CEGraph'])){
		echo '<img src="reclassification_cegraph.php?type=developmental_stage&ids='.$probe_ids_combined.'" border=0 align=top>';
		echo '<br /><br />';
	}
	echo '<a href="reclassification_download.php?type=developmental_stage&ids='.$probe_ids_combined.'">Download Developmental Stage Data</a>';
	echo '<br /><br />';
}

if (isset($_REQUEST['biotic_stress'])){
	echo "<br /><b>Biotic Stress:</b>\n";
	echo "<br /><br />\n";
	if (isset($_REQUEST['Heatmap'])){
		echo '<img src="reclassification_heatmap.php?type=biotic_stress&ids='.$probe_ids_combined.'" border=0 align=top>';
		echo '<br /><br />';
	}
	echo "<br />\n";
	if (isset($_REQUEST['CEGraph'])){
		echo '<img src="reclassification_cegraph.php?type=biotic_stress&ids='.$probe_ids_combined.'" border=0 align=top>';
		echo '<br /><br />';
	}
	echo '<a href="reclassification_download.php?type=biotic_stress&ids='.$probe_ids_combined.'">Download Biotic Stress Data</a>';
	echo '<br /><br />';
}

if (isset($_REQUEST['abiotic_stress'])){
	echo "<br /><b>Abiotic Stress:</b>\n";
	echo "<br /><br />\n";
	if (isset($_REQUEST['Heatmap'])){
		echo '<img src="reclassification_heatmap.php?type=abiotic_stress&ids='.$probe_ids_combined.'" border=0 align=top>';
		echo '<br /><br />';
	}
	echo "<br />\n";
	if (isset($_REQUEST['CEGraph'])){
		echo '<img src="reclassification_cegraph.php?type=abiotic_stress&ids='.$probe_ids_combined.'" border=0 align=top>';
		echo '<br /><br />';
	}
	echo '<a href="reclassification_download.php?type=abiotic_stress&ids='.$probe_ids_combined.'">Download Abiotic Stress Data</a>';
	echo '<br /><br />';
}

if (isset($_REQUEST['hormone'])){
	echo "<br /><b>Hormone:</b>\n";
	echo "<br /><br />\n";
	if (isset($_REQUEST['Heatmap'])){
		echo '<img src="reclassification_heatmap.php?type=hormone&ids='.$probe_ids_combined.'" border=0 align=top>';
		echo '<br /><br />';
	}
	echo "<br />\n";
	if (isset($_REQUEST['CEGraph'])){
		echo '<img src="reclassification_cegraph.php?type=hormone&ids='.$probe_ids_combined.'" border=0 align=top>';
		echo '<br /><br />';
	}
	echo '<a href="reclassification_download.php?type=hormone&ids='.$probe_ids_combined.'">Download Hormone Data</a>';
	echo '<br /><br />';
}

if (isset($_REQUEST['genetic_modification'])){
	echo "<br /><b>Genetic Modification:</b>\n";
	echo "<br /><br />\n";
	if (isset($_REQUEST['Heatmap'])){
		echo '<img src="reclassification_heatmap.php?type=genetic_modification&ids='.$probe_ids_combined.'" border=0 align=top>';
		echo '<br /><br />';
	}
	echo "<br />\n";
	if (isset($_REQUEST['CEGraph'])){
		echo '<img src="reclassification_cegraph.php?type=genetic_modification&ids='.$probe_ids_combined.'" border=0 align=top>';
		echo '<br /><br />';
	}
	echo '<a href="reclassification_download.php?type=genetic_modification&ids='.$probe_ids_combined.'">Download Genetic Modification Data</a>';
	echo '<br /><br />';
}

if (isset($_REQUEST['variety'])){
	echo "<br /><b>Variety:</b>\n";
	echo "<br /><br />\n";
	if (isset($_REQUEST['Heatmap'])){
		echo '<img src="reclassification_heatmap.php?type=variety&ids='.$probe_ids_combined.'" border=0 align=top>';
		echo '<br /><br />';
	}
	echo "<br />\n";
	if (isset($_REQUEST['CEGraph'])){
		echo '<img src="reclassification_cegraph.php?type=variety&ids='.$probe_ids_combined.'" border=0 align=top>';
		echo '<br /><br />';
	}
	echo '<a href="reclassification_download.php?type=variety&ids='.$probe_ids_combined.'">Download Variety Data</a>';
	echo '<br /><br />';
}

do_html_footer($doc_path); 

?>
