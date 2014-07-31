<?php
$current_page = "Enterprice Solution";
include "includes/header.php";
$rwc = mysql_fetch_array(mysql_query("select * from " . $prev . "contents where cont_title ='Enterprice Solution'"));
?>

<!-----------Header End-----------------------------> 

<div class="container" style=" width: 1000px; margin: 0 auto; ">


    <!--Howitworks Start-->
    <div class="containt">
        <?= nl2br(html_entity_decode($rwc['contents'])) ?>
    </div>

    <!-- left side-->
    <!-- rightside-->


    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>




    <!-- end rightside-->

</div>
<div style="clear:both"></div>

<!--FOOTER BOX-->
<?php include 'includes/footer.php'; ?> 
<!--FOOTER BOX END-->