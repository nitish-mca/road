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
$platform = $_REQUEST["platform"];
$probe_database = 'gene_probe_'.$platform;

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
	if ( preg_match ('/\d{5}\.\d+$/', $search_terms[$i]) ) {
    	$search_terms[$i] = preg_replace ('/\.\d+$/', '', $search_terms[$i]);
    }
	if ( preg_match ('/\d{7}-\d+$/', $search_terms[$i]) ) {
    	$search_terms[$i] = preg_replace ('/-\d+$/', '', $search_terms[$i]);
    }
	if ( preg_match ('/^os\d{2}g\d{5}$/', $search_terms[$i]) ) {
    	$search_terms[$i] = 'loc_'.$search_terms[$i];
    }
    if ( preg_match ('/^os\d{2}t\d{7}$/', $search_terms[$i]) ) {
    	$search_terms[$i] = preg_replace ('/t/', 'g', $search_terms[$i]);
    }
}

$conn = db_connect();

$gene_info = array();
$gene_ids = array();
$count=0;

for ($i=0;$i<$num_post_terms;$i++){
	if ($identifier_type=='geneid'){
		$query_probe = "select * from $probe_database where lower(geneid)='$search_terms[$i]'";
	}elseif ($identifier_type=='elementid'){
		$search_terms[$i] = preg_replace ('/\'/', "''", $search_terms[$i]);
		$query_probe = "select * from $probe_database where ( lower(main) like '%$search_terms[$i]%' or lower(other) like '%$search_terms[$i]%') and type = 'RGAP'";
	}
	$result = @$conn->query($query_probe);
	for (; $row = $result->fetch_assoc(); $count++){
		$gene_info[$count] = $row;
		$gene_ids[$count] = $row{'geneid'};
	}	
}

$num_genes = count ($gene_ids);

if ($num_genes == 0){
	do_html_header($doc_path);
	echo "No probe found. Please go back and try again!\n";
	do_html_footer($doc_path); 
	exit;
}

$gene_ids_combined = join(",", $gene_ids);

if ($platform == 'affymetrix'){
	if (isset($_REQUEST['anatomy'])){
		$query_anatomy = "select * from metadata where platform='affymetrix' and type='anatomy' order by id";
		$result = @$conn->query($query_anatomy);
		$num_anatomy = $result->num_rows;
		for ($i=0; $row = $result->fetch_assoc(); $i++){
			$anatomy_info[$i] = $row;
		}	
	}
	if (isset($_REQUEST['developmental_stage'])){
		$query_deve = "select * from metadata where platform='affymetrix' and type='developmental_stage' order by id";
		$result = @$conn->query($query_deve);
		$num_deve = $result->num_rows;
		for ($i=0; $row = $result->fetch_assoc(); $i++){
			$deve_info[$i] = $row;
		}	
	}
}

$result->free();
$conn->close();

if ($platform == 'affymetrix'){
	$platform_display = 'Affymetrix';
}elseif($platform == 'agilent44k'){
	$platform_display = 'Agilent 44K';
}

do_html_header($doc_path);
echo "<h2>$platform_display Meta-Analysis Results</h2><br/>\n";

?>
<script type="text/JavaScript">
	function TypeCheck(){
		if(document.myform.TypeCtr.checked==true){
			document.myform.anatomy.checked=true;
			document.myform.developmental_stage.checked=true;
		}else {
			document.myform.anatomy.checked=false;
			document.myform.developmental_stage.checked=false;
		}
	}
</script>

<form name='myform' action='meta_search.php' method='post'>
	<table cellpadding='4' cellspacing='3' width='600'>
		
		<tr>
			<td>
				Microarray platform:
			</td>
			<td>
				<input type="radio" name="platform" value="affymetrix" <?php if ($_REQUEST['platform']=='affymetrix') echo 'checked'; ?> >Affymetrix
				<input type="radio" name="platform" value="agilent44k" <?php if ($_REQUEST['platform']=='agilent44k') echo 'checked'; ?> >Agilent 44K
			</td>
		</tr>
		
		<tr>
			<td>
				Data type:
			</td>
			<td>
				<input type="Checkbox" name="anatomy" value="1" <?php if (isset($_REQUEST['anatomy'])) echo 'checked'; ?> >Anatomy
				<input type="Checkbox" name="developmental_stage" value="1" <?php if (isset($_REQUEST['developmental_stage'])) echo 'checked'; ?> >Developmental Stage
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
					Heatmap scale bar:
			</td>
			<td>
				<input type="Radio" name="SingleScale" value="S1" <?php if ($_REQUEST['SingleScale']=='S1') echo 'checked'; ?> >5,9,13
				<input type="Radio" name="SingleScale" value="S2" <?php if ($_REQUEST['SingleScale']=='S2') echo 'checked'; ?> >5,10,15
				<input type="Radio" name="SingleScale" value="S3" <?php if ($_REQUEST['SingleScale']=='S3') echo 'checked'; ?> >7,12,17
			</td>
		</tr>

		<tr>
			<td>
			</td>
			<td>
				<input type='hidden' name='search_text' value="<?php echo $search_text;?>">
				<input type='hidden' name='identifier_type' value='<?php echo $identifier_type;?>'>
				<input type ="submit" value="Update">&nbsp;&nbsp;	
			</td>
		</tr>
	</table>
