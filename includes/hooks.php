<?php
if(!defined('THEMEAXE')){
	exit('What are you doing here??');
}
function themeaxe_head_meta(){
	global $post;
	$tags = '';
	$description = '';
	if(isset($post->ID)){
		$tags = get_post_meta($post->ID,'_axe_meta_keywords',true);
		$description = get_post_meta($post->ID,'_axe_meta_description',true);
		if(empty($description)){
			$len = 100;
			$description = wp_trim_words($post->post_content,$len);
		}
	}
	?>
	<meta name="keywords" content="<?php echo $tags; ?>" />
	<meta name="description" content="<?php echo $description; ?>" />
	<?php

	if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
}
add_action('wp_head','themeaxe_head_meta');


function themeaxe_head_metaauthor(){
	global $post;
	$author = '';
	if(isset($post->post_author)){
		$author = get_userdata($post->post_author);
		$author = $author->user_nicename;
	}
	?>
	<meta name="author" content="<?php echo $author; ?>">
	<?php
}
add_action('wp_head','themeaxe_head_metaauthor');

function themeaxe_logo(){
	$class = apply_filters('axe_logoclass_filter','w w3 axelogoarea');
	?>
	<div id="logoarea" class="<?php echo $class; ?>">
		<?php
		do_action('axe_above_logo');
		themeaxe_printLogo();
		do_action('axe_after_logo');
		?>
	</div>
	<?php
}
add_action('axe_logomenusection','themeaxe_logo',10);

function themeaxe_mainmenu(){
	$class = apply_filters('axe_mainmenuclass_filter','w w9 axemainmenu');
	?>
	<div id="mainmenu" class="<?php echo $class; ?>">
		<?php do_action('axe_above_main_nav');
		$args = apply_filters('axe_menu_theme_location',array('theme_location'  =>'primary'));
		wp_nav_menu($args);
		do_action('axe_after_main_nav');
		?>

	</div>
	<?php
}
add_action('axe_logomenusection','themeaxe_mainmenu',15);

function themeaxe_topbarsection(){
	$class = apply_filters('axe_topbarclass_filter','primarycolor');
	?>
	<div id="topheader" class="<?php echo $class; ?>">
		<div class="wrapwidth">
			<?php themeaxe_Topbar(); ?>

		</div>
	</div>
	<?php
}
add_action('axe_topbar','themeaxe_topbarsection',10);

function themeaxe_subheadsection(){
	$class = apply_filters('axe_logomenuclass_filter','');
	?>
	<div class="subhead">
		<?php do_action('axe_before_logomenusection'); ?>
		<div id="logomenusection" class="<?php echo $class; ?>">
			<div class="wrapwidth">
				<?php do_action('axe_logomenusection'); ?>

			</div>
		</div>
		<?php do_action('axe_after_logomenusection'); ?>


	</div>
	<?php
}
add_action('axe_subhead','themeaxe_subheadsection',10);

function themeaxe_bannersection(){
	?>
	<div id="bannersection">
		<?php
		do_action('axe_inside_bannersection_above');
		themeaxe_FeaturedSection();
		do_action('axe_inside_bannersection_below');
		?>

	</div>
	<?php
}
add_action('axe_banner','themeaxe_bannersection',10);

function themeaxe_postnavigation(){
	$nxt = get_next_posts_link('Older Posts');
	$prv = get_previous_posts_link('Newer Posts');
	$navclass= '';
	if($nxt || $prv){
		$navclass = 'whitebg shadowed';
	}
	if($nxt || $prv){
		?>
		<div class="paginationblock <?php echo $navclass; ?>">
			<div class="nav-previous left"><?php echo $nxt; ?></div>
			<div class="nav-next right"><?php echo $prv; ?></div>
		</div>
		<?php
	}
}
add_action('axe_post_navigation','themeaxe_postnavigation',10);

/* Search Template */

function themeaxe_search_template_title(){
	$title = get_the_title();
	if($title){
		?>
		<a href="<?php the_permalink(); ?>">
			<h2 class="titleheading">
				<?php echo $title; ?>
			</h2>
		</a>
		<?php
	}
}
add_action('axesearch_template','themeaxe_search_template_title',10);
function  themeaxe_search_template_content(){
	?>
	<div class="contents">
		<?php themeaxe_FeaturedImg(); ?>
		<?php the_excerpt(); ?>
	</div>
	<?php
}
add_action('axesearch_template','themeaxe_search_template_content',20);

