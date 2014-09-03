<?php
	// pagination
	function activis_pagination($pages = '', $range = 2)
	{  
		 $showitems = ($range * 2)+1;  
	
		 global $paged;
		 if(empty($paged)) $paged = 1;
	
		 if($pages == '')
		 {
			 global $wp_query;
			 $pages = $wp_query->max_num_pages;
			 if(!$pages)
			 {
				 $pages = 1;
			 }
		 }   
	
		 if(1 != $pages)
		 {
			 echo "<div class='pagination pagination-centered'><ul>";
			 if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
			 if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";
	
			 for ($i=1; $i <= $pages; $i++)
			 {
				 if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
				 {
					 echo "<li>";
					 echo ($paged == $i)? "<a class='active' href='#'>".$i."</a>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
					 echo "</li>";
				 }
			 }
	
			 if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
			 if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
			 echo "</ul></div>\n";
		 }
	}


	// Filtre pour ajouter une class au premier et dernier element de wp_list_pages
	function wp_list_pages_firstlast($pageList) {
 
		$pageList = preg_replace('/class="/','class="first ', $pageList, 1);
	 
		$reversedString = strrev($pageList);
		$reversedSearch = '/'.strrev('class="').'/';
		$endClass = strrev('class="last ');
	 
		$pageList = strrev(preg_replace($reversedSearch,$endClass, $reversedString, 1));
	 
		return $pageList;
	}
	add_filter('wp_list_pages', 'wp_list_pages_firstlast');

	
	// fil d'ariane plus avancé que celui de yoast
	function activis_breadcrumbs() {
		
	  $delimiter = ' » ';
	  $home = __('Accueil', 'activis'); // text for the 'Home' link
	  $before = '<span class="current">'; // tag before the current crumb
	  $after = '</span>'; // tag after the current crumb
	 
	  //if ( !is_home() && !is_front_page() || is_paged() ) {
	 
		echo '<div id="breadcrumbs">';
	 
		global $post;
		$homeLink = get_bloginfo('url');
		echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
	 
		if ( is_category() ) {
		  global $wp_query;
		  $cat_obj = $wp_query->get_queried_object();
		  $thisCat = $cat_obj->term_id;
		  $thisCat = get_category($thisCat);
		  $parentCat = get_category($thisCat->parent);
		  if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
		  echo $before . __('Archive par catégorie', 'activis').' "' . single_cat_title('', false) . '"' . $after;
	 
		} elseif ( is_day() ) {
		  echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
		  echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
		  echo $before . get_the_time('d') . $after;
	 
		} elseif ( is_month() ) {
		  echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
		  echo $before . get_the_time('F') . $after;
	 
		} elseif ( is_year() ) {
		  echo $before . get_the_time('Y') . $after;
	 
		} elseif ( is_single() && !is_attachment() ) {
		  if ( get_post_type() != 'post' ) {
			$post_type = get_post_type_object(get_post_type());
			$slug = $post_type->rewrite;
			echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
			echo $before . get_the_title() . $after;
		  } else {
			$cat = get_the_category(); $cat = $cat[0];
			if(get_option('page_for_posts')) {
				echo '<a href="'.get_permalink(get_option('page_for_posts')).'">'.get_the_title(get_option('page_for_posts')).'</a> '. $delimiter;
			}
			echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
			echo $before . get_the_title() . $after;
		  }
	 
		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() && !is_search() && !is_tag() && !is_author() ) {
		  $post_type = get_post_type_object(get_post_type());
		  echo $before . $post_type->labels->singular_name . $after;
	 
		} elseif ( is_attachment() ) {
		  $parent = get_post($post->post_parent);
		  $cat = get_the_category($parent->ID); $cat = $cat[0];
		  echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
		  echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
		  echo $before . get_the_title() . $after;
	 
		} elseif ( is_page() && !$post->post_parent ) {
		  echo $before . get_the_title() . $after;
	 
		} elseif ( is_page() && $post->post_parent ) {
		  $parent_id  = $post->post_parent;
		  $breadcrumbs = array();
		  while ($parent_id) {
			$page = get_page($parent_id);
			$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
			$parent_id  = $page->post_parent;
		  }
		  $breadcrumbs = array_reverse($breadcrumbs);
		  foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
		  echo $before . get_the_title() . $after;
	 
		} elseif ( is_search() ) {
		  echo $before . __('Résultats de recherche pour', 'activis').' "' . get_search_query() . '"' . $after;
	 
		} elseif ( is_tag() ) {
		  echo $before . __('Posts taggués', 'activis').' "' . single_tag_title('', false) . '"' . $after;
	 
		} elseif ( is_author() ) {
		   global $author;
		  $userdata = get_userdata($author);
		  echo $before . __('Articles postés par', 'activis').' ' . $userdata->display_name . $after;
	 
		} elseif ( is_404() ) {
		  echo $before . __('Erreur 404', 'activis') . $after;

		}elseif ( is_home() ) {
			echo $before . __('Blogue', 'activis') . $after;
		}
	 
		if ( get_query_var('paged') ) {
		  if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
		  echo $delimiter. ' ' .__('Page', 'activis') . ' ' . get_query_var('paged');
		  if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
		}
	 
		echo '</div>';
	 
	  //}
	}
	
	// Creation d'un mask code postal canadien pour gravityform
	add_filter("gform_input_masks", "add_mask");
	function add_mask($masks){
		$masks["Code Postal"] = "a9a-9a9";
		return $masks;
	}
	
	// retirer les bulle rouge de la side bar
	function yoast_remove_dot( $str ) {
	  return false;
	}
	add_filter( 'wpseo_use_page_analysis', 'yoast_remove_dot', 10, 1 );

	// change validation message error in english
	if( ICL_LANGUAGE_CODE == 'en' ){
		add_filter("gform_validation_message", "change_message", 10, 2);
	}
	function change_message($message, $form){
	  return '<div class="validation_error">The form does not appear correctly filled. Errors have been highlighted below.</div>';
	}

	// ajout dun anchor apres la soumission dun formulaire gravityform
	add_filter("gform_confirmation_anchor", create_function("","return true;"));

	add_filter('sanitize_file_name', 'activis_sanitise_filename', 10);
	function activis_sanitise_filename ($filename) {
		$filenameClean = remove_accents( $filename );
		$filenameClean = strtolower($filenameClean);
		return preg_replace('/[^A-Za-z0-9.\-]/', '', $filenameClean);
	}

	// set default attachment setting
	add_action( 'after_setup_theme', 'default_attachment_display_settings' );
	function default_attachment_display_settings() {
		update_option( 'image_default_align', 'left' );
		update_option( 'image_default_link_type', 'none' );
		update_option( 'image_default_size', 'large' );
	}


?>