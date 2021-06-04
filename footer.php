<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'What are you doing here.' );
}
?>
</div>  <!-- #maincontent -->


<div id="basefooter">
	<div class="basefooterinner">
		<div id="fullwidthbeforefooter">
			<?php do_action('axe_fullwidth_before_footer'); ?>
		</div>
		<div id="footer" class="">
			<?php do_action('axe_above_footer'); ?>
			<div class="wrapwidth footinner axeflex">
				<?php themeaxe_Footer(); ?>

			</div>
			<?php do_action('axe_after_footer'); ?>

		</div> <!-- #footer -->
		<?php do_action('axe_before_footer_bottom'); ?>
		<div class="footer-bottom">
			<div class="wrapwidth">
				<?php themeaxe_sidebar('footer-copyright'); ?>

			</div>
		</div>

	</div>
</div>
</div> <!-- #wrapper -->

<?php wp_footer(); ?>
<!-- <center><?php echo memory_get_peak_usage(false)/1024/1024 . 'MB'?></center>-->
</body>
</html>