/* Search Template */

/* No Result Template */
function themeaxe_blogloop_noresult_content(){
	?>
	<div class="mcontent whitebg shadowed">
		<h1>Ooops !!</h1>
		<p>No results matched your criteria.</p>
	</div>
	<?php
}
add_action('axeblogloop_noresult','themeaxe_blogloop_noresult_content',10);
/* No Result Template  */

/* Blog Template */
function themeaxe_getBlogStyle(){
	$blog = themeaxe_GetAllThemeSettings('blog');
	return $blog->blogstyle->value;

}
function themeaxe_blogloop_start_div(){
	$blogstyle = str_replace('-','',themeaxe_getBlogStyle());
	$class= apply_filters('axe_blogloop_class','whitebg shadowed');

	echo '<div class="bloglistlayout '.$blogstyle . ' ' . get_post_format().'">';
	echo '<div class="mcontent posrelative '. $class .'">';
	echo '<div id="post-'.get_the_ID().'" class="' . implode(' ',get_post_class()).'">';
}
add_action('axeblogloop_start','themeaxe_blogloop_start_div');

function themeaxe_blogtemplates(){
	$blogstyle = str_replace('-','_',themeaxe_getBlogStyle());
	switch ($blogstyle) {
		case 'side_image_list':
		case 'no_image_list':
		case 'default_tiles':
		case 'type_two_tiles':
		do_action('axeblogloop_template_'.$blogstyle);
		break;
		default:
		do_action('axeblogloop_template_default_list');
		break;
	}
}
add_action('axeblogloop_template','themeaxe_blogtemplates');
/* axeblogloop_template_default_list */
function themeaxe_blogloop_template_content(){
	?>
	<div class="contents">
		<?php do_action('axeblogloop_template_default_list_inner');?>
	</div>
	<?php
}
add_action('axeblogloop_template_default_list','themeaxe_blogloop_template_content',40);
/* axeblogloop_template_default_list */

/* axeblogloop_template_side_image_list */
function themeaxe_blogloopside_image(){
	?>
	<div class="w w4 axeblogloop_template_side_image_list_image">
		<?php do_action('axeblogloop_template_side_image_list_image_inner'); ?>
	</div>
	<?php
}
add_action('axeblogloop_template_side_image_list','themeaxe_blogloopside_image',10);
function themeaxe_blogloopside_content(){
	?>
	<div class="w w8 axeblogloop_template_side_image_list_content">
		<div class="contents">
			<?php do_action('axeblogloop_template_side_image_list_inner'); ?>
		</div>
	</div>
	<?php
}
add_action('axeblogloop_template_side_image_list','themeaxe_blogloopside_content',20);
/* axeblogloop_template_side_image_list */

/* axeblogloop_template_no_image_list */
function themeaxe_blogloopnoimage_content(){
	?>
	<div class="axeblogloop_template_no_image_list_content">
		<div class="contents">
			<?php do_action('axeblogloop_template_no_image_list_inner'); ?>
		</div>
	</div>
	<?php
}
/* axeblogloop_template_no_image_list */

/* axeblogloop_template_default_tiles */
function themeaxe_blogloopdefault_tiles_image(){
	?>
	<div class="axeblogloop_template_default_tiles_image">
		<?php do_action('axeblogloop_template_default_tiles_image_inner'); ?>
	</div>
	<?php
}
add_action('axeblogloop_template_default_tiles','themeaxe_blogloopdefault_tiles_image',10);
function themeaxe_blogloopdefault_tiles_content(){
	?>
	<div class="axeblogloop_template_default_tiles_content">
		<div class="contents">
			<?php do_action('axeblogloop_template_default_tiles_inner'); ?>
		</div>
	</div>
	<?php
}
add_action('axeblogloop_template_default_tiles','themeaxe_blogloopdefault_tiles_content',20);
/* axeblogloop_template_default_tiles */

/* axeblogloop_template_type_two_tiles */
function themeaxe_bloglooptype_two_tiles_image(){
	?>
	<div class="axeblogloop_template_type_two_tiles_image">
		<?php do_action('axeblogloop_template_type_two_tiles_image_inner'); ?>
	</div>
	<?php
}
add_action('axeblogloop_template_type_two_tiles','themeaxe_bloglooptype_two_tiles_image',10);
function themeaxe_bloglooptype_two_tiles_content(){
	?>
	<div class="axeblogloop_template_type_two_tiles_content">
		<div class="contents">
			<?php do_action('axeblogloop_template_type_two_tiles_inner'); ?>
		</div>
	</div>
	<?php
}
add_action('axeblogloop_template_type_two_tiles_image_inner','themeaxe_bloglooptype_two_tiles_content',20);
/* axeblogloop_template_type_two_tiles */

