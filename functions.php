<?php
//do not show adminbar
add_filter('show_admin_bar', '__return_false');

class BlogfusedThemeHelper {

    private static $instance;
    var $template_dir_url;
    
    
    private function __construct() {

        add_action('after_setup_theme', array($this, 'setup'),1); //initialize the setup, load files
        add_action('widgets_init', array($this, 'register_widget')); //initialize regiseter widget, load widget
      
        add_action('wp_print_styles', array($this, 'load_css'));
        add_action('wp_print_scripts', array($this, 'load_js'));
     
        add_action('wp_head',array($this,'load_icons'));
        
        $this->template_dir_url=  get_template_directory_uri();
        
  }

    public static function get_instance() {

        if (!isset(self::$instance))
            self::$instance = new self();

        return self::$instance;
    }

    public function setup() {
        
         if (is_admin()) {
             require( get_template_directory() . '/admin/theme-options.php' );
         }
           require( get_template_directory() . '/lib/nav-class.php' );
       
        $this->register_features();
        $this->register_menus();
    }

    
    public function register_features() {

       // This theme uses post thumbnails
        add_theme_support('post-thumbnails');
        add_image_size('post-thumbnail', 610, 193, true);
        add_image_size('single-thumbnail', 800, 220, true);
        add_image_size('post-thumbnail-fix', 800, 220, true);
        add_image_size('post-thumbnail-full', 1170, 340, true);
    }

    public function register_menus() {

        register_nav_menus(array(
            'primary' => __('Top Main Menu', 'fusedpress'),
            'footer-menu-1' => __('Footer Navigation1', 'magzine-footer1'),
            'footer-menu-2' => __('Footer Navigation2', 'magzine-footer2'),
            'footer-menu-3' => __('Footer Navigation3', 'magzine-footer3'),
            
        ));
    }

    public function register_widget() {

        register_sidebar(array(
            'name' => __('Widget Area', 'fusedpress'),
            'id' => 'sidebar',
            'before_widget' => '<li id="%1$s" class="widget %2$s">',
            'after_widget' => "</li>",
            'before_title' => '<h3 class="widget-title"><span>',
            'after_title' => '</span></h3>',
        ));
         
       register_sidebar(array(
            'name' => __('Footer Section', 'fusedpress'),
            'id' => 'footer-section',
            'description' => __('An optional widget area for your site footer drag available widget here.', 'fusedpress'),
            'before_widget' => '<li id="%1$s" class="widget %2$s clearfix">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

    }
   

    public function load_fonts() {
        wp_register_style('google-font1', 'http://fonts.googleapis.com/css?family=PT+Sans', array(), false, 'screen'); // register the stylesheet
        wp_enqueue_style('google-font1'); // print the stylesheet into page
     
    }

    public function load_css() {
        $template_dir=$this->template_dir_url;
        wp_enqueue_style('bootstrap-css', $template_dir . '/assets/css/bootstrap.css');
        wp_enqueue_style('fused-css', $template_dir . '/assets/css/fused.css');
        wp_enqueue_style('bootstrap-responsive-css', $template_dir . '/assets/css/bootstrap-responsive.css');
       
    }
    
    public function load_icons(){
        $template_dir=$this->template_dir_url;
   ?>
        
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $template_dir;?>/assets/ico/apple-touch-icon-144-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $template_dir;?>/assets/ico/apple-touch-icon-114-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $template_dir;?>/assets/ico/apple-touch-icon-72-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" href="<?php echo $template_dir;?>/assets/ico/apple-touch-icon-57-precomposed.png" />
    <link rel="shortcut icon" href="<?php echo $template_dir;?>/assets/ico/favicon.png" />
    <?php
    
    }

    public function load_js() {
        $template_dir = $this->template_dir_url;
        
        wp_enqueue_script('bootstrap', $template_dir . '/assets/js/bootstrap.min.js', array('jquery'));
        wp_enqueue_script('fused-js', $template_dir . '/assets/js/theme.js', array('jquery','bootstrap'));
        if(is_singular())
            wp_enqueue_script ('comment-reply');
    }

 }

BlogfusedThemeHelper::get_instance(); //instantiate the helper which will setup the theme in turn


/**
 * Fused Featured Image
 * 
 * Show / Hide featured image with url on the basis of
 *  theme option
 */
function blogfused_get_featured_image() {
       $show_featured = blogfused_get_option('show_featured_image');
       
         if ($show_featured){
          
             the_post_thumbnail('single-thumbnail');

        }
    }
/**
 * Fused Featured Image With Url
 * 
 * Show / Hide featured image with url on the basis of
 * theme option
 */
function blogfused_get_featured_image_with_url() {

    $show_featured = blogfused_get_option('show_featured_image');
    if($show_featured){
           
                $post_permalink = get_permalink();
                $large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), '$featured_image');
                echo '<a href="' . $post_permalink . '" data-src="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" >';
                        the_post_thumbnail('post-thumbnail');
                echo '</a>';

    }
}
/**
 * Get Theme Option
 * 
 * This function is used to get theme 
 * option selected by user from wp admin
 * @param type $option
 * @return type 
 */
