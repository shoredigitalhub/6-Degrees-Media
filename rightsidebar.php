<?php
/*
Template Name: Right Sidebar Template
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'What are you doing here.' );
}
get_header();
?>
<div id="maincontentinner">
    <?php do_action('axe_before_maincontent_inner'); ?>
    <div class="wrapwidth axeflex">
        <div class="w w8 contentcolumn">
            <?php
            if (have_posts()) {
                while (have_posts()) {
                    the_post();
                    get_template_part('page','content');
                    if ( comments_open() || get_comments_number() ) {
                        comments_template();
                    }
                }
            }
            ?>
        </div>
        <div class="w w4 sidebarcolumn">
            <div class="axesidebar">
                <?php do_action('right_sidebar_caller'); ?>
            </div>
        </div>

    </div>
    <?php do_action('axe_after_maincontent_inner'); ?>
</div>
<?php
do_action('axe_after_page_content_full');
?>
<div class="before_axe_get_footer_container">
    <?php
    do_action('before_axe_get_footer');
    ?>
</div>
<?php
get_footer();
?>