<?php
/*
 * Require the framework class before doing anything else, so we can use the defined urls and dirs
 * Also if running on windows you may have url problems, which can be fixed by defining the framework url first
 *
 */
//define('NHP_OPTIONS_URL', site_url('path the options folder'));
if (!class_exists('NHP_Options')) {
    require_once( dirname(__FILE__) . '/options/options.php' );
}

/*
 * 
 * Custom function for filtering the sections array given by theme, good for child themes to override or add to the sections.
 * Simply include this function in the child themes functions.php file.
 *
 * NOTE: the defined constansts for urls, and dir will NOT be available at this point in a child theme, so you must use
 * get_template_directory_uri() if you want to use any of the built in icons
 *
 */

function add_another_section($sections) {

//$sections = array();
    $sections[] = array(
        'title' => __('A Section added by hook', 'nhp-opts'),
        'desc' => __('<p class="description">This is a section created by adding a filter to the sections array, great to allow child themes, to add/remove sections from the options.</p>', 'nhp-opts'),
//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
//You dont have to though, leave it blank for default.
        'icon' => trailingslashit(get_template_directory_uri()) . 'options/img/glyphicons/glyphicons_062_attach.png',
//Lets leave this as a blank section, no options just some intro text set above.
        'fields' => array()
    );

    return $sections;
}

/*
 * 
 * Custom function for filtering the args array given by theme, good for child themes to override or add to the args array.
 *
 */

function change_framework_args($args) {

//$args['dev_mode'] = false;

    return $args;
}


/*
 * This is the meat of creating the optons page
 *
 * Override some of the default values, uncomment the args and change the values
 * - no $args are required, but there there to be over ridden if needed.
 *
 *
 */

