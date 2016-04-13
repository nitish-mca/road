<?php
//this is test
// include this file in all our files
// this way, every file will contain all the functions

$doc_path = "D:/Websites/ROAD";
//$doc_path = "/Users/Peijian/Websites/RAD";
$doc_path = '/var/www/projects/s';

function db_connect(){
	
	$result = new mysqli('localhost', 'root', 'root', 'road'); 
	//$result = new mysqli('127.0.0.1', 'RADuser', '$RADuserR0nald$', 'rad'); 
	if (!$result)
		return false;
	return $result;
}

function do_html_header($doc_path){
	// echo an HTML header
	$HTML_INC_HEADER=fopen("$doc_path/inc/ROAD_inc_header.php", 'r');
	$html_inc_header=fread($HTML_INC_HEADER, filesize("$doc_path/inc/ROAD_inc_header.php"));
	fclose($HTML_INC_HEADER);


	$HTML_INC_LEFT_MENU=fopen("$doc_path/inc/ROAD_inc_left_menu.php", 'r');
	$html_inc_left_menu=fread($HTML_INC_LEFT_MENU, filesize("$doc_path/inc/ROAD_inc_left_menu.php"));
	fclose($HTML_INC_LEFT_MENU);

?>
<html>
<head>
    <title>Rice Oligonucleotide Array Database</title>
    <link rel=stylesheet type="text/css" href="../RAD.css">
</head>

<body>
    
    <table>

	<?php echo $html_inc_header; ?>
	
	<tr>
	    <td class="menu" valign="top">

            <?php echo $html_inc_left_menu; ?>

	    </td>

        <td width="5">
        </td>

	    <td class="main" valign="top" width="600">
            <!-- INFORMATION GOES UNDERNEATH HERE -->
<?php
}


function do_html_footer($doc_path){
	// echo an HTML footer
	$HTML_INC_RIGHT_MENU=fopen("$doc_path/inc/ROAD_inc_right_menu.php", 'r');
	$html_inc_right_menu=fread($HTML_INC_RIGHT_MENU, filesize("$doc_path/inc/ROAD_inc_right_menu.php"));
	fclose($HTML_INC_RIGHT_MENU);
?>

			<!-- INFORMATION GOES ABOVE HERE -->

	    </td>

		<td width="5">
        </td>

		<td class="menu" valign="top">

            <?php echo $html_inc_right_menu; ?>

	    </td>

	</tr>
    </table>
</body>
</html>

<?php
}


#
# hyper() - return the p value of an hypergeometric distribution
#
function hyper($k, $n, $M, $N) {

	$numerator = array();
	$denominator = array();
	for ($i=($M-$k+1);$i<=$M; $i++) {
		array_push ($numerator, $i);
	}
	for ($i=($N-$M-$n+$k+1);$i<=($N-$M); $i++) {
		array_push ($numerator, $i);
	}
	for ($i=1;$i<=$n; $i++) {
		array_push ($numerator, $i);
	}
	for ($i=1;$i<=$k; $i++) {
		array_push ($denominator, $i);
	}
	for ($i=1;$i<=($n-$k); $i++) {
		array_push ($denominator, $i);
	}
	for ($i=($N-$n+1);$i<=$N; $i++) {
		array_push ($denominator, $i);
	}
	sort ($numerator);
	sort ($denominator);
	$p=1;
	$n=count($numerator)/2;
	for ($i=0; $i<$n; $i++) {
		$p*=(($numerator[$i]/$denominator[$i])*($numerator[$i+$n]/$denominator[$i+$n]));
	}
	return $p;
}

?>
