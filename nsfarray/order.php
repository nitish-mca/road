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

                    <h2>Order Rice Oligonucleotide Arrays</h2>
                    <br/>

                    <font color=red><b>Note</b></font>: The UCD ArrayCore facility was closed 10/1/09. Please stop placing order.

                    <br/><br/>

                    To place an order for NSF Rice Oligonucleotide Arrays, please fill
                    in all required fields in the form below.  Orders will be shipped immediately after payment is received.

                    <br/>
                    <br/>

                    The cost per 45K array (as a set of 2 23K arrays) is $208.00.  The cost per 5K Xoo array is $110.  Please
                    specify which array when ordering.

                    <br/>
                    <br/>

                    <b>Note</b>: recipients are responsible for the taxes required by their own particular country
                    and international shipping costs.
                    <br/>
                    <br/>

                    For customers outside the US, please contact your customs agency to get proper forms and to find out 
                    how much taxes you will be responsible for. 
                    You will be required to have this in order before we can ship your arrays. 
                    We will email you to find out if the proper paperwork is in order. <b>FedEx will not deliver without proper 
                        documentation and taxes paid</b>.

                    <br/>
                    <br/>

                    After placing your order, you will immediately receive a Username and Password which you may use to track
                    the current status of your order through the <a href='order_login.shtml'>Track Orders</a> page.
                    <br/>
                    <br/>

                    We are not liable for slides damaged during shipping.

                    <br/>
                    <br/>
                    <br/>
                    <br/>

                    <fieldset>
                        <form action="/scripts/ricearray/order/rice_order.pl" method="post">		
                            <table>

                                <tr>
                                    <td class="order" align="left" valign="top">
                                        <u><b>Shipping Information</b></u>                           
                                    </td>
                                    <td class="order" align="left" valign="top">
                                        <u><b>Billing Information</b></u>
                                        <br/>
                                        <input type="checkbox" id="bill_copy" onClick="copyShipForm();">Click to copy Shipping Information</input>
                                    </td>
                                </tr>                   

                                <tr>
                                    <td class="order" align="left">
                                        Name *
                                        <br/>
                                        <input type="text" id="ship_name" maxlength="100" name="ship_name" size="30">
                                    </td>
                                    <td class="order" align="left">
                                        Name *
                                        <br/>
                                        <input type="text" id="bill_name" maxlength="100" name="bill_name" size="30">                           
                                    </td>
                                </tr>
                                <tr>
                                    <td class="order" align="left">
                                        Email *
                                        <br/>
                                        <input type="text" id="ship_email" maxlength="100" name="ship_email" size="30">
                                    </td> 
                                    <td class="order" align="left">
                                        Email *
                                        <br/>
                                        <input type="text" id="bill_email" maxlength="100" name="bill_email" size="30">
                                    </td>                
                                </tr>
                                <tr>
                                    <td class="order" align="left">
                                        Address *
                                        <br/>
                                        <textarea id="ship_address" name="ship_address" rows="4" cols="35" wrap="hard"></textarea>
                                    </td>
                                    <td class="order" align="left">
                                        Address *
                                        <br/>
                                        <textarea id="bill_address" name="bill_address" rows="4" cols="35" wrap="hard"></textarea>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="order" align="left">
                                        Phone number *
                                        <br/>
                                        <input type="text" id="ship_phone" maxlength="100" name="ship_phone" size="20">
                                        <br/>(Please include country code if outside North America)
                                    </td>                
                                    <td class="order" align="left">
                                        Phone number *
                                        <br/>
                                        <input type="text" id="bill_phone" maxlength="100" name="bill_phone" size="20">
                                        <br/>(Please include country code if outside North America)
                                    </td>
                                </tr>

                                <tr>
                                    <td class="order" align="left">
                                        Fax number
                                        <br/>
                                        <input type="text" id="ship_fax" maxlength="100" name="ship_fax" size="20">
                                        <br/>(Please include country code if outside North America)
                                    </td>
                                    <td class="order" align="left">
                                        Fax number
                                        <br/>
                                        <input type="text" id="bill_fax" maxlength="100" name="bill_fax" size="20">
                                        <br/>(Please include country code if outside North America)
                                    </td>
                                </tr>          

                                <tr>
                                    <td class="order" align="left">
                                        FedEx account number
                                        <br/>
                                        <input type="text" id="ship_fedex" maxlength="100" name="ship_fedex" size="25">
                                        <br/><b>We cannot ship slides without a FedEx account number</b> 	   
                                    </td>
                                    <td class="order" align="left" valign="top">
                                        Payment type *
                                        <br/>
                                        <select id="bill_type" name="bill_type">
                                            <option value="">-- Select a payment method --</option>
                                            <option value="check">Check</option>
                                            <option value="money_order">Money Order</option>
                                            <option value="wire_transfer">Wire Transfer</option>
                                        </select> 
                                    </td>
                                </tr>

                                <tr>
                                    <td class="order" align="left">
                                        &nbsp;
                                    </td>
                                    <td class="order" align="left">
                                        &nbsp;
                                    </td>
                                </tr>

                                <tr>
                                    <td class="order" align="left">
                                        <u><b>Experiment Information</b></u>
                                    </td>
                                    <td class="order" align="left">

                                    </td>
                                </tr>

                                <tr>
                                    <td class="order" align="right">
                                        Principal Investigator&nbsp;*
                                    </td>
                                    <td class="order" align="left">
                                        <input type='text' id='expt_pi' name='expt_pi' maxlength='40' size='30'>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="order" align="right">
                                        Institution&nbsp;*
                                    </td>
                                    <td class="order" align="left">
                                        <input type='text' id='expt_inst' name='expt_inst' maxlength='40' size='30'>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="order" align="right">
                                        Country&nbsp;*
                                    </td>
                                    <td class="order" align="left">
                                        <input type='text' id='expt_country' name='expt_country' maxlength='40' size='30'>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="order" align="right">
                                        Brief experiment description
                                    </td>
                                    <td class="order" align="left">
                                        <textarea name="expt_desc" rows="4" cols="35" wrap="hard"></textarea>
                                        <br/>(500 chars max)
                                    </td>
                                </tr>
                                <tr>
                                    <td class="order" align="right">
                                        Would you like assistance with experimental design?
                                    </td>
                                    <td class="order" align="left">                	    
                                        <input type="checkbox" name="expt_help">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="order" align="right">
                                        Would you like the <a href="http://array.ucdavis.edu/services.jsp">UCDavis ArrayCore facility</a> to perform the hybridizations?
                                    </td>
                                    <td class="order" align="left">                	    
                                        <input type="checkbox" name="expt_hyb">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="order" align="right">
                                        Date required *
                                    </td>
                                    <td class="order" align="left">
                                        <input id="expt_date" type="text" maxlength="40" name="expt_date" size="20">
                                        <br/>(yyyy-mm-dd)                	   
                                    </td>
                                </tr>
                                <tr>
                                    <td class="order" align="right">
                                        Number of arrays (in sets of 2 for 45K rice) *
                                    </td>
                                    <td class="order" align="left">
                                        <input id="expt_num" type="text" maxlength="20" name="expt_num" size="10">
                                        <!-- &nbsp;<input type="checkbox" name="affil_ucd"/> UC Davis?<br/> -->               	   
                                    </td>
                                </tr>
                                <tr>
                                    <td class="order" align="right">
                                        &nbsp;
                                    </td>
                                    <td class="order" align="left">
                                        * required                	   
                                    </td>
                                </tr>
                                <tr>
                                    <td class="order" align="right">
                                        &nbsp;
                                    </td>
                                    <td class="order" align="left">
                                        &nbsp;                	   
                                    </td>
                                </tr>
                                <tr>
                                    <td class="order" align="right">	
                                        <input type="submit" onClick="return checkOrderForm();" value="Submit">
                                    </td>
                                    <td class="order" align="left">
                                        <input type="reset" value="Clear">
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
