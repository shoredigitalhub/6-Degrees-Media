<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'What are you doing here.' );
}
get_template_part( 'admin/includes/functions');

/* AXe Content Caller */
if(!function_exists('themeaxe_ContentCaller')){
	function themeaxe_ContentCaller($file,$once = false){
		if(file_exists(CURRENTTHEMEAXEROOT.'/'.$file.'.php')){
			$file = CURRENTTHEMEAXEROOT.'/'.$file.'.php';

		}else if(file_exists(THEMEAXEROOT.'/'.$file.'.php')){
			$file = THEMEAXEROOT.'/'.$file.'.php';

		}else if(file_exists($file)){
			/*$file = $file;*/
		}else{
			$file = '';
		}


		if(!empty($file)){
			if($once){
				include_once $file;
			}else{
				include $file;
			}
		}else{
			/*echo 'not found';*/
		}

	}
}
/* AXe Content Caller */

$axeincludesarray = array('hooks','widgets','postmeta','metaboxes','helper','plugins');
foreach($axeincludesarray as $key){
	themeaxe_ContentCaller(THEMEAXEROOT.'/includes/'.$key.'.php',true);
}

$axethemesettings = null;

function themeaxe_adminmenu(){
	$maintheme = add_theme_page('Light AXe', THEMEAXE, 'administrator', 'light-axe', 'themeaxe_settings');

	$items = themeaxe_Settings_MenuItems();
	foreach($items as $k => $v){
		$suffix = add_theme_page($v, ' - '.$v, 'administrator', 'light-axe&tab='.$k.'#'.$k, 'themeaxe_'.$k,'' );
		add_action( "admin_print_scripts-$suffix", 'themeaxe_admin_scripts');
	}
	add_theme_page(  'About Light AXe', ' - About', 'administrator', 'about-light-axe', 'themeaxe_abouttheme' );
}
add_action('admin_menu', 'themeaxe_adminmenu',10);

function themeaxe_admin_enquescripts($hook){
	if ( 'post.php' == $hook  || 'admin.php' == $hook ) {

	}
	if( 'widgets.php' == $hook){
		wp_dequeue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-ui-sortable' );
	}
	wp_dequeue_script('themeaxe-color');
	wp_enqueue_script(THEMEAXENAME.'-themeaxe-color', THEMEAXEADMINJSPATH.'color.js', 'jquery', THEMEAXEVER,true);
	wp_enqueue_media();
	wp_enqueue_script('themeaxe-js', THEMEAXEADMINJSPATH.'themeaxe.js', 'jquery', THEMEAXEVER,true);
	wp_enqueue_style('themeaxe-admin-css', THEMEAXEADMINCSSPATH.'themeaxe-admin.css', false, THEMEAXEVER,false);
}
add_action( 'admin_enqueue_scripts', 'themeaxe_admin_enquescripts' );

function themeaxe_adminbar_menu() {
	global $wp_admin_bar;

	$wp_admin_bar->add_menu(array('parent' => 'site-name', 'title' => THEMEAXE, 'id' => 'axe-theme_settings', 'href' => home_url().'/wp-admin/admin.php?page=light-axe'));
}
add_action('admin_bar_menu', 'themeaxe_adminbar_menu', 2000);

function themeaxe_admin_scripts() {
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_script('themeaxe-color', THEMEAXEADMINJSPATH.'color.js', 'jquery', THEMEAXEVER,true);
}

function themeaxe_enquescripts(){
	wp_dequeue_script('jquery');
	wp_dequeue_script('jquery-ui-core');
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core');

	wp_enqueue_style('themeaxe-style-css', get_stylesheet_directory_uri() .'/style.css', false, THEMEAXEVER,false);
	wp_enqueue_script('themeaxe-axetheme-js', THEMEAXEJSPATH.'axeTheme.js', false, THEMEAXEVER,true);
}
add_action('wp_enqueue_scripts','themeaxe_enquescripts');

