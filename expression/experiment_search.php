<?php

$host = 'localhost';
$dbname = 'road';
$username = 'root';
$password = 'root';

// include function files for this application
require_once('../RAD_fns.php');
$conn = mysqli_connect($host, $username, $password, $dbname);
$term = $_GET["term"];
$section = $_GET["section"];

# roma
$q_exps = "select * from experiment";

# db queries
$q_exp_num = "select accession_no from experiment";
$q_sam_num = "select sam_id from sample";

$conn = db_connect();
$result = @$conn->query($q_exp_num);
$exp_num = $result->num_rows;

$result = @$conn->query($q_sam_num);
$sam_num = $result->num_rows;

# add filters to sql
$q_exps_filt = addFilters($q_exps, $term, $section);

$sort = '';
$order = '';
# add sort
if (isset($_GET["sort"])) {
    $sort = $_GET["sort"];
    $order = $_GET["order"];
    $q_exps_filt = addSorts($q_exps_filt, $sort, $order);
}

# get information for each experiment
$result = @$conn->query($q_exps_filt);

$i = 0;
$expData = array();
while ($row = $result->fetch_assoc()) {
    $r_exp_id[$i] = $row['exp_id'];
    $r_exp_title[$i] = $row['short_title'];
    $r_exp_contributor[$i] = $row['contributor'];
    $r_exp_platform[$i] = $row['platform'];
    $i++;
    $data[] = $row;
}

$exp_hits = count($r_exp_id);

$i = 0;
# get sam nums for each experiment
foreach ($r_exp_id as $exp_id) {

    $q_exp_sam_nums = "select * from sample where exp_id = '$exp_id'";

    $result = @$conn->query($q_exp_sam_nums);
    $r_exp_sam_num[$i] = $result->num_rows;

    $i++;
}

$result->free();
$conn->close();

do_html_header($doc_path);

echo "	          <h2>Search Rice Oligonucleotide Array Database Experiments</h2>\n";

echo "            <br/>\n";
echo "            <br/>\n";

echo "            Number of experiments in database: <b>$exp_num</b>\n";
echo "            <br/>\n";
echo "            Number of samples in database: <b>$sam_num</b>\n";

echo "            <br/>\n";
echo "            <br/>\n";

if (isset($term)) {

    echo "            Search term: <b>$term</b>\n";
    echo "            <br/>\n";

    if ($section == "title") {
        echo "            Search section: <b>Experiment Title</b>\n";
    } elseif ($section == "contributor") {
        echo "            Search section: <b>Contributor Name</b>\n";
    } elseif ($section == "description") {
        echo "            Search section: <b>Experiment Description</b>\n";
    } elseif ($section == "platform") {
        echo "            Search section: <b>Platform</b>\n";
    }

    echo "            <br/>\n";
    echo "            <br/>\n";
    echo "            Number of results found: <b>$exp_hits</b>\n";

    echo "            <br/>\n";
    echo "            <br/>\n";
}

if ($exp_hits == 0) {

    echo "            No results were found matching your search criteria. Please <a href='javascript:history.go(-1);'>go back</a> and modify your search parameters and try again.\n";
    echo "            Search terms are case insensitive.\n";
} elseif ($exp_hits >= 1) {

    echo "            Click on a experiment's Title to view more information about the experiment. Click on a column header to sort results by that column.\n";
    echo "            <br/>\n";
    echo "            <br/>\n";

    echo "            <fieldset>\n";
    echo "        	       <table width='100%' cellspacing='1' cellpadding='1' rules='cols' border='1'>\n";

    echo "                    <tr bgcolor=Orange>\n";

    # experiment listing number header
    echo "                       <td>\n";
    echo "                	          &nbsp;\n";
    echo "                       </td>\n";

    # experiment id header
    $header_id = headerLink($term, $section, "id", $order);
    echo "                       <td align='center'>\n";
    echo "                	          <b>$header_id</b>\n";
    echo "                       </td>\n";

    # platform header
    $header_platform = headerLink($term, $section, "platform", $order);
    echo "                       <td align='center'>\n";
    echo "                	          <b>$header_platform</b>\n";
    echo "                       </td>\n";

    # experiment title header
    $header_title = headerLink($term, $section, "title", $order);
    echo "                       <td align='center'>\n";
    echo "                	          <b>$header_title</b>\n";
    echo "                       </td>\n";

    # contributor header
    $header_contributor = headerLink($term, $section, "contributor", $order);
    echo "                       <td align='center'>\n";
    echo "                	          <b>$header_contributor</b>\n";
    echo "                       </td>\n";

    # number of hybs header
    echo "                       <td align='center'>\n";
    echo "                	          <b>Samples</b>\n";
    echo "                       </td>\n";

    echo "                    </tr>\n<pre>";


    for ($i = 0; $i < $exp_hits; $i++) {

        $rowbgcolor = ($i % 2 == 0 ? 'LightYellow' : 'LightBlue');

        echo "                    <tr bgcolor=$rowbgcolor>\n";

        $j = $i + 1;

        # listing number
        echo "                       <td>\n";
        echo "                           <b>$j.</b>\n";
        echo "                       </td>\n";

        # experiment id
        echo "                       <td>\n" . $data[$i]['accession_no'];
        //echo "                           <a href='/expression/experiment_detail.php?experiment=$r_exp_id[$i]&sort=id&order=asc'>$r_exp_id[$i]</a>\n";
        echo "                       </td>\n";

        # experiment platform
        echo "                       <td>\n" . $data[$i]['platform'];
        //echo "                           <a href='/expression/experiment_search.php?term=$r_exp_platform[$i]&section=platform'>$r_exp_platform[$i]\n</a>\n";
        echo "                       </td>\n";

        # sample link
        echo "                       <td>\n" . $data[$i]['title'];
        //echo "                           <a href='/expression/experiment_detail.php?experiment=$r_exp_id[$i]&sort=id&order=asc'>$r_exp_title[$i]</a>\n";
        echo "                       </td>\n";

        # contributor name
        echo "                       <td>\n" . $data[$i]['contributor'];
        //echo "                           <a href='/expression/experiment_search.php?term=$r_exp_contributor[$i]&section=contributor'>$r_exp_contributor[$i]\n</a>\n";
        echo "                       </td>\n";

        # number of samples
        echo "                       <td align='center'>\n" . $data[$i]['sample'];
        //echo "                           $r_exp_sam_num[$i]\n";
        echo "                       </td>\n";

        echo "                    </tr>\n";
    }

    echo "        	       </table>\n";
    echo "            </fieldset>\n";
}

