<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
    <div>
        <label class="screen-reader-text" for="s"><?php _e('Rechercher :', 'activis') ?></label>
        <input type="text" value="" name="s" id="s" />
        <input type="submit" id="searchsubmit" value="<?php _e('Rechercher', 'activis') ?>" />
    </div>
</form>