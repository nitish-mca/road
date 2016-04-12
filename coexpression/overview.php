<html>
    <head>
        <title>Rice Oligo Array Database</title>
        <link rel=stylesheet type="text/css" href="../RAD.css">
    </head>

    <body>

        <table>
            <?php include "../inc/ROAD_inc_header.php" ?>
            <tr>
                <td class="menu" valign="top">
                    <?php include "../inc/ROAD_inc_left_menu.php" ?>

                </td>

                <td width="5">
                </td>

                <td class="main" valign="top" width="600">
                    <!-- INFORMATION GOES UNDERNEATH HERE -->

                    <h2>Rice Coexpression Analysis</h2>
                    <br/>

                    The Pearson correlation coefficient of two genes is calculated based on 1,081 rice Affymetrix microarray data (NCBI GEO AC: 
                    <a href=http://www.ncbi.nlm.nih.gov/geo/query/acc.cgi?acc=GPL2025 target=_blank>GPL2025</a>) after filtering low quality slides. 
                    On the rice whole genome scale, there are 37,993 genes which have Affymetrix probeset matched, of which 34,016 have unique 
                    Affymetrix probeset available and only these genes were included in this database. So total 578,527,120 correlation coefficients 
                    for every pair of selected genes were obtained.<br />
                    In order to build the coexpression network, a PCC cutoff is needed to consider the pair of genes coexpressed. To choose an 
                    appropriate PCC cutoff , we examined the changes in the node number, edge number, and network density using different cutoffs. The following
                    figure shows that as the cutoff value increases, both the node number and edge number decrease; however, as the cutoff reaches a relatively
                    high value, the decreasing rate of edges becomes slower than that of nodes, which might lead to an increase in the network density. Indeed, 
                    the network density reaches minimum around PCC 0.75 and increases thereafter. So PCC 0.75 was selected for the coexpression analysis. The resulting
                    coexpression network contains 8,521 nodes and 496,682 edges, and a network density of 0.01368. These coexpressed gene pairs are the base
                    of this database.<br /><br />
                    <img src="../images/Affy_PCC_cutoff.jpg" width=385 height=539><br /><br />
                    There are two main functions in this coexpression section. One is the coexpression analysis which will give out the coexpressed genes of query gene under
                    a certain PCC cutoff. The other one is coexpression network construction of query genes under certain PCC cutoff and depth of network.
                    <br /><br />
                    The following figure shows the correlation coefficient distribution on the whole genome scale and the interval is 0.01.
                    <br /><br />
                    <img src="../images/Affy_cc_distribution.JPG" width=590 height=433> 


                    <!-- INFORMATION GOES ABOVE HERE -->

                    <br/>
                    <br/>
                    <font color="#708899">Last modified: <!--#echo var="LAST_MODIFIED" --></font>

                </td>

                <td width="5">
                </td>

                <td class="menu" valign="top">

                    <?php include "../inc/ROAD_inc_right_menu.php" ?>
                </td>

            </tr>
        </table>
    </body>
</html>
