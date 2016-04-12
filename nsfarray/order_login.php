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

                    <?php include "../inc/ROAD_inc_left_menu.php"?>

                </td>

                <td width="5">
                </td>

                <td class="main" valign="top" width="600">
                    <!-- INFORMATION GOES UNDERNEATH HERE -->

                    <h2>Rice Oligonucleotide Array Order Status</h2>
                    <br/>

                    To track the status of your Rice Oligonucleotide Array purchase, login with your username and password below.
                    Entries are case sensitive.

                    <br/>
                    <br/>

                    To apply for a username and password, contact <a href="mailto:pjcao@ucdavis.edu?subject=Rice order username/password request">pjcao@ucdavis.edu</a>.

                    <br/>
                    <br/>

                    <fieldset>
                        <form action="/scripts/ricearray/order/rice_order_track.pl" method="post">
                            <table>
                                <tr>
                                    <td class="order" align="right">
                                        Username
                                    </td>
                                    <td class="order" align="left">
                                        <input type="text" id="user" maxlength="10" name="user" size="12">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="order" align="right">
                                        Password
                                    </td>
                                    <td class="order" align="left">
                                        <input type="password" id="pass" maxlength="20" name="pass" size="12">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        &nbsp;
                                    </td>
                                    <td align="left">

                                        <br/>  
                                        <input type="submit" value="Submit"/>
                                        &nbsp;
                                        <input type="reset" value="Clear"/>

                                        <input type="hidden" name="action" value="list"/>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </fieldset>


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
