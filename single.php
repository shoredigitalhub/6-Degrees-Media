<?php
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
                    ?>
                    <div class="mcontent whitebg">
                        <div id="post-<?php the_ID(); ?>" <?php post_class()?>>
                            <?php do_action('axe_main_title'); ?>
                            <?php do_action('axe_blogpost_meta'); ?>
                            <?php do_action('axe_blogpost_content'); ?>
                        </div>
                    </div>
                    <?php
                    if ( comments_open() || get_comments_number() ) {
                        comments_template();
                    }
                }
            }
            ?>
        </div>
        <div class="w w4 sidebarcolumn">
            <div class="axesidebar">
                <?php themeaxe_sidebar('default');?>
            </div>
        </div>

    </div>
    <?php do_action('axe_after_maincontent_inner'); ?>
</div>
<?php
do_action('axe_after_page_content');
?>
<div class="before_axe_get_footer_container">
    <?php
    do_action('before_axe_get_footer');
    ?>
</div>
<?php
get_footer();
?>