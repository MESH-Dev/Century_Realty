<?php

add_action('init', 'register_my_menus');
add_action('init', 'loadup_scripts'); // Add Custom Scripts

function register_my_menus() {
	register_nav_menus(
		array(
			'primary-menu' => __('Primary Menu'),
			'footer-menu' => __('Footer Menu')
		)	
	);
}

 
//show_admin_bar(false);
 

function loadup_scripts()
{
    if (!is_admin()) {
        wp_deregister_script('jquery'); // Deregister WordPress jQuery
        wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js' ); // Google CDN jQuery
        wp_enqueue_script('jquery'); // Enqueue it!

        wp_register_script('slider', get_template_directory_uri() . '/js/responsiveslides.min.js'); // Custom scripts
        wp_enqueue_script('slider'); // Enqueue it!

        wp_enqueue_style('fontawesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css');
    }
}

// Add Thumbnail Theme Support
add_theme_support('post-thumbnails');
add_image_size('large', 700, '', true); // Large Thumbnail
add_image_size('medium', 250, '', true); // Medium Thumbnail
add_image_size('small', 120, '', true); // Small Thumbnail
add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

// Register Widget Area for the Sidebar
register_sidebar( array(
	'name' => __( 'Primary Widget Area', 'Sidebar' ),
	'id' => 'primary-widget-area',
	'description' => __( 'The primary widget area', 'Sidebar' ),
	'before_widget' => '<div class="box">',
	'after_widget' => '</div>',
	'before_title' => '<h1>',
	'after_title' => '</h1>',
) );

// Load Optimised Google Analytics in the footer
// Change the UA-XXXXXXXX-X to your Account ID
function add_google_analytics()
{
    $google = "<!-- Google Analytics -->";
    $google .= "<script>";
    $google .= "var _gaq=[['_setAccount','UA-XXXXXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));";
    $google .= "</script>";
    echo $google;
}

add_action('wp_footer', 'add_google_analytics'); // Google Analytics optimised in footer


/*** CLEAN UP FUNCTIONS ----------------------------------------*/
  
  /* admin part cleanups */
  add_action('admin_menu','remove_dashboard_widgets'); // cleaning dashboard widgets  
  add_action('admin_menu', 'delete_menu_items'); // deleting menu items from admin area
  add_action('admin_menu','customize_meta_boxes'); // remove some meta boxes from pages and posts edition page
  add_filter('manage_posts_columns', 'custom_post_columns'); // remove column entries from list of posts
  add_filter('manage_pages_columns', 'custom_pages_columns'); // remove column entries from list of page
  add_action('wp_before_admin_bar_render', 'wce_admin_bar_render' ); // clean up the admin bar
  add_action('widgets_init', 'unregister_default_widgets', 11); // remove widgets from the widget page
  
  /* selfish frshstart plugins code parts*/
  add_action('admin_notices','rynonuke_update_notification_nonadmins',1); // remove notification for enayone but admin
  add_action('pre_ping','rynonuke_self_pings'); // disable self-trackbacking
  add_action('admin_init','rynonuke_dolly'); // remove the hello dolly plugin
  add_filter('user_contactmethods','rynonuke_contactmethods',10,1);  // add facebook and twitter account to user profil

  /* Add admin custom actions styles*/
    //add_action('login_head', 'style_my_login_please'); // add a custom css for the login form
    // add_action('admin_head', 'style_my_admin_please'); // add a custom css for the admin area

  
  
  
  
  /***************** Security + header clean-ups ************************/
  /** remove the wlmanifest (useless !!) */
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'rsd_link');
  remove_action( 'wp_head', 'index_rel_link' ); // index link
  remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
  remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
  // remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.
  // remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
  //remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
  remove_action('wp_head','start_post_rel_link');
  remove_action('wp_head','adjacent_posts_rel_link_wp_head');
  remove_action('wp_head', 'wp_generator'); // remove WP version from header
  remove_action('wp_head','wp_shortlink_wp_head');
  remove_filter( 'the_content', 'capital_P_dangit' ); // Get outta my Wordpress codez dangit!
  remove_filter( 'the_title', 'capital_P_dangit' );
  remove_filter( 'comment_text', 'capital_P_dangit' );

  // removes detailed login error information for security
  add_filter('login_errors',create_function('$a', "return null;")); 
  /**---------------------------------------------------------------------------------------------------*/    
  
 




 /* Here come my different fonctions 
  * 
  * 
  * */
  
