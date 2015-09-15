<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-touch-fullscreen" content="yes">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="shortcut icon" type="image/png" href="<?php echo get_template_directory_uri();?>/assets/images/favicon.png"/>

		<script src="//cdn.optimizely.com/js/2808850734.js"></script>

		<title><?php \NV\Theme::page_title(); ?></title>
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			ga('create', 'UA-32568720-1', 'auto');
			ga('require', 'linkid', 'linkid.js');
			ga('send', 'pageview');
		</script>

		<?php \NV\Custom\Functions::facebook_og_images(); ?>

		<!--[if lt IE 9]>
			<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<?php wp_head();?>
		<?php if (get_field('header_image')) { ?>
			<style type="text/css">
				#header {background: url('<?php the_field('header_image'); ?>');}
			</style>
		<?php } ?>
	</head>
	<body data-scroll="home" <?php body_class() ?>>
		<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-5T8S2K"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5T8S2K');</script>
<!-- End Google Tag Manager -->
		<div id="frame">
			<header class="main-header">
				<span class="main-header-btn pull-left toggle-btn toggle-btn-left" data-nav="left">
				<i class="icon-menu"></i>
				</span>
				<a href="/" class="main-logo">
					<img src="<?php echo get_template_directory_uri();?>/assets/images/logo.png" alt="Reviews.com"/>
				</a>
				<a class="main-header-btn pull-right toggle-btn toggle-btn-right btn-search" data-nav="right" href="#search">
					<i class="icon-search-1"></i>
				</a>
			</header>