add_action('axeblogloop_template_no_image_list','themeaxe_blogloopnoimage_content',10);
function themeaxe_blogloopexcerpt(){
	the_excerpt();
}
add_action('axeblogloop_template_side_image_list_inner','themeaxe_blogloopexcerpt',20);
add_action('axeblogloop_template_default_list_inner','themeaxe_blogloopexcerpt',20);
add_action('axeblogloop_template_no_image_list_inner','themeaxe_blogloopexcerpt',30);
add_action('axeblogloop_template_type_two_tiles_inner','themeaxe_blogloopexcerpt',20);

function themeaxe_blogloopimage(){
	$getdefault = false;

	if(is_home() || is_author()){
		$blogstyle = str_replace('-','_',themeaxe_getBlogStyle());
		switch ($blogstyle) {
			case 'side_image_list':
			case 'default_tiles':
			case 'type_two_tiles':
			$getdefault = true;
			break;
		}
	}
	themeaxe_FeaturedImg(0,'',$getdefault);
}
add_action('axeblogloop_template_default_list_inner','themeaxe_blogloopimage',10);
add_action('axeblogloop_template_side_image_list_image_inner','themeaxe_blogloopimage',10);
add_action('axeblogloop_template_default_tiles_image_inner','themeaxe_blogloopimage',10);
add_action('axeblogloop_template_type_two_tiles_image_inner','themeaxe_blogloopimage',10);

function themeaxe_blogloop_template_comment(){
	?>
	<span class="commentcount"><a href="<?php echo get_the_permalink().'#comments'; ?>"><?php $cnum = get_comments_number(); echo $cnum; ?></a></span>
	<?php
}
add_action('axeblogloop_template_default_list','themeaxe_blogloop_template_comment',10);
function themeaxe_blogloop_template_title(){
	$title = get_the_title();
	if($title){
		?>
		<a href="<?php the_permalink(); ?>" class="axeblogtitleurl">
			<h2 class="titleheading">
				<?php echo $title; ?>
			</h2>
		</a>
		<?php
	}
}
add_action('axeblogloop_template_default_list','themeaxe_blogloop_template_title',20);
add_action('axeblogloop_template_side_image_list_inner','themeaxe_blogloop_template_title',10);
add_action('axeblogloop_template_no_image_list_inner','themeaxe_blogloop_template_title',10);
add_action('axeblogloop_template_default_tiles_inner','themeaxe_blogloop_template_title',10);
add_action('axeblogloop_template_type_two_tiles_inner','themeaxe_blogloop_template_title',10);
add_action('axeblogloop_template_type_two_tiles_image_inner','themeaxe_blogloop_template_title',5);
function themeaxe_blogloop_template_meta(){
	?>
	<h6 class="postmeta"><span>By <?php the_author_posts_link(); ?></span><span class="right"><?php echo get_the_date(); ?></span></h6>
	<?php
}
add_action('axeblogloop_template_default_list','themeaxe_blogloop_template_meta',30);
add_action('axeblogloop_template_side_image_list_inner','themeaxe_blogloop_template_meta',15);
add_action('axeblogloop_template_no_image_list_inner','themeaxe_blogloop_template_meta',20);
add_action('axeblogloop_template_default_tiles_inner','themeaxe_blogloop_template_meta',30);
add_action('axeblogloop_template_type_two_tiles_inner','themeaxe_blogloop_template_meta',30);
add_action('axe_blogpost_meta','themeaxe_blogloop_template_meta',10);


function themeaxe_blogloop_end_div(){
	echo '';
	echo '</div>';
	echo '</div>';
	echo '</div>';
}
add_action('axeblogloop_end','themeaxe_blogloop_end_div');
/* Blog Template */


