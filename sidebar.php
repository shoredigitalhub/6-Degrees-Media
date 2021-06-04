<?php
/*
Sidebar.php
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'What are you doing here.' );
}
?>
<div class="sidebarcolumn dsidebar w w4">
	<div class="axesidebar">
		<?php
		if(function_exists('is_shop')){
			if(is_shop() || is_archive('product_category')){
				themeaxe_sidebar('shopsidebar',true);
			}else{
				themeaxe_sidebar('default');
			}
		}else{
			themeaxe_sidebar('default');
		}
		?>

	</div>
</div>