function themeaxe_init_settings(){
	global $axethemesettings;
	$axethemesettings = get_option('themeaxe_options');

	if(!$axethemesettings){
		$options = array(
			'general'=>array(
				'logo'=>array(
					'key'=>'logo',
					'value'=>THEMEAXEIMAGESPATH.'logo.png',
					'type'=>'url',
					'adminclass'=>'themeaxemedialoader',
				),
				'favicon'=>array(
					'key'=>'favicon',
					'value'=>THEMEAXEIMAGESPATH.'logo.png',
					'type'=>'url',
					'adminclass'=>'themeaxemedialoader',
				),
				'bgcolor'=>array(
					'key'=>'body-background-color',
					'value'=>'ffffff',
					'type'=>'color',
				),
				'bgimage'=>array(
					'key'=>'body-background-image',
					'value'=>'',
					'type'=>'url',
					'adminclass'=>'themeaxemedialoader',
				),
				'bgimagetype'=>array(
					'key'=>'body-background-image-type',
					'value'=>'default',
					'type'=>'select',
					'values'=>'default,fill,fit,repeat,custom',
				),
				'bgimagesize'=>array(
					'key'=>'body-background-image-size',
					'value'=>'auto',
					'type'=>'select',
					'values'=>'auto,contain,cover',
				),
				'bgrepeat'=>array(
					'key'=>'body-background-image-repeat',
					'value'=>'no-repeat',
					'type'=>'select',
					'values'=>'no-repeat,repeat,repeat-x,repeat-y',
				),
				'bgattachment'=>array(
					'key'=>'body-background-image-attachment',
					'value'=>'scroll',
					'type'=>'select',
					'values'=>'scroll,fixed',
				),
				'bgyposition'=>array(
					'key'=>'body-background-y-position',
					'value'=>'center',
					'type'=>'select',
					'values'=>'center,top,bottom',
				),
				'bgxposition'=>array(
					'key'=>'body-background-x-position',
					'value'=>'center',
					'type'=>'select',
					'values'=>'center,right,left',
				),
				'wrapperstyle'=>array(
					'key'=>'wrapper-style',
					'value'=>'boxed',
					'type'=>'select',
					'values'=>'boxed,fullwidth',
				),
				'wrapperwidth'=>array(
					'key'=>'wrapper-width',
					'value'=>'960',
					'type'=>'number',
				),
				'primarycolor'=>array(
					'key'=>'primary-color',
					'value'=>'0095DA',
					'type'=>'color',
				),
				'secondarycolor'=>array(
					'key'=>'secondary-color',
					'value'=>'8DC63F',
					'type'=>'color',
				),
				'tertiarycolor'=>array(
					'key'=>'tertiary-color',
					'value'=>'FFFFFF',
					'type'=>'color',
				),
				'featuredimgstyle'=>array(
					'key'=>'featuredimage-style',
					'value'=>'fullwidth',
					'type'=>'select',
					'values'=>'boxed,fullwidth,parallax',
				),
			),
			'blog'=>array(
				'blogstyle'=>array(
					'key'=>'blog-style',
					'value' => 'default-list',
					'type' => 'radio',
					'values' => 'default-list,side-image-list,no-image-list,default-tiles,type-two-tiles',
				),
			),
			'typography'=>array(
				'body'=>array(
					'font'=>'arial',
					'size'=>'13',
					'tablet' => '13',
					'mobile' => '13',
					'color'=>'272727',
					'alias'=>'body'
				),
				'paragraph'=>array(
					'font'=>'arial',
					'size'=>'13',
					'tablet' => '13',
					'mobile' => '13',
					'color'=>'272727',
					'alias'=>'p'
				),
				'anchor'=>array(
					'font'=>'arial',
					'size'=>'13',
					'tablet' => '13',
					'mobile' => '13',
					'color'=>'444444',
					'alias'=>'a'
				),
				'anchor-hover'=>array(
					'font'=>'arial',
					'size'=>'13',
					'tablet' => '13',
					'mobile' => '13',
					'color'=>'0095da',
					'alias'=>'a:hover'
				),
				'heading1'=>array(
					'font'=>'arial',
					'size'=>'24',
					'tablet' => '24',
					'mobile' => '24',
					'color'=>'0095da',
					'alias'=>'h1'
				),
				'heading2'=>array(
					'font'=>'arial',
					'size'=>'22',
					'tablet' => '22',
					'mobile' => '22',
					'color'=>'8dc63f',
					'alias'=>'h2'
				),
				'heading3'=>array(
					'font'=>'arial',
					'size'=>'20',
					'tablet' => '20',
					'mobile' => '20',
					'color'=>'8dc63f',
					'alias'=>'h3'
				),
				'heading4'=>array(
					'font'=>'arial',
					'size'=>'18',
					'tablet' => '18',
					'mobile' => '18',
					'color'=>'8dc63f',
					'alias'=>'h4'
				),
				'heading5'=>array(
					'font'=>'arial',
					'size'=>'16',
					'tablet' => '16',
					'mobile' => '16',
					'color'=>'8dc63f',
					'alias'=>'h5'
				),
				'heading6'=>array(
					'font'=>'arial',
					'size'=>'14',
					'tablet' => '14',
					'mobile' => '14',
					'color'=>'8dc63f',
					'alias'=>'h6'
				),
			),
			'socialmedia'=>array(
				array('Facebook','http://www.facebook.com',THEMEAXEIMAGESPATH. 'social/facebook.png','','no',''),
				array('LinkedIn','http://www.linkedin.com',THEMEAXEIMAGESPATH.'social/linkedin.png','','no',''),
				array('Twitter','http://www.twitter.com',THEMEAXEIMAGESPATH.'social/twitter.png','','no',''),
				array('G+','http://www.gplus.com',THEMEAXEIMAGESPATH.'social/g+.png','','no',''),
				array('Youtube','http://www.youtube.com',THEMEAXEIMAGESPATH.'social/youtube.png','','no','')
			),
			'sidebars'=>array(
	/*array('Topbar Section','topbarsection','topbarsection w w4'),
	array('Banner Section','bannersection','bannersection'),*/
),
			'analytics'=>array(
				'uacode'=>array(
					'key'=>'UA-Code',
					'value'=>'',
					'type'=>'text',
				),
			),
			'gmaps'=>array(
				'gmaps'=>array(
					'key'=>'GMaps-API-Key',
					'value'=>'',
					'type'=>'text',
				),
			),
			'columns'=>array(
				'topbarcols'=>array(
					'key'=>'topbarcolumns',
					'value'=>'4',
					'type'=>'select',
					'values'=>'0,1,2,3,4',
				),
				'footercols'=>array(
					'key'=>'footercolumns',
					'value'=>'4',
					'type'=>'select',
					'values'=>'0,1,2,3,4',
				),
			),
			'contact'=>array(
				'address'=>array(
					'key'=>'address',
					'value'=>'',
					'type'=>'text',
					'adminclass'=>'',
				),
				'address2'=>array(
					'key'=>'address2',
					'value'=>'',
					'type'=>'text',
					'adminclass'=>'',
				),
				'phone1'=>array(
					'key'=>'phone1',
					'value'=>'',
					'type'=>'text',
					'adminclass'=>'',
				),
				'phone2'=>array(
					'key'=>'phone2',
					'value'=>'',
					'type'=>'text',
					'adminclass'=>'',
				),
				'fax'=>array(
					'key'=>'fax',
					'value'=>'',
					'type'=>'text',
					'adminclass'=>'',
				),
				'email'=>array(
					'key'=>'email',
					'value'=>'',
					'type'=>'email',
					'adminclass'=>'',
				),
				'officehours'=>array(
					'key'=>'officehours',
					'value'=>'',
					'type'=>'textarea',
					'adminclass'=>'',
				),
			),
			'gfonts'=>null,

		);
$options = apply_filters('filter_axesettings_before_init',$options);
$axethemesettings = $options;
$options = json_encode($options);
if(is_user_logged_in() && current_user_can('administrator')){
	add_option('themeaxe_options',$options);
}
$axethemesettings = get_option('themeaxe_options');

}else{
	// $axethemesettings = json_decode($axethemesettings);
}
$axethemesettings = json_decode($axethemesettings);
}