/* Page Template */
function themeaxe_afterpagecontent_sections(){
	global $post;
	if(!$post){return;}
	$after = get_post_meta($post->ID,'_axe_after_content',true);
	/*$after = json_decode($after,true);*/
	if(is_array($after)){
		foreach($after as $aft){
			$enabled = isset($aft['axe_after_content_enabled']) ? esc_attr($aft['axe_after_content_enabled']) ? esc_attr($aft['axe_after_content_enabled']) : 'yes' : 'yes';
			if($enabled === 'yes'){
				$allvalues = array('enabled'=>$enabled);
				$type = isset($aft['axe_after_content_type']) ? esc_attr($aft['axe_after_content_type']) ? esc_attr($aft['axe_after_content_type']) : 'block' : 'block';
				$containerwidth = isset($aft['axe_after_content_containerwidth']) ? esc_attr($aft['axe_after_content_containerwidth']) ? esc_attr($aft['axe_after_content_containerwidth']) : '12' : '12';
				$allvalues['type'] = $type;
				$allvalues['containerwidth'] = $containerwidth == '12' ? 'fullwidth' : 'w w'.$containerwidth.' w680p';
				$allvalues['bg'] = isset($aft['axe_after_content_bg']) ? trim($aft['axe_after_content_bg']) : '';
				$allvalues['bgcolor'] = isset($aft['axe_after_content_bgcolor']) ? trim($aft['axe_after_content_bgcolor']) : '';
				$allvalues['transparent_color'] = isset($aft['axe_after_content_transparent_color']) ? trim($aft['axe_after_content_transparent_color']) : 'no';
				$allvalues['outerwrapper'] = isset($aft['axe_after_content_outerwrapper']) ? trim($aft['axe_after_content_outerwrapper']) : '';
				$allvalues['innerwrapper'] = isset($aft['axe_after_content_innerwrapper']) ? trim($aft['axe_after_content_innerwrapper']) : '';
				$allvalues['autopara'] = isset($aft['axe_after_content_autopara']) ? trim($aft['axe_after_content_autopara']) : 'yes';

				$allvalues['bgstyle'] = esc_attr($aft['axe_after_content_bgstyle']) ? esc_attr($aft['axe_after_content_bgstyle']) : 'normal';
				$allvalues['bgpx'] = esc_attr($aft['axe_after_content_bgposx']) ? esc_attr($aft['axe_after_content_bgposx']) : 'c';
				$allvalues['bgpy'] = esc_attr($aft['axe_after_content_bgposy']) ? esc_attr($aft['axe_after_content_bgposy']) : 'c';

				if($allvalues['bg']){
					$allvalues['bg'] = 'background-image:url(\''.$allvalues['bg'] . '\');';
					$aft['axe_after_content_containerclass'] .= ' bg' .$allvalues['bgstyle'] . ' bgpx'.$allvalues['bgpx'] .' bgpy'. $allvalues['bgpy'];
				}
				if($allvalues['transparent_color'] !== 'no'){
					$allvalues['bgcolor'] = '';
				}else if($allvalues['bgcolor']){
					$allvalues['bgcolor'] = 'background-color:#'.$allvalues['bgcolor'].';';
				}
				$allvalues['bgstyletag'] = 'style="'.$allvalues['bg'].$allvalues['bgcolor'].'"';

				$frontfunc = 'themeaxe_front_aftercontent_type_'.$type;
				$frontfunc = function_exists($frontfunc) ? $frontfunc : 'themeaxe_front_aftercontent_type_richtext';

				$html = '';
				$html .= $frontfunc($aft,$allvalues);

				echo $html;
			}
		}
	}
}
add_action('axe_after_page_content','themeaxe_afterpagecontent_sections',10);

