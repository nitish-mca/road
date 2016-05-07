<html>
    <head>
        <title>Rice Oligonucleotide Array Database</title>
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

                    <h2>Rice Expression Analysis</h2>
                    <br/>

                    <h3>Data Source</h3>
                    All the raw data were downloaded from public databases, including NCBI GEO, ArrayExpress and PLEXdb.

                    <br/>

                    <h3>Data Processing</h3>
                    <b>One-channel Array</b>
                    <br />
                    MAS 5.0 method provided by R package affy was used to convert Affymetrix probe level data to expression
                    values. The trimmed mean target intensity of each array was arbitrarily set to 500. 
                    The data were log2 transformed.

                    <br /><br />

                    <b>Two-channel Array</b>
                    <br />
                    R package marray in Bioconductor was used to do the normalization of two-channel array. Within-array 
                    Lowess normalization and between-array MAD scale normalization were used.

                    <br /><br />

                    <h3>Data Download</h3>
                    <a href="files/Affymetrix_log.zip">Affymetrix_log.zip</a> Whole Affymetrix normalized data (zip, 187M)<br />
                    <a href="files/Agilent22K.zip">Agilent22K.zip</a> Whole Agilent 22K normalized data (zip, 6M)<br />
                    <a href="files/Agilent44K.zip">Agilent44K.zip</a> Whole Agilent 44K normalized data (zip, 9M)<br />
                    <a href="files/BGIYale.zip">BGIYale.zip</a> Whole BGI/Yale normalized data (zip, 45M)<br />
                    <a href="files/NSF20K.zip">NSF20K.zip</a> Whole NSF 20K normalized data (zip, 6M)<br />
                    <a href="files/NSF45K.zip">NSF45K.zip</a> Whole NSF 45K normalized data (zip, 10M)<br />

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
