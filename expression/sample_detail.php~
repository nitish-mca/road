<?php
$host = 'localhost';
$dbname = 'test';
$username = 'root';
$password = 'JustD01t!';


// include function files for this application
require_once('../RAD_fns.php'); 
$conn = mysqli_connect($host, $username, $password, $dbname);  
$sam_id = $_GET["sample"];

$q_sam = "select * from sample where sam_id = '$sam_id'";

# get information for this sample
$conn = db_connect();
$result = @$conn->query($q_sam);
$r_sam = $result->fetch_assoc();

$result->free();
$conn->close();

do_html_header($doc_path);

echo "			<h2>Search Rice Oligonucleotide Array Database Experiments</h2>\n";

echo "			<br/>\n";
echo "			<br/>\n";

echo "			<fieldset>\n";

echo "				   <table border='0' cellpadding='1' cellspacing='1'>\n";
	
echo "					<tr>\n";
echo "					   <td width='150px'><b>Sample ID</b></td>\n";
echo "					   <td align='left' width='500px'>".$r_sam['sam_id']."</td>\n";
echo "					</tr>\n";

echo "					<tr>\n";
echo "					   <td><b>Experiment ID</b></td>\n";
echo "					   <td align='left'>".$r_sam['exp_id']."</td>\n";
echo "					</tr>\n";

echo "					<tr>\n";
echo "					   <td><b>Platform</b></td>\n";
echo "					   <td align='left'>".$r_sam['platform']."</td>\n";
echo "					</tr>\n";
	
echo "					<tr>\n";
echo "					   <td><b>Sample Title</b></td>\n";
echo "					   <td align='left'>".$r_sam['sam_title']."</td>\n";
echo "					</tr>\n";

echo "					<tr>\n";
echo "					   <td><b>Sample Type</b></td>\n";
echo "					   <td align='left'>".$r_sam['type']."</td>\n";
echo "					</tr>\n";

echo "					<tr>\n";
echo "					   <td><b>PO ID</b></td>\n";
echo "					   <td align='left'><a href='http://www.plantontology.org/amigo/go.cgi?view=details&search_constraint=terms&depth=0&query=".$r_sam['po_id']."'>".$r_sam['po_id']."</a></td>\n";
echo "					</tr>\n";

echo "					<tr>\n";
echo "					   <td><b>PO Name</b></td>\n";
echo "					   <td align='left'>".$r_sam['po_name']."</td>\n";
echo "					</tr>\n";

echo "					<tr>\n";
echo "					   <td><b>EO ID</b></td>\n";
echo "					   <td align='left'><a href='http://www.gramene.org/db/ontology/search?id=".$r_sam['eo_id']."'>".$r_sam['eo_id']."</a></td>\n";
echo "					</tr>\n";

echo "					<tr>\n";
echo "					   <td><b>EO Name</b></td>\n";
echo "					   <td align='left'>".$r_sam['eo_name']."</td>\n";
echo "					</tr>\n";

if ($r_sam['platform'] != 'Affymetrix'){
	echo "					<tr><td>&nbsp;</td><td></td></tr>\n";

	echo "					<tr bgcolor='#EEEEEE'>\n";
	echo "					   <td><b>Channel 1</b></td>\n";
	echo "					   <td></td>\n";
	echo "					</tr>\n";
}else {
	echo "					<tr><td>&nbsp;</td><td></td></tr>\n";
	echo "					<tr bgcolor='#EEEEEE'><td>&nbsp;</td><td></td></tr>\n";
}

echo "					<tr>\n";
echo "					   <td><b>Source Name</b></td>\n";
echo "					   <td align='left'>".$r_sam['source_name_1']."</td>\n";
echo "					</tr>\n";

echo "					<tr>\n";
echo "					   <td><b>Organism(s)</b></td>\n";
echo "					   <td align='left'>".$r_sam['organism_1']."</td>\n";
echo "					</tr>\n";

echo "					<tr>\n";
echo "					   <td><b>Characteristics</b></td>\n";
echo "					   <td align='left'>".$r_sam['charact_1']."</td>\n";
echo "					</tr>\n";

