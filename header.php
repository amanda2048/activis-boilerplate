<!DOCTYPE html>
<!--[if lt IE 7]>  <html class="ie ie6 lte9 lte8 lte7" lang="fr"> <![endif]-->
<!--[if IE 7]>     <html class="ie ie7 lte9 lte8 lte7" lang="fr"> <![endif]-->
<!--[if IE 8]>     <html class="ie ie8 lte9 lte8" lang="fr"> <![endif]-->
<!--[if IE 9]>     <html class="ie ie9 lte9" lang="fr"> <![endif]-->
<!--[if gt IE 9]>  <html lang="fr"> <![endif]-->
<!--[if !IE]><!--> <html lang="fr" prefix="og:http://ogp.me/ns#"> <!--<![endif]-->
<head>
    
	<title><?php wp_title(''); ?></title>
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    <?php // To be sure you're using the latest rendering mode for IE. ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

	<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/_/images/min/favicon.ico">

	<?php wp_head(); ?>

    <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body <?php body_class(); ?>> 

    <div class="navbar navbar-inverse" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                     <?php wp_list_pages('title_li='); ?>
                     <li><?php echo icl_post_languages(); ?></li>
                </ul>
            </div><!--/.navbar-collapse -->
        </div>
    </div>

    <div class="container">