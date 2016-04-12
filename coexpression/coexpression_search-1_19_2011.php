<?php
$host = 'localhost';
$dbname = 'test';
$username = 'root';
$password = 'JustD01t!';

// include function files for this application
require_once('../RAD_fns.php');
$conn = mysqli_connect($host, $username, $password, $dbname);  



//create short variable names
$genelist = $_POST['genelist'];
$cutoff = $_POST['cutoff'];
$genelist=trim($genelist);

if ($genelist == ""){
	do_html_header($doc_path);
	echo "No query gene. Please go back and try again!\n";
	do_html_footer($doc_path); 
	exit;
}
	
$genearray = explode ("\n", $genelist);

$conn = db_connect();

$query = "select * from annotation"; 
$result = @$conn->query($query);
$anno = array();

while ($data=$result->fetch_assoc()){
	$locus=$data['geneid'];
	$annotation=$data['annotation'];
	$anno[$locus]=$annotation;
}

do_html_header($doc_path);

foreach ($genearray as $gene){
	$gene=trim($gene);
	$gene = Strtolower($gene);
	$gene= preg_replace ('/\.\d+$/', '', $gene);
	if ( preg_match ('/^os\d{2}g\d{5}$/', $gene) ) {
    	$gene='loc_'.$gene;
    }
	
	$query = "select * from coexpression where lower(geneid)='$gene'"; 
	$result = @$conn->query($query);
		
	if (!$result) {
		echo 'Can not access the server now. Please try again later. <br />';
	}

	$num_results = @$result->num_rows;
	if ($num_results ==0) {
		$gene= preg_replace ('/^loc_os/', 'LOC_Os', $gene);
		echo "<b>$gene: </b>";
		echo $anno["$gene"];
		echo '<br \>';
		echo "There is no gene coexpressed with the query gene under the correlation coefficient cutoff (>$cutoff)".'.<br /><br />';
		continue;
	}
		
	$data=$result->fetch_assoc();
	
	$gene=$data['geneid'];
	echo "<b>$gene: </b>";
	echo $anno["$gene"];
	echo '<br \>';

	$interactors = explode (';', $data['interactor']);
		
	$positive = array();
	//$negative = array();
		
	foreach ($interactors as $interactor){
		$values = explode (':', $interactor);
		if ($values[1]>$cutoff) {
			$positive["$values[0]"]=$values[1];
		}
		//elseif ($values[1]<-$cutoff) {
		//	$negative["$values[0]"]=$values[1];
		//}
	}

		
	//echo '<table><tr><td vAlign="top">';
		
	echo 'Coexpressed genes';
	echo '<table class="ResultSmallText" cellspacing="0" cellpadding="0" rules="cols" bordercolor="Lime" border="1">';
	echo "<tr Height=10px bgcolor=Orange>";
	echo '<td NOWRAP="true" width="100px">&nbsp;Gene ID</td>';
	echo '<td NOWRAP="true" width="50px">&nbsp;PCC</td>';
	echo '<td NOWRAP="true">&nbsp;RGAP Ver 6 Annotation</td>';
	echo '</tr>';
		
	if (sizeof($positive)>0){
		arsort ($positive);
		$i=1;
		foreach ($positive as $key=>$value){
			$i++;
			$rowbgcolor=($i%2==0?'LightYellow':'LightBlue');
			echo "<tr Height=8px bgcolor=$rowbgcolor>";
			echo "<td NOWRAP='true'>";
			echo "<a href=http://rice.plantbiology.msu.edu/cgi-bin/ORF_infopage.cgi?db=osa1r6&orf=$key target=_blank>&nbsp;$key&nbsp;</a>";
			echo '</td>';
			echo "<td NOWRAP='true'>&nbsp;$value&nbsp;</td>";
			echo "<td NOWRAP='true'>";
			//if (strlen ($anno["$key"]) <=40){
				echo '&nbsp;';
				echo $anno["$key"];
			//}else {
			//	$subanno=substr ($anno["$key"],0,40);
			//	echo "$subanno......";
			//}
			echo '</td>';
			echo '</tr>';
		}
	}

	echo '</table>';
/*	
	echo '</td><td vAlign="top">';

	echo 'Negatively coexpressed genes';
	echo '<table class="ResultSmallText" cellspacing="0" cellpadding="0" rules="cols" bordercolor="Lime" border="1">';
	echo "<tr Height=10px bgcolor=Orange>";
	echo '<td NOWRAP="true" width="80px">Gene ID</td>';
	echo '<td NOWRAP="true" width="50px">CC</td>';
	echo '<td NOWRAP="true">TIGR Ver 5 Annotation</td>';
	echo '</tr>';
		
	if (sizeof($negative)>0){
		asort ($negative);
		$i=1;
		foreach ($negative as $key=>$value){
			$i++;
			$rowbgcolor=($i%2==0?'LightYellow':'LightBlue');
			echo "<tr Height=8px bgcolor=$rowbgcolor>";
			echo "<td NOWRAP='true'>";
			echo "<a href=http://rice.plantbiology.msu.edu/cgi-bin/ORF_infopage.cgi?db=osa1r6&orf=LOC_$key target=_blank>$key</a>";
			echo '</td>';
			echo "<td NOWRAP='true'>$value</td>";
			echo "<td NOWRAP='true'>";
			if (strlen ($anno["$key"]) <=40){
				echo $anno["$key"];
			}else {
				$subanno=substr ($anno["$key"],0,40);
				echo "$subanno......";
			}
			echo '</td>';
			echo '</tr>';
		}
	}
		
	echo '</table>';
		echo '</td></tr></table>';
*/	
	echo '<br />';
}

$result->free();
$conn->close();

do_html_footer($doc_path); 


?>