function blogfused_get_option($option) { 
  $settings = get_option('blogfused');
   if(isset($settings[$option]))
       return $settings[$option];
   
   return false;//if empty return false
    
}
/**
 *  get comment template
 * 
 * Show / Hide comment template on the basis of
 * theme option
 */
function blogfused_get_comment_template() {

    $show_comment = blogfused_get_option('show_comment');
    $show_comment ? comments_template('', true) : false;
}


/**
 * Headline Function 
 * 
 * get the title head line for every page 
 * and posts using meta box page head line 
 * from admin post section
 */

function blogfused_the_headline(){
      global $post;
    
     if(is_category()):
          printf(__('Category Archives: %s', 'fused'), '<span>' . single_cat_title('', false) . '</span>');
      
      elseif(is_search()):
          printf( __( 'Search Results for: %s', 'fused' ), '<span>' . get_search_query() . '</span>' );
      elseif(is_archive()):
          if(is_day()):
              printf(__('Daily Archives: %s', 'fused'), '<span>' . get_the_date() . '</span>');
          elseif(is_month()):
              printf(__('Monthly Archives: %s', 'fused'), '<span>' . get_the_date(_x('F Y', 'monthly archives date format', 'fused')) . '</span>'); 
          elseif(is_year()):
              printf(__('Yearly Archives: %s', 'fused'), '<span>' . get_the_date(_x('Y', 'yearly archives date format', 'fused')) . '</span>');
         
          else:
               _e('Blog Archives', 'fused');
          endif;
       
      elseif(is_singular()):
              
            echo get_the_title($post->ID);
        
       endif; 
    
    
}

/*
* Get Pagination
*/

    function blogfused_get_pagination() {

        global $wp_query;
        $total = $wp_query->max_num_pages;

        if ($total > 1) {

         // get the current page
            if (!$current_page = get_query_var('paged'))
                $current_page = 1;
            $perma_struct = get_option('permalink_structure');
            $format = empty($perma_struct) ? '&page=%#%' : 'page/%#%/';
            echo'<div class="pagination">';
            echo paginate_links(array(
                'base' => get_pagenum_link(1) .
                '%_%',
                'format' => $format,
                'current' => $current_page,
                'total' => $total,
                'mid_size' => 4,
                'type'=>'list'
            ));
            echo'</div>';
        }
    }