</form>

<?php


if (isset($_REQUEST['anatomy'])){
	echo "<br /><b>$platform_display Anatomy:</b>\n";
	echo "<br /><br />\n";
	if (isset($_REQUEST['Heatmap'])){
		echo '<img src="meta_heatmap.php?type=anatomy&platform='.$platform.'&scale='.$_REQUEST['SingleScale'].'&ids='.$gene_ids_combined.'" border=0 align=top>';
		echo '<br /><br />';
		echo '<a href="meta_heatmap_high.php?type=anatomy&platform='.$platform.'&scale='.$_REQUEST['SingleScale'].'&ids='.$gene_ids_combined.'">Download High Resolution Image</a>';
		echo '<br /><br />';
	}
	echo "<br />\n";
	
	if (isset($_REQUEST['CEGraph'])){
		echo '<img src="meta_cegraph.php?type=anatomy&platform='.$platform.'&ids='.$gene_ids_combined.'" border=0 align=top>';
		echo '<br /><br />';
		echo '<a href="meta_cegraph_high.php?type=anatomy&platform='.$platform.'&ids='.$gene_ids_combined.'">Download High Resolution Image</a>';
		echo '<br /><br />';
	}
	echo '<a href="meta_download.php?type=anatomy&platform='.$platform.'&ids='.$gene_ids_combined.'">Download Anatomy Data</a>';
	
	echo '<br /><br />';
}


if (isset($_REQUEST['developmental_stage'])){
	echo "<br /><b>$platform_display Developmental Stage:</b>\n";
	echo "<br /><br />\n";
	if (isset($_REQUEST['Heatmap'])){
		echo '<img src="meta_heatmap.php?type=developmental_stage&platform='.$platform.'&scale='.$_REQUEST['SingleScale'].'&ids='.$gene_ids_combined.'" border=0 align=top>';
		echo '<br /><br />';
		echo '<a href="meta_heatmap_high.php?type=developmental_stage&platform='.$platform.'&scale='.$_REQUEST['SingleScale'].'&ids='.$gene_ids_combined.'">Download High Resolution Image</a>';
		echo '<br /><br />';
	}
	echo "<br />\n";
	if (isset($_REQUEST['CEGraph'])){
		echo '<img src="meta_cegraph.php?type=developmental_stage&platform='.$platform.'&ids='.$gene_ids_combined.'" border=0 align=top>';
		echo '<br /><br />';
		echo '<a href="meta_cegraph_high.php?type=developmental_stage&platform='.$platform.'&ids='.$gene_ids_combined.'">Download High Resolution Image</a>';
		echo '<br /><br />';
	}
	echo '<a href="meta_download.php?type=developmental_stage&platform='.$platform.'&ids='.$gene_ids_combined.'">Download Developmental Stage Data</a>';
	echo '<br /><br />';
}


//Table containing formation about probes matched

$type = '';

if (isset($_REQUEST['anatomy'])){
	$type .= 'anatomy,';
}
if (isset($_REQUEST['developmental_stage'])){
	$type .= 'developmental_stage,';
}

$type = preg_replace ('/,$/', '', $type);

echo "<b>Probe matched:</b>\n";
echo "<br /><br />\n";
echo "Click each probeset will direct to the detailed expression page.<br /><br />\n";

echo "<table border='1' cellpadding='1' cellspacing='1' rules='cols'>\n";

echo "<tr align=center bgcolor=Orange>\n";
echo "<td><b>No.</b></td>\n";
echo "<td><b>Gene ID</b></td>\n";
echo "<td><b>Main ProbeSet</b></td>\n";
echo "<td><b>Other ProbeSets</b></td>\n";
echo "<td><b>Gene Annotation</b></td>\n";
echo "</tr>\n";

$probe_ids = array();

