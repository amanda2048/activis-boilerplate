<?php

// start all the functions
add_action('after_setup_theme','activis_startup');

function activis_startup() {

    // launching operation cleanup
    add_action('init', 'activis_head_cleanup');
    // remove WP version from RSS
    add_filter('the_generator', 'activis_rss_version');
    // remove pesky injected css for recent comments widget
    add_filter( 'wp_head', 'activis_remove_wp_widget_recent_comments_style', 1 );
    // clean up comment styles in the head
    add_action('wp_head', 'activis_remove_recent_comments_style', 1);
    // clean up gallery output in wp
    add_filter('gallery_style', 'activis_gallery_style');

    // enqueue base scripts and styles
    add_action('wp_enqueue_scripts', 'activis_scripts_and_styles', 999);
    
    // additional post related cleaning
    add_filter( 'img_caption_shortcode', 'activis_cleaner_caption', 10, 3 );
    add_filter('get_image_tag_class', 'activis_image_tag_class', 0, 4);
    add_filter('get_image_tag', 'activis_image_editor', 0, 4);
    add_filter( 'the_content', 'activis_img_unautop', 30 );

    define('ICL_DONT_LOAD_NAVIGATION_CSS', true);
	define('ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true);
	define('ICL_DONT_LOAD_LANGUAGES_JS', true);

} /* end activis_startup */


/**********************
WP_HEAD GOODNESS
The default WordPress head is
a mess. Let's clean it up.

Thanks for Bones
http://themble.com/bones/
**********************/

function activis_head_cleanup() {
	// category feeds
	// remove_action( 'wp_head', 'feed_links_extra', 3 );
	// post and comment feeds
	// remove_action( 'wp_head', 'feed_links', 2 );
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// index link
	remove_action( 'wp_head', 'index_rel_link' );
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
  // remove WP version from css
  add_filter( 'style_loader_src', 'activis_remove_wp_ver_css_js', 9999 );
  // remove Wp version from scripts
  add_filter( 'script_loader_src', 'activis_remove_wp_ver_css_js', 9999 );

} /* end head cleanup */

// remove WP version from RSS
function activis_rss_version() { return ''; }

// remove WP version from scripts
function activis_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}

// remove injected CSS for recent comments widget
function activis_remove_wp_widget_recent_comments_style() {
   if ( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
      remove_filter('wp_head', 'wp_widget_recent_comments_style' );
   }
}

// remove injected CSS from recent comments widget
function activis_remove_recent_comments_style() {
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
  }
}

// remove injected CSS from gallery
function activis_gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}

/**********************
Enqueue CSS and Scripts
**********************/

function activis_scripts_and_styles() {
	if( !is_admin()){

		// register Google font
	    wp_register_style('google-font', 'http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Lora:400,700|Droid+Sans+Mono');

	    // main style
		wp_register_style( 'main-style',get_template_directory_uri() . '/styles.css', array(), 'v20130409', 'all' );

		// jQuery
	  	wp_deregister_script('jquery');
	    wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js');

	    // comment reply script for threaded comments
	    if( get_option( 'thread_comments' ) )  { wp_enqueue_script( 'comment-reply' ); }
	    
	     // Bootstrap
	    wp_deregister_script('bootstrap');
	    wp_register_script( 'bootstrap', get_bloginfo('template_directory').'/_/bootstrap/js/bootstrap.min.js', false, 'v20130409', true);
	    

	    // Fancybox
	    //wp_deregister_script('fancybox');
	    //wp_register_script( 'fancybox', get_bloginfo('template_directory').'/_/js/fancybox/jquery.fancybox.js', false, 'v20130409', true);
	    //wp_enqueue_script('fancybox');

	    //wp_register_style( 'fancybox-style',get_template_directory_uri() . '/_/js/fancybox/jquery.fancybox.css', array(), '20120208', 'all' );
		//wp_enqueue_style( 'fancybox-style' );

	    /*
	    if( is_home() || is_front_page() ){
	    	//Load Cycle
			wp_deregister_script('cycle');
		    wp_register_script( 'cycle', get_bloginfo('template_directory').'/_/js/jquery.cycle2.min.js', false, 'v20130409', true);
		    wp_enqueue_script('cycle');
	    }
		*/

	    // General function and call JavaScript
		wp_deregister_script('functions');
	    wp_register_script( 'functions', get_bloginfo('template_directory').'/_/js/functions.js', false, 'v20130409', true);

	    // enqueue styles and scripts
	    wp_enqueue_style( 'google-font' ); 
	    wp_enqueue_style( 'main-style' );

	    wp_enqueue_script( 'jquery' );
	    wp_enqueue_script( 'html5shiv' );
	    wp_enqueue_script( 'respond' );
	    wp_enqueue_script('bootstrap');
	    wp_enqueue_script('functions');

	  }

}

/*********************
Post related cleaning
*********************/
/* Customized the output of caption, you can remove the filter to restore back to the WP default output. Courtesy of DevPress. http://devpress.com/blog/captions-in-wordpress/ */
function activis_cleaner_caption( $output, $attr, $content ) {

	/* We're not worried abut captions in feeds, so just return the output here. */
	if ( is_feed() )
		return $output;

	/* Set up the default arguments. */
	$defaults = array(
		'id' => '',
		'align' => 'alignnone',
		'width' => '',
		'caption' => ''
	);

	/* Merge the defaults with user input. */
	$attr = shortcode_atts( $defaults, $attr );

	/* If the width is less than 1 or there is no caption, return the content wrapped between the [caption]< tags. */
	if ( 1 > $attr['width'] || empty( $attr['caption'] ) )
		return $content;

	/* Set up the attributes for the caption <div>. */
	$attributes = ' class="figure ' . esc_attr( $attr['align'] ) . '"';

	/* Open the caption <div>. */
	$output = '<figure' . $attributes .'>';

	/* Allow shortcodes for the content the caption was created for. */
	$output .= do_shortcode( $content );

	/* Append the caption text. */
	$output .= '<figcaption>' . $attr['caption'] . '</figcaption>';

	/* Close the caption </div>. */
	$output .= '</figure>';

	/* Return the formatted, clean caption. */
	return $output;
	
} /* end activis_cleaner_caption */

// Clean the output of attributes of images in editor. Courtesy of SitePoint. http://www.sitepoint.com/wordpress-change-img-tag-html/
function activis_image_tag_class($class, $id, $align, $size) {
	$align = 'align' . esc_attr($align);
	return $align;
} /* end activis_image_tag_class */

// Remove width and height in editor, for a better responsive world.
function activis_image_editor($html, $id, $alt, $title) {
	return preg_replace(array(
			'/\s+width="\d+"/i',
			'/\s+height="\d+"/i',
			'/alt=""/i'
		),
		array(
			'',
			'',
			'',
			'alt="' . $title . '"'
		),
		$html);
} /* end activis_image_editor */

// Wrap images with figure tag. Courtesy of Interconnectit http://interconnectit.com/2175/how-to-remove-p-tags-from-images-in-wordpress/
function activis_img_unautop($pee) {
    $pee = preg_replace('/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '<figure>$1</figure>', $pee);
    return $pee;
} /* end activis_img_unautop */
?>