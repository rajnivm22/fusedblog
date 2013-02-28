<?php
  if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
     get_header(); 
   $theme_layout=   blogfused_get_option('theme_layout');?>

  <section id="container" > 
      <h1 class="assistive-text">Contents</h1>
      <div class="page-header fused-single-header">
           <div class="container">
                 <div class="row-fluid row-headlines">
                        <hgroup>
                            <h1><?php blogfused_the_headline();?></h1>
                        </hgroup>    
                 </div>
               <?php if (function_exists('breadcrumb_trail')): ?>
                  <div class="row-fluid breadcrumbs">
                      <?php breadcrumb_trail(blogfused_get_breadcrumbs_args()); ?>
                 </div>
               <?php endif;?>
           </div> <!-- end of button row -->       
       </div><!--end of page header -->
  <div class="container">
     <div class="row-fluid fused-posts-list <?php echo $theme_layout;?>">
      <div id="content" class="span8">
         <?php while ( have_posts() ) : the_post(); ?>
              <article <?php post_class('clearfix');?> id="post-<?php the_ID();?>">
                    <header>
                        <h1 class="post-title">
                            <?php the_title();?>
                        </h1>
                        <div class="post-meta clearfix">
                            <span class="posted-by">Posted by</span>
                            <span class='post-author'><?php the_author_posts_link();?></span>
                            <div class="datetime"><?php the_date('\<\s\t\r\o\n\g\>j\<\s\u\p\>S\<\/\s\u\p\>\<\/\s\t\r\o\n\g\> \<\s\p\a\n\>M\<\/\s\p\a\n\>');?></div>              
                            <span class="comments-link-top"><i class='icon-comment'></i> <?php comments_popup_link( __( 'Leave a comment', 'twentyten' ), __( '1 Comment', 'twentyten' ), __( '% Comments', 'twentyten' ) ); ?></span>
                        </div>  
                    </header>
                    <?php  if ( has_post_thumbnail() ) : ?>
                        <div class="post-format-img">
                            <?php blogfused_get_featured_image(); ?>
                        </div>
                    <?php endif; ?>
                    <div class="entry">
                        <?php the_content();?>
                   </div>
            </article>    
              <?php  blogfused_get_comment_template();?>
         <?php endwhile; // end of the loop. ?>
        </div>
       <?php get_sidebar();?>  
    </div><!--end of fused posts list -->            
 </div> <!-- container class for fixed width -->     
</section>     
<?php get_footer();?>