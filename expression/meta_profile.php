<?php
$host = 'localhost';
$dbname = 'test';
$username = 'root';
$password = 'JustD01t!';


// include function files for this application
require_once('../RAD_fns.php'); 
$conn = mysqli_connect($host, $username, $password, $dbname);  
$type = $_GET["type"];
$term = $_GET["term"];

$q_meta = "select * from meta_profile where type = '$type' and title = '$term' order by id";

$conn = db_connect();
$result = @$conn->query($q_meta);
$n_meta = $result->num_rows;

$meta_info = array();
$sam_ids = array();

for ($i = 0; $i < $n_meta; $i++) {
	$row=$result->fetch_assoc();
	$meta_info[$i]=$row;
	$sam_id=$row['sam_id'];
	array_push ($sam_ids, "'$sam_id'");
}

$sam_ids_combined = join(",", $sam_ids);

$q_sams = "select * from sample where sam_id in ($sam_ids_combined)";

$result = @$conn->query($q_sams);

$sam_info = array();

while ($row=$result->fetch_assoc()) {
	$sam_id=$row['sam_id'];
	$sam_info[$sam_id]=$row;
}

$result->free();
$conn->close();

do_html_header($doc_path);

echo "			<center><h2>$n_meta samples were classified for $term</h2><center>\n";

echo "			<br/>\n";
echo "			<br/>\n";



echo "				<table width='100%' cellspacing='1' cellpadding='1' rules='cols' border='1'>\n";

echo "					<tr bgcolor=Orange>\n";

echo "						<td>\n";
echo "							   &nbsp;\n";
echo "						</td>\n";

echo "						<td>\n";
echo "							   <b>Sample ID</b>\n";
echo "						</td>\n";

echo "						<td nowrap='nowrap'>\n";
echo "							   <b>Experiment ID</b>\n";
echo "						</td>\n";

echo "						<td>\n";
echo "							   <b>Sample Title</b>\n";
echo "						</td>\n";

echo "						<td>\n";
echo "							   <b>PO ID</b>\n";
echo "						</td>\n";

echo "						<td>\n";
echo "							   <b>PO Name</b>\n";
echo "						</td>\n";

echo "						<td>\n";
echo "							   <b>EO ID</b>\n";
echo "						</td>\n";

echo "						<td nowrap='nowrap'>\n";
echo "							   <b>EO Name</b>\n";
echo "						</td>\n";

echo "					</tr>\n";


for ($i = 0; $i < $n_meta; $i++) {

	$rowbgcolor=($i%2==0?'LightYellow':'LightBlue');
		
	echo "                    <tr bgcolor=$rowbgcolor>\n";

	$j = $i + 1;


	echo "					   <td valign='center'>\n";
	echo "						  <b>$j.</b>\n";
	echo "					   </td>\n";

	$row=$meta_info[$i];

	echo "					   <td>\n";
	echo "						   <a href='/expression/sample_detail.php?sample=".$row['sam_id']."'>".$row['sam_id']."</a>\n";
	echo "					   </td>\n";

	echo "					   <td>\n";
	echo "						   <a href='/expression/experiment_detail.php?experiment=".$row['exp_id']."'>".$row['exp_id']."</a>\n";
	echo "					   </td>\n";

	$sam_id=$row['sam_id'];
	$saminfo=$sam_info[$sam_id];

	echo "					   <td nowrap='nowrap'>".$saminfo['sam_title']."</td>\n";

	echo "					   <td>\n";
	echo "						   <a href='http://www.plantontology.org/amigo/go.cgi?view=details&search_constraint=terms&depth=0&query=".$saminfo['po_id']."'>".$saminfo['po_id']."</a>\n";
	echo "					   </td>\n";

	echo "					   <td nowrap='nowrap'>".$saminfo['po_name']."</td>\n";

	echo "					   <td nowrap='nowrap'>\n";
	echo "						   <a href='http://www.gramene.org/db/ontology/search?id=".$saminfo['eo_id']."'>".$saminfo['eo_id']."</a>\n";
	echo "					   </td>\n";

	echo "					   <td nowrap='nowrap'>".$saminfo['eo_name']."</td>\n";

	echo "					</tr>\n";
}

echo "	   			</table>\n";

do_html_footer($doc_path);

?>