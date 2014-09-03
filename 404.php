<?php get_header(); ?>
	
	<h1><?php _e("Oups! Je ne peux pas trouver cette page, désolé ...", 'activis'); ?></h1>
	
	<p><?php _e("Ne vous inquiétez pas! Nous avons quelques conseils pour vous aider à trouver :", 'activis'); ?></p>
	<ol class="page404">
		<li><?php _e("Recherchez-le: ", 'activis'); ?><?php get_search_form(); ?> </li>
		<li><?php _e("Si vous avez tapé une URL ... Assurez-vous que l'orthographe, la capitalisation, et la ponctuation sont correctes. Ensuite, essayez de recharger la page.", 'activis'); ?></li>
		<li><a href="<?php bloginfo('url') ?>"><?php _e("Retournez à la page d'accueil.", 'activis'); ?></a></li>
	</ol>

<?php get_footer(); ?>