/**
*
* @return type 
*/
   function blogfused_get_breadcrumbs_args() {
       
       return array('before' => false, 'separator' => '>');
    } 
    
    
  /**
 * Generates the html for comment
 * @param type $comment
 * @param type $args
 * @param type $depeth 
 */
   
 function blogfused_comment_format($comment,$args,$depth){
    
        $GLOBALS['comment']= $comment;
        $comment_class='';
        if($comment->comment_approved=='0')
            $comment_class='comment-pending';
 ?>
        
 <li <?php comment_class($comment_class); ?> id="li-comment-<?php comment_ID() ?>">
            
<article id="comment-<?php comment_ID(); ?>" class="comment">
            <div class="comment-author">
                    <?php echo get_avatar($comment,32);?>
            </div><!-- comment author end here -->
            <div class="comment-data">
                    <div class="author-meta">
                        <?php  printf('<span class="fn">%s</span>',get_comment_author_link());?>
                        <span class="comment-time">
                            <a href="<?php echo esc_url(get_comment_link($comment->comment_ID));?>">
                            <?php echo blogfused_get_time_diff(strtotime($comment->comment_date),current_time('timestamp')); ?>
                            </a>
                        </span>
                    </div>
                    <div class="comment-body">
                        <?php comment_text();?> 
                    </div>
                    <div class="meta">
                        <?php edit_comment_link(__('Edit','bpmagic'),'');?>
                    </div>
                    <div class="reply">
                            <?php echo blogfused_get_comment_reply_link(array_merge($args,array('depth'=>$depeth,'max_depth'=>$args['max_depth'])));?>  
                    </div><!-- reply end here -->
            </div><!-- comment data end here -->
    <?php if($comment->comment_approved=='0'):?>
            <span class="comment-awaiting"><?php _e('your comment is awaiting approval!','bpmagic');?></span>
    <?php endif;?> 

</article><!-- comment end here -->
<?php 
}

/**
 * A slightly modified version of Jason's time diff function
 * get the time diff as human readable
 * @param type $from integer timestamp
 * @param type $to integer timestamp
 * @return type 
 *
 * @url <http://www.jasonbobich.com/wordpress/a-better-way-to-add-time-ago-to-your-wordpress-theme/>
 */
function blogfused_get_time_diff($from,$to) {
 
     // Array of time period chunks
	$chunks = array(
		array( 60 * 60 * 24 * 365 , __( 'year', 'bpmagic' ), __( 'years', 'bpmagic' ) ),
		array( 60 * 60 * 24 * 30 , __( 'month', 'bpmagic' ), __( 'months', 'bpmagic' ) ),
		array( 60 * 60 * 24 * 7, __( 'week', 'bpmagic' ), __( 'weeks', 'bpmagic' ) ),
		array( 60 * 60 * 24 , __( 'day', 'bpmagic' ), __( 'days', 'bpmagic' ) ),
		array( 60 * 60 , __( 'hour', 'bpmagic' ), __( 'hours', 'bpmagic' ) ),
		array( 60 , __( 'minute', 'bpmagic' ), __( 'minutes', 'bpmagic' ) ),
		array( 1, __( 'second', 'bpmagic' ), __( 'seconds', 'bpmagic' ) )
	);
 
	
 
	$current_time =$to;
	$newer_date =$to;// strtotime( $current_time );
 
	// Difference in seconds
	$since = $newer_date - $from;
 
	// Something went wrong with date calculation and we ended up with a negative date.
	if ( 0 > $since )
		return __( 'sometime', 'bpmagic' );
 
	/**
	 * We only want to output one chunks of time here, eg:
	 * x years
	 * xx months
	 * so there's only one bit of calculation below:
	 */
 
	//Step one: the first chunk
	for ( $i = 0, $j = count($chunks); $i < $j; $i++) {
		$seconds = $chunks[$i][0];
 
		// Finding the biggest chunk (if the chunk fits, break)
		if ( ( $count = floor($since / $seconds) ) != 0 )
			break;
	}
 
	// Set output var
	$output = ( 1 == $count ) ? '1 '. $chunks[$i][1] : $count . ' ' . $chunks[$i][2];
 
 
	if ( !(int)trim($output) ){
		$output = '0 ' . __( 'seconds', 'bpmagic' );
	}
 
	$output .= __(' ago', 'bpmagic');
 
	return $output;
}

