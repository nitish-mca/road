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

                    <h2>NSF Rice Oligonucleotide Array Validation</h2>
                    <br/>

                    <h3>The 45K array was validated using RNA harvested from light/dark grown rice plants</h3>
                    <br/>

                    For a detailed description of the experiment used to validate the 45K array design, download
                    the <a href='files/45k_validation.pdf'>Validation of NSF supported rice 45k array with light vs. dark experiment</a> (pdf, 164K).

                    <br/>
                    <br/>

                    <h3>The 20K array was validated using RNA harvested from light/dark grown rice plants</h3>

                    <br/>

                    <b>Error Rate</b>
                    <br/>
                    <br/>

                    1. The error rate was evaluated using 217 hygromycin spots.
                    The 20K chip has 217 spots corresponding to the hygromycin resistance gene, 
                    which are randomly spotted. These spots can be used as positive controls for 
                    transgenic samples, and also as a negative control for nontransgenic samples.

                    <br/>
                    <br/>

                    Example 1. Positive control; NH1ox transgenic plants vs wild-type.
                    <br/>
                    <br/>

                    <table border='1' cellpadding='4' cellspacing='3'>
                        <tr>
                            <td>
                                <b>Slide</b>
                            </td>
                            <td>
                                <b>1</b>
                            </td>
                            <td>
                                <b>2</b>
                            </td>
                            <td>
                                <b>3</b>
                            </td>
                            <td>
                                <b>4</b>
                            </td>
                            <td>
                                <b>5</b>
                            </td>
                            <td>
                                <b>6</b>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Number of hph spots &gt; 2 fold</b>
                            </td>
                            <td>
                                217
                            </td>
                            <td>
                                217
                            </td>
                            <td>
                                217
                            </td>
                            <td>
                                217
                            </td>
                            <td>
                                217
                            </td>
                            <td>
                                217
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Ratio (%)</b>
                            </td>
                            <td>
                                100
                            </td>
                            <td>
                                100
                            </td>
                            <td>
                                100
                            </td>
                            <td>
                                100
                            </td>
                            <td>
                                100
                            </td>
                            <td>
                                100
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Total hph spots</b>
                            </td>
                            <td>
                                217
                            </td>
                            <td>
                                217
                            </td>
                            <td>
                                217
                            </td>
                            <td>
                                217
                            </td>
                            <td>
                                217
                            </td>
                            <td>
                                217
                            </td>
                        </tr>
                    </table>
                    <br/>
                    <br/>

                    Example 2. Negative control; light vs. dark-grown non-transgenic seedlings.
                    <br/>
                    <br/>

                    <table border='1' cellpadding='4' cellspacing='3'>
                        <tr>
                            <td>
                                <b>Slide</b>
                            </td>
                            <td>
                                <b>1</b>
                            </td>
                            <td>
                                <b>2</b>
                            </td>
                            <td>
                                <b>3</b>
                            </td>
                            <td>
                                <b>4</b>
                            </td>
                            <td>
                                <b>5</b>
                            </td>
                            <td>
                                <b>6</b>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Number of hph spots &gt; 2 fold</b>
                            </td>
                            <td>
                                2
                            </td>
                            <td>
                                0
                            </td>
                            <td>
                                1
                            </td>
                            <td>
                                1
                            </td>
                            <td>
                                1
                            </td>
                            <td>
                                1 
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Ratio (%)</b>
                            </td>
                            <td>
                                0.92
                            </td>
                            <td>
                                0.00
                            </td>
                            <td>
                                0.46
                            </td>
                            <td>
                                0.46
                            </td>
                            <td>
                                0.46
                            </td>
                            <td>
                                0.46
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Total hph spots</b>
                            </td>
                            <td>
                                217
                            </td>
                            <td>
                                217
                            </td>
                            <td>
                                217
                            </td>
                            <td>
                                217
                            </td>
                            <td>
                                217
                            </td>
                            <td>
                                217
                            </td>
                        </tr>
                    </table>

                    <br/>
                    <br/>

                    <b>Reproducibility</b>
                    <br/>
                    <br/>

                    2. The reproducibility was tested using dye swapping.

                    <br/>
                    <br/>

                    <table cellspacing='3'>
                        <tr>
                            <td>
                                <b>Dark (cy3 green) light (cy5 red)</b>
                            </td>
                            <td>
                                <b>Light (cy3 green) dark (cy5 red)</b>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <img src='../images/rice_valid_1.png'>
                            </td>
                            <td>
                                <img src='../images/rice_valid_2.png'>
                            </td>
                        </tr>
                    </table>

                    <br/>
                    <br/>

                    Correlation coefficient and scatter-plot between replicates:

                    <br/>
                    <br/>

                    <table cellspacing='3'>
                        <tr>
                            <td>
                                <img src='../images/rice_valid_correlation_a.png'>
                            </td>
                        </tr>

                        <td>
                            <img src='../images/rice_valid_correlation_b.png'>
                        </td>
            </tr>
        </table>

        <br/>
        <br/>

        <h3>Sources of Variation</h3>
        <br/>

        3. Sources of variation were evaluated (using ANOVA, Rocke et al.) In this
        example, the treatment factor was the major source of variation:

        <br/>
        <br/>

        <img src='../images/rice_valid_var.png'>

        <br/>
        <br/>

        <b>Gene Ontology Analysis</b>
        <br/>
        <br/>

        4. Gene Ontology (GO) analysis was performed.

        <br/>
        <br/>

        Summary of GO annotation for the 20K oligo set:

        <br/>
        <br/>

        <table border='1' cellpadding='4' cellspacing='3'>
            <tr>
                <td>
                    <b>GO Terms</b>
                </td>
                <td>
                    <b>0.1% FDR</b>
                </td>
                <td>
                    <b>5% FDR</b>
                </td>
                <td>
                    <b>Total</b>
                </td>
            </tr>

            <tr>
                <td>
                    <b>Biological Process</b>
                </td>
                <td>
                    1,038 (37.5%)
                </td>
                <td>
                    2,272 (34.8%)
                </td>
                <td>
                    5,645 (27.9%)
                </td>
            </tr>
            <tr>
                <td>
                    <b>Cellular Component</b>
                </td>
                <td>
                    558 (20.2%)
                </td>
                <td>
                    1,233 (18.9%)
                </td>
                <td>
                    3,015 (14.9%)
                </td>
            </tr>
            <tr>
                <td>
                    <b>Molecular Function</b>
                </td>
                <td>
                    1,400 (50.6%)
                </td>
                <td>
                    3,051 (46.8%)
                </td>
                <td>
                    7,227 (35.7%)
                </td>
            </tr>
            <tr>
                <td>
                    <b>All GO-terms</b>
                </td>
                <td>
                    1,530 (55.3%)
                </td>
                <td>
                    3,330 (51.0%)
                </td>
                <td>
                    7,967 (39.4%)
                </td>
            </tr>
            <tr>
                <td>
                    <b>Light/dark Microarray</b>
                </td>
                <td>
                    2,767 (100% )
                </td>
                <td>
                    6,525 (100%)
                </td>
                <td>
                    21,120 (100%)
                </td>
            </tr>
        </table>

        <br/>
        <br/>

        e.g. Photosynthesis.  Result of light/dark microarray experiment for genes involved
        in photosynthesis. 14 of 19 genes were differentially expressed in terms of p-value (FDR) and fold change.
        TIGR ID was the name of gene model in the TIGR Rice Annotation release 3.  FDR was the false
        discovery rate (p-value) developed by Rocke (2004).

        <br/>
        <br/>

        <table  border='1' cellpadding='4' cellspacing='3'>
            <tr>
                <td>
                    <b>TIGR ID</b>
                </td>
                <td>
                    <b>Biological Process</b>
                </td>
                <td>
                    <b>Putative Function</b>
                </td>
                <td>
                    <b>FDR</b>
                </td>
                <td>
                    <b>Log<sub>2</sub>L/D</b>
                </td>
            </tr>
            <tr>
                <td>11673.m03640</td>
                <td>
                    Photosynthesis
                </td>
                <td>
                    Chlorophyll
                    A-B binding protein
                </td>
                <td>
                    1.05E-07
                </td>
                <td>
                    6.068103
                </td>
            </tr>
            <tr>
                <td>
                    11674.m03347
                </td>
                <td>
                    Photosynthesis
                </td>
                <td>
                    Chlorophyll
                    A-B binding protein
                </td>
                <td>
                    1.05E-07
                </td>
                <td>
                    6.855869
                </td>
            </tr>
            <tr>
                <td>
                    11674.m00949
                </td>
                <td>
                    Photosynthesis
                </td>
                <td>
                    Photosystem II
                    PsbR
                </td>
                <td>
                    1.09E-07
                </td>
                <td>
                    6.849156
                </td>
            </tr>
            <tr>
                <td>
                    11673.m03790
                </td>
                <td>
                    Photosynthesis
                </td>
                <td>
                    Chlorophyll
                    A-B binding protein
                </td>
                <td>
                    1.32E-07
                </td>
                <td>
                    6.155692
                </td>
            </tr>
            <tr>
                <td>
                    11681.m01619
                </td>
                <td>
                    Photosynthesis
                </td>
                <td>
                    Chlorophyll
                    A-B binding protein
                </td>
                <td>
                    1.32E-07
                </td>
                <td>
                    7.033996
                </td>
            </tr>
            <tr>
                <td>
                    11667.m04019
                </td>
                <td>
                    Photosynthesis
                </td>
                <td>
                        Chlorophyll
                    A-B binding protein
                </td>
                <td>
                    1.62E-07
                </td>
                <td>
                    7.028789
                </td>
            </tr>
            <tr>
                <td>
                    11669.m05717
                </td>
                <td>
                    Photosynthesis
                </td>
                <td>
                    Photosystem I
                    F subunit 
                </td>
                <td>
                    1.91E-07
                </td>
                <td>
                    4.929572
                </td>
            </tr>
            <tr>
                <td>
                    11673.m00461
                </td>
                <td>
                    Photosynthesis
                </td>
                <td>
                    Photosystem I
                    psaG / psaK
                </td>
                <td>
                    2.12E-07
                </td>
                <td>
                    6.161693
                </td>
            </tr>
            <tr>
                <td>
                    11668.m05158
                </td>
                <td>
                    Photosynthesis
                </td>
                <td>
                    Chlorophyll
                    A-B binding protein
                </td>
                <td>
                    4.03E-07
                </td>
                <td>
                    3.17475
                </td>
            </tr>
            <tr>
                <td>
                    11667.m07138
                </td>
                <td>
                    Photosynthesis
                </td>
                <td>
                    Photosystem
                    II?PsbW
                </td>
                <td>
                    6.77E-07
                </td>
                <td>
                    2.950762
                </td>
            </tr>
            <tr>
                <td>
                    11667.m05117
                </td>
                <td>
                    Photosynthesis
                </td>
                <td>
                    Chlorophyll
                    A-B binding protein
                </td>
                <td>
                    1.24E-06
                </td>
                <td>
                    2.084434
                </td>
            </tr>
            <tr>
                <td>
                    11669.m04812
                </td>
                <td>
                    Photosynthesis
                </td>
                <td>
                    Ferredoxin
                </td>
                <td>
                    3.79E-06
                </td>
                <td>
                    1.590981
                </td>
            </tr>
            <tr>
                <td>
                    11667.m00476
                </td>
                <td>
                    Photosynthesis
                </td>
                <td>
                    Triosephosphate
                    isomerase
                </td>
                <td>
                    7.64E-06
                </td>
                <td>
                    1.418197
                </td>
            </tr>
            <tr>
                <td>
                    11673.m00448
                </td>
                <td>
                    Photosynthesis
                </td>
                <td>
                    Photosystem
                    PsbR
                </td>
                <td>
                    5.87E-03
                </td>
                <td>
                    1.417425
                </td>
            </tr>
            <tr>
                <td>
                    11667.m06239
                </td>
                <td>
                    Photosynthesis
                </td>
                <td>
                    Triosephosphate
                    isomerase
                </td>
                <td>
                    4.58E-02
                </td>
                <td>
                    0.17687
                </td>
            </tr>
            <tr>
                <td>
                    11669.m06319
                </td>
                <td>
                    Photosynthesis
                </td>
                <td>
                    Ferredoxin
                </td>
                <td>
                    7.04E-02
                </td>
                <td>
                    -0.15064
                </td>
            </tr>
            <tr>
                <td>
                    11669.m04559
                </td>
                <td>
                    Photosynthesis
                </td>
                <td>
                    Ferredoxin
                </td>
                <td>
                    1.05E-01
                </td>
                <td>
                    0.191392
                </td>
            </tr>
            <tr>
                <td>
                    11682.m03483
                </td>
                <td>
                    Photosynthesis
                </td>
                <td>
                    Ferredoxin
                    [2Fe-2S]
                </td>
                <td>
                    1.05E-01
                </td>
                <td>
                    0.109432
                </td>
            </tr>
            <tr>
                <td>
                    11670.m03233
                </td>
                <td>
                    Photosynthesis
                </td>
                <td>
                    Ferredoxin
                    [2Fe-2S]
                </td>
                <td>
                    9.33E-01
                </td>
                <td>
                    -0.01316
                </td>
            </tr>
        </table>

        <br/>
        <br/>

        <b>Differentially Expressed Genes</b>
        <br/>
        <br/>

        5. Differentially expressed genes were identified using LMGene (Rocke et al.) The list of differentially
        expressed genes in the light vs. dark experiment with both log2 ratios and p-value are given below:

        <br/>
        <br/>

        <a href='../images/rice_valid_differ.png'><img border='0' src='/images/rice_valid_differ_sm.png'></a>

        <br/>
        <br/>

        <h3>References</h3>
        <br/>

        Chern MS, Fitzgerald HA, Canlas PE, Navarre DA, and Ronald PC. 2005. Over-expression of a Rice NPR1 Homologue Leads
        to Constitutive Activation of Defense Response and Hypersensitivity to Light. MPMI. 18. (6): 511-520.

        <br/>
        <br/>

        Rocke DM. 2004. Design and Analysis of Experiments with High Throughput Biological Assay Data. Sem. Cell Dev. Biol., 15, 708-713. 



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
