<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'What are you doing here.' );
}
do_action('before_axe_titleheading');
do_action('axe_main_title');
?>
<div class="contents">
	<div id="post-<?php the_ID(); ?>" <?php post_class()?>>
		<?php
		do_action('before_axe_page_content');
		do_action('axe_page_content');
		do_action('after_axe_page_content');
		?>
	</div>
</div>
<?php do_action('after_axe_contents'); ?>
