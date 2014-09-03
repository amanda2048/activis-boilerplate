<div id="comments">
	<!-- Prevents loading the file directly -->
	<?php if(!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) : ?>
	    <?php die('Please do not load this page directly or we will hunt you down. Thanks and have a great day!'); ?>
	<?php endif; ?>
	
	<!-- Password Required -->
	<?php if(!empty($post->post_password)) : ?>
	    <?php if($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) : ?>
	    <?php endif; ?>
	<?php endif; ?>
	
	<?php $i++; ?> <!-- variable for alternating comment styles -->
	<?php if($comments) : ?>
		<h3><?php comments_number(__('Aucun commentaire', 'activis'), __('1 commentaire', 'activis'), __('% commentaires', 'activis')); ?></h3>
	    <ol>
	    <?php foreach($comments as $comment) : ?>
	    	<?php $comment_type = get_comment_type(); ?> <!-- checks for comment type -->
	    	<?php if($comment_type == 'comment') { ?> <!-- outputs only comments -->
		        <li id="comment-<?php comment_ID(); ?>" class="comment <?php if($i&1) { echo 'odd';} else {echo 'even';} ?> <?php $user_info = get_userdata(1); if ($user_info->ID == $comment->user_id) echo 'authorComment'; ?> <?php if ($comment->user_id > 0) echo 'user-comment'; ?>">
		            <?php if ($comment->comment_approved == '0') : ?> <!-- if comment is awaiting approval -->
		                <p class="waiting-for-approval">
		                	<em><?php _e("Votre commentaire est en attente d'approbation.", 'activis'); ?></em>
		                </p>
		            <?php endif; ?>
		            <div class="comment-text">
						<p class="gravatar">
							<?php /*if(function_exists('get_avatar')) { echo get_avatar($comment, '36'); }*/ ?>
							<?php comment_type(); ?> <?php _e('par', 'activis'); ?> <?php comment_author_link(); ?> <?php _e('le', 'activis'); ?> <?php comment_date(); ?> <?php _e('à', 'activis'); ?> <?php comment_time(); ?>
							<br>
							<?php edit_comment_link(__("Modifier le commentaire", 'activis'), '', ''); ?>
						</p>
			            <?php comment_text(); ?>
		            </div><!--.commentText-->
		        </li>
			<?php } else { $trackback = true; } ?>
	    <?php endforeach; ?>
	    </ol>
	<?php else : ?>
	    <p><?php _e("Pas encore de commentaires.", 'activis'); ?></p>
	<?php endif; ?>
	
	<div id="comments-form">
		<?php if(comments_open()) : ?>
		    <?php if(get_option('comment_registration') && !$user_ID) : ?>
		        <p><?php _e("Vous devez être", 'activis'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"><?php _e("connecté", 'activis') ?></a> <?php _e('pour écrire un commentaire.', 'activis') ?></p><?php else : ?>
		        <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
		            <?php if($user_ID) : ?>
		                <p><?php _e("Connecté en tant que", 'activis'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title=""><?php _e("Déconnectez-vous", 'activis'); ?> &raquo;</a></p>
		            <?php else : ?>
		            	<!--<p>
		            		<?php _e("Admis", 'activis'); ?>: <?php echo allowed_tags(); ?>
		            	</p>-->
		                <p>
							<label for="author"><small><?php _e("Nom", 'activis'); ?> <?php if($req) _e("(requis)", 'activis');  ?></small></label>
							<input type="text" name="author" id="author" class="champ_texte marginright20" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
		                </p>
		                <p>
		                	<label for="email"><small><?php _e("Courriel (ne sera pas publié)", 'activis'); ?> <?php if($req) _e("(requis)", 'activis'); ?></small></label>
		                	<input type="text" name="email" id="email" class="champ_texte" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
		                </p>
		                <p>
		                	<label for="url"><small><?php _e("Site Web", 'activis'); ?></small></label>
		                	<input type="text" name="url" id="url" class="champ_texte" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
		                </p>
		            <?php endif; ?>
		            <p>
		            	<label for="comment"><small><?php _e("Commentaire", 'activis'); ?></small></label>
		            	<textarea name="comment" id="comment" class="boite_texte" cols="100%" rows="10" tabindex="4"></textarea>
		            </p>
		            <p>
		            	<input name="submit" type="submit" id="submit" class="btn_submit" tabindex="5" value="<?php _e("Envoyer", 'activis') ?>" />
		            	<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
		            </p>
		            <?php do_action('comment_form', $post->ID); ?>
		        </form>
<!--				<p><small>By submitting a comment you grant <?php bloginfo('name'); ?> a perpetual license to reproduce your words and name/web site in attribution. Inappropriate and irrelevant comments will be removed at an admin’s discretion. Your email is used for verification purposes only, it will never be shared.</small></p>
-->		    <?php endif; ?>
		<?php else : ?>
		    <p><?php _e("Les commentaires sont fermés.", 'activis'); ?></p>
		<?php endif; ?>
	</div><!--#commentsForm-->
</div><!--#comments-->