function themeaxe_front_aftercontent_type_richtext($aft,$allvalues){
	extract($allvalues);
	$html = '';
	$html .= '<div id="'.$aft['axe_after_content_id'].'" class="axe_after_content_section aacs_'.$type.' '.$aft['axe_after_content_containerclass'].' ' . $containerwidth.' ' . $outerwrapper .'" '.$bgstyletag.'>';
	$html .= '<div class="'.$aft['axe_after_content_class'] .' ' . $innerwrapper.'">';
	if(!empty($aft['axe_after_content_title'])){
		$html .= '<h2 class="axe_after_content_title">'.apply_filters('the_title',$aft['axe_after_content_title']) . '</h2>';
	}
	if(!empty($aft['axe_after_content_subtitle'])){
		$html .= '<h4 class="axe_after_content_subtitle">'.apply_filters('the_title',$aft['axe_after_content_subtitle']) . '</h4>';
	}
	$aft['axe_after_content'] = themeaxe_ContentFilterNoWPAutoP($aft['axe_after_content']);
	$html .= $autopara == 'yes' ? wpautop($aft['axe_after_content']) : $aft['axe_after_content'];
	$html .= '</div>';
	$html .= '</div>';
	return $html;
}
function themeaxe_front_aftercontent_type_textarea($aft,$allvalues){
	extract($allvalues);
	$html = '';
	$html .= '<div id="'.$aft['axe_after_content_id'].'" class="axe_after_content_section aacs_'.$type.' '.$aft['axe_after_content_containerclass'].' ' . $containerwidth.' ' . $outerwrapper .'" '.$bgstyletag.'>';
	$html .= '<div class="'.$aft['axe_after_content_class'] .' ' . $innerwrapper.'">';
	if(!empty($aft['axe_after_content_title'])){
		$html .= '<h2 class="axe_after_content_title">'.apply_filters('the_title',$aft['axe_after_content_title']) . '</h2>';
	}
	if(!empty($aft['axe_after_content_subtitle'])){
		$html .= '<h4 class="axe_after_content_subtitle">'.apply_filters('the_title',$aft['axe_after_content_subtitle']) . '</h4>';
	}
	$aft['axe_after_content'] = themeaxe_ContentFilterNoWPAutoP($aft['axe_after_content']);
	$html .= $autopara == 'yes' ? wpautop($aft['axe_after_content']) : $aft['axe_after_content'];
	$html .= '</div>';
	$html .= '</div>';
	return $html;
}
function themeaxe_front_aftercontent_type_separator($aft,$allvalues){
	extract($allvalues);
	$html = '';
	$html .= '<div id="'.$aft['axe_after_content_id'].'" class="clear axe_after_content_section aacs_'.$type.' '.$aft['axe_after_content_containerclass'].' ' . $outerwrapper .'" '.$bgstyletag.'>';
	$html .= '<div class="'.$aft['axe_after_content_class'] .' ' . $innerwrapper.'">';
	$html .= '<hr/>';
	$html .= '</div>';
	$html .= '</div>';
	return $html;
}
function themeaxe_front_aftercontent_type_clear($aft,$allvalues){
	extract($allvalues);
	$html = '';
	$html .= '<div id="'.$aft['axe_after_content_id'].'" class="clear axe_after_content_section aacs_'.$type.' '.$aft['axe_after_content_containerclass'].' ' . $outerwrapper .'" '.$bgstyletag.'>';
	$html .= '<div class="'.$aft['axe_after_content_class'] .' ' . $innerwrapper.'">';
	$html .= '</div>';
	$html .= '</div>';
	return $html;
}
function themeaxe_front_aftercontent_type_sectionstart($aft,$allvalues){
	extract($allvalues);
	$html = '';
	$html .= '<section id="'.$aft['axe_after_content_id'].'" class="axe_after_content_section aacs_'.$type.' '.$aft['axe_after_content_containerclass'].' ' . $containerwidth.' ' . $outerwrapper .'" '.$bgstyletag.'>';
	$html .= '<div class="'.$aft['axe_after_content_class'] .' ' . $innerwrapper.'">';
	if(!empty($aft['axe_after_content_title'])){
		$html .= '<h2 class="axe_after_content_title">'.apply_filters('the_title',$aft['axe_after_content_title']) . '</h2>';
	}
	if(!empty($aft['axe_after_content_subtitle'])){
		$html .= '<h4 class="axe_after_content_subtitle">'.apply_filters('the_title',$aft['axe_after_content_subtitle']) . '</h4>';
	}
	return $html;
}
function themeaxe_front_aftercontent_type_sectionend($aft,$allvalues){
	$html = '';
	$html .= '</div>';
	$html .= '</section>';
	return $html;
}
/* Page Template */

