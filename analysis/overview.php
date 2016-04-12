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

                    <h2>Rice GO Enrichment Analysis</h2>
                    <br/>

                    Gene Ontologies (GO) provide controlled vocabulary to describe the biological process, 
                    molecular function, and component of the cell to which a gene product putatively contributes. 
                    GO are useful for identifying biological patterns in a list of genes in a genome, microarray 
                    data set, or cDNA collection.
                    <br />

                    <h3>GO Statistics</h3>

                    <table cellspacing='1' cellpadding='1' border='1'>
                        <tr>
                            <td>&nbsp;</td>
                            <td><b>Gramene GO</b></td>
                        </tr>
                        <tr>
                            <td>No. of GO Terms</td>
                            <td>2,215</td>
                        </tr>
                        <tr>
                            <td>No. of Biological Process GO Terms</td>
                            <td>824</td>
                        </tr>
                        <tr>
                            <td>No. of Cellular Component Process GO Terms</td>
                            <td>262</td>
                        </tr>
                        <tr>
                            <td>No. of Molecular Funtion GO Terms</td>
                            <td>1,129</td>
                        </tr>
                        <tr>
                            <td>No. of Genes with GO</td>
                            <td>29,610</td>
                        </tr>
                    </table>

                    <br />

                    <h3>GO Enrichment</h3>

                    Hypergeometric distribution was used to get the p value of GO enrichment analysis.

                    <br/><br/>

                    <h2>Rice KO Enrichment Analysis</h2>
                    <br/>

                    KEGG Orthology (KO) is the basis for the representation of KEGG reference pathway maps
                    and BRITE functional hierarchies. It consists of manually defined ortholog groups that 
                    correspond to KEGG pathway nodes and BRITE hierarchy nodes.
                    <br />

                    <h3>KO Statistics</h3>

                    <table cellspacing='1' cellpadding='1' border='1'>
                        <tr>
                            <td>&nbsp;</td>
                            <td><b>KEGG KO</b></td>
                        </tr>
                        <tr>
                            <td>No. of KO Terms</td>
                            <td>2,024</td>
                        </tr>
                        <tr>
                            <td>No. of Genes with KO</td>
                            <td>3,314</td>
                        </tr>
                    </table>

                    <br />

                    <h3>KO Enrichment</h3>

                    Hypergeometric distribution was used to get the p value of KO enrichment analysis.



                    <!-- INFORMATION GOES ABOVE HERE -->

                    <br/>
                    <br/>
                    <font color="#708899">Last modified: <!--#echo var="LAST_MODIFIED" --></font>

                </td>

                <td width="5">
                </td>

                <td class="menu" valign="top">

                    <!--#include virtual="/inc/ROAD_inc_right_menu.shtml"-->

                </td>

            </tr>
        </table>
    </body>
</html>
