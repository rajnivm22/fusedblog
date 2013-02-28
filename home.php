<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
 get_header(); 
 $theme_layout=   blogfused_get_option('theme_layout');?> 
<section id="container" > 
   <div class="container">
       <div class="row-fluid fused-posts-list <?php echo $theme_layout;?>">
            <div id="content" class="span8">
                <?php get_template_part('loop','posts');?>
             </div>

             <?php get_sidebar();?>  
        </div><!--end of fused posts list -->            
   </div> <!-- container class for fixed width -->     
</section>     

<?php get_footer();?>