function themeaxe_updateoptions(){
	$msg = '';
	$result = null;
	$import = false;
	if(isset($_POST['themeaxe_update_opts'])){
		if(intval($_POST['themeaxe_update_opts']) == 1){
			if(!is_user_logged_in() || !current_user_can('administrator')){
				$result = false;
				$msg = __('You do not have enough privileges to perform this action!!', 'light-axe');
				return array($result,$msg);
			}
			$importtext = $_POST['axeimportsettings'];
			if(!empty($importtext)){
				$importtext = json_decode(stripslashes($importtext),true);
				if(isset($importtext['general']) && isset($importtext['typography']) && isset($importtext['contact']) && isset($importtext['columns']) && isset($importtext['analytics']) && isset($importtext['gmaps'])){
					$options = $importtext;
					$import = true;
				}
			}

			if(!$import){
				$social = null;
				$i = 0;
				if(isset($_POST['socialmediatitle'])){
					foreach($_POST['socialmediatitle'] as $smt){
						$social[$i] = array(
							sanitize_text_field($smt),
							sanitize_text_field($_POST['socialmedialink'][$i]),
							sanitize_text_field($_POST['socialmediaicon'][$i]),
							sanitize_text_field($_POST['socialmediaclasses'][$i]),
							sanitize_text_field($_POST['socialmediafontawesome'][$i]),
							sanitize_text_field($_POST['socialmediaitemclasses'][$i]),
						);
						$i++;
					}
				}

				$sidebars = null;
				$i = 0;
				if(isset($_POST['widgettitle'])){
					foreach($_POST['widgettitle'] as $smt){
						$sidebars[$i] = array(
							sanitize_text_field($smt),
							sanitize_text_field($_POST['widgetid'][$i]),
							sanitize_text_field($_POST['widgetclass'][$i]),
						);
						$i++;
					}
				}

				$gfonts = null;
				$i = 0;
				if(isset($_POST['gfontname'])){
					foreach($_POST['gfontname'] as $smt){
						$gfonts[$i] = array(
							sanitize_text_field($smt),
							sanitize_text_field($_POST['gfontfamily'][$i]),
							sanitize_text_field($_POST['gfontlink'][$i]),
							sanitize_text_field($_POST['gfontfallback'][$i]),
						);
						$i++;
					}
				}

				$typos = array(
					'body'=>null,
					'paragraph'=>null,
					'anchor'=>null,
					'anchor-hover'=>null,
					'heading1'=>null,
					'heading2'=>null,
					'heading3'=>null,
					'heading4'=>null,
					'heading5'=>null,
					'heading6'=>null
				);

				foreach($typos as $key => $val){
					$typos[$key] = array(
						'font'=>sanitize_text_field($_POST[$key.'-font']),
						'size'=>intval(sanitize_text_field($_POST[$key.'-size'])),
						'tablet'=>intval(sanitize_text_field($_POST[$key.'-tablet'])),
						'mobile'=>intval(sanitize_text_field($_POST[$key.'-mobile'])),
						'color'=>sanitize_text_field($_POST[$key.'-color']),
						'alias'=>sanitize_text_field($_POST[$key.'-alias'])
					);
				}

				$contact = array(
					'address'=>array(
						'key'=>'address',
						'value'=>sanitize_text_field($_POST['address']),
						'type'=>'text',
						'adminclass'=>'',
					),
					'address2'=>array(
						'key'=>'address2',
						'value'=>sanitize_text_field($_POST['address2']),
						'type'=>'text',
						'adminclass'=>'',
					),
					'phone1'=>array(
						'key'=>'phone1',
						'value'=>sanitize_text_field($_POST['phone1']),
						'type'=>'text',
						'adminclass'=>'',
					),
					'phone2'=>array(
						'key'=>'phone2',
						'value'=>sanitize_text_field($_POST['phone2']),
						'type'=>'text',
						'adminclass'=>'',
					),
					'fax'=>array(
						'key'=>'fax',
						'value'=>sanitize_text_field($_POST['fax']),
						'type'=>'text',
						'adminclass'=>'',
					),
					'email'=>array(
						'key'=>'email',
						'value'=>sanitize_text_field($_POST['email']),
						'type'=>'email',
						'adminclass'=>'',
					),
					'officehours'=>array(
						'key'=>'officehours',
						'value'=>wp_kses_post($_POST['officehours']),
						'type'=>'textarea',
						'adminclass'=>'',
					),
				);

				$options = array(
					'general'=>array(
						'logo'=>array(
							'key'=>'logo',
							'value'=>sanitize_text_field($_POST['logo']),
							'type'=>'url',
							'adminclass'=>'themeaxemedialoader',
						),
						'favicon'=>array(
							'key'=>'favicon',
							'value'=>sanitize_text_field($_POST['favicon']),
							'type'=>'url',
							'adminclass'=>'themeaxemedialoader',
						),
						'bgcolor'=>array(
							'key'=>'body-background-color',
							'value'=>sanitize_text_field($_POST['body-background-color']),
							'type'=>'color',
						),
						'bgimage'=>array(
							'key'=>'body-background-image',
							'value'=>sanitize_text_field($_POST['body-background-image']),
							'type'=>'url',
							'adminclass'=>'themeaxemedialoader',
						),
						'bgimagetype'=>array(
							'key'=>'body-background-image-type',
							'value'=>sanitize_text_field($_POST['body-background-image-type']),
							'type'=>'select',
							'values'=>'default,fill,fit,repeat,custom',
						),
						'bgimagesize'=>array(
							'key'=>'body-background-image-size',
							'value'=>sanitize_text_field($_POST['body-background-image-size']),
							'type'=>'select',
							'values'=>'auto,contain,cover',
						),
						'bgrepeat'=>array(
							'key'=>'body-background-image-repeat',
							'value'=>sanitize_text_field($_POST['body-background-image-repeat']),
							'type'=>'select',
							'values'=>'no-repeat,repeat,repeat-x,repeat-y',
						),
						'bgattachment'=>array(
							'key'=>'body-background-image-attachment',
							'value'=>sanitize_text_field($_POST['body-background-image-attachment']),
							'type'=>'select',
							'values'=>'scroll,fixed',
						),
						'bgyposition'=>array(
							'key'=>'body-background-y-position',
							'value'=>sanitize_text_field($_POST['body-background-y-position']),
							'type'=>'select',
							'values'=>'center,top,bottom',
						),
						'bgxposition'=>array(
							'key'=>'body-background-x-position',
							'value'=>sanitize_text_field($_POST['body-background-x-position']),
							'type'=>'select',
							'values'=>'center,right,left',
						),
						'wrapperstyle'=>array(
							'key'=>'wrapper-style',
							'value'=>sanitize_text_field($_POST['wrapper-style']),
							'type'=>'select',
							'values'=>'boxed,fullwidth',
						),
						'wrapperwidth'=>array(
							'key'=>'wrapper-width',
							'value'=>sanitize_text_field($_POST['wrapper-width']),
							'type'=>'number',
						),
						'primarycolor'=>array(
							'key'=>'primary-color',
							'value'=>sanitize_text_field($_POST['primary-color']),
							'type'=>'color',
						),
						'secondarycolor'=>array(
							'key'=>'secondary-color',
							'value'=>sanitize_text_field($_POST['secondary-color']),
							'type'=>'color',
						),
						'tertiarycolor'=>array(
							'key'=>'tertiary-color',
							'value'=>sanitize_text_field($_POST['tertiary-color']),
							'type'=>'color',
						),
						'featuredimgstyle'=>array(
							'key'=>'featuredimage-style',
							'value'=>sanitize_text_field($_POST['featuredimage-style']),
							'type'=>'select',
							'values'=>'boxed,fullwidth,parallax',
						),
					),
					'blog'=>array(
						'blogstyle'=>array(
							'key'=>'blog-style',
							'value' => isset($_POST['blog-style']) ? sanitize_text_field($_POST['blog-style']) : 'default-list',
							'type' => 'radio',
							'values' => 'default-list,side-image-list,no-image-list,default-tiles,type-two-tiles',
						),
						'blogimg'=>isset($_POST['blog-img']) ? sanitize_text_field($_POST['blog-img']) : '',
					),
					'typography'=>$typos,
					'socialmedia'=>$social,
					'sidebars'=>$sidebars,
					'contact' => $contact,
					'columns'=>array(
						'topbarcols'=>array(
							'key'=>'topbarcolumns',
							'value'=>sanitize_text_field($_POST['topbarcolumns']),
							'type'=>'select',
							'values'=>'0,1,2,3,4',
						),
						'footercols'=>array(
							'key'=>'footercolumns',
							'value'=>sanitize_text_field($_POST['footercolumns']),
							'type'=>'select',
							'values'=>'0,1,2,3,4',
						),
					),
					'analytics'=>array(
						'uacode'=>array(
							'key'=>'UA-Code',
							'value'=>sanitize_text_field($_POST['UA-Code']),
							'type'=>'text',
						),
					),
					'gmaps'=>array(
						'gmaps'=>array(
							'key'=>'GMaps-API-Key',
							'value'=>sanitize_text_field($_POST['GMaps-API-Key']),
							'type'=>'text',
						),
					),
					'gfonts'=>$gfonts,
				);
}

$options = apply_filters('filter_axesettings_before_update',$options);
$options = json_encode($options);
$activetabis = themeaxe_GetSettingsActiveTabIs();
if(update_option('themeaxe_options',$options)){
	echo "<script>window.location = 'admin.php?page=light-axe&success=1&activetabis=$activetabis'</script>";
	exit();
}else{
	$msg = __('Settings were not updated.', 'light-axe');
	$result = false;
}

}
}else if(isset($_GET['success'])){
	$result = true;
	$msg = __('Theme settings updated successfully.', 'light-axe');
}
return array($result,$msg);
}

