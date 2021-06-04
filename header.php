<?php
/**
 * Header template.
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
  exit( 'What are you doing here.' );
}
do_action('above_html');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <title><?php wp_title(); ?></title>
  <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' />
  <link rel="profile" href="http://gmpg.org/xfn/11" />
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <!--[if lt IE 9]>
   <script>
      document.createElement('header');
      document.createElement('nav');
      document.createElement('section');
      document.createElement('article');
      document.createElement('aside');
      document.createElement('footer');
   </script>
 <![endif]-->
 <?php
 wp_head();
 ?>
</head>
<body <?php body_class(); ?>>
  <div id="wrapper">
    <?php themeaxe_ContentCaller('tempheader'); ?>

    <div id="maincontent">
      <?php do_action('above_main_content'); ?>