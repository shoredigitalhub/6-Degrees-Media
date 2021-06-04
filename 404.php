<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'What are you doing here.' );
}
get_header();
?>
<div id="maincontentinner">
    <div class="wrapwidth">
        <div class="mcontent whitebg">
            <h1 class="titleheading">
                Not Found
            </h1>
            <div class="contents">
                Oops.. This is not what you are looking for...
            </div>
        </div>
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