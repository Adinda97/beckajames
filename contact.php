<?php
/* Template Name: Contact */

get_header();
?>


<div class="row py-lg-5 my-lg-5 py-5 contact">
    <div class="col-lg-5 col-12 offset-lg-1 me-4 img" style="background-image: url('<?php bloginfo('template_directory'); ?>/assets/img/dames_brillen.png');">
        
    </div>
    <civ class="col-lg-5 col-12 p-lg-4 p-5">
        <h2>Neem contact met ons op!</h2>
        <?php echo do_shortcode("[gravityform id='1' title='false' description='false' ajax='true' tabindex='49']"); ?>		
    </civ>
</div>


<?php
get_footer();

?>