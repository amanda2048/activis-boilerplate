<?php get_header(); ?>

	<h1>
		<?php if ( is_day() ) : ?>
			<?php printf( __( 'Archives journalière: <span>%s</span>', 'activis' ), get_the_date() ); ?>
		<?php elseif ( is_month() ) : ?>
			<?php printf( __( 'Archives mensuelles: <span>%s</span>', 'activis' ), get_the_date('F Y') ); ?>
		<?php elseif ( is_year() ) : ?>
			<?php printf( __( 'Archives annuelles: <span>%s</span>', 'activis' ), get_the_date('Y') ); ?>
		<?php else : ?>
			<?php _e("Archives du blogue", 'activis'); ?>
		<?php endif; ?>
	</h1>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		
		<?php the_excerpt(); ?>
		
	<?php endwhile; else: ?>
		<div class="no-results">
			<p><strong><?php _e("Il y a eu une erreur.", 'activis'); ?></strong></p>
			<p><?php _e("Nous nous excusons pour tout inconvénient, s'il vous plaît", 'activis'); ?> <a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('description'); ?>"><?php _e("retournez à la page d'accueil", 'activis'); ?></a> <?php _e("ou utilisez le formulaire de recherche ci-dessous.", 'activis'); ?></p>
			<?php get_search_form(); ?> 
		</div><!--noResults-->
	<?php endif; ?>
		
<?php get_footer(); ?>