function setup_framework_options() {
    $args = array();

//Set it to dev mode to view the class settings/info in the form - default is false
    $args['dev_mode'] = false;

//google api key MUST BE DEFINED IF YOU WANT TO USE GOOGLE WEBFONTS
//$args['google_api_key'] = '***';
//Remove the default stylesheet? make sure you enqueue another one all the page will look whack!
//$args['stylesheet_override'] = true;
//Add HTML before the form
    

//Setup custom links in the footer for share icons
    $args['share_icons']['facebook'] = array(
        'link' => 'https://www.facebook.com/bpdev',
        'title' => 'Folow me on Facebook',
        'img' => NHP_OPTIONS_URL . 'img/glyphicons/glyphicons_320_facebook.png'
    );
    $args['share_icons']['twitter'] = array(
        'link' => 'https://twitter.com/buddydev',
        'title' => 'Folow me on Twitter',
        'img' => NHP_OPTIONS_URL . 'img/glyphicons/glyphicons_322_twitter.png'
    );
    $args['share_icons']['linked_in'] = array(
        'link' => ' http://in.linkedin.com/in/brajeshsingh',
        'title' => 'Find me on LinkedIn',
        'img' => NHP_OPTIONS_URL . 'img/glyphicons/glyphicons_337_linked_in.png'
    );
    $args['share_icons']['github'] = array(
        'link' => 'https://github.com/sbrajesh',
        'title' => 'Find me on Github',
        'img' => NHP_OPTIONS_URL . 'img/glyphicons/glyphicons_341_github.png'
    );

//Choose to disable the import/export feature
//$args['show_import_export'] = false;
//Choose a custom option name for your theme options, the default is the theme name in lowercase with spaces replaced by underscores
    $args['opt_name'] = 'blogfused';

//Custom menu icon
//$args['menu_icon'] = '';
//Custom menu title for options page - default is "Options"
    $args['menu_title'] = __('Theme Options', 'nhp-opts');

//Custom Page Title for options page - default is "Options"
    $args['page_title'] = __('Blog Theme Options', 'nhp-opts');

//Custom page slug for options page (wp-admin/themes.php?page=***) - default is "nhp_theme_options"
    $args['page_slug'] = 'fused_theme_options';

//Custom page capability - default is set to "manage_options"
//$args['page_cap'] = 'manage_options';
//page type - "menu" (adds a top menu section) or "submenu" (adds a submenu) - default is set to "menu"
    $args['page_type'] = 'submenu';

//parent menu - default is set to "themes.php" (Appearance)
//the list of available parent menus is available here: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    $args['page_parent'] = 'themes.php';

//custom page location - default 100 - must be unique or will override other items
    $args['page_position'] = 27;

//Custom page icon class (used to override the page icon next to heading)
//$args['page_icon'] = 'icon-themes';
//Want to disable the sections showing as a submenu in the admin? uncomment this line
//$args['allow_sub_menu'] = false;
//Set ANY custom page help tabs - displayed using the new help tab API, show in order of definition		
    $args['help_tabs'][] = array(
        'id' => 'nhp-opts-1',
        'title' => __('Theme Information 1', 'nhp-opts'),
        'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'nhp-opts')
    );


//Set the Help Sidebar for the options page - no sidebar by default										
    $args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'nhp-opts');



    $sections = array();

    $sections[] = array(
        'title' => __('General Setting'),
        'desc' => __('<p class="description">Here is <b>general settings</b> work globally.</p>', 'nhp-opts'),
        'icon' => NHP_OPTIONS_URL . 'img/glyphicons/glyphicons_119_adjust.png',
        'fields' => array(
                
               array(
                    'id'=>'header_scripts',
                    'type'=>'textarea',
                    'title'=>__('Header Scripts','nhp-opts'),
                    'desc'=>__('Add <b>header script</b> code here.','nhp-opts')
                ),
            
              array(
                    'id' => 'show_featured_image',
                    'type' => 'select',
                    'title' => __('Featured Image', 'nhp-opts'),
                    'desc' => __('<p class="description">Select option to <b> show/hide featured image</b>.</p>', 'nhp-opts'),
                    'options' => array(
                        '1' => __('Show', 'nhp-opts'),
                        '0' => __('Hide', 'nhp-opts')
                    ),
                    'std' => '1'
                ),
            
             array(
                'id' => 'show_comment',
                'type' => 'select',
                'title' => __('Comments', 'nhp-opts'),
                'desc' => __('<p class="description">Select option to <b>allow comments</b>.</p>', 'nhp-opts'),
                'options' => array(
                    '1' => __('Show', 'nhp-opts'),
                    '0' => __('Hide', 'nhp-opts')
                ),
                'std' => '1'
            )
        ));

   
      $sections[] = array(
		'title' => __('Layout', 'nhp-opts'),
		'desc' => __('<p class="description">Please select a <b>layout</b> for your site.</p>', 'nhp-opts'),
		'icon' => NHP_OPTIONS_URL . 'img/glyphicons/glyphicons_111_align_center.png',
		'fields' => array(
		    array(
		        'id' => 'theme_layout',
		        'type' => 'radio_img',
		        'title' => __('Select Layout', 'nhp-opts'),
		        'desc' => __('You can choose <b>2 column(right or left sidebar) </b> or <b>single cloumn</b> layout.', 'nhp-opts'),
		        'options' => array(
                            'two-col-right' => array('title' => '2 Column Right', 'img' => NHP_OPTIONS_URL . 'img/2cr.png'),
		            'two-col-left' => array('title' => '2 Column Left', 'img' => NHP_OPTIONS_URL . 'img/2cl.png')
		        ), //Must provide key => value(array:title|img) pairs for radio options
		        'std' => 'two-col-right'
		    ),
		   
            ));

           

 $sections[] = array(
        'title' => __('Typography', 'nhp-opts'),
        'desc' => __('<p class="description">Typograpty settings section</p>', 'nhp-opts'),
        'icon' => NHP_OPTIONS_URL . 'img/glyphicons/glyphicons_030_pencil.png',
        'fields' => array(
            array(
                'id' => 'font_family',
                'type' => 'font_family_select', //doesnt need to be called for callback fields
                'title' => __('Fonts Family', 'nhp-opts'),
                
            ),
            array(
                'id' => 'font_size',
                'type' => 'font_size_select',
                'title' => __('Font Size', 'nhp-opts'),
               
               
                ),
            array(
                'id' => 'font_style',
                'type' => 'font_style_select',
                'title' => __('Font Style', 'nhp-opts'),
                
            ),
            array(
                'id' => 'line_height',
                'type' => 'text',
                'title' => __('Line Height', 'nhp-opts'),
               
            ),
            array(
                'id' => 'heading_font_family',
                'type' => 'font_family_select', //doesnt need to be called for callback fields
                'title' => __('Heading Fonts', 'nhp-opts'),
                
            ),
            array(
                'id' => 'h1_style',
                'type' => 'text',
                'title' => __('H1 Size', 'nhp-opts'),
                
            ),
            array(
                'id' => 'h2_style',
                'type' => 'text',
                'title' => __('H2 Size', 'nhp-opts'),
               
            ),
            array(
                'id' => 'h3_style',
                'type' => 'text',
                'title' => __('H3 Size', 'nhp-opts'),
               
            ),
            array(
                'id' => 'h4_style',
                'type' => 'text',
                'title' => __('H4 Size', 'nhp-opts'),
               
            ),
            array(
                'id' => 'h5_style',
                'type' => 'text',
                'title' => __('H5 Size', 'nhp-opts'),
               
            ),
            array(
                'id' => 'h6_style',
                'type' => 'text',
                'title' => __('H6 Size', 'nhp-opts'),
                
            )
            ));
    

    $sections[] = array(
        'title' => __('Color', 'nhp-opts'),
        'desc' => __('<p class="description">Color settings for different/different section.</p>', 'nhp-opts'),
        'icon' => NHP_OPTIONS_URL . 'img/glyphicons/glyphicons_021_snowflake.png',
        'fields' => array(
            array(
                'id' => 'post_color',
                'type' => 'color',
                'title' => __('Posts Title Color', 'nhp-opts'),
               
            ),
            array(
                'id' => 'page_title_color',
                'type' => 'color',
                'title' => __('Pages Title Color', 'nhp-opts'),
               
            ),
	    array(
                'id' => 'page_title_color_hover',
                'type' => 'color',
                'title' => __('Pages Title Color Hover', 'nhp-opts'),
                
            ),
            array(
                'id' => 'date_comment_color',
                'type' => 'color',
                'title' => __('Comment/ Date Color', 'nhp-opts'),
               
            ),
            array(
                'id' => 'text_color',
                'type' => 'color',
                'title' => __('Body Text Color', 'nhp-opts'),
               
            ),
            array(
                'id' => 'header_bgcolor',
                'type' => 'color',
                'title' => __('Header Background', 'nhp-opts'),
                
            ),
            array(
                'id' => 'body_background',
                'type' => 'color',
                'title' => __('Body Background', 'nhp-opts'),
                
            ),
            array(
                'id' => 'footer_background',
                'type' => 'color',
                'title' => __('Footer Background', 'nhp-opts'),
               
            ),
            array(
                'id' => 'heading_color',
                'type' => 'color',
                'title' => __('Heading Color(H1,H2,H3,H4......H6)', 'nhp-opts'),
               
            ),
            array(
                'id' => 'sidebar_link_color',
                'type' => 'color',
                'title' => __('Sidebar Link Color', 'nhp-opts'),
                
            ),
            array(
                'id' => 'footer_link_color',
                'type' => 'color',
                'title' => __('Footer Link Color', 'nhp-opts'),
               
            ),
            array(
                'id' => 'readmore_color',
                'type' => 'color',
                'title' => __('Readmore Color', 'nhp-opts'),
                
            ),
            array(
                'id' => 'readmore_color_hover',
                'type' => 'color',
                'title' => __('Readmore Color Hover Background', 'nhp-opts'),
               
            ),
            ));


    $sections[] = array(
        'title' => __('Social Setting', 'nhp-opts'),
        'desc' => __('<p class="description">Social setting section in footer</p>', 'nhp-opts'),
        'icon' => NHP_OPTIONS_URL . 'img/glyphicons/glyphicons_073_signal.png',
        'fields' => array(
            
            
           array(
                'id' => 'twitter_link',
                'type' => 'text',
                'title' => __('Twitter Link', 'nhp-opts'),
                'link' => 'link url',
                'url' => 'http://www.twitter.com',
                'desc' => '<br/>Add <b>twitter</b> profile link',
                'sub_desc' => __('for ex  http://www.twitter.com ', 'nhp-opts'),
                'img' => 'img url'
            ),
           
            array(
                'id' => 'facebook_link',
                'type' => 'text',
                'title' => __('Facebook Url', 'nhp-opts'),
                'url' => 'http://www.facebook.com',
                'desc' => '<br/>Add <b>facebook</b> profile link',
                'sub_desc' => __('for ex  http://www.facebook.com', 'nhp-opts'),
                'img' => 'img url'
            ),
            array(
                'id' => 'flicker_link',
                'type' => 'text',
                'title' => __('Ficker Url', 'nhp-opts'),
                'url' => 'http://www.flicker.com',
                'desc' => '<br/>Add <b>flicker</b> profile link',
                'sub_desc' => __('for ex  http://www.flicker.com', 'nhp-opts'),
                'img' => 'img url'
            )
          
    ));
    
   $sections[] = array(
        'title' => __('Footer Setting', 'nhp-opts'),
        'desc' => __('<p class="description">Footer setting section</p>', 'nhp-opts'),
        'icon' => NHP_OPTIONS_URL . 'img/glyphicons/glyphicons_151_edit.png',
        'fields' => array(
                
              array(
                        'id' => 'footer_show',
                        'type' => 'select',
                        'title' => __('Footer Section', 'nhp-opts'),
                        'desc' => __('<p class="description">Select option to show <b>footer content area</b>.</p>', 'nhp-opts'),
                        'options' => array(
                            '1' => __('Show', 'nhp-opts'),
                            '0' => __('Hide', 'nhp-opts')
                        ),
                        'std' => '1'
                        ),
               
               
                array(
                    'id' => 'copyright_text',
                    'type' => 'textarea',
                    'title' => __('Copyright Text', 'nhp-opts'),
                    'desc' => __('Add <b>copyright text</b> for footer.', 'nhp-opts'),
                    'std' => __('<p class="alignleft">Copyright © 2013 fusedpress. All rights reserved .</p>'
                                    , 'nhp-opts')
                )
           
            ));
    
    $sections[] = array(
        'title' => __('Google Analytics Setting', 'nhp-opts'),
        'desc' => __('<p class="description">Here is setting for adding <b>google analytics code</b> in footer. HTML is allowed</p>', 'nhp-opts'),
        'icon' => NHP_OPTIONS_URL . 'img/glyphicons/glyphicons_362_google+_alt.png',
        'fields' => array(
            array(
                'id' => 'analytical_code',
                'type' => 'textarea',
                'title' => __('Analytics Code', 'nhp-opts'),
                'desc' => __('<p class="description">Add <b>google analytics code</b> here.</p>', 'nhp-opts')
            )
            ));
    
    
       



    $tabs = array();

    if (function_exists('wp_get_theme')) {
        $theme_data = wp_get_theme();
        $theme_uri = $theme_data->get('ThemeURI');
        $description = $theme_data->get('Description');
        $author = $theme_data->get('Author');
        $version = $theme_data->get('Version');
        $tags = $theme_data->get('Tags');
    } else {
        $theme_data = get_theme_data(trailingslashit(get_stylesheet_directory()) . 'style.css');
        $theme_uri = $theme_data['URI'];
        $description = $theme_data['Description'];
        $author = $theme_data['Author'];
        $version = $theme_data['Version'];
        $tags = $theme_data['Tags'];
    }

    $theme_info = '<div class="nhp-opts-section-desc">';
    $theme_info .= '<p class="nhp-opts-theme-data description theme-uri">' . __('<strong>Theme URL:</strong> ', 'nhp-opts') . '<a href="' . $theme_uri . '" target="_blank">' . $theme_uri . '</a></p>';
    $theme_info .= '<p class="nhp-opts-theme-data description theme-author">' . __('<strong>Author:</strong> ', 'nhp-opts') . $author . '</p>';
    $theme_info .= '<p class="nhp-opts-theme-data description theme-version">' . __('<strong>Version:</strong> ', 'nhp-opts') . $version . '</p>';
    $theme_info .= '<p class="nhp-opts-theme-data description theme-description">' . $description . '</p>';
    $theme_info .= '<p class="nhp-opts-theme-data description theme-tags">' . __('<strong>Tags:</strong> ', 'nhp-opts') . implode(', ', $tags) . '</p>';
    $theme_info .= '</div>';



    $tabs['theme_info'] = array(
        'icon' => NHP_OPTIONS_URL . 'img/glyphicons/glyphicons_195_circle_info.png',
        'title' => __('Theme Information', 'nhp-opts'),
        'content' => $theme_info
    );

    if (file_exists(trailingslashit(get_stylesheet_directory()) . 'README.html')) {
        $tabs['theme_docs'] = array(
            'icon' => NHP_OPTIONS_URL . 'img/glyphicons/glyphicons_071_book.png',
            'title' => __('Documentation', 'nhp-opts'),
            'content' => nl2br(file_get_contents(trailingslashit(get_stylesheet_directory()) . 'README.html'))
        );
    }//if

    global $NHP_Options;
    $NHP_Options = new NHP_Options($sections, $args, $tabs);
}

//function
add_action('init', 'setup_framework_options', 0);

/*
 * 
 * Custom function for the callback referenced above
 *
 */

function my_custom_field($field, $value) {
    print_r($field);
    print_r($value);
}

//function

/*
 * 
 * Custom function for the callback validation referenced above
 *
 */

function validate_callback_function($field, $value, $existing_value) {

    $error = false;
    $value = 'just testing';
    /*
      do your validation

      if(something){
      $value = $value;
      }elseif(somthing else){
      $error = true;
      $value = $existing_value;
      $field['msg'] = 'your custom error message';
      }
     */

    $return['value'] = $value;
    if ($error == true) {
        $return['error'] = $field;
    }
    return $return;
}

//function
?>
