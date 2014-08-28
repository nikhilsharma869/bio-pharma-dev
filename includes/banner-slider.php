<script language="javascript" src="js/jquery-1.11.1.min.js" ></script>
<script src="jplugins/skdslider/skdslider.js"></script>
<link href="jplugins/skdslider/skdslider.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    jQuery(document).ready(function($){
        jQuery('.slides').skdslider({delay:5000, animationSpeed: 2000,showNav:false,showNextPrev:true,showPlayButton:false,autoSlide:true,animationType:'sliding'});        
    });
</script>

<div class="banner-strip"></div>
<div class="banner-strip"></div>
<div class="banner-slider">
    <ul class="slides">
        <?php
            for ($i=1; $i <= 13 ; $i++) {            
            ?>
            <li>
                <?php if($i < 10) { ?>
                <img src="slides/banners/<?php echo '0'.$i.'.jpg';?>" />
                <?php } else { ?>
                <img src="/slides/banners/<?php echo $i.'.jpg';?>" />
                <?php } ?>                
            </li>
            <?php
            }
        ?>
    </ul>
</div>