for ($i = 0; $i < $num_genes; $i++) {
	
	$rowbgcolor=($i%2==0?'LightYellow':'LightBlue');
	echo "<tr bgcolor=$rowbgcolor>\n";
	
	$row = $gene_info[$i];

	echo "<td>&nbsp;";
	echo $i+1;
	echo "&nbsp;</td>\n";

	echo "<td>&nbsp;";
	echo $row['geneid'];
	echo "&nbsp;</td>\n";

	echo "<td>&nbsp;";
	echo "<a href=meta_detail.php?type=$type&platform=".$platform."&id=".$row['main'].' target=_blank>'.$row['main']."</a>\n";
	echo "&nbsp;</td>\n";

	array_push ($probe_ids, $row['main']);

	echo "<td>";
	$ids= explode(";", $row['other']);
	sort($ids);
	foreach ($ids as $id){
		echo "&nbsp;<a href=meta_detail.php?type=$type&platform=".$platform."&id=".$id.' target=_blank>'.$id."</a>&nbsp;<br/>\n";
	}
	echo "</td>\n";

	echo "<td nowrap='nowrap'>&nbsp;";
	echo $row['annotation'];
	echo "&nbsp;</td>\n";

	echo "</tr>\n";

}

echo "</table>\n";
echo "<br />For genes with multiple probesets available, the probeset with highest expression was seleced as the main probeset and used in the Meta-Analysis.<br />";
echo '<br /><br />';

$probe_ids_combined = join(",", $probe_ids);

if ($platform == 'affymetrix'){
	if (isset($_REQUEST['anatomy'])){
		echo "<b>Meta profile for Anatomy:</b>\n";
		echo "<br /><br />\n";
		echo "Click each tissue will direct to the detailed information page about samples classified for this tissue.<br /><br />\n";
		echo "<table border='1' cellpadding='1' cellspacing='1' rules='cols'>\n";

		echo "<tr align=center bgcolor=Orange>\n";
		echo "<td><b>No.</b></td>\n";
		echo "<td><b>Tissue</b></td>\n";
		echo "<td><b>Number of samples</b></td>\n";
		echo "<td><b>Raw data</b></td>\n";
		echo "</tr>\n";

		for ($i = 0; $i < $num_anatomy; $i++) {
			
			$rowbgcolor=($i%2==0?'LightYellow':'LightBlue');
			echo "<tr bgcolor=$rowbgcolor>\n";
			
			$row = $anatomy_info[$i];

			echo "<td>&nbsp;";
			echo $i+1;
			echo "&nbsp;</td>\n";

			echo "<td>&nbsp;";
			echo "<a href=meta_profile.php?type=anatomy&term=".$row['sam_id'].' target=_blank>'.$row['sam_id']."</a>\n";
			echo "&nbsp;</td>\n";

			echo "<td>&nbsp;";
			echo $row['number'];
			echo "&nbsp;</td>\n";

			echo "<td>&nbsp;";
			echo "<a href=meta_raw_data.php?type=anatomy&term=".$row['sam_id'].'&ids='.$probe_ids_combined.'>Download raw data'."</a>\n";
			echo "&nbsp;</td>\n";

			echo "</tr>\n";

		}

		echo "</table>\n";
		echo '<br /><br />';
	}
	if (isset($_REQUEST['developmental_stage'])){
		echo "<b>Meta profile for Developmental Stage:</b>\n";
		echo "<br /><br />\n";
		echo "Click each developmental stage will direct to the detailed information page about samples classified for this stage.<br /><br />\n";
		echo "<table border='1' cellpadding='1' cellspacing='1' rules='cols'>\n";

		echo "<tr align=center bgcolor=Orange>\n";
		echo "<td><b>No.</b></td>\n";
		echo "<td><b>Developmental Stage</b></td>\n";
		echo "<td><b>Number of samples</b></td>\n";
		echo "<td><b>Raw data</b></td>\n";
		echo "</tr>\n";

		for ($i = 0; $i < $num_deve; $i++) {
			
			$rowbgcolor=($i%2==0?'LightYellow':'LightBlue');
			echo "<tr bgcolor=$rowbgcolor>\n";
			
			$row = $deve_info[$i];

			echo "<td>&nbsp;";
			echo $i+1;
			echo "&nbsp;</td>\n";

			echo "<td>&nbsp;";
			echo "<a href=meta_profile.php?type=developmental_stage&term=".$row['sam_id'].' target=_blank>'.$row['sam_id']."</a>\n";
			echo "&nbsp;</td>\n";

			echo "<td>&nbsp;";
			echo $row['number'];
			echo "&nbsp;</td>\n";

			echo "<td>&nbsp;";
			echo "<a href=meta_raw_data.php?type=developmental_stage&term=".$row['sam_id'].'&ids='.$probe_ids_combined.'>Download raw data'."</a>\n";
			echo "&nbsp;</td>\n";

			echo "</tr>\n";

		}

		echo "</table>\n";
		echo '<br /><br />';
	}
}

do_html_footer($doc_path); 

?>
