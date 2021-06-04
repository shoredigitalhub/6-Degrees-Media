<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'What are you doing here.' );
}
get_header();
?>
<div id="maincontentinner">
    <?php do_action('axe_before_maincontent_inner'); ?>
    <div class="wrapwidth">
        <div class="mcontent">
            <?php  do_action('axe_before_index_loop'); ?>
            <div class="axeflex">
                <div class="w w8 contentcolumn">
                    <?php
                    if (have_posts()) {
                        while (have_posts()) {
                            the_post();
                            do_action('axeblogloop_start');
                            do_action('axesearch_template');
                            do_action('axeblogloop_end');
                        }

                        do_action('axe_post_navigation');
                    }else{
                        do_action('axeblogloop_noresult');
                    }
                    ?>
                </div>
                <div class="w w4 sidebarcolumn">
                    <div class="axesidebar">
                        <?php themeaxe_sidebar('default');?>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <?php if(!is_search()){ do_action('axe_after_maincontent_inner'); } ?>
</div>
<?php
if(!is_search()){ do_action('axe_after_page_content'); }
?>
<div class="before_axe_get_footer_container">
    <?php
    do_action('before_axe_get_footer');
    ?>
</div>
<?php get_footer();
?>