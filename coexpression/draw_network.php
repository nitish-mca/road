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
$depth = $_POST['depth'];
$type = $_POST['type'];

$genelist=trim($genelist);

if ($genelist == ""){
	do_html_header($doc_path);
	echo "No query gene. Please go back and try again!\n";
	do_html_footer($doc_path); 
	exit;
}

if ($type == 'general'){
	$database='network';
}elseif ($type == 'abiotic'){
	$database='network_abiotic';
}elseif ($type == 'biotic'){
	$database='network_biotic';
}

$genearray = explode ("\n", $genelist);
$interactors =  array();
$ppi = array();

foreach ($genearray as $gene){
	$gene=trim($gene);
	$gene = Strtolower($gene);
	$gene= preg_replace ('/\.\d+$/', '', $gene);
	if ( preg_match ('/^os\d{2}g\d{5}$/', $gene) ) {
    	$gene='loc_'.$gene;
    }
	$gene= preg_replace ('/^loc_os/', 'LOC_Os', $gene);
	$interactors[$gene]=1;
}

$conn = db_connect();

for ($i=0;$i<$depth;$i++){

	$num_interactors = count ($interactors);
	if ($num_interactors==0){
		break;
	}
	
	$search_terms = array();
	foreach ($interactors as $key=>$value ){
		$key = "'$key'";
		array_push ($search_terms, $key);
	}
	$geneids = join(",", $search_terms);
	$query = "select * from $database where geneid in ($geneids)";

	$result = @$conn->query($query);
		
	if (!$result) {
		do_html_header($doc_path);
		echo 'Can not access the server now. Please try again later. <br />';
		do_html_footer($doc_path); 
		exit;
	}

	$num_results = @$result->num_rows;
	if ($num_results ==0) {
		do_html_header($doc_path);
		echo "There is no gene coexpressed with the query gene(s) under the correlation coefficient cutoff (>$cutoff)".'.<br /><br />';
		do_html_footer($doc_path); 
		exit;
	}
	
	$interactors_tmp =  array();
	$ppi_tmp = array();
	while ($row = $result->fetch_assoc()) {
		$bait = $row['geneid'];
		$preys = explode (';', $row['interactor']);

		foreach ($preys as $prey){
			$values = explode (':', $prey);
			if ($values[1]>$cutoff) {
				$interactors_tmp[$bait]=1;
				$interactors_tmp[$values[0]]=1;
				if ( strcmp($bait, $values[0])<0){
					$tmp="$bait;$values[0]";
				}else {
					$tmp="$values[0];$bait";
				}
				$ppi_tmp[$tmp]=$values[1];
			}
		}
	}

	$interactors = $interactors_tmp;
	$ppi = $ppi_tmp;
}


$query = "select * from annotation"; 
$result = @$conn->query($query);
$anno = array();

while ($data=$result->fetch_assoc()){
	$locus=$data['geneid'];
	$annotation=$data['annotation'];
	$anno[$locus]=$annotation;
}

$result->free();
$conn->close();

$num_interactors = count ($interactors);
$num_ppi = count ($ppi);

