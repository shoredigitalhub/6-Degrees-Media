<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'What are you doing here.' );
}
require_once(get_template_directory() . '/includes/constants.php');
require_once(get_template_directory() . '/includes/settings.php');

add_action ( 'after_setup_theme', 'themeaxe_setup' );
function themeaxe_setup() {
	load_theme_textdomain( 'light-axe', get_template_directory() . '/languages' );
	/*require_once(get_template_directory().'/includes/constants.php');*/

	/* Add default posts and comments RSS feed links to <head>. */
	add_theme_support ( 'automatic-feed-links' );
	/* Main Navigation */
	register_nav_menu ( 'primary', __ ( 'Primary Menu', 'light-axe' ) );
	/* Footer navigation */
	register_nav_menu ( 'footer', __ ( 'Footer Menu', 'light-axe' ) );
	/* Mini Top navigation */
	register_nav_menu ( 'topnav', __ ( 'Mini Top Nav', 'light-axe' ) );
	/* Featured Image Support */
	add_theme_support ( 'post-thumbnails' );
	/* Post Type Support */
	add_theme_support( 'post-formats', array( 'aside' ) );
	/* Woocommerce Support */
	add_theme_support( 'woocommerce' );
	/* Edito Stylesheet */
	add_editor_style();
	/* Title Tag */
	add_theme_support( "title-tag" );
	/* HTML5 */
	add_theme_support( "html5", array('search-form','comment-form','comment-list','gallery','caption',) );
	/* Custom Menu */
	add_theme_support( "custom-menu" );
	/* Widgets Selective Refresh */
	add_theme_support( 'customize-selective-refresh-widgets' );
	/* Mime type add-ons */
	add_action('upload_mimes', 'themeaxe_file_types_to_uploads');
	/* Main Theme Settings */
	themeaxe_init_settings();
	/* Set Content Width */
	if ( ! isset( $content_width ) ) {
		$content_width = themeaxe_GetThemeContentWidth();
	}
	/* Custom Backgrounds */
	add_theme_support('custom-background',themeaxe_GetThemeBackgroundOptions());
	/* Custom Header */
	add_theme_support('custom-header',themeaxe_GetThemeHeaderOptions());
	/* Custom Logo */
	add_theme_support('custom-logo',themeaxe_GetThemeLogoOptions());
	/* Added GoUp */
	add_action('wp_footer','themeaxe_goup');
}

add_action('wp_enqueue_scripts','themeaxe_custom_loadcss');
function themeaxe_custom_loadcss(){
	wp_enqueue_style('themeaxe-fontawesome', 'https://use.fontawesome.com/releases/v5.7.1/css/all.css', false, THEMEAXEVER,false);
}

function themeaxe_excerptlength($length) {
	return 50;
}
add_filter ( 'excerpt_length', 'themeaxe_excerptlength' );

function themeaxe_file_types_to_uploads($file_types){
	$new_filetypes = array();
	$new_filetypes['svg'] = 'image/svg+xml';
	$file_types = array_merge($file_types, $new_filetypes );
	return $file_types;
}

/**
 * Returns a "Continue Reading" link for excerpts
 */