do_html_footer($doc_path);

#
# addFilters(sql query, search term, search section) - modify sql query with applicable filters
#

function addFilters($q_exps_filt, $term, $section) {

    # make search term lowercase for case-insensitive comparisons
    $term = Strtolower($term);

    if ($section == "title") {

        $q_exps_filt .= " where lower(exp_title) like \"%$term%\"";
    } elseif ($section == "contributor") {

        $q_exps_filt .= " where lower(contributor) like \"%$term%\"";
    } elseif ($section == "description") {

        $q_exps_filt .= " where lower(summary) like \"%$term%\"";
    } elseif ($section == "platform") {

        $q_exps_filt .= " where lower(platform) like \"%$term%\"";
    }

    return $q_exps_filt;
}

#
# addSorts(sql query, sort section, sort by) - modify sql query with sort information
#

function addSorts($q_exps_filt, $sort, $order) {


    if ($sort == "id") {

        if ($order == "asc") {

            $q_exps_filt .= " order by exp_id asc";
        } elseif ($order == "desc") {

            $q_exps_filt .= " order by exp_id desc";
        }
    }

    if ($sort == "platform") {

        if ($order == "asc") {

            $q_exps_filt .= " order by platform asc";
        } elseif ($order == "desc") {

            $q_exps_filt .= " order by platform desc";
        }
    } elseif ($sort == "title") {

        if ($order == "asc") {

            $q_exps_filt .= " order by short_title asc";
        } elseif ($order == "desc") {

            $q_exps_filt .= " order by short_title desc";
        }
    } elseif ($sort == "contributor") {

        if ($order == "asc") {

            $q_exps_filt .= " order by contributor asc";
        } elseif ($order == "desc") {

            $q_exps_filt .= " order by contributor desc";
        }
    }

    return $q_exps_filt;
}

#
# headerLink () - return a column header link on how it should be sorted
#

function headerLink($term, $section, $sort, $order) {

    $header;

    if ($sort == "id") {

        if ($order == "asc") {

            $header = "<a href='/expression/experiment_search.php?term=$term&section=$section&sort=$sort&order=desc'>ID</a>";
        } else {

            $header = "<a href='/expression/experiment_search.php?term=$term&section=$section&sort=$sort&order=asc'>ID</a>";
        }
    } elseif ($sort == "platform") {

        if ($order == "asc") {

            $header = "<a href='/expression/experiment_search.php?term=$term&section=$section&sort=$sort&order=desc'>Platform</a>";
        } else {

            $header = "<a href='/expression/experiment_search.php?term=$term&section=$section&sort=$sort&order=asc'>Platform</a>";
        }
    } elseif ($sort == "title") {

        if ($order == "asc") {

            $header = "<a href='/expression/experiment_search.php?term=$term&section=$section&sort=$sort&order=desc'>Title</a>";
        } else {

            $header = "<a href='/expression/experiment_search.php?term=$term&section=$section&sort=$sort&order=asc'>Title</a>";
        }
    } elseif ($sort == "contributor") {

        if ($order == "asc") {

            $header = "<a href='/expression/experiment_search.php?term=$term&section=$section&sort=$sort&order=desc'>Contributor</a>";
        } else {

            $header = "<a href='/expression/experiment_search.php?term=$term&section=$section&sort=$sort&order=asc'>Contributor</a>";
        }
    }

    return $header;
}

?>