echo "					<tr>\n";
echo "					   <td><b>Biomaterial Provider</b></td>\n";
echo "					   <td align='left'>".$r_sam['provider_1']."</td>\n";
echo "					</tr>\n";

echo "					<tr>\n";
echo "					   <td><b>Treatment Protocol</b></td>\n";
echo "					   <td align='left'>".$r_sam['treatment_prot_1']."</td>\n";
echo "					</tr>\n";

echo "					<tr>\n";
echo "					   <td><b>Growth Protocol</b></td>\n";
echo "					   <td align='left'>".$r_sam['growth_prot_1']."</td>\n";
echo "					</tr>\n";

echo "					<tr>\n";
echo "					   <td><b>Extracted Molecule</b></td>\n";
echo "					   <td align='left'>".$r_sam['molecule_1']."</td>\n";
echo "					</tr>\n";

echo "					<tr>\n";
echo "					   <td><b>Extraction Protocol</b></td>\n";
echo "					   <td align='left'>".$r_sam['extraction_prot_1']."</td>\n";
echo "					</tr>\n";

echo "					<tr>\n";
echo "					   <td><b>Label</b></td>\n";
echo "					   <td align='left'>".$r_sam['lable_1']."</td>\n";
echo "					</tr>\n";

echo "					<tr>\n";
echo "					   <td><b>Label Protocol</b></td>\n";
echo "					   <td align='left'>".$r_sam['label_prot_1']."</td>\n";
echo "					</tr>\n";


if ($r_sam['platform'] != 'Affymetrix'){
	echo "					<tr><td>&nbsp;</td><td></td></tr>\n";

	echo "					<tr bgcolor='#EEEEEE'>\n";
	echo "					   <td><b>Channel 2</b></td>\n";
	echo "					   <td></td>\n";
	echo "					</tr>\n";


	echo "					<tr>\n";
	echo "					   <td><b>Source Name</b></td>\n";
	echo "					   <td align='left'>".$r_sam['source_name_2']."</td>\n";
	echo "					</tr>\n";

	echo "					<tr>\n";
	echo "					   <td><b>Organism(s)</b></td>\n";
	echo "					   <td align='left'>".$r_sam['organism_2']."</td>\n";
	echo "					</tr>\n";

	echo "					<tr>\n";
	echo "					   <td><b>Characteristics</b></td>\n";
	echo "					   <td align='left'>".$r_sam['charact_2']."</td>\n";
	echo "					</tr>\n";

	echo "					<tr>\n";
	echo "					   <td><b>Biomaterial Provider</b></td>\n";
	echo "					   <td align='left'>".$r_sam['provider_2']."</td>\n";
	echo "					</tr>\n";

	echo "					<tr>\n";
	echo "					   <td><b>Treatment Protocol</b></td>\n";
	echo "					   <td align='left'>".$r_sam['treatment_prot_2']."</td>\n";
	echo "					</tr>\n";

	echo "					<tr>\n";
	echo "					   <td><b>Growth Protocol</b></td>\n";
	echo "					   <td align='left'>".$r_sam['growth_prot_2']."</td>\n";
	echo "					</tr>\n";

	echo "					<tr>\n";
	echo "					   <td><b>Extracted Molecule</b></td>\n";
	echo "					   <td align='left'>".$r_sam['molecule_2']."</td>\n";
	echo "					</tr>\n";

	echo "					<tr>\n";
	echo "					   <td><b>Extraction Protocol</b></td>\n";
	echo "					   <td align='left'>".$r_sam['extraction_prot_2']."</td>\n";
	echo "					</tr>\n";

	echo "					<tr>\n";
	echo "					   <td><b>Label</b></td>\n";
	echo "					   <td align='left'>".$r_sam['lable_2']."</td>\n";
	echo "					</tr>\n";

	echo "					<tr>\n";
	echo "					   <td><b>Label Protocol</b></td>\n";
	echo "					   <td align='left'>".$r_sam['label_prot_2']."</td>\n";
	echo "					</tr>\n";
}