/*** cleaning up the dashboard- ----------------------------------------*/
function remove_dashboard_widgets(){
  
  //remove_meta_box('dashboard_right_now','dashboard','core'); // right now overview box
  remove_meta_box('dashboard_incoming_links','dashboard','core'); // incoming links box
  //remove_meta_box('dashboard_quick_press','dashboard','core'); // quick press box
  remove_meta_box('dashboard_plugins','dashboard','core'); // new plugins box
  //remove_meta_box('dashboard_recent_drafts','dashboard','core'); // recent drafts box
  remove_meta_box('dashboard_recent_comments','dashboard','core'); // recent comments box
  remove_meta_box('dashboard_primary','dashboard','core'); // wordpress development blog box
  remove_meta_box('dashboard_secondary','dashboard','core'); // other wordpress news box
    
  
} 

/*----------------------------------------------------------------------*/


/* Remove some menus froms the admin area*/
function delete_menu_items() {
  
  /*** Remove menu http://codex.wordpress.org/Function_Reference/remove_menu_page 
  syntaxe : remove_menu_page( $menu_slug )  **/
  //remove_menu_page('index.php'); // Dashboard
  remove_menu_page('edit.php'); // Posts
  //remove_menu_page('upload.php'); // Media
  remove_menu_page('link-manager.php'); // Links
  //remove_menu_page('edit.php?post_type=page'); // Pages
  remove_menu_page('edit-comments.php'); // Comments
  //remove_menu_page('themes.php'); // Appearance
  //remove_menu_page('plugins.php'); // Plugins
  //remove_menu_page('users.php'); // Users
  //remove_menu_page('tools.php'); // Tools
  //remove_menu_page('options-general.php'); // Settings
    
    
    
  /*** Remove submenu http://codex.wordpress.org/Function_Reference/remove_submenu_page 
  syntaxe : remove_submenu_page( $menu_slug, $submenu_slug ) **/
  //remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' ); // remove tags from edit
}

/*----------------------------------------------------------------------*/


/* remove some meta boxes from pages and posts -------------------------
feel free to comment / uncomment  */

function customize_meta_boxes() {
  /* Removes meta boxes from Posts */
  //remove_meta_box('postcustom','post','normal'); // custom fields metabox
  //remove_meta_box('trackbacksdiv','post','normal'); // trackbacks metabox 
  //remove_meta_box('commentstatusdiv','post','normal'); // comment status metabox 
  //remove_meta_box('commentsdiv','post','normal'); // comments  metabox 
  //remove_meta_box('postexcerpt','post','normal'); // post excerpts metabox 
  //remove_meta_box('authordiv','post','normal'); // author metabox 
  //remove_meta_box('revisionsdiv','post','normal'); // revisions  metabox 
  //remove_meta_box('tagsdiv-post_tag','post','normal'); // tags
  //remove_meta_box('slugdiv','post','normal'); // slug metabox 
  //remove_meta_box('categorydiv','post','normal'); // comments metabox
  //remove_meta_box('postimagediv','post','normal'); // featured image metabox
  //remove_meta_box('formatdiv','post','normal'); // format metabox 
  
  
  /* Removes meta boxes from pages */   
  //remove_meta_box('postcustom','page','normal'); // custom fields metabox
  remove_meta_box('trackbacksdiv','page','normal'); // trackbacks metabox
  //remove_meta_box('commentstatusdiv','page','normal'); // comment status metabox 
  //remove_meta_box('commentsdiv','page','normal'); // comments  metabox 
  remove_meta_box('authordiv','page','normal'); // author metabox 
  //remove_meta_box('revisionsdiv','page','normal'); // revisions  metabox 
  //remove_meta_box('postimagediv','page','side'); // featured image metabox
  //remove_meta_box('slugdiv','page','normal'); // slug metabox 
 
  
  
  /* remove meta boxes for links **/
  //remove_meta_box('linkcategorydiv','link','normal');
  //remove_meta_box('linkxfndiv','link','normal');
  //remove_meta_box('linkadvanceddiv','link','normal');
  
}

/*-----------------------------------------------------------------------*/





/** removing parts from column ------------------------------------------*/
/* use the column id, if you need to hide more of them
syntaxe : unset($defaults['columnID']);   */

/** remove column entries from posts **/
function custom_post_columns($defaults) {
  unset($defaults['comments']); // comments 
  unset($defaults['author']); // authors
  unset($defaults['tags']); // tag 
  //unset($defaults['date']); // date
  //unset($defaults['categories']); // categories    
  return $defaults;
}


/** remove column entries from pages **/
function custom_pages_columns($defaults) {
  unset($defaults['comments']); // comments 
  unset($defaults['author']); // authors
  unset($defaults['date']);  // date 
  return $defaults;
}

/*-----------------------------------------------------------------------**/


