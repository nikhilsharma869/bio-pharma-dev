<script language="javascript" src="js/jquery-1.11.1.min.js" ></script>
<link href="jplugins/slippry/slippry.css" rel="stylesheet" type="text/css" />
<script src="jplugins/slippry/slippry.min.js"></script>
<script type="text/javascript">
    jQuery(window).load(function($){
        // jQuery('.slides').skdslider({delay:5000, animationSpeed: 2000,showNav:false,showNextPrev:true,showPlayButton:false,autoSlide:true,animationType:'sliding'});        
        jQuery('.slides').slippry({pager: false});
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
                <a href="#">
                <?php if($i < 10) { ?>
                <img src="/slides/banners/<?php echo '0'.$i.'.jpg';?>" />
                <?php } else { ?>
                <img src="/slides/banners/<?php echo $i.'.jpg';?>" />
                <?php } ?>
                </a>                
            </li>
            <?php
            }
        ?>
    </ul>
</div>

