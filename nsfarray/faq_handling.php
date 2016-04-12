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

                    <h2>Rice Oligonucleotide Array Handling and Printing FAQ</h2>
                    <br/>

                    <b>1. How do I store the microarrays after I have received them?</b>

                    <br/>
                    <br/>

                    You should store the microarrays in a dessicator in the dark slide box they were shipped in. 
                    The arrays can be stored in its original packaging sealed in argon gas for at least 6 months 
                    without any problem.

                    <br/>
                    <br/>

                    <b>2. How many slides should I order?</b>

                    <br/>
                    <br/>

                    Depending on your experiment design, it may be preferable to order all the arrays you might need 
                    at once to reduce variability as having arrays from the same manufacturing batch run reduces your data 
                    variability.

                    <br/>
                    <br/>

                    <b>3. How should I hybridize my RNA to the microarrays?</b>

                    <br/>
                    <br/>

                    Protocols optimized for our arrays can be found in <a href='protocols.shtml'>Experimental Protocols</a>. 
                    If, and only if, you follow the protocol, then the preliminary calibration experiment results in 
                    H.H. Chou's lab suggest that the optimal hybridization temperature for the 45K arrays should be 
                    set at 48 degree C and the subsequent wash of your slides can be conducted at 50 (preferable) 
                    or at the same 48 C. The slightly higher wash temperature of 50 C helps to get rid of unattached 
                    transcripts, but is not essential. Note that the high density 45K rice array is designed to such 
                    precision that a significant deviation from this recommend hybridization temperature is likely 
                    to produce lower quality results. A hybridization workstation is also recommended to maintain 
                    uniform hybridization and wash temperatures. If you do use a hybridization workstation, make 
                    sure you set the wash cycle long enough to get rid of unattached transcripts. The default 
                    settings on the workstation we used seem to wash imperfectly until we increase its wash time. 
                    For each experiment, your hybridization chamber or workstation has to be washed thoroughly to 
                    remove any contaminants from previous use before you start.
                    <br/>
                    <br/>

                    <b>4. Now that I have hybridization results, how can I analyze the data?</b>

                    <br/>
                    <br/>

                    A variety of software packages are commercially available for analyzing microarrays. 
                    You can use them or obtain a freeware version available from academic institutions or from 
                    <a href='http://www.tigr.org/software'>TIGR Software</a>. 
                    You can submit your data to the project website using the <a href='masgen_index.shtml'>MIAME Submission Tool</a> 
                    and the data will be processed using our project data processing <a href='rice_faq_process.shtml'>Protocols</a>. 
                    This service is free with the caveat that the data become publicly available in 90 days.
                    <br/>
                    <br/>

                    <b>5. How will the spot location information be provided?</b>

                    <br/>
                    <br/>

                    A Gene Array List (gal) file is available for download in the <a href='layout.shtml'>Array Layout</a> page.
                    <br/>
                    <br/>

                    <b>6. What kind of arrayer was used to print these arrays?</b>

                    <br/>
                    <br/>

                    <a href='http://www.brooks.com/index.cfm'>Intelligent Automation Systems</a> (each machine is made slightly differently according to users requests).
                    <br/>
                    <br/>

                    <b>7. What kind of pins were used to print the arrays, and in what orientation?</b>

                    <br/>
                    <br/>

                    TeleChem's Stealth Microspotting Pins 2.5 (Cat# SMP2.5). 
                    The pins are arranged in a 12 x 4 grid in a TeleChem Stealth Printhead (Cat# IASSPH64)
                    <br/>
                    <br/>

                    <b>8. What should I do if I'm getting high background?</b>

                    <br/>
                    <br/>

                    a). Make certain that your RNA is clean and not degraded (ie. 260/280 ratio between 1.8-2.1 and make certain RNA is not degraded by checking it on a gel).
                    <br/>
                    b). Make certain that you have thoroughly cleaned your slide after incubation in pre-hybridization solution. If you see white streaks after washing the slides in water and isopropanol, repeat the washes until the slide is clear.



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
