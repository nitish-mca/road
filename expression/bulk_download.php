<?php
$host = 'localhost';
$dbname = 'test';
$username = 'root';
$password = 'JustD01t!';

// include function files for this application
require_once('../RAD_fns.php'); 
$conn = mysqli_connect($host, $username, $password, $dbname); 

$MAX_TITLE = 45;

$platform = 'Affymetrix';

if (isset($_GET["platform"])){
	$platform = $_GET["platform"];
}

# db queries
$q_exp_num = "select exp_id from experiment where platform='$platform'"; 
$q_sam_num = "select sam_id from sample where platform='$platform'";


$conn = db_connect();
$result = @$conn->query($q_exp_num);
$exp_num = $result->num_rows;

$result = @$conn->query($q_sam_num);
$sam_num = $result->num_rows;

$experiments=array();
# get list of experiments in the database
$q_exp = "select exp_id, short_title from experiment where platform='$platform'";
$result = @$conn->query($q_exp);

while ($row = $result->fetch_row()) {
	array_push($experiments, $row);
}

$result->free();
$conn->close();

do_html_header($doc_path);

?>
<h2>Bulk Download <?php echo $platform; ?> Expression Data</h2>
<br/>

Number of experiments in database: <b><?php echo $exp_num; ?></b>
<br/>
Number of samples/hybridizations in database: <b><?php echo $sam_num; ?></b>

<br/>
<br/>

<a href='/expression/experiment_search.php'>Browse</a> a list of all experiments in the database.

<br/>
<br/>

<fieldset>
	<form name='myform' action='expression_bulk_download.php' method='post'>
		<table cellpadding='4' cellspacing='3' width='100%'>	
			<tr>
				<td>
					Select platform:
				</td>
				<td>
					<input type="radio" name="platform" value="Affymetrix"  <?php if ($platform=='Affymetrix') echo 'checked'; ?> onchange="location.href='bulk_download.php?platform=Affymetrix';">Affymetrix
					<input type="radio" name="platform" value="Agilent22K"  <?php if ($platform=='Agilent22K') echo 'checked'; ?> onchange="location.href='bulk_download.php?platform=Agilent22K';">Agilent 22K
					<input type="radio" name="platform" value="Agilent44K"  <?php if ($platform=='Agilent44K') echo 'checked'; ?> onchange="location.href='bulk_download.php?platform=Agilent44K';">Agilent 44K
					<input type="radio" name="platform" value="BGIYale"  <?php if ($platform=='BGIYale') echo 'checked'; ?> onchange="location.href='bulk_download.php?platform=BGIYale';">BGI/Yale
					<input type="radio" name="platform" value="NSF20K"  <?php if ($platform=='NSF20K') echo 'checked'; ?> onchange="location.href='bulk_download.php?platform=NSF20K';">NSF 20K
					<input type="radio" name="platform" value="NSF45K"  <?php if ($platform=='NSF45K') echo 'checked'; ?> onchange="location.href='bulk_download.php?platform=NSF45K';">NSF 45K
				</td>
			</tr>

			<tr>
				<td>
					Select an experiment:
				</td>
				<td>

<?php
# experiment field

echo "				<select name='exp'>\n";
echo "					<option value='0'>-- Select an experiment --</option>\n";

foreach ($experiments as $experiment) {
    $exp_id = $experiment[0];
    if (strlen($experiment[1]) > $MAX_TITLE) {
        $exp_title = substr($experiment[1], 0, $MAX_TITLE);
		$exp_title .= "...";
    }else {  
        $exp_title = $experiment[1];
    }
    echo "					<option value='$exp_id'>$exp_id - $exp_title</option>\n";
}

echo "				</select>\n";
?>

				</td>
			</tr>

			<tr>
				<td>
					Average Expression:
				</td>
				<td>
					<input type="radio" name="ave" value="Y">Yes
					<input type="radio" name="ave" value="N" checked>No
				</td>
			</tr>

			<tr>
				<td>
				</td>
				<td>
					<input type='hidden' name='platform' value='<?php echo $platform;?>'>
					<input type ="submit" value="Submit">&nbsp;&nbsp;
					<input type ="reset" value="Clear">
				</td>
			</tr>
		</table>
	</form>
</fieldset>

<?php
do_html_footer($doc_path);

?>