function themeaxe_settings(){
	get_template_part( 'admin/axetheme-settings');
}

function themeaxe_GetAllThemeSettings($key = ''){
	global $axethemesettings;
	$key = trim((string)$key);
	$fields = $axethemesettings;
	if($key){
		if(isset($axethemesettings->$key)){
			$fields = $axethemesettings->$key;
		}else{
			$fields = null;
		}
	}
	return $fields;
}

function themeaxe_fieldgenerator($val){
	$html = '';
	switch($val->type){
		case 'select':
		$html = themeaxe_select($val);
		break;
		case 'color':
		$html = themeaxe_color($val);
		break;
		case 'textarea':
		$html = themeaxe_textarea($val);
		break;
		default:
		$html = themeaxe_text($val);
		break;
	}
	return $html;
}

function themeaxe_select($val){
	$name = themeaxe_fieldname($val);
	$class = themeaxe_fieldAdminClass($val);
	$html = '<select placeholder="'.$name.'" '.$class.' name="'.$val->key.'" >';
	$values = explode(',',$val->values);
	foreach($values as $v){
		$selected = '';
		if($v == $val->value){
			$selected = 'selected="selected"';
		}
		$html .= '<option value="'.$v.'" '.$selected.'>'.$v.'</option>';
	}

	$html .= '</select>';
	return $html;
}

