<?php
if(!defined('THEMEAXE')){
	exit('What are you doing here??');
}

require_once THEMEAXEROOT.'/includes/vendors/tgm/tgm-plugin-activator/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'themeaxe_register_required_plugins' );

function themeaxe_register_required_plugins(){

	$plugins = array(
		/*array(
			'name'               => 'Light AXe Shortcodes',
			'slug'               => 'light-axe-shortcodes',
			'required'           => true,
			'version'            => '1.0.0',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
			'is_callable'        => '',
		),*/
		array(
			'name'      => 'Elementor Page Builder',
			'slug'      => 'elementor',
			'required'  => false,
		),
		array(
			'name'      => 'Page Builder',
			'slug'      => 'siteorigin-panels',
			'required'  => false,
		),
		array(
			'name'      => 'MetaSlider',
			'slug'      => 'ml-slider',
			'required'  => false,
		),
		array(
			'name'      => 'Contact Form 7',
			'slug'      => 'contact-form-7',
			'required'  => false,
		),
		array(
			'name'      => 'WP Fastest Cache',
			'slug'      => 'wp-fastest-cache',
			'required'  => false,
		),
		array(
			'name'      => 'All In One WP Security & Firewall',
			'slug'      => 'all-in-one-wp-security-and-firewall',
			'required'  => false,
		),
		array(
			'name'      => 'Yoast SEO',
			'slug'      => 'wordpress-seo',
			'required'  => false,
		),
	);

	$config = array(
		'id'           => 'light-axe',
		'default_path' =>  get_template_directory() . '/includes/plugins/',
		'menu'         => 'light-axe-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);

	tgmpa( $plugins, $config );
}
?>