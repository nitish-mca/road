<?php
$host = 'localhost';
$dbname = 'test';
$username = 'root';
$password = 'JustD01t!';
// include function files for this application
require_once('../RAD_fns.php'); 
$conn = mysqli_connect($host, $username, $password, $dbname);  
$number = $_POST["number"];
$tissue = $_POST['tissue'];
$cutoff = $_POST['cutoff'];

$title = $tissue;
$title = preg_replace ('/_/', ' ', $title);
if ($title == 'SAM') {
	$title= 'Shoot apical meristem';
}

if ($number == '' or $number <= 0) {
	$number = 10;
}

$query_probe = "select * from probe where 	platform = 'Affymetrix' order by probeid";

$conn = db_connect();
$result = @$conn->query($query_probe);

$msu = array();
$rap = array();
$cdna = array();

while ($row = $result->fetch_assoc()) {
	$id = $row['probeid'];
	$msu[$id] = $row['MSU6_id'];
	$rap[$id] = $row['RAP3_id'];
	$cdna[$id] = $row['cDNA_id'];
}

$query_annotation = "select * from annotation";
$result = @$conn->query($query_annotation);

$annotation=array();

while ($row = $result->fetch_assoc()) {
	$annotation[$row['geneid']]=$row['annotation'];
}

$query_data = "select probeid,$tissue 
						from anatomy_affymetrix
						where $tissue > '$cutoff'
						order by $tissue desc
						limit 0, $number";
						
$result = @$conn->query($query_data);

$num_probes = $result->num_rows;

do_html_header($doc_path);

echo "<center><h2>Highly Expressed Genes</h2><center><br/>\n";
echo "Tissue: $title<br/>\n";
echo "Number of probe sets in display: top $num_probes<br/><br/>\n";

echo "<table width='100%' cellspacing='1' cellpadding='1' rules='cols' border='1'>\n";

echo "<tr align=center bgcolor=Orange>\n";
echo "<td><b>Order</b></td>\n";
echo "<td><b>Affymetrix ProbeSet ID</b></td>\n";
echo "<td><b>Matched MSU/TIGR Gene ID</b></td>\n";
echo "<td><b>Matched RAP3 Gene ID</b></td>\n";
echo "<td><b>Matched KOME cDNA ID</b></td>\n";
echo "<td><b>Expression Value</b></td>\n";
echo "</tr>\n";

$i=0;
while ($row = $result->fetch_assoc()) {

	$i++;
	$rowbgcolor=($i%2==0?'LightYellow':'LightBlue');

	echo "<tr bgcolor=$rowbgcolor>\n";
	
	echo "<td>&nbsp;";
	echo $i;
	echo "&nbsp;</td>\n";

	echo "<td>&nbsp;";
	echo '<a href="meta_detail.php?platform=affymetrix&type=anatomy&id='.$row['probeid'].'" target=_blank>'.$row['probeid']."</a>\n";
	echo "&nbsp;</td>\n";
	
	$probeid = $row['probeid'];
	$probe_ids[$i-1] = $probeid;

	echo "<td>";
	$ids= explode(";", $msu[$probeid]);
	sort($ids);
	foreach ($ids as $id){
		if ($id != 'N/A'){
			$locus=$id;
			$locus = preg_replace ('/\.\d+$/', '', $locus);
			$locsu_annotation=$annotation[$locus];
			echo "&nbsp;<a href=http://rice.plantbiology.msu.edu/cgi-bin/ORF_infopage.cgi?db=osa1r6&orf=$id target=_blank>$id</a>&nbsp;<a href=# title=\"$locsu_annotation\">Annotation</a><br/>\n";
		}else {
			echo "&nbsp;$id&nbsp;<br/>\n";
		}
	}
	echo "</td>\n";

	echo "<td nowrap>";
	$ids= explode(";", $rap[$probeid]);
	sort($ids);
	foreach ($ids as $id){
		if ($id != 'N/A'){
			echo "&nbsp;<a href=http://rapdb.dna.affrc.go.jp/viewer/gbrowse_details/build5?name=$id target=_blank>$id</a>&nbsp;<a href=# title=\"$annotation[$id]\">Annotation</a><br/>\n";
		}else {
			echo "&nbsp;$id&nbsp;<br/>\n";
		}
	}
	echo "</td>\n";

	echo "<td>";
	$ids= explode(";", $cdna[$probeid]);
	sort($ids);
	foreach ($ids as $id){
		echo "&nbsp;$id&nbsp;<br/>\n";
	}
	echo "</td>\n";

	echo "<td>&nbsp;";
	echo $row[$tissue];
	echo "&nbsp;</td>\n";

	echo "</tr>\n";
}
echo "</table>\n";

$probe_ids_combined = join(",", $probe_ids);

echo "<br /><br />\n";
echo "<br /><b>Heatmap:</b>\n";
echo "<br /><br />\n";
echo '<img src="top_heatmap.php?&ids='.$probe_ids_combined.'" border=0 align=top>';
echo '<br /><br />';
echo '<a href="top_heatmap_high.php?&ids='.$probe_ids_combined.'">Download High Resolution Image</a>';
echo '<br /><br />';

echo "<br /><br />\n";
echo "<br /><b>Classic Expression Graph:</b>\n";
echo "<br /><br />\n";
echo '<img src="top_cegraph.php?&ids='.$probe_ids_combined.'" border=0 align=top>';
echo '<br /><br />';
echo '<a href="top_cegraph_high.php?&ids='.$probe_ids_combined.'">Download High Resolution Image</a>';
echo '<br /><br />';

do_html_footer($doc_path); 

$result->free();
$conn->close();

?>
