<?php
foreach (glob(get_template_directory()."/_/{includes,lib}/*.php",GLOB_BRACE) as $inc) {
   require_once($inc);
}

/**********************
Add theme supports
 **********************/
function activis_theme_support() {
    // Add language supports.
    load_theme_textdomain('activis', get_template_directory() . '_/lang');

    // Add post thumbnail supports. http://codex.wordpress.org/Post_Thumbnails
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(200, 200, false);
    //add_image_size( 'fd-lrg', 1024, 99999);
    //add_image_size( 'fd-med', 768, 99999);
    //add_image_size( 'fd-sm', 320, 9999);

    // rss thingy
    add_theme_support('automatic-feed-links');

    // Add post formarts supports. http://codex.wordpress.org/Post_Formats
    //add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));

    // Add custom background support
    /*add_theme_support( 'custom-background',
        array(
            'default-image' => '',  // background image default
            'default-color' => '', // background color default (dont add the #)
            'wp-head-callback' => '_custom_background_cb',
            'admin-head-callback' => '',
            'admin-preview-callback' => ''
        )
    );*/

	// WPML languages switcher
	function icl_post_languages(){
		$languages = icl_get_languages('skip_missing=0');
		foreach($languages as $l){
			if(!$l['active']) $langs[] = '<a href="'.$l['url'].'">'.$l['native_name'].'</a>';
		}
		echo join(', ', $langs);
	}

	// add fancybox compatibility to img
	/*add_filter('the_content', 'activis_fancybox');
	function activis_fancybox($content) {
	       global $post;
	       $pattern ="/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
	       $replacement = '<a$1href=$2$3.$4$5 rel="fancybox" title="'.$post->post_title.'"$6>';
	       $content = preg_replace($pattern, $replacement, $content);
	       return $content;
	}*/
}
add_action('after_setup_theme', 'activis_theme_support'); /* end activis theme support */

// if current page is a sub page
function is_tree($pid) {      // $pid = The ID of the page we're looking for pages underneath
	global $post;         // load details about this page

	if ( is_page($pid) )
               return true;   // we're at the page or at a sub page

	$anc = get_post_ancestors( $post->ID );
	foreach ( $anc as $ancestor ) {
		if( is_page() && $ancestor == $pid ) {
			return true;
		}
	}
        return false;  // we aren't at the page, and the page is not an ancestor
}