/**
 * Retrieve HTML content for reply to comment link.
 * a copy of get_comment_reply_link
 * The default arguments that can be override are 'add_below', 'respond_id',
 * 'reply_text', 'login_text', and 'depth'. The 'login_text' argument will be
 * used, if the user must log in or register first before posting a comment. The
 * 'reply_text' will be used, if they can post a reply. The 'add_below' and
 * 'respond_id' arguments are for the JavaScript moveAddCommentForm() function
 * parameters.
 *
 * @since 2.7.0
 *
 * @param array $args Optional. Override default options.
 * @param int $comment Optional. Comment being replied to.
 * @param int $post Optional. Post that the comment is going to be displayed on.
 * @return string|bool|null Link to show comment form, if successful. False, if comments are closed.
 */
function blogfused_get_comment_reply_link($args = array(), $comment = null, $post = null) {
	global $user_ID;

	$defaults = array('add_below' => 'comment', 'respond_id' => 'respond', 'reply_text' => __('Reply'),
		'login_text' => __('Log in to Reply'), 'depth' => 0, 'before' => '', 'after' => '');

	$args = wp_parse_args($args, $defaults);

	if ( 0 == $args['depth'] || $args['max_depth'] <= $args['depth'] )
		return;

	extract($args, EXTR_SKIP);

	$comment = get_comment($comment);
	if ( empty($post) )
		$post = $comment->comment_post_ID;
	$post = get_post($post);

	if ( !comments_open($post->ID) )
		return false;

	$link = '';

	if ( get_option('comment_registration') && !$user_ID )
		$link = '<a rel="nofollow" class="btn btn-mini btn-info comment-reply-login" href="' . esc_url( wp_login_url( get_permalink() ) ) . '">' . $login_text . '</a>';
	else
		$link = "<a class='btn btn-mini btn-info comment-reply-link' href='" . esc_url( add_query_arg( 'replytocom', $comment->comment_ID ) ) . "#" . $respond_id . "' onclick='return addComment.moveForm(\"$add_below-$comment->comment_ID\", \"$comment->comment_ID\", \"$respond_id\", \"$post->ID\")'>$reply_text</a>";
	return apply_filters('comment_reply_link', $before . $link . $after, $args, $comment, $post);
}

/**
 * a copy of comment_form()
 * 
 * Outputs a complete commenting form for use within a template.
 * Most strings and form fields may be controlled through the $args array passed
 * into the function, while you may also choose to use the comment_form_default_fields
 * filter to modify the array of default fields if you'd just like to add a new
 * one or remove a single field. All fields are also individually passed through
 * a filter of the form comment_form_field_$name where $name is the key used
 * in the array of fields.
 *
 * @since 3.0.0
 * @param array $args Options for strings, fields etc in the form
 * @param mixed $post_id Post ID to generate the form for, uses the current post if null
 * @return void
 */
