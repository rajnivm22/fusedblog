<?php
/**
* Template Name: Two Column
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 get_header();?>
<section id="container" > 
   <div class="page-header fused-single-header">
         <div class="container">
                 <div class="row-fluid row-headlines">
                        <hgroup>
                            <h1><?php blogfused_the_headline();?></h1>
                        </hgroup>    
                 </div>
                 <div class="row-fluid breadcrumbs">
                      <?php breadcrumb_trail(blogfused_get_breadcrumbs_args()); ?>
                 </div>
          </div> <!-- end of button row -->       
    </div><!--end of page header -->
  <div class="container">
     <div class='row-fluid'>
        <div id="content" class="span8">
           <?php while ( have_posts() ) : the_post(); ?>
           <article <?php post_class('clearfix');?> id="post-<?php the_ID();?>">
                <?php  if ( has_post_thumbnail() ) : ?>
                    <div class="post-format-img">
                        <?php blogfused_get_featured_image(); ?>
                    </div>
                <?php endif; ?>
               <div class="entry">
                  <?php the_content();?>
                  <?php edit_post_link();?>
               </div>
            </article>
            <?php  blogfused_get_comment_template();?>
           <?php endwhile; // end of the loop. ?>
        </div>
       <?php get_sidebar();?> 
     </div>
   </div> <!-- container class for fixed width -->     
</section>     

<?php get_footer();?>