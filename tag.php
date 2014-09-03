<?php get_header(); ?>

	<h1><?php printf( __( 'Archives du mot-clé: %s', 'activis' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?></h1>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		
		<?php the_excerpt(); ?> 
		
	<?php endwhile; else: ?>
		<div class="no-results">
			<p><strong><?php _e("Il y a eu une erreur.", 'activis'); ?></strong></p>
			<p><?php _e("Nous nous excusons pour tout inconvénient, s'il vous plaît", 'activis'); ?> <a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('description'); ?>"><?php _e("retournez à la page d'accueil", 'activis'); ?></a> <?php _e("ou utilisez le formulaire de recherche ci-dessous.", 'activis'); ?></p>
			<?php get_search_form(); ?> 
		</div>
	<?php endif; ?>

<?php get_footer(); ?>