function themeaxe_text($val){
	$name = themeaxe_fieldname($val);
	$class='';
	if(isset($val->adminclass)){
		$class = 'class="'.$val->adminclass.'"';
	}
	return '<input type="'.$val->type.'" '.$class.' placeholder="'.$name.'" name="'.$val->key.'" value="'.$val->value.'"  />';
}

function themeaxe_textarea($val){
	$name = themeaxe_fieldname($val);
	$class='';
	if(isset($val->adminclass)){
		$class = 'class="'.$val->adminclass.'"';
	}
	return '<textarea '.$class.' placeholder="'.$name.'" name="'.$val->key.'">'.esc_attr($val->value).'</textarea>';
}

function themeaxe_color($val){
	$name = themeaxe_fieldname($val);
	$class= themeaxe_fieldAdminClass($val);
	return '<input type="text" class="color" placeholder="'.$name.'" name="'.$val->key.'" value="'.$val->value.'"  />';
}

function themeaxe_fieldname($val){
	return ucfirst(str_replace('-',' ',$val->key));
}

function themeaxe_fieldAdminClass($val){
	$class='';
	if(isset($val->adminclass)){
		$class = 'class="'.$val->adminclass.'"';
	}
	return $class;
}

function themeaxe_fonts(){
	$fonts = array(
		/* Serifs */
		'baskerville'=>array('font'=>'Baskerville','family'=>'Baskerville, "Baskerville Old Face", "Hoefler Text", Garamond, "Times New Roman", serif'),
		'book-antiqua'=>array('font'=>'Book Antiqua','family'=>'"Book Antiqua", Palatino, "Palatino Linotype", "Palatino LT STD", Georgia, serif'),
		'garamond'=>array('font'=>'Garamond','family'=>'Garamond, Baskerville, "Baskerville Old Face", "Hoefler Text", "Times New Roman", serif'),
		'georgia'=>array('font'=>'Georgia','family'=>'Georgia, serif'),
		'lucida-bright'=>array('font'=>'Lucida Bright','family'=>'"Lucida Bright", Georgia, serif'),
		'palatino'=>array('font'=>'Palatino','family'=>'"Palatino Linotype", "Book Antiqua", Palatino, serif'),
		'times-new-roman'=>array('font'=>'Time New Roman','family'=>'"Times New Roman", Times, serif'),
		/* Serifs */

		/* San Serifs */
		'arial' => array('font'=>'Arial','family'=>'Arial, Helvetica, sans-serif;'),
		'arial-black'=>array('font'=>'Arial Black','family'=>'"Arial Black", Gadget, sans-serif'),
		'arial-narrow'=>array('font'=>'Arial Narrow','family'=>'"Arial Narrow", Arial, sans-serif'),
		'calibri'=>array('font'=>'Calibri','family'=>'Calibri, Candara, Segoe, "Segoe UI", Optima, Arial, sans-serif'),
		'century-gothic'=>array('font'=>'Century Gothic','family'=>'"Century Gothic", CenturyGothic, AppleGothic, sans-serif'),

		'comic-sans'=>array('font'=>'Comic Sans','family'=>'"Comic Sans MS", cursive, sans-serif'),
		'impact'=>array('font'=>'Impact','family'=>'Impact, Charcoal, sans-serif'),
		'lucida'=>array('font'=>'Lucida','family'=>'"Lucida Sans Unicode", "Lucida Grande", sans-serif'),
		'lucida-sans-typewriter'=>array('font'=>'Lucida Sans Typewriter','family'=>'"Lucida Sans Typewriter", "Lucida Console", Monaco, "Bitstream Vera Sans Mono", monospace'),
		'tahoma'=>array('font'=>'Tahoma','family'=>'Tahoma, Geneva, sans-serif'),
		'trebuchet-ms'=>array('font'=>'Trebuchet MS','family'=>'"Trebuchet MS", Helvetica, sans-serif'),
		'verdana'=>array('font'=>'Verdana','family'=>'Verdana, Geneva, sans-serif'),
		/* San Serifs */

		/* Monospace */
		'courier-new'=>array('font'=>'Courier New','family'=>'"Courier New", Courier, monospace'),
		'lucida-console'=>array('font'=>'Lucida Console','family'=>'"Lucida Console", Monaco, monospace'),
		/* Monospace */

		/* Fantasy */
		'copperplate'=>array('font'=>'Copperplate','family'=>'Copperplate, "Copperplate Gothic Light", fantasy'),
		'papyrus'=>array('font'=>'Papyrus','family'=>'Papyrus, fantasy'),
		/* Fantasy */

		/* Script */
		'brush-script-mt'=>array('font'=>'Brush Script MT','family'=>'"Brush Script MT", cursive'),
		/* Script */
	);

	$lcf = themeaxe_customFonts();
	if($lcf){
		$fonts = array_merge($fonts,$lcf);
	}

	$gfonts = themeaxe_gFontList();
	if($gfonts){
		$fonts = array_merge($fonts,$gfonts);
	}

	return $fonts;
}