if ($num_interactors==0 or $num_ppi==0){
	do_html_header($doc_path);
	echo "There is no gene coexpressed with the query gene(s) under the correlation coefficient cutoff (>$cutoff)".'.<br /><br />';
	do_html_footer($doc_path); 
	exit;
}elseif ($num_interactors>500){
	do_html_header($doc_path);
	echo "There are too many nodes ($num_interactors) to construct a network. Please increase the 'Correlation Coefficient cutoff' or decrease the 'Depth to search coexpressed genes', and try again.<br /><br />";
	do_html_footer($doc_path); 
	exit;
}else {
?>

<html>
    
    <head>
        <title>Rice Array Database</title>
		<link rel=stylesheet type="text/css" href="../RAD.css">
        
        <script type="text/javascript" src="/js/cytoscape_web/json2.min.js"></script>
        <script type="text/javascript" src="/js/cytoscape_web/AC_OETags.min.js"></script>
        <script type="text/javascript" src="/js/cytoscape_web/cytoscapeweb.min.js"></script>
       
        <script type="text/javascript">
            window.onload=function() {
                // id of Cytoscape Web container div
                var div_id = "cytoscapeweb";
                
                // create a network model object
                var networ_json = {
					dataSchema: {
                    	nodes: [ { name: "label", type: "string" },
                    	         { name: "annotation", type: "string" },
								 { name: "link", type: "string" }
           		        	   ],
						edges: [ { name: "label", type: "string" },
						         { name: "PCC", type: "string" }
						  	   ]
                    	},
                    data: {
                        nodes: [
<?php 
	$i=0;
	foreach ($interactors as $key=>$value){
		$i++;
		$link="<a href=http://rice.plantbiology.msu.edu/cgi-bin/ORF_infopage.cgi?db=osa1r6&orf=$key target=_blank>&nbsp;$key&nbsp;</a>";
		if ($i==$num_interactors){
			echo '{ id: "'.$key.'", label: "'.$key.'", annotation: "'.$anno[$key].'", link: "'.$link.'" }';
		}else {
			echo '{ id: "'.$key.'", label: "'.$key.'", annotation: "'.$anno[$key].'", link: "'.$link.'" },';
		}
	}
?>
							   ],
                        edges: [ 
<?php 
	$i=0;
	foreach ($ppi as $key=>$value){
		$i++;
		$tmp = explode (';', $key);
		if ($i==$num_ppi){
			echo '{ id: "'.$key.'", target: "'.$tmp[1].'", source: "'.$tmp[0].'", label: "'.$key.'", PCC: "'.$value.'" }';
		}else {
			echo '{ id: "'.$key.'", target: "'.$tmp[1].'", source: "'.$tmp[0].'", label: "'.$key.'", PCC: "'.$value.'" },';
		}
	}
?>
							    ]
                    }
                };

                // initialization options
                var options = {
                    swfPath: "/swf/CytoscapeWeb",
                    flashInstallerPath: "/swf/playerProductInstall"
                };
                
                // init and draw
                var vis = new org.cytoscapeweb.Visualization(div_id, options);

				// callback when Cytoscape Web has finished drawing
                vis.ready(function() {
                
                    // add a listener for when nodes and edges are clicked
                    vis.addListener("click", "nodes", function(event) {
                        handle_click(event);
                    })
                    .addListener("click", "edges", function(event) {
                        handle_click(event);
                    });
                    
                    function handle_click(event) {
                         var target = event.target;
                         
                         clear();
                         print("event.group = " + event.group);
                         for (var i in target.data) {
                            var variable_name = i;
                            var variable_value = target.data[i];
                            print( "event.target.data." + variable_name + " = " + variable_value );
                         }
                    }
                    
                    function clear() {
                        document.getElementById("note").innerHTML = "";
                    }
                
                    function print(msg) {
                        document.getElementById("note").innerHTML += "<p>" + msg + "</p>";
                    }
                });

                vis.draw({ network: networ_json });
            };
        </script>
        
        <style>
            #cytoscapeweb { width: 1200; height: 600; }
			#note { width: 1200; height: 220; background-color: #f0f0f0; overflow: auto;  }
        </style>
    </head>
    
    <body>
<?php

do_html_header($doc_path);

if ($type == 'general'){
	echo '<center><h2>Rice General Coexpression Network</h2></center><br/>';
}elseif ($type == 'abiotic'){
	echo '<center><h2>Rice Abiotic Stress Coexpression Network</h2></center><br/>';
}elseif ($type == 'biotic'){
	echo '<center><h2>Rice Biotic Stress Coexpression Network</h2></center><br/>';
}

echo "            Number of nodes in the network: <b>$num_interactors</b>\n";
echo "            <br/>\n";
echo "            Number of edges in the network: <b>$num_ppi</b>\n";
echo "            <br/>\n";
?>
			<form method="post" action="local_cytoscape.php">
				<input type='hidden' name='genelist' value='<?php echo $genelist;?>'>
				<input type='hidden' name='type' value='<?php echo $type;?>'>
				<input type='hidden' name='cutoff' value='<?php echo $cutoff;?>'>
				<input type='hidden' name='depth' value='<?php echo $depth;?>'>
				<input type ="submit" value="Generate SIF file for local Cytoscape">&nbsp;&nbsp;
			</form>
			<br />
			<div id="cytoscapeweb">
				Cytoscape Web will replace the contents of this div with your graph.
			</div>
			<div id="note">
				<p>Click nodes or edges to dispaly the detailed information.</p>
			</div>

<?php
	do_html_footer($doc_path); 
}
?>