/** remove widgets from the widget page ------------------------------------*/
/* Credits : http://wpmu.org/how-to-remove-default-wordpress-widgets-and-clean-up-your-widgets-page/ 
uncomment what you want to remove  */
 function unregister_default_widgets() {
     // unregister_widget('WP_Widget_Pages');
     // unregister_widget('WP_Widget_Calendar');
     // unregister_widget('WP_Widget_Archives');
      unregister_widget('WP_Widget_Links');
     // unregister_widget('WP_Widget_Meta');
     // unregister_widget('WP_Widget_Search');
     // unregister_widget('WP_Widget_Text');
     // unregister_widget('WP_Widget_Categories');
     // unregister_widget('WP_Widget_Recent_Posts');
     // unregister_widget('WP_Widget_Recent_Comments');
     // unregister_widget('WP_Widget_RSS');
     // unregister_widget('WP_Widget_Tag_Cloud');
     //unregister_widget('WP_Nav_Menu_Widget');
    //unregister_widget('Twenty_Eleven_Ephemera_Widget');
 }





/****** removings items froms admin bars 
use the last part of the ID after "wp-admin-bar-" to add some menu to the list  exemple for comments : id="wp-admin-bar-comments" so the id to use is "comments"  ***********/
function wce_admin_bar_render() {
global $wp_admin_bar;
  $wp_admin_bar->remove_menu('comments'); //remove comments
  $wp_admin_bar->remove_menu('wp-logo'); //remove the whole wordpress logo, help etc part
  
}
/*-----------------------------------------------------------------------**/




/**  Other usefull cleanups from selfish fresh start plugin http://wordpress.org/extend/plugins/selfish-fresh-start/ --------------------*/

// remove update notifications for everybody except admin users
function rynonuke_update_notification_nonadmins() {
  if (!current_user_can('administrator')) 
    remove_action('admin_notices','update_nag',3);
}

// disable self-trackbacking
function rynonuke_self_pings( &$links ) {
    foreach ( $links as $l => $link )
        if ( 0 === strpos( $link, home_url() ) )
            unset($links[$l]);
}

//remove the hello dolly plugin
function rynonuke_dolly() {
    if (is_admin() && file_exists(WP_PLUGIN_DIR.'/hello.php'))
  @unlink(WP_PLUGIN_DIR.'/hello.php');

}
/*----------------------------------------------------------------------- **/



/** WordPress user profil cleanups  ------------------------------------*/
  
/* remove the color scheme options */
  function admin_color_scheme() {
   global $_wp_admin_css_colors;
   $_wp_admin_css_colors = 0;
}

// add_action('admin_head', 'admin_color_scheme');

// rem/add user profile fields
function rynonuke_contactmethods($contactmethods) {
  unset($contactmethods['yim']);
  unset($contactmethods['aim']);
  unset($contactmethods['jabber']);
  $contactmethods['rynonuke_twitter']='Twitter';
  $contactmethods['rynonuke_facebook']='Facebook';
  return $contactmethods;
}


/*----------------------------------------------------------------------- **/
    
/*** Add a login stylesheet and a wordpress specific stylesheet------------
stylesheets are in the plugin directory, you can change the content to make it suite your needs. You'll also find a logo.png file, to brand the login form using your personnal logo
-----------*/

function style_my_login_please() {  
/** stylesheet link for login **/
//echo '<link rel="stylesheet" type="text/css" href="' .plugins_url( 'css/custom_login.css' , __FILE__ ). '"/>';
}

/** stylesheet link for admin **/
function style_my_admin_please() {
   // echo '<link rel="stylesheet" type="text/css" href="' .plugins_url( 'css/custom_admin.css' , __FILE__ ).'"/>';
}
 