function themeaxe_customFonts(){
	$listCFonts = null;
	if(file_exists(FONTFOLDER)){
		if(is_dir(FONTFOLDER)){
			$listCFonts = array_diff ( scandir ( FONTFOLDER ), array ('.','..','index.html' ) );
		}
	}
	$lcf = null;
	if($listCFonts){
		foreach ($listCFonts as $cfont) {
			$lcf[themeaxe_cfontId($cfont)] = array('font'=>themeaxe_cfontName($cfont),'family'=> '"'.themeaxe_cfontFamily($cfont).'"');
		}
	}

	return $lcf;
}

function themeaxe_cfontName($name){
	return str_replace('-',' ',$name);
}

function themeaxe_cfontId($name){
	return (str_replace(' ','-',$name));
}

function themeaxe_cfontFamily($name){
	return str_replace(array('-webfont'),array(''),$name);
}

function themeaxe_myFontFace(){
	$cfonts = themeaxe_customFonts();
	$fface = '';
	if($cfonts){
		if(file_exists(FONTFOLDER)){
			foreach ($cfonts as $font => $val) {
				if(file_exists(FONTFOLDER .'/'. $font)){
					$files = null;
					if(is_dir(FONTFOLDER .'/'. $font)){
						$files = array_diff ( scandir ( FONTFOLDER .'/'. $font ), array ('.','..','.html' ) );
					}
					if($files){
						$face = '';
						$eot = '';
						$eotfix = '';
						$woff = '';
						$ttf = '';
						$otf = '';
						$svg = '';
						foreach ( $files as $f )
						{


							$fx = explode ( ".", $f );
							$ff = end ( $fx );

							if(in_array($ff, array('ttf','otf','woff','svg','eot'))){
								/*echo 'inside';*/
								switch($ff){
									case 'eot':
									$eot = 'url(\''.FONTURI.'/'.$font.'/'.$f.'\');';
									$eotfix = 'url(\''.FONTURI.'/'.$font.'/'.$f.'?#iefix\') format(\'embedded-opentype\')';
									break;
									case 'woff':
									$woff = 'url(\''.FONTURI.'/'.$font.'/'.$f.'\') format(\'woff\')';
									break;
									case 'ttf':
									$ttf = 'url(\''.FONTURI.'/'.$font.'/'.$f.'\') format(\'truetype\')';
									break;
									case 'otf':
									$otf ='url(\''.FONTURI.'/'.$font.'/'.$f.'\') format(\'opentype\')';
									break;
									case 'svg':
									$svg = 'url(\''.FONTURI.'/'.$font.'/'.$f.'#'.themeaxe_cfontFamily($font).'\') format(\'svg\')';
									break;
								}

							}else{
								/*echo 'No File Ext : '. $ff;*/
							}


						}

						if(!empty($eot)){
							$face = 'src:'.$eot . '
							src: '. $eotfix;
							$cfs = array($woff,$ttf,$otf,$svg);
							foreach ($cfs as $s) {
								if(!empty($s)){
									$face .= ',
									'.$s;
								}
							}
							$face .= ';';

						}else{
							$face = 'src: ';
							$cfs = array($woff,$ttf,$otf,$svg);
							foreach ($cfs as $s) {
								if(!empty($s)){
									$face .= ','.$s;
								}
							}
							$face .= ';';
						}
						$fface .= '@font-face{
							font-family:"'.themeaxe_cfontFamily($font).'";
							'. $face.'
							font-weight:normal;
							font-style: normal;
						}
						';


					}else{
						/*echo 'No Files in : ' . FONTFOLDER .'/'. $font;*/
					}
				}else{
					/* 404 */
				}
			}
		}else{
			/* 404 */
		}
	}
	return $fface;
}

