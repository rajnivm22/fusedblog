<!--footer -->
<footer id="footer">   <!--Footer starts here-->
    <h2 class="assistive-text"><?php _e('Footer Navigation'); ?></h2>
      <?php if(blogfused_get_option('footer_show')): ?>
       <div id="footer-top" >
             <div class="container">
                  <div class="row-fluid">
                      <div id="top-f-left" class="span8">
                            <ul >
                                <?php dynamic_sidebar('footer-section');?>
                               
                               <li class="widget clearfix"> <!--widget starts here-->
                                   <h3 class="widget-title"><?php echo  blogfused_get_theme_menu_name('footer-menu-1'); ?> </h3>
                                     <?php wp_nav_menu(array('theme_location'=> 'footer-menu-1')); ?>
                               </li>  <!--widget ends here-->
                               <li class="widget clearfix"> <!--widget starts here-->
                                  <h3 class="widget-title"><?php echo  blogfused_get_theme_menu_name('footer-menu-2'); ?></h3>
                                     <?php wp_nav_menu(array('theme_location'=> 'footer-menu-2')); ?>
                              </li>  <!--widget ends here-->
                          </ul>
                     </div>
                     <div class="span4 footer-right">
                        <ul>
                            <li>
                                <h3><?php _e('Search our Website'); ?></h3>
                                <div id="search-box" > 
                                    <?php  get_search_form(); ?>
                                </div>
                            </li>
                        </ul>
                     </div>
                </div>
        </div><!-- end of top footer container section -->
     </div><!--end of footer top section -->
     <?php  endif; ?>
      <div id="footer-bottom">
          <div id="b-footer-bg">
                <div class="container">
                     <div class="row-fluid">
                            <nav class="span8"> 
                                <ul>
                                     <?php wp_nav_menu(array('theme_location'=> 'footer-menu-3')); ?>
                                </ul>
                            </nav>
                            <div class="span4 footer-links">
                                <a class="facebook" href="<?php echo blogfused_get_option('facebook_link');?>"></a>
                                <a class="twitter" href="<?php echo blogfused_get_option('twitter_link');?>"></a>
                                <a class="flicker" href="<?php echo blogfused_get_option('flicker_link');?>"></a>
                            </div>
                      </div><!-- end of row -->  
                 </div>
            </div>
            <?php if(blogfused_get_option('copyright_text')):?>
                <div class="container" id="site-description">
                    <p><?php echo blogfused_get_option('copyright_text');?></p>
                </div>
           <?php  endif; ?>
            <br class="clear" />
        </div>
   </footer>  <!--Footer ends here--> 
 </div><!--end of main fluid container -->   
    <?php wp_footer();?>
 </body>
 </html>