function blogfused_comment_form( $args = array(), $post_id = null ) {
	global $id;

	if ( null === $post_id )
		$post_id = $id;
	else
		$id = $post_id;

	$commenter = wp_get_current_commenter();
	$user = wp_get_current_user();
	$user_identity = $user->exists() ? $user->display_name : '';

	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$fields =  array(
		'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
		            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
		'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
		            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
		'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website' ) . '</label>' .
		            '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
	);

	$required_text = sprintf( ' ' . __('Required fields are marked %s'), '<span class="required">*</span>' );
	$defaults = array(
		'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
		'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><textarea class="span10" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
		'must_log_in'          => '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.' ) . ( $req ? $required_text : '' ) . '</p>',
		'comment_notes_after'  => '<p class="form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ), ' <code>' . allowed_tags() . '</code>' ) . '</p>',
		'id_form'              => 'commentform',
		'id_submit'            => 'submit',
		'title_reply'          => __( 'Leave a Reply' ),
		'title_reply_to'       => __( 'Leave a Reply to %s' ),
		'cancel_reply_link'    => __( 'Cancel reply' ),
		'label_submit'         => __( 'Post Comment' ),
	);

	$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

	
       if ( comments_open( $post_id ) ) : 
                 do_action( 'comment_form_before' ); ?>
            <div id="respond">
                    <h3 id="reply-title"><?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?> <small><?php echo blogfused_get_cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></small></h3>
                    <?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
                            <?php echo $args['must_log_in']; ?>
                            <?php do_action( 'comment_form_must_log_in_after' ); ?>
                    <?php else : ?>
                          <form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>">
                                <?php do_action( 'comment_form_top' ); ?>
                                    <?php if ( is_user_logged_in() ) : ?>
                                            <div class="row-fluid comment-notes-logged-in">
                                                <div class="span1">
                                                    <?php echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity ); ?>
                                                    <?php do_action( 'comment_form_logged_in_after', $commenter, $user_identity ); ?>
                                                </div>
                                                <div class="span11">
                                                        <?php echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); ?>
                                                </div>
                                            </div>

                                    <?php else : ?>
                                            <div class="row-fluid comment-notes comment-notes-top">
                                                <?php echo $args['comment_notes_before']; ?>
                                            </div>
                                    <div class="row-fluid">
                                            <div class="controls">
                                                <div class="span4">
                                                    <?php
                                                            do_action( 'comment_form_before_fields' );
                                                            foreach ( (array) $args['fields'] as $name => $field ) {
                                                                    echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
                                                            }
                                                            do_action( 'comment_form_after_fields' );
                                                            ?>
                                                </div> 
                                                <div class="span8">
                                                    <?php echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); ?>
                                                </div>
                                            </div>
                                    </div>   
                                    <?php endif; ?>
                                    <div class="row-fluid comment-notes comment-notes-bottom">
                                        <?php echo $args['comment_notes_after']; ?>
                                    </div>   
                                    <div class="row-fluid">
                                         <p class="form-submit pull-right">
                                            <input name="submit" class='btn btn-success' type="submit" id="<?php echo esc_attr( $args['id_submit'] ); ?>" value="<?php echo esc_attr( $args['label_submit'] ); ?>" />
                                            <?php comment_id_fields( $post_id ); ?>
                                        </p>
                                    </div>    
                                    <?php do_action( 'comment_form', $post_id ); ?>
                            </form>
                    <?php endif; ?>
            </div><!-- #respond -->
            <?php do_action( 'comment_form_after' ); 
        else :
             do_action( 'comment_form_comments_closed' ); 
    endif; 
        
}
/**
 * Retrieve HTML content for cancel comment reply link.
 *
 * @since 2.7.0
 *
 * @param string $text Optional. Text to display for cancel reply link.
 */
function blogfused_get_cancel_comment_reply_link($text = '') {
	if ( empty($text) )
		$text = __('Click here to cancel reply.');

	$style = isset($_GET['replytocom']) ? '' : ' style="display:none;"';
	$link = esc_html( remove_query_arg('replytocom') ) . '#respond';
	return apply_filters('cancel_comment_reply_link', '<a rel="nofollow" class="btn btn-mini btn-inverse" id="cancel-comment-reply-link" href="' . $link . '"' . $style . '>' . $text . '</a>', $link, $text);
}


/**
 * get theme menu on the basis of theme location
 * 
 * @link http://www.andrewgail.com/getting-a-menu-name-in-wordpress/
 * @param type $theme_location
 * @return boolean 
 */
function blogfused_get_theme_menu($theme_location) {
	if( ! $theme_location ) return false;
 
	$theme_locations = get_nav_menu_locations();
	if( ! isset( $theme_locations[$theme_location] ) ) return false;
 
	$menu_obj = get_term( $theme_locations[$theme_location], 'nav_menu' );
	if( ! $menu_obj ) $menu_obj = false;
 
	return $menu_obj;
}

/**
 * get theme menu name 
 * 
 * @link http://www.andrewgail.com/getting-a-menu-name-in-wordpress/
 * @param type $theme_location
 * @return boolean 
 */
function blogfused_get_theme_menu_name($theme_location) {
	if( ! $theme_location ) return false;
 
	$menu_obj = blogfused_get_theme_menu( $theme_location );
	if( ! $menu_obj ) return false;
 
	if( ! isset( $menu_obj->name ) ) return false;
 
	return $menu_obj->name;
}
?>