// registration code for quotes post type
  function register_quotes_posttype() {
    $labels = array(
      'name'        => _x( 'Quotes', 'post type general name' ),
      'singular_name'   => _x( 'Quotes', 'post type singular name' ),
      'add_new'       => __( 'Add New' ),
      'add_new_item'    => __( 'Quotes' ),
      'edit_item'     => __( 'Quotes' ),
      'new_item'      => __( 'Quotes' ),
      'view_item'     => __( 'Quotes' ),
      'search_items'    => __( 'Quotes' ),
      'not_found'     => __( 'Quotes' ),
      'not_found_in_trash'=> __( 'Quotes' ),
      'parent_item_colon' => __( 'Quotes' ),
      'menu_name'     => __( 'Quotes' )
    );
    
    $taxonomies = array();

    $supports = array('title','editor');
    
    $post_type_args = array(
      'labels'      => $labels,
      'singular_label'  => __('Quotes'),
      'public'      => true,
      'show_ui'       => true,
      'publicly_queryable'=> true,
      'query_var'     => true,
      'exclude_from_search'=> false,
      'show_in_nav_menus' => false,
      'capability_type'   => 'post',
      'has_archive'     => false,
      'hierarchical'    => false,
      'rewrite'       => array('slug' => 'quotes', 'with_front' => false ),
      'supports'      => $supports,
      'menu_position'   => 5,
      'menu_icon'     => 'http://centuryequities.com/wp-content/plugins/easy-content-types//includes/images/icon.png',
      'taxonomies'    => $taxonomies
     );
     register_post_type('quotes',$post_type_args);
  }
  add_action('init', 'register_quotes_posttype');

  function ecpt_export_ui_scripts() {

  global $ecpt_options, $post;
  ?>
  <script type="text/javascript">
      jQuery(document).ready(function($)
      {

        if($('.form-table .ecpt_upload_field').length > 0 ) {
          // Media Uploader
          window.formfield = '';

          $('body').on('click', '.ecpt_upload_image_button', function() {
          window.formfield = $('.ecpt_upload_field',$(this).parent());
            tb_show('', 'media-upload.php?type=file&post_id=<?php echo $post->ID; ?>&TB_iframe=true');
                    return false;
            });

            window.original_send_to_editor = window.send_to_editor;
            window.send_to_editor = function(html) {
              if (window.formfield) {
                imgurl = $('a','<div>'+html+'</div>').attr('href');
                window.formfield.val(imgurl);
                tb_remove();
              }
              else {
                window.original_send_to_editor(html);
              }
              window.formfield = '';
              window.imagefield = false;
            }
        }
        if($('.form-table .ecpt-slider').length > 0 ) {
          $('.ecpt-slider').each(function(){
            var $this = $(this);
            var id = $this.attr('rel');
            var val = $('#' + id).val();
            var max = $('#' + id).attr('rel');
            max = parseInt(max);
            //var step = $('#' + id).closest('input').attr('rel');
            $this.slider({
              value: val,
              max: max,
              step: 1,
              slide: function(event, ui) {
                $('#' + id).val(ui.value);
              }
            });
          });
        }

        if($('.form-table .ecpt_datepicker').length > 0 ) {
          var dateFormat = 'mm/dd/yy';
          $('.ecpt_datepicker').datepicker({dateFormat: dateFormat});
        }

        // add new repeatable field
        $(".ecpt_add_new_field").on('click', function() {
          var field = $(this).closest('td').find("div.ecpt_repeatable_wrapper:last").clone(true);
          var fieldLocation = $(this).closest('td').find('div.ecpt_repeatable_wrapper:last');
          // set the new field val to blank
          $('input', field).val("");
          field.insertAfter(fieldLocation, $(this).closest('td'));

          return false;
        });

        // add new repeatable upload field
        $(".ecpt_add_new_upload_field").on('click', function() {
          var container = $(this).closest('tr');
          var field = $(this).closest('td').find("div.ecpt_repeatable_upload_wrapper:last").clone(true);
          var fieldLocation = $(this).closest('td').find('div.ecpt_repeatable_upload_wrapper:last');
          // set the new field val to blank
          $('input[type="text"]', field).val("");

          field.insertAfter(fieldLocation, $(this).closest('td'));

          return false;
        });

        // remove repeatable field
        $('.ecpt_remove_repeatable').on('click', function(e) {
          e.preventDefault();
          var field = $(this).parent();
          $('input', field).val("");
          field.remove();
          return false;
        });

      });
    </script>
  <?php
}

function ecpt_export_datepicker_ui_scripts() {
  global $ecpt_base_dir;
  wp_enqueue_script('jquery-ui-datepicker');
  wp_enqueue_script('jquery-ui-slider');
}
function ecpt_export_datepicker_ui_styles() {
  global $ecpt_base_dir;
  wp_enqueue_style('jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css', false, '1.8', 'all');
}

// these are for newest versions of WP
add_action('admin_print_scripts-post.php', 'ecpt_export_datepicker_ui_scripts');
add_action('admin_print_scripts-edit.php', 'ecpt_export_datepicker_ui_scripts');
add_action('admin_print_scripts-post-new.php', 'ecpt_export_datepicker_ui_scripts');
add_action('admin_print_styles-post.php', 'ecpt_export_datepicker_ui_styles');
add_action('admin_print_styles-edit.php', 'ecpt_export_datepicker_ui_styles');
add_action('admin_print_styles-post-new.php', 'ecpt_export_datepicker_ui_styles');

if ((isset($_GET['post']) && (isset($_GET['action']) && $_GET['action'] == 'edit') ) || (strstr($_SERVER['REQUEST_URI'], 'wp-admin/post-new.php')))
{
  add_action('admin_head', 'ecpt_export_ui_scripts');
}

// converts a time stamp to date string for meta fields
if(!function_exists('ecpt_timestamp_to_date')) {
  function ecpt_timestamp_to_date($date) {

    return date('m/d/Y', $date);
  }
}
if(!function_exists('ecpt_format_date')) {
  function ecpt_format_date($date) {

    $date = strtotime($date);

    return $date;
  }
}








?>