echo "					<tr><td>&nbsp;</td><td></td></tr>\n";
echo "					<tr bgcolor='#EEEEEE'><td>&nbsp;</td><td></td></tr>\n";

echo "					<tr>\n";
echo "					   <td><b>Hybridization Protocol</b></td>\n";
echo "					   <td align='left'>".$r_sam['hyb_prot']."</td>\n";
echo "					</tr>\n";

echo "					<tr>\n";
echo "					   <td><b>Scan Protocol</b></td>\n";
echo "					   <td align='left'>".$r_sam['scan_prot']."</td>\n";
echo "					</tr>\n";

echo "					<tr>\n";
echo "					   <td><b>Description</b></td>\n";
echo "					   <td align='left'>".$r_sam['description']."</td>\n";
echo "					</tr>\n";

echo "					<tr><td>&nbsp;</td><td></td></tr>\n";

echo "					<tr bgcolor='#EEEEEE'>\n";
echo "					   <td><b>Submission date</b></td>\n";
echo "					   <td align='left'>".$r_sam['sub_date']."</td>\n";
echo "					</tr>\n";

echo "					<tr bgcolor='#EEEEEE'>\n";
echo "					   <td><b>Contact name</b></td>\n";
echo "					   <td align='left'>".$r_sam['contact']."</td>\n";
echo "					</tr>\n";

echo "					<tr bgcolor='#EEEEEE'>\n";
echo "					   <td><b>E-mail(s)</b></td>\n";
echo "					   <td align='left'>".$r_sam['email']."</td>\n";
echo "					</tr>\n";

echo "					<tr bgcolor='#EEEEEE'>\n";
echo "					   <td><b>Phone</b></td>\n";
echo "					   <td align='left'>".$r_sam['phone']."</td>\n";
echo "					</tr>\n";

echo "					<tr bgcolor='#EEEEEE'>\n";
echo "					   <td><b>Fax</b></td>\n";
echo "					   <td align='left'>".$r_sam['fax']."</td>\n";
echo "					</tr>\n";

echo "					<tr bgcolor='#EEEEEE'>\n";
echo "					   <td><b>URL</b></td>\n";
echo "					   <td align='left'>".$r_sam['url']."</td>\n";
echo "					</tr>\n";

echo "					<tr bgcolor='#EEEEEE'>\n";
echo "					   <td><b>Organization name</b></td>\n";
echo "					   <td align='left'>".$r_sam['organization']."</td>\n";
echo "					</tr>\n";

echo "					<tr bgcolor='#EEEEEE'>\n";
echo "					   <td><b>Department</b></td>\n";
echo "					   <td align='left'>".$r_sam['department']."</td>\n";
echo "					</tr>\n";

echo "					<tr bgcolor='#EEEEEE'>\n";
echo "					   <td><b>Lab</b></td>\n";
echo "					   <td align='left'>".$r_sam['lab']."</td>\n";
echo "					</tr>\n";

echo "					<tr bgcolor='#EEEEEE'>\n";
echo "					   <td><b>Street address</b></td>\n";
echo "					   <td align='left'>".$r_sam['street']."</td>\n";
echo "					</tr>\n";

echo "					<tr bgcolor='#EEEEEE'>\n";
echo "					   <td><b>City</b></td>\n";
echo "					   <td align='left'>".$r_sam['city']."</td>\n";
echo "					</tr>\n";

echo "					<tr bgcolor='#EEEEEE'>\n";
echo "					   <td><b>State/province</b></td>\n";
echo "					   <td align='left'>".$r_sam['state']."</td>\n";
echo "					</tr>\n";

echo "					<tr bgcolor='#EEEEEE'>\n";
echo "					   <td><b>ZIP/Postal code</b></td>\n";
echo "					   <td align='left'>".$r_sam['zip']."</td>\n";
echo "					</tr>\n";

echo "					<tr bgcolor='#EEEEEE'>\n";
echo "					   <td><b>Country</b></td>\n";
echo "					   <td align='left'>".$r_sam['country']."</td>\n";
echo "					</tr>\n";

echo "				</table>\n";

echo "			</fieldset>\n";


do_html_footer($doc_path);

?>