function themeaxe_readmore_link() {
	return ' <a href="' . esc_url ( get_permalink () ) . '" class="themeaxe_readmore">' . __ ( 'Read More <span class="meta-nav"><i class="fa fa-chevron-right"></i></span>', 'light-axe' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis.
 *
 * function tied to the excerpt_more filter hook.
 */
function themeaxe_automore($more) {
	return '';
}
add_filter ( 'excerpt_more', 'themeaxe_automore' );

function themeaxe_the_excerpt_more_link( $excerpt ){
	$post = get_post();
	$excerpt .= themeaxe_readmore_link ();
	return $excerpt;
}
add_filter( 'the_excerpt', 'themeaxe_the_excerpt_more_link', 30 );
/*
* Widgets setions for the theme
*/
function themeaxe_widgets_init() {
	$sidebars = themeaxe_GetAllThemeSettings('sidebars');

	$fixedsbars = array(
		array(__('Default Sidebar', 'light-axe' ),'default','default whitebg shadowed'),
		array(__('Topbar Section One', 'light-axe' ),'topbarsectionone','topbarsectionone'),
		array(__('Topbar Section Two', 'light-axe' ),'topbarsectiontwo','topbarsectiontwo'),
		array(__('Topbar Section Three', 'light-axe' ),'topbarsectionthree','topbarsectionthree'),
		array(__('Topbar Section Four', 'light-axe' ),'topbarsectionfour','topbarsectionfour'),
		array(__('Banner Section', 'light-axe' ),'bannersection','bannersection'),
		array(__('Left Sidebar', 'light-axe' ),'leftsidebar','leftsidebar whitebg shadowed'),
		array(__('Right Sidebar', 'light-axe' ),'rightsidebar','rightsidebar whitebg shadowed'),
		array(__('Shop Sidebar', 'light-axe' ),'shopsidebar','shopsidebar whitebg shadowed'),
		array(__('Footer Section One', 'light-axe' ),'footersectionone','footersectionone'),
		array(__('Footer Section Two', 'light-axe' ),'footersectiontwo','footersectiontwo'),
		array(__('Footer Section Three', 'light-axe' ),'footersectionthree','footersectionthree'),
		array(__('Footer Section Four', 'light-axe' ),'footersectionfour','footersectionfour'),
	);

	if($sidebars){
		$sidebars = array_merge($fixedsbars,$sidebars);
	}else{
		$sidebars = $fixedsbars;
	}

	if(is_array($sidebars)){
		foreach($sidebars as $key => $val){
			register_sidebar ( array (
				'name' =>  $val[0],
				'id' => 'sidebar-'.$val[1],
				'description' => __ ( $val[0]. ' widgets', 'light-axe' ),
				'before_widget' => '<aside id="%1$s" class="widget themeaxe-sidebar sidebar-'.$val[1].' '.$val[2].' %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h3>',
				'after_title' => '</h3>'
			) );
		}
	}
}
add_action ( 'widgets_init', 'themeaxe_widgets_init' );

add_filter('widget_text', 'do_shortcode');
add_filter('the_title', 'do_shortcode');
add_filter('widget_title', 'do_shortcode');

/* Custom CSS */
if(!function_exists('themeaxe_CustomCSS')){
	function themeaxe_CustomCSS(){
		$typography = (array) themeaxe_GetAllThemeSettings('typography');
		$general = themeaxe_GetAllThemeSettings('general');
		$style = '';
		$style .= themeaxe_gFontFace();
		$style .= '<style type="text/css">';

		/* @fontface here */
		$style .= themeaxe_myFontFace();
		/* @fontface here */

		/* Style */
		$container = '';
		$other = '';

		if(axeHelper::isValidArray($typography)){
			foreach($typography as $key => $val){

				switch($val->alias){
					case 'h1':
					$container = '';
					$sty ='';

					break;
					case 'h2':
					$container = '';
					$sty ='';
					break;
					case 'a:hover':
					$container = '#mainmenu ul li:hover > a, #mainmenu ul li.current_page_item > a,#mainmenu ul li.current_page_parent > a,#mainmenu ul li.current_page_ancestor > a,';
					$sty = 'border-color:#'.$val->color.'!important;';
					break;
					case 'body':
					/*$general = $axethemesettings->general;*/
					$sty = 'background-color:#'.$general->bgcolor->value.';';
					$img = trim($general->bgimage->value);
					if(!empty($img)){
						$sty .= "background-image:url('".$img."')".';';
						$type = $general->bgimagetype->value;
						switch($type){
							case 'fullwidth':
							$sty .= "background-size:cover;";
							$sty .= 'background-repeat:no-repeat;';
							break;
							case 'fixed':
							$sty .= "background-attachment:fixed;";
							$sty .= 'background-repeat:no-repeat;';
							$sty .= "background-position:" . $general->bgyposition->value . ' ' .$general->bgxposition->value.';';
							break;
							default:
							$sty .= "background-repeat:".$type.';';
							$sty .= "background-position:" . $general->bgyposition->value . ' ' .$general->bgxposition->value.';';
							break;
						}

					}
					break;
					default:
					$container = '';
					$sty ='';
					break;
				}



				$fonts = themeaxe_fonts();
				$fselect = null;
				if(isset($fonts[strtolower($val->font)])){
					$fselect = $fonts[strtolower($val->font)];
				}
				if(!$fselect){
					if(isset($fonts[$val->font])){
						$fselect = $fonts[$val->font];
					}
				}
				if($fselect){
					$style .= $container.$val->alias.'{';
					$style .= 'font-family:'.$fselect['family'] .';';
					$style .= 'font-size:'.$val->size .'px;';
					$style .= 'line-height:'. (intval($val->size) + 6) .'px;';
					$style .= 'color:#'.$val->color .';';
					$style .= $sty;
					$style .= '} ';
				}
			}
		}
		/* Style */
		$primary = $general->primarycolor->value;
		$other .= '.primary{color:#'.$primary.';} .primarybg,.commentcount,input[type="submit"],.readmore,.woocommerce #content input.button, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce-page #content input.button, .woocommerce-page #respond input#submit, .woocommerce-page a.button, .woocommerce-page button.button, .woocommerce-page input.button,.woocommerce #content input.button.alt, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce-page #content input.button.alt, .woocommerce-page #respond input#submit.alt, .woocommerce-page a.button.alt, .woocommerce-page button.button.alt, .woocommerce-page input.button.alt{background-color:#'.$primary.';}.primaryborder,#footer{border-color:#'.$primary.';}';

		$secondary = $general->secondarycolor->value;
		$other .= '.secondary,#topheader ul li a:hover,#topheader a:hover,#maincontent ul li:before{color:#'.$secondary.';} .secondarybg,.commentcount:hover,input[type="submit"]:hover,input[type="submit"]:focus,.woocommerce #content input.button:hover, .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce-page #content input.button:hover, .woocommerce-page #respond input#submit:hover, .woocommerce-page a.button:hover, .woocommerce-page button.button:hover, .woocommerce-page input.button:hover,.woocommerce #content input.button.alt:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce-page #content input.button.alt:hover, .woocommerce-page #respond input#submit.alt:hover, .woocommerce-page a.button.alt:hover, .woocommerce-page button.button.alt:hover, .woocommerce-page input.button.alt:hover,.woocommerce span.onsale, .woocommerce-page span.onsale,::selection{background-color:#'.$secondary.';}.secondaryborder{border-color:#'.$secondary.';}.woocommerce span.onsale, .woocommerce-page span.onsale,,.single-product #maincontent div.product .button:hover,#maincontent .woocommerce input.button:hover,.woocommerce .cart-collaterals .shipping_calculator .button:hover, .woocommerce-page .cart-collaterals .shipping_calculator .button:hover,input[type="submit"]:hover,::selection{background:#'.$secondary.'}';

		$style .= $other;

		$width = $general->wrapperwidth->value;
		switch($general->wrapperstyle->value){
			case 'fullwidth':
			$style .= '.wrapwidth{ width:98%;}';
			$style .= '@media screen and(max-width:1024px){ .wrapwidth{width:94%;}}';
			break;
			default:
			$style .= '.wrapwidth{ width:'.$width.'px;}';
			$style .= '@media screen and(max-width:'.$width.'px){ .wrapwidth{width:94%;}}';
			break;
		}

		$style .= '</style>';

		echo $style;

	}
}
add_action('wp_head','themeaxe_CustomCSS',9999);
/* Custom CSS */

/* Logo */
function themeaxe_printLogo(){
	$logo = '';
	if(has_custom_logo()){
		$logo = get_custom_logo();
	}else{
		$logo = themeaxe_getLogo();
	}
	echo $logo;
}
function themeaxe_getLogo(){
	$general = themeaxe_GetAllThemeSettings('general');
	$logo = apply_filters('axe_main_logo','<a href="'.home_url().'" class="sitelogo"><img src="'.$general->logo->value.'" '.themeaxe_GetImageSize($general->logo->value).'/></a>');
	return $logo;
}
/* Logo */

/* Get Image Sizes */
function themeaxe_GetImageSize($imgurl){
	$sizes = '';
	if(substr_count($imgurl, get_site_url())){
		$imgpath = str_replace( get_site_url(),  trim(ABSPATH,DIRECTORY_SEPARATOR) , $imgurl);
		if(file_exists($imgpath)){
			$sizes = getimagesize($imgpath);
			if(is_array($sizes)){
				$sizes = isset($sizes[3]) ? $sizes[3] : '';
			}
		}
	}
	return $sizes;
}
/* Get Image Sizes */

/* Favicon */
function themeaxe_printFavicon(){
	if(has_site_icon()){
		wp_site_icon();
	}else{
		$general = themeaxe_GetAllThemeSettings('general');
		$fav = '<link  rel="shortcut icon" href="'.$general->favicon->value.'" />';
		echo $fav;
	}
}
add_action('wp_head','themeaxe_printFavicon');
add_action('login_head', 'themeaxe_printFavicon');
add_action('admin_head', 'themeaxe_printFavicon');
/* Favicon */

/* Google Analytics */
function themeaxe_printGoogleAnalytics(){
	$analytics = themeaxe_GetAllThemeSettings('analytics');
	$uacode = '';
	$analytics = $analytics->uacode->value;
	if(!empty($analytics)){
		$uacode = "<script type=\"text/javascript\">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '".$analytics."']);
		_gaq.push(['_trackPageview']);
		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;

			ga.src = 'https://stats.g.doubleclick.net/dc.js';

			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
			</script>";
		}

		echo $uacode;
	}
	add_action('wp_head','themeaxe_printGoogleAnalytics',999999);
	/* Google Analytics */
	/*<link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>*/

	/* AXE Footer */
	function themeaxe_Footer(){
		$footercols = themeaxe_GetAllThemeSettings('columns');

		$footercols = $footercols->footercols->value;
		$footercol = '';
		if($footercols){
			$colwidth = 12/$footercols;
			$arr = array('one','two','three','four');
			$ix = 0;
			while($ix < $footercols){
				$footercol .= '<div class="w footercolumns footercolumns-'. ($ix+1).' w'.$colwidth.'">
				'.themeaxe_get_sidebar('footersection'.$arr[$ix]).'</div>';
				$ix++;
			}
		}
		echo $footercol;
	}

	/* AXE Footer */

	/* AXE Topbar */
	function themeaxe_Topbar(){
		$topbarcols = themeaxe_GetAllThemeSettings('columns');

		$topbarcols = $topbarcols->topbarcols->value;
		$topbarcol = '';
		if($topbarcols){
			$colwidth = 12/$topbarcols;
			$arr = array('one','two','three','four');
			$ix = 0;
			while($ix < $topbarcols){
				$topbarcol .= '<div class="left topbarcolumns topbarcolumns-'. ($ix+1) .' w'.$colwidth.'">
				'.themeaxe_get_sidebar('topbarsection'.$arr[$ix]).'</div>';
				$ix++;
			}
		}
		echo $topbarcol;
	}

	/* AXE Topbar */

	/* AXe Featured Image */
	function themeaxe_FeaturedImg($id = 0, $class="",$getdefault = false){
		echo themeaxe_getFeaturedImg($id,$class, $getdefault);
	}
	function themeaxe_getFeaturedImg($id = 0, $class="", $getdefault = false){
		$feat_image = '';
		if(!intval($id)){
			global $post;
			if(isset($post->ID)){
				$id = $post->ID;
			}
		}

		if($id){
			$feat_image = get_the_post_thumbnail_url( $id, 'full' );
		}

		if(empty($feat_image)){
			$feat_image = get_post_meta($id,'axe-featured-image',true);
			if(empty($feat_image)){
				if($getdefault){
					$feat_image = THEMEAXEIMAGESPATH . 'blog.jpg';
				}
			}
		}

		if(empty($feat_image)){
			$feat_image = get_header_image();
		}

		if(!empty($feat_image)){
			$html = '<div style="background-image:url('. $feat_image . ')" class="featuredimg ' . $class . '" rel="' . $feat_image . '">';
			$html .= apply_filters('axe_inside_bannerbackground','');
			$html .= '</div>';
			return $html;
		}else{
			return '';
		}
	}

	function themeaxe_FeaturedImage($id = 0, $class=""){
		echo themeaxe_getFeaturedImg($id,$class);
	}
	function themeaxe_getFeaturedImage($id = 0, $class=""){
		if(!intval($id)){
			global $post;
			$id = $post->ID;

			if(function_exists('is_woocommerce')){
				if(is_woocommerce()){
					$id = get_option('woocommerce_shop_page_id');
				}
			}else{
				/* Do nothing.  Already have the ID. */
			}
		}

		$feat_image = get_the_post_thumbnail_url( $id, 'full' );


		if(empty($feat_image)){
			$feat_image = get_header_image();
		}

		if(!empty($feat_image)){
			return apply_filters('axe_featuredimage_filter', '<div class="featuredimg headerfeaturedimg ' . $class . '"><img class="img_featimage" rel="' . $feat_image . '" src="' . $feat_image . '"/></div>');
		}else{
			return '';
		}
	}
	/* AXe Featured Img */



	/* AXe Featured Image + Gallery */
	function themeaxe_FeaturedSection($id = 0){
		global $post;
		$fimg = '';
		$general = themeaxe_GetAllThemeSettings('general');
		$featureimgstyle = $general->featuredimgstyle->value;

		if(is_home() || is_tax() || is_archive() || is_search()){
			$id = get_option( 'page_for_posts' );
			if($id){
				$fimg = get_post_meta($id,'_axe_post_banner',true);

				if($fimg){
					$fimg = do_shortcode($fimg);
				}else{
					switch($featureimgstyle){
						case 'fullwidth':
						$fimg = themeaxe_getFeaturedImage($id,'pagefeaturedimage fullwidth');
						break;
						case 'parallax':
						$fimg = themeaxe_getFeaturedImg($id,'pagefeaturedimage parallax');
						break;
						default:
						$fimg = '<div class="wrapwidth">'. themeaxe_getFeaturedImage($id,'pagefeaturedimage') . '</div>';
						break;
					}
				}
			}
		}else{
			if(isset($post->ID)){
				$check = get_post_meta($post->ID,'_axe_post_banner_show',true);
				if($check != '2'){
					$fimg = get_post_meta($post->ID,'_axe_post_banner',true);

					if($fimg){
						$fimg = do_shortcode($fimg);
					}else{

						switch($featureimgstyle){
							case 'fullwidth':
							$fimg = themeaxe_getFeaturedImage($id,'pagefeaturedimage fullwidth');
							break;
							case 'parallax':
							$fimg = themeaxe_getFeaturedImg($id,'pagefeaturedimage parallax');
							break;
							default:
							$fimg = '<div class="wrapwidth">'. themeaxe_getFeaturedImage($id,'pagefeaturedimage') . '</div>';
							break;
						}
						if(empty($fimg)){
							themeaxe_sidebar('bannersection');
						}
					}
				}
			}
		}

		if(!empty($fimg)){
			echo apply_filters('axe_banner_filter',$fimg);
		}
	}
	/* AXe Featured Image + Gallery */

	/* Rewrite Flush */

	function themeaxe_rewrite_flush() {
		flush_rewrite_rules();
	}
	add_action( 'after_switch_theme', 'themeaxe_rewrite_flush' );

	/* Rewrite Flush */

	/* Get RGB value for colors from HEX Values */
	function themeaxe_GetRGB($color, $opacity = 1){
		$color = str_split(rtrim($color,'#'),2);
		$opacity = floatval($opacity);
		$opacity = $opacity > 1 ? 1 : $opacity;
		$a = $opacity < 0 ? 0 : $opacity;

		$rgb = array(255,255,255);
		$rgba = '';
		if(is_array($color)){
			$ind = 0;
			foreach($color as $c){
				$rgb[$ind] = hexdec($c);
				$ind++;
			}
		}

		foreach($rgb as $r){
			$rgba .= $r.',';
		}

		$rgba = rtrim($rgba,',');

		return $rgba;

	}
	/* Get RGB value for colors from HEX Values */

	function themeaxe_goup(){
		echo '<div id="goup"><span class="fa fa-chevron-up"></span></div>';
	}

	/* AXe Apply Content Filter Without WPAutoP */
	function themeaxe_ContentFilterNoWPAutoP($content){
		remove_filter( 'the_content', 'wpautop' );
		$content =  apply_filters('the_content',$content);
		add_filter( 'the_content', 'wpautop' );

		return $content;
	}
	/* AXe Apply Content Filter Without WPAutoP */