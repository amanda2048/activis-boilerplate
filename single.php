<?php get_header(); ?>

	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		
		<h1><?php the_title(); ?></h1>
				
		<?php the_content(); ?>
		
		<?php echo date_multilingual(get_the_date('r'), 'fr'); ?>
		<?php comments_popup_link(__('Aucun commentaire','activis'), __('1 commentaire','activis'), __('% commentaires','activis'), 'comments-link', __('Les commentaires sont fermés','activis')); ?> 
		<?php the_category(', ') ?>
					
		<?php comments_template( '', true ); ?>

	<?php endwhile; ?>

<?php get_footer(); ?>