function themeaxe_myFFace(){
	$cfonts = themeaxe_customFonts();
	$fface = '';
	if($cfonts){
		if(file_exists(FONTFOLDER)){
			foreach ($cfonts as $font => $val) {
				$files = array_diff ( scandir ( FONTFOLDER .'/'. $font ), array ('.','..' ) );
				if($files){
					foreach ( $files as $f )
					{
						$fx = explode ( ".", $f );
						$ff = end ( $fx );

						if(in_array($ff, array('css'))){
							$fface .= '<link rel="stylesheet" href="'.FONTURI .'/'.$font.'/'.$f.'" type="text/css" charset="utf-8" />';
							break;
						}
					}
				}
			}
		}else{
			/* 404 */
		}
	}
	return $fface;
}

/* GFont List */
function themeaxe_gFontList(){
	$gf = themeaxe_GetAllThemeSettings('gfonts');
	$gfonts  = null;
	if($gf){
		foreach ($gf as $cfont) {
			$fontfamily = isset($cfont[3]) ? trim($cfont[3]) : '';
			$fontfamily = $fontfamily ? '"'.$cfont[1] . '",'.$fontfamily : $cfont[1];
			$gfonts[themeaxe_cfontId($cfont[0])] = array('font'=>themeaxe_cfontName($cfont[0]),'family'=> themeaxe_cfontFamily($fontfamily),'url'=>themeaxe_cfontFamily($cfont[2]));
		}
	}
	return $gfonts;
}

function themeaxe_gFontFace(){
	$fface = '';
	$gfonts = themeaxe_gFontList();
	if($gfonts){
		foreach ($gfonts as $key => $val) {
			$fface .= '<link href="'.$val['url'].'" rel="stylesheet" type="text/css">
			';
		}
	}
	return $fface;
}
/* GFont List */

function themeaxe_abouttheme(){
	get_template_part('admin/axetheme', 'about');
}

/* Default Settings */
function themeaxe_GetThemeContentWidth(){
	$axethemesettings = themeaxe_GetAllThemeSettings('general');
	if($axethemesettings){
		if(isset($axethemesettings->wrapperwidth)){
			return $axethemesettings->wrapperwidth->value;
		}
	}
	return 960;
}

function themeaxe_GetThemeBackgroundOptions(){
	$general = themeaxe_GetAllThemeSettings('general');
	$args = array(
		'default-image' => $general->bgimage->value,
		'default-preset' => $general->bgimagetype->value,  /*'default', 'fill', 'fit', 'repeat', 'custom'*/
		'default-position-x' => $general->bgxposition->value,    /* 'left', 'center', 'right'*/
		'default-position-y' => $general->bgyposition->value,     /*'top', 'center', 'bottom'*/
		'default-size' => $general->bgimagesize->value,    /*'auto', 'contain', 'cover'*/
		'default-repeat' => $general->bgrepeat->value,  /* 'repeat-x', 'repeat-y', 'repeat', 'no-repeat'*/
		'default-attachment' => $general->bgattachment->value,  /* 'scroll', 'fixed'*/
		'default-color' => $general->bgcolor->value,
		'wp-head-callback' => '_custom_background_cb',
		'admin-head-callback' => '',
		'admin-preview-callback' => '',
	);

	return $args;
}

function themeaxe_GetThemeHeaderOptions(){
	$args = array(
		'default-image' => '',
		'random-default' => false,
		'width'  => 0,
		'height' => 0,
		'flex-height' => false,
		'flex-width' => false,
		'default-text-color' => '',
		'header-text' => true,
		'uploads' => true,
		'wp-head-callback' => '',
		'admin-head-callback' => '',
		'admin-preview-callback' => '',
		'video'  => false,
		'video-active-callback' => 'is_front_page',
	);
	return $args;
}
function themeaxe_GetThemeLogoOptions(){
	$general = themeaxe_GetAllThemeSettings('general');
	$args  = array(
		'height'      => 100,
		'width'       => 400,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array( 'site-title', 'site-description' ),
	);

	return $args;
}
/* Default Settings */

?>