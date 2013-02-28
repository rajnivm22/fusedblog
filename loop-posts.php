<?php if(have_posts()):?>
    <?php while ( have_posts() ) : the_post(); ?>
        <article <?php post_class('post clearfix');?> id="post-<?php the_ID();?>">
            <header>
                <h1 class="post-title"><a href="<?php the_permalink();?>" title="View <?php    the_title_attribute();?>"><?php the_title();?></a></h1>
                <div class="post-meta clearfix">
                    <span class="posted-by"><?php _e('Posted by'); ?></span>
                    <span class='post-author'><?php the_author_posts_link();?></span>
                    <div class="datetime"><?php the_date('\<\s\t\r\o\n\g\>j\<\s\u\p\>S\<\/\s\u\p\>\<\/\s\t\r\o\n\g\> \<\s\p\a\n\>M\<\/\s\p\a\n\>');?></div>              
                    <span class="comments-link-top"><i class='icon-comment'></i> <?php comments_popup_link( __( 'Leave a comment', 'fused' ), __( '1 Comment', 'fused' ), __( '% Comments', 'fused' ) ); ?></span>
                </div> 
            </header>

              <?php  if ( has_post_thumbnail() ) : ?>
                  <div class="post-format-img">
                      <?php  blogfused_get_featured_image_with_url(); ?>
                  </div>
             <?php endif; ?>
             <div class="clearfix entry ">
                    <?php the_excerpt();?>
                    <a href="<?php the_permalink();?>" title="<?php  the_title_attribute();?>" class="btn btn-info pull-right"><?php _e('Read More'); ?></a>
                    <div class="post-meta post-meta-bottom">
                        <div class="cat-links"><span class="posted-in"><?php _e( 'Posted in', 'buddypress' ) ?> <?php the_category(', ') ?></span></div>
                        <?php the_tags('<div class="tag-links"><span class="tagged-in">Tags:</span> ', ',', '</div>'); ?>
                        <span class="comments-link">
                            <span><i class='icon-comment'></i> <?php comments_popup_link( __( 'Leave a comment', 'fused' ), __( '1 Comment', 'fused' ), __( '% Comments', 'fused' ) ); ?>
                        </span>
                        <?php edit_post_link( __( 'Edit', 'fused' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
                   </div>
            </div>
        </article>    
     <?php endwhile; // end of the loop. ?>
          
            <?php blogfused_get_pagination()?>
     
     <?php else:?>
            <div class="post-404">
                <h2 class="muted not-found-title"> We Could not find anything matching. Please try searching again!</h2>
                <?php if(!is_search())get_search_form();?>
            </div>   
<?php endif; ?>
