<?php
error_reporting(2);
$host = 'localhost';
$dbname = 'road';
$username = 'root';
$password = 'root';


// include function files for this application
require_once('../RAD_fns.php');

$conn = mysqli_connect($host, $username, $password, $dbname);
$MAX_TITLE = 45;

$platform = 'agilent';

if (isset($_GET["platform"])) {
    $platform = $_GET["platform"];
}

# db queries
$q_exp_num = "select accession_no from experiment where platform='$platform'";
$q_sam_num = "select sum(sample) as total from experiment where platform='$platform'";


$conn = db_connect();
$result = @$conn->query($q_exp_num);
$exp_num = $result->num_rows;

$result = @$conn->query($q_sam_num);

$sam_num = $result->fetch_assoc();

$experiments = array();
# get list of experiments in the database

$q_exp = "select accession_no, title from experiment where platform LIKE '$platform%'";
$result = $conn->query($q_exp) or die('dd');

while ($row = $result->fetch_row()) {
    array_push($experiments, $row);
}
$result->free();
$conn->close();

do_html_header($doc_path);
?>
<h2>Search Rice <?php echo ucfirst($platform); ?> Expression Data</h2>
<br/>
<br/>

Number of experiments in database: <b><?php echo $exp_num; ?></b>
<br/>
Number of samples/hybridizations in database: <b><?php echo $sam_num['total']; ?></b>

<br/>
<br/>

<a href='../expression/experiment_search.php'>Browse</a> a list of all experiments in the database.

<br/>
<br/>

<script type="text/JavaScript">
    function SetExample(){
    document.myform.search_text.value='FR000120\nFR000159\nFR002641\nFR004789\nFR004789\nFR006791\nFR007482\nFR007866\nFR008342';
    }
</script>

<fieldset>
    <form name='myform' action='expression_search.php' method='post'>
        <table cellpadding='4' cellspacing='3' width='100%'>
            <!--
                        <tr>
                            <td>
                                Upload file (max 1000 identifiers, one per line):
                            </td>
                            <td>
                                <input type="file" name="search_file" size="40">
                            </td>
                        </tr>
            -->    
            <tr>
                <td>
                    Identifier terms (max 1000 identifiers, one per line):<br /><br />
                    <INPUT TYPE="button" VALUE="Example" onClick="SetExample()">
                </td>
                <td>
                    <textarea name="search_text" id="search_text" rows="10" cols="50"></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    Identifier type:
                </td>
                <td>
                    <input type="radio" name="identifier_type" value="loci_id" checked>LOCI ID
                    <input type="radio" name="identifier_type" value="elementid">Microarray Element ID
                </td>
            </tr>

            <tr>
                <td>
                    Select platform:
                </td>
                <td>
                    <!--
                    <select name="platform" onchange="location.href='expression.php?platform=' + this.options[this.selectedIndex].value;">
                            <option value="Affymetrix" <?php if ($platform == 'Affymetrix') echo 'selected'; ?> >Affymetrix</option>
                            <option value="Agilent22K" <?php if ($platform == 'Agilent22K') echo 'selected'; ?> >Agilent 22K</option>
                            <option value="Agilent44K" <?php if ($platform == 'Agilent44K') echo 'selected'; ?> >Agilent 44K</option>
                            <option value="BGIYale" <?php if ($platform == 'BGIYale') echo 'selected'; ?> >BGI/Yale</option>
                            <option value="NSF20K" <?php if ($platform == 'NSF20K') echo 'selected'; ?> >NSF 20K</option>
                            <option value="NSF45K" <?php if ($platform == 'NSF45K') echo 'selected'; ?> >NSF 45K</option>
                    </select>
                    -->
                    <input type="radio" name="platform" value="affymetrix"  <?php if ($platform == 'affymetrix') echo 'checked'; ?> onchange="location.href = 'expression.php?platform=affymetrix';">Affymetrix
                    <input type="radio" name="platform" value="agilent(28K-array)"  <?php if ($platform == 'agilent(28K-array)') echo 'checked'; ?> onchange="location.href = 'expression.php?platform=agilent(28K-array)';">Agilent (28K-array)
                    <input type="radio" name="platform" value="agilent(28K-array)"  <?php if ($platform == 'agilent(4x44K-array)') echo 'checked'; ?> onchange="location.href = 'expression.php?platform=agilent(4x44K-array)';">Agilent (4x44K-array)
                    <input type="radio" name="platform" value="illumina"  <?php if ($platform == 'illumina') echo 'checked'; ?> onchange="location.href = 'expression.php?platform=illumina';">Illumina
                    <input type="radio" name="platform" value="RNA-Seq"  <?php if ($platform == 'RNA-Seq') echo 'checked'; ?> onchange="location.href = 'expression.php?platform=RNA-Seq';">RNA-Seq

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
                        } else {
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
                    Display format:
                </td>
                <td>
                    <input type="Checkbox" name="Ave" value="1">Show Average
                    <input type="Checkbox" name="Heatmap" value="1" checked>Show Heatmap
                    <input type="Checkbox" name="CEGraph" value="1">Classic Expression Graph
                    <br />
                    <?php
                    if ($platform == 'Affymetrix') {
                        ?>
                        &nbsp;Select Heatmap Scale Bar:
                        <input type="Radio" name="SingleScale" value="S1" checked>5,9,13
                        <input type="Radio" name="SingleScale" value="S2" >5,10,15
                        <input type="Radio" name="SingleScale" value="S3" >7,12,17
                        <?php
                    } else {
                        ?>
                        &nbsp;Select Heatmap Scale Bar:
                        <input type="Radio" name="TwoScale" value="T1" checked>-1,0,1
                        <input type="Radio" name="TwoScale" value="T2">-2,0,2
                        <input type="Radio" name="TwoScale" value="T3">-3,0,3
                        <?php
                    }
                    ?>

                </td>
            </tr>

            <tr>
                <td>
                </td>
                <td>
                    <input type='hidden' name='platform' value='<?php echo $platform; ?>'>
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