function themeaxe_taxonomy_title(){
	$title = '';
	if(is_home()){
		$blogpageid =  get_option( 'page_for_posts' );
		$title = $blogpageid ? get_the_title($blogpageid) : __('Blog', 'light-axe');
		$title = apply_filters('axe_taxonomy_title_blog_filter',$title);
	}else if(is_search()){
		$title = sprintf( __( 'Search Results for: %s' ,'light-axe'), '<span>' . get_search_query() . '</span>');
	}else if(is_archive()){
		if(is_day()){
			$title = apply_filters('axe_taxonomy_title_day_filter',__('Posts from ', 'light-axe'). get_the_date());
		}else if(is_month()){
			$title = apply_filters('axe_taxonomy_title_month_filter',__('Posts from ', 'light-axe'). get_the_date('F, Y'));
		}else if(is_year()){
			$title = apply_filters('axe_taxonomy_title_year_filter',__('Posts from ', 'light-axe'). get_the_date('Y'));
		}else if(is_author()){
			$auth = get_userdata( sanitize_user(get_query_var('author')) );
			if($auth){
				$title = apply_filters('axe_taxonomy_title_author_filter',__('Posts by ', 'light-axe'). $auth->user_nicename);
			}else{
				$title = apply_filters('axe_taxonomy_title_author_default_filter',__('Posts by Same Author', 'light-axe'));
			}
		}else{
			$title = single_cat_title('',false);
		}
	}
	$title = apply_filters('axe_taxonomy_title_filter',$title);
	if($title){
		echo apply_filters('axe_taxonomy_title_heading_filter','<h1 class="titleheading">'.$title.'</h1>');
	}
}
add_action('axe_before_index_loop','themeaxe_taxonomy_title',10);
function themeaxe_main_title(){
	$title = get_the_title();
	if($title){
		?>
		<h1 class="<?php echo apply_filters('axe_main_title_class_filter', 'titleheading'); ?>">
			<?php
			do_action('before_axe_page_title');
			echo apply_filters('axe_main_title_filter', $title);
			do_action('after_axe_page_title');
			?>
		</h1>
		<?php
	}
}
add_action('axe_main_title','themeaxe_main_title',10);

function themeaxe_main_blogpost_content(){
	?>
	<div class="contents">
		<?php the_content(); ?>
	</div>
	<?php
}
add_action('axe_blogpost_content','themeaxe_main_blogpost_content',10);
add_action('axe_page_content','themeaxe_main_blogpost_content',10);

function themeaxe_edit_content_link(){
	?>
	<div class="axe_edit_content">
		<?php edit_post_link(__('Edit','light-axe')); ?>
	</div>
	<?php
}
add_action('axe_blogpost_content','themeaxe_edit_content_link',20);
add_action('axe_page_content','themeaxe_edit_content_link',20);

function themeaxe_main_blogpost_categories(){
	?>
	<div class="axe_post_categories"><?php echo __('Categories: ','light-axe'); the_category(', '); ?></div>
	<?php
}
add_action('axe_blogpost_content','themeaxe_main_blogpost_categories',15);

function themeaxe_main_blogpost_tags(){
	?>
	<div class="axe_post_tags"><?php the_tags(); ?></div>
	<?php
}
add_action('axe_blogpost_content','themeaxe_main_blogpost_tags',15);

function themeaxe_blogpost_navigation(){
	$defaults = apply_filters('filter_axe_blogpost_navigation_args',array(
		'before'           => '<div class="clear">' . __( 'Pages:', 'light-axe' ),
		'after'            => '</div>',
		'link_before'      => '',
		'link_after'       => '',
		'next_or_number'   => 'number',
		'separator'        => ' ',
		'nextpagelink'     => __( 'Next', 'light-axe'),
		'previouspagelink' => __( 'Previous', 'light-axe' ),
		'pagelink'         => '%',
		'echo'             => 1
	));

	wp_link_pages( $defaults );
}
add_action('after_axe_page_content','themeaxe_blogpost_navigation',5);
add_action('axe_blogpost_content','themeaxe_blogpost_navigation',20);

function themeaxe_blogpost_postnav(){
	posts_nav_link();
}
/*add_action('axe_blogpost_content','axe_blogpost_postnav',30);*/

function themeaxe_custom_body_classes($classes){
	$bclass = get_post_meta(get_the_ID(),'_axe_post_customclass',true);
	if($bclass){
		$bclass = explode(' ', $bclass);
		$classes = array_merge($classes, $bclass);
	}
	return $classes;
}
add_filter('body_class','themeaxe_custom_body_classes',100);

function themeaxe_remove_empty_p( $content ) {
	$content = force_balance_tags( $content );
	$content = preg_replace( '#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content );
	$content = preg_replace( '~\s?<p>(\s|&nbsp;)+</p>\s?~', '', $content );
	return $content;
}
add_filter('axe_nopara', 'themeaxe_remove_empty_p', 20, 1);
?>