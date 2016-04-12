<table style='font-size: 10pt;'>

    <tr>
        <td>
            <ul id="mx">
                <li>
                    <a href="../index.php">Home</a>
                </li>

                <li>
                    <a href="../element/search_single.php">Element&nbsp;Search</a>
                    <ul id="menu_element">
                        <li>
                            <a href="../element/overview.php">Overview</a>
                        </li>
                        <li>
                            <a href="../element/search_single.php">Single-platform Search</a>
                        </li>
                        <li>
                            <a href="../element/search_multiple.php">Multiple-platform Search</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="../expression/expression.php">Expression&nbsp;Analysis</a>
                    <ul id="menu_expression">
                        <li>
                            <a href="../expression/overview.php">Overview</a>
                        </li>

                        <li>
                            <a href="../expression/experiment.php">Search Experiments</a>
                        </li>

                        <li>
                            <a href="../expression/expression.php">Search Gene Expression</a>
                        </li>

                        <li>
                            <a href="../expression/meta_analysis.php">Meta-Analysis</a>
                        </li>

                        <li>
                            <a href="../expression/highly.php">Highly Expressed Gene</a>
                        </li>

                        <li>
                            <a href="../expression/bulk_download.php">Bulk Download</a>
                        </li>

                    </ul>
                </li>

                <li>
                    <a href="../coexpression/coexpression.php">Coexpression&nbsp;Analysis</a>
                    <ul id="menu_coexpression">
                        <li>
                            <a href="../coexpression/overview.php">Overview</a>
                        </li>
                        <li>
                            <a href="../coexpression/coexpression.php">Coexpression&nbsp;Analysis</a>
                        </li>
                        <li>
                            <a href="../coexpression/network.php">Coexpression&nbsp;Network</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="../analysis/go_enrichment.php">Functional&nbsp;Analysis</a>
                    <ul id="menu_go">
                        <li>
                            <a href="../analysis/overview.php">Overview</a>
                        </li>
                        <li>
                            <a href="../analysis/go_enrichment.php">GO Enrichment Analysis</a>
                        </li>
                        <li>
                            <a href="../analysis/ko_enrichment.php">KO Enrichment Analysis</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="../contacts.php">Contact Us</a>
                </li>


                <li>
                    <a href="../links.php">Links</a>
                </li>


                <li>
                    <a href="../citing.php">Citing</a>
                </li>


                <li>
                    <a href="http://indica.ucdavis.edu/">Ronald Lab</a>
                </li>

            </ul>
        </td>
    </tr>
</table>


<br/>
<br/>

<form method="get" action="http://www.google.com/search">
    <input type="hidden" name="ie">
    <input type="hidden" name="oe">
    <table>
        <tr>
            <td>
                <a href="http://www.google.com/">
                    <img src="/images/logo_google.gif" border="0" alt="Google">
                </a>
                <input type="text" name="q" size="14" maxlength="255" value="">
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" name="btnG" value="Search Site">
                <font size="-1">
                <input type="hidden" name="domains" value="http://www.ricearray.org/">
                <br/>
                <input type="hidden" name="sitesearch" value="http://www.ricearray.org/" checked>
                <br/>
                </font>
            </td>
        </tr>
    </table>
</form>
<br/>
<br/>

&nbsp;

<!-- Start of StatCounter Code --
<script type="text/javascript">
var sc_project=4466322; 
var sc_invisible=0; 
var sc_partition=55; 
var sc_click_stat=1; 
var sc_security="f5351788"; 
</script>

<script type="text/javascript" src="http://www.statcounter.com/counter/counter.js"></script><noscript><div class="statcounter"><a title="hit counter" href="http://www.statcounter.com/free_hit_counter.html" target="_blank"><img class="statcounter" src="http://c.statcounter.com/4466322/0/f5351788/0/" alt="hit counter" ></a></div></noscript>
<!-- End of StatCounter Code -->

<br/>
<br/>
<br/>
<br/>


<script type="text/javascript">
    var mItem = [];
    var mTime = [];
    var mWait = 300;

    mSet('mx', 'm');

    function mSet(ul, c) {

        if (document.getElementById) {

            ul = document.getElementById(ul).getElementsByTagName('ul');
            var i, j, e, a, f, b;
            var m = mItem.length;

            for (i = 0; i < ul.length; i++) {

                if (e = ul[i].getAttribute('id')) {

                    mItem[m] = e;
                    e = ul[i].parentNode;
                    e.className = c;

                    f = new Function('mShow(\'' + mItem[m] + '\');');
                    b = new Function('mBlur(\'' + mItem[m] + '\');');
                    e.onmouseover = f;
                    e.onmouseout = b;
                    a = e.getElementsByTagName('a');

                    for (j = 0; j < a.length; j++) {
                        a[j].onfocus = f;
                        a[j].onblur = b;
                    }

                    m++;
                }
            }
        }
    }


    function mShow(id) {

        for (var i = 0; i < mItem.length; i++) {

            if (document.getElementById(mItem[i]).style.display != 'none') {

                if (mItem[i] != id)
                    mHide(mItem[i]);

                else
                    mClear(mItem[i]);
            }
        }

        document.getElementById(id).style.display = 'block';
    }


    function mHide(id) {

        mClear(id);
        document.getElementById(id).style.display = 'none';
    }


    function mBlur(id) {

        mTime[id] = setTimeout('mHide(\'' + id + '\');', mWait);
    }


    function mClear(id) {

        if (mTime[id]) {
            clearTimeout(mTime[id]);
            mTime[id] = null;
        }
    }

</script>
