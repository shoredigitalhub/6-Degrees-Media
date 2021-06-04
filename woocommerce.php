<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'What are you doing here.' );
}
get_header();
?>
<div id="maincontentinner">
	<?php do_action('axe_before_maincontent_inner'); ?>
	<div class="wrapwidth woo_wrapwidth">
		<?php
		if ( is_singular( 'product' ) ) {
			woocommerce_content();
		}else{
			do_action( 'woocommerce_before_main_content' );

			?>
			<header class="woocommerce-products-header">
				<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
					<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
				<?php endif; ?>

				<?php
				do_action( 'woocommerce_archive_description' );
				?>
			</header>
			<?php
			if ( woocommerce_product_loop() ) {
				do_action( 'woocommerce_before_shop_loop' );

				woocommerce_product_loop_start();

				if ( wc_get_loop_prop( 'total' ) ) {
					while ( have_posts() ) {
						the_post();
						do_action( 'woocommerce_shop_loop' );
						wc_get_template_part( 'content', 'product' );
					}
				}

				woocommerce_product_loop_end();
				do_action( 'woocommerce_after_shop_loop' );
			} else {
				do_action( 'woocommerce_no_products_found' );
			}

			do_action( 'woocommerce_after_main_content' );
			do_action( 'woocommerce_sidebar' );
		}
		?>
	</div>
	<?php do_action('axe_after_maincontent_inner'); ?>
</div>
<?php do_action('axe_after_page_content'); ?>
<div class="before_axe_get_footer_container">
	<?php do_action('before_axe_get_footer'); ?>
</div>
<?php
get_footer();
?>