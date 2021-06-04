<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'What are you doing here.' );
}
if(!defined('THEMEAXE')){
	define('THEMEAXE','Light AXe&trade;');
	define('THEMEAXENAME','light-axe');
	define('THEMEAXEVER','1.1.6');
	define('THEMEAXELANGDOMAIN', 'light-axe');

	define('THEMEAXEROOT',get_template_directory());
	define('THEMEAXEPATH', trailingslashit(get_template_directory_uri()));
	define('THEMEAXEASSETSPATH',trailingslashit(THEMEAXEPATH.'assets'));
	define('THEMEAXEJSPATH',trailingslashit(THEMEAXEASSETSPATH.'js'));
	define('THEMEAXEIMAGESPATH',trailingslashit(THEMEAXEASSETSPATH.'images'));

	define('THEMEAXEADMINPATH',trailingslashit(THEMEAXEPATH . 'admin'));
	define('THEMEAXEADMINASSETSPATH',trailingslashit(THEMEAXEADMINPATH . 'assets'));
	define('THEMEAXEADMINJSPATH',trailingslashit(THEMEAXEADMINASSETSPATH . 'js'));
	define('THEMEAXEADMINCSSPATH',trailingslashit(THEMEAXEADMINASSETSPATH . 'css'));
	define('THEMEAXEADMINIMAGESPATH',trailingslashit(THEMEAXEADMINASSETSPATH . 'images'));

	define('CURRENTTHEMEAXEROOT',get_stylesheet_directory());
	define('CURRENTTHEMEAXEPATH', get_stylesheet_directory_uri());
	define('FONTFOLDER',CURRENTTHEMEAXEROOT.'/fonts');
	define('FONTURI',CURRENTTHEMEAXEPATH.'/fonts');
}