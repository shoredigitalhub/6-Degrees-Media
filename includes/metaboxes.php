<?php
if(!defined('THEMEAXE')){
	exit('What are you doing here??');
}
themeaxe_metaboxes_actions_caller();
function themeaxe_metaboxes_actions_caller(){
	add_action( 'add_meta_boxes', 'themeaxe_add_meta_box' );
	add_action( 'save_post', 'themeaxe_metabox_save' );

	/* New Meta Box Types */
	add_filter('axe_aftercontent_common_fields', 'themeaxe_commonBGAndContainerFields',10,3);

	$blockTypes = themeaxe_GetAfterContentBlockTypes();

	foreach($blockTypes as $key => $block){
		$func = 'themeaxe_admin_ContentType_'.ucfirst($key);
		if(!function_exists($func)){
			$func = 'themeaxe_admin_ContentType_Richtext';
		}
		add_action('axe_aftercontent_meta_form_'.$key, $func,10,2);
	}
	/* New Meta Box Types */
}
function themeaxe_GetAfterContentBlockTypes(){
	$types = array(
		'richtext'=>array('id'=>'addnewrichtext', 'class'=>'axeaddaftercontentbtn axeadminbtn btnmargintop', 'title'=>__('Add New Rich Text Block', 'light-axe'), 'content'=>__('Rich Text', 'light-axe'), 'priority'=>10),
		'text'=>array('id'=>'addnewtext', 'class'=>'axeaddaftercontentbtn axeadminbtn btnmargintop', 'title'=>__('Add New Text Block', 'light-axe'), 'content'=>__('Text', 'light-axe'), 'priority'=>10),
		'separator'=>array('id'=>'addseparatorbutton', 'class'=>'axeaddaftercontentbtn axeadminbtn btnmargintop', 'title'=>__('Add New Separator', 'light-axe'), 'content'=>__('Separator', 'light-axe'), 'priority'=>100),
		'clear'=>array('id'=>'addclearbutton', 'class'=>'axeaddaftercontentbtn axeadminbtn btnmargintop', 'title'=>__('Add New Clear Block', 'light-axe'), 'content'=>__('Clear Block', 'light-axe'), 'priority'=>100),
		'sectionstart'=>array('id'=>'addnewsectionstart', 'class'=>'axeaddaftercontentbtn axeadminbtn btnmargintop', 'title'=>__('Add New Section Start', 'light-axe'), 'content'=>__('Section Start', 'light-axe'), 'priority'=>100),
		'sectionend'=>array('id'=>'addnewsectionend', 'class'=>'axeaddaftercontentbtn axeadminbtn btnmargintop', 'title'=>__('Add New Section End', 'light-axe'), 'content'=>__('Section End', 'light-axe'), 'priority'=>100),
	);

	$types = apply_filters('filter_axe_get_aftercontent_blocktypes',$types);

	$types = wp_list_sort($types,'priority','ASC',true);

	return $types;
}
function themeaxe_metaboxseo($post){
	$title = get_post_meta($post->ID, '_axe_meta_title',true);
	$keywords = get_post_meta($post->ID, '_axe_meta_keywords',true);
	$description = get_post_meta($post->ID, '_axe_meta_description',true);

	echo '<label for="axe_meta_title">';
	_e( 'Meta Title', 'light-axe' );
	echo '</label> ';
	echo '<input type="text" id="axe_meta_title" name="axe_meta_title" value="' . esc_attr( $title ) . '" class="widefat" maxlength="160"/>';

	echo '<label for="axe_meta_keywords">';
	_e( 'Meta Keywords', 'light-axe' );
	echo '</label> ';
	echo '<input type="text" id="axe_meta_keywords" name="axe_meta_keywords" value="' . esc_attr( $keywords ) . '" class="widefat" maxlength="160"/>';

	echo '<br/><br/><label for="axe_meta_description">';
	_e( 'Meta Description', 'light-axe' );
	echo '</label> ';
	echo '<textarea id="axe_meta_description" name="axe_meta_description" class="widefat" maxlength="160">' . esc_attr( $description ) . '</textarea>';
}
function themeaxe_metaboxaftercontent($post){
	$after = get_post_meta($post->ID, '_axe_after_content',true);
	echo '<label for="axe_after_content">';
	_e( 'Use axebox or sidebox shortcodes to adjust layout further.', 'light-axe' );
	echo '</label> ';
	echo '<div class="axethemeadminwrapper"><table id="axeaftercontent">';
	echo '<thead>';
	echo '<tr>';
	echo '<th width="10px">&nbsp;</th>';
	echo '<th>Content</th>';
	echo '<th width="10px">&nbsp;</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody id="axeaftercontentgroup" class="axesortme">';
	if(axeHelper::isValidArray($after)){
		$ix=1;
		$allvalues = array();
		$allvalues['bgstyles'] = array('normal', 'fullwidth', 'contain', 'parallax', 'repeat', 'repeat-x', 'repeat-y');
		$allvalues['bgposx'] = array('c'=>'center', 'l'=>'left', 'r'=>'right');
		$allvalues['bgposy'] = array('c'=>'center', 't'=>'top', 'b'=>'bottom');
		$widths = themeaxe_AfterContentContainerWidth();
		$mandatory = array(
			'type'=>array('id'=>'type', 'val'=>'richtext', 'type'=>'hidden'),
			'enwidths'=>array('id'=>'enwidths', 'val'=>'', 'label'=>'', 'children'=>array(
				'enabled'=>array('id'=>'enabled', 'val'=>'yes', 'type'=>'yesno', 'label'=>'Is Enabled?', 'placeholder'=>'', 'containerclass'=>'w w6 axepadright'),
				'containerwidth'=>array('id'=>'containerwidth', 'val'=>'12', 'type'=>'assoselect', 'label'=>'Container Width', 'placeholder'=>'', 'options'=>$widths, 'containerclass'=>'w w6 axepadleft'),
			),),
		);

		foreach($after as $aft){
			$aft = apply_filters('admin_after_content_prepare',$aft);
			$type = isset($aft['axe_after_content_type']) ? esc_attr($aft['axe_after_content_type']) ? esc_attr($aft['axe_after_content_type']) : 'richtext' : 'richtext';
			$enabled = isset($aft['axe_after_content_enabled']) ? esc_attr($aft['axe_after_content_enabled']) ? esc_attr($aft['axe_after_content_enabled']) : 'yes' : 'yes';
			$containerwidth = isset($aft['axe_after_content_containerwidth']) ? esc_attr($aft['axe_after_content_containerwidth']) ? esc_attr($aft['axe_after_content_containerwidth']) : '12' : '12';
			$btitle = esc_attr($aft['axe_after_content_title']) ? strtoupper($type) .  ': '. esc_attr($aft['axe_after_content_title']) : strtoupper($type) .  ': '. ucwords(str_replace('-', ' ',esc_attr($aft['axe_after_content_id'])));
			$btitle = $enabled === 'yes' ? $btitle : $btitle . ' (Disabled)';
			$allvalues['outerwrapper'] = themeaxe_yesnoWrapper(esc_attr($aft['axe_after_content_outerwrapper']));
			$allvalues['innerwrapper'] = themeaxe_yesnoWrapper(esc_attr($aft['axe_after_content_innerwrapper']));
			$allvalues['autopara'] = themeaxe_yesnoWrapper(esc_attr($aft['axe_after_content_autopara']), 'yes');
			$allvalues['bgstyle'] = esc_attr($aft['axe_after_content_bgstyle']) ? esc_attr($aft['axe_after_content_bgstyle']) : 'normal';
			$allvalues['bgpx'] = esc_attr($aft['axe_after_content_bgposx']) ? esc_attr($aft['axe_after_content_bgposx']) : 'c';
			$allvalues['bgpy'] = esc_attr($aft['axe_after_content_bgposy']) ? esc_attr($aft['axe_after_content_bgposy']) : 'c';
			$allvalues['enabled'] = themeaxe_yesnoField($enabled, 'yes');

			$allvalues['type'] = $type;
			$allvalues['containerwidth'] = $containerwidth;

			$mandatory['type']['val'] = $type;
			$mandatory['enwidths']['children']['enabled']['val'] = $enabled;
			$mandatory['enwidths']['children']['containerwidth']['val'] = $containerwidth;

			$mandatory = apply_filters('axe_admin_aftercontent_mandatory_fields',$mandatory, $aft);

			$allvalues['ix'] = $ix;

			$allvalues = apply_filters('axe_aftercontent_meta_allvalues',$allvalues);

			echo '<tr class="themeaxe-form-row axesortable ui-sortable">';
			echo '<td align="center" class="axesorthandle">=</td>';

			echo '<td><b>'.$btitle.': </b><span class="editorshow">Show/Hide</span>';
			echo '<div id="axemetaeditorblock_'.$ix.'" class="axemetaeditorblock">';

			echo themeaxe_MetaFormGenerator($mandatory,$ix);
			do_action('axe_aftercontent_meta_form_'.$type, $aft, $allvalues);
			echo apply_filters('axe_metabox_additional_fields', '',$aft);
			do_action('action_axe_metabox_additional_fields',$aft);

			echo '</div>';
			echo '</td>';
			echo '<td align="center" class="axeclosehandle">x</td>';
			echo '</tr>';

			$ix++;
		}
	}
	echo '</tbody>';
	echo '</table>';
	themeaxe_metaboxaftercontentButtons();
	echo '</div>';
}
function themeaxe_metaboxaftercontentButtons(){
	$buttons = themeaxe_GetAfterContentBlockTypes();
	$html = '';
	$html .= '<div><ul class="aftercontent_add_buttons">';
	if(axeHelper::isValidArray($buttons)){
		foreach($buttons as $type=>$button){
			$type = trim($type);
			if($type){
				$html .= '<li><span id="'.$button['id'].'" class="'.$button['class'].'" dtype="'.$type.'" title="'.$button['title'].'">'.$button['content'].'</span></li>';
			}
		}
	}
	$html .= '</ul></div>';

	echo $html;
}
function themeaxe_metaboxbanner($post){
	$banner = get_post_meta($post->ID, '_axe_post_banner',true);
	$bannershow = intval(get_post_meta($post->ID, '_axe_post_banner_show',true));
	echo '<label for="axe_banner">';
	_e( 'Banner Shortcode', 'light-axe' );
	echo '</label> ';
	echo '<input type="text" id="axe_banner" name="axe_banner" value="' . esc_attr( $banner ) . '" class="widefat"/>';
	echo '<br/></br/><label for="axe_banner_show">';
	_e( 'Display Banner Section', 'light-axe' );
	echo '</label> ';
	$no = '';
	$yes = '';
	switch($bannershow){
		case 2:
		$no = ' checked="checked" ';
		break;
		default:
		$yes = ' checked="checked" ';
	}
	echo '&nbsp;No <input type="radio" name="axe_banner_show" value="2" '.$no.'/>';
	echo '&nbsp;&nbsp;Yes <input type="radio" name="axe_banner_show" value="1" '.$yes.'/>';
	echo '<p class="axenote">Note: Priority is set in following order:<br/>1. Banner Shortcode<br/>2. Featured Image<br/>3. Default Banner</p>';
}
function themeaxe_metaboxcustomclass($post){
	$classes = get_post_meta($post->ID, '_axe_post_customclass',true);
	echo '<label for="axe_post_customclass">';
	_e( 'Custom Classes', 'light-axe' );
	echo '</label> ';
	echo '<input type="text" id="axe_post_customclass" name="axe_post_customclass" value="' . esc_attr( $classes ) . '" class="widefat" maxlength="250"/>';

}
function themeaxe_metaboxcustomsidebars($post){
	$rightsidebar = get_post_meta($post->ID, 'right_sidebar',true);
	$leftsidebar = get_post_meta($post->ID, 'leftt_sidebar',true);
	echo '<div>';
	echo '<label for="right_sidebar">';
	_e( 'Right Sidebar', 'light-axe' );
	echo '</label> ';
	echo '<input type="text" id="right_sidebar" name="right_sidebar" value="' . esc_attr( $rightsidebar ) . '" class="widefat" maxlength="250"/>';
	echo '</div>';

	echo '<div>';
	echo '<label for="left_sidebar">';
	_e( 'Left Sidebar', 'light-axe' );
	echo '</label> ';
	echo '<input type="text" id="leftt_sidebar" name="left_sidebar" value="' . esc_attr( $leftsidebar ) . '" class="widefat" maxlength="250"/>';
	echo '</div>';
}
function themeaxe_add_meta_box(){
	$for = apply_filters('add_metabox_to_posttype',array('page', 'post'));
	$foraftercontent = apply_filters('add_aftercontent_metabox_to_posttype',array('page'));
	foreach ($for as $val) {
		if(in_array($val, $foraftercontent)){
			add_meta_box( 'axeaftercontent', 'After Content', 'themeaxe_metaboxaftercontent', $val , 'advanced', 'low' );
		}
		add_meta_box( 'axeseosettings', 'SEO Settings', 'themeaxe_metaboxseo', $val , 'advanced', 'low' );
		add_meta_box( 'axebannersettings', 'Banner Section', 'themeaxe_metaboxbanner', $val , 'side', 'low' );
		add_meta_box( 'axecustomclasssettings', 'Custom Classes', 'themeaxe_metaboxcustomclass', $val , 'side', 'low' );
		add_meta_box( 'axesidebarssettings', 'Custom Sidebars', 'themeaxe_metaboxcustomsidebars', $val , 'side', 'low' );
	}

}


function themeaxe_metabox_save($post_id){
	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if(!isset($_POST['axe_meta_title'])){
		return;
	}
	$fieldstosave = array(
		'_axe_meta_title'=>array('posted'=>'axe_meta_title', 'val'=>'', 'expected'=>'string'),
		'_axe_meta_keywords'=>array('posted'=>'axe_meta_keywords', 'val'=>'', 'expected'=>'string'),
		'_axe_meta_description'=>array('posted'=>'axe_meta_description', 'val'=>'', 'expected'=>'string'),
		'_axe_post_customclass'=>array('posted'=>'axe_post_customclass', 'val'=>'', 'expected'=>'string'),
		'_axe_post_banner'=>array('posted'=>'axe_banner', 'val'=>'', 'expected'=>'string'),
		'_axe_post_banner_show'=>array('posted'=>'axe_banner_show', 'val'=>'', 'expected'=>'int'),
		'right_sidebar'=>array('posted'=>'right_sidebar', 'val'=>'', 'expected'=>'string'),
		'left_sidebar'=>array('posted'=>'left_sidebar', 'val'=>'', 'expected'=>'string'),
	);
	if ( isset( $_POST['post_type'] ) && 'page'){
		$fieldstosave['_axe_after_content'] =  array('posted'=>'axe_after_content', 'val'=>'', 'expected'=>'array', 'toadd'=>array('axe_after_content', 'axe_after_content_title', 'axe_after_content_containerclass', 'axe_after_content_class', 'axe_after_content_bg', 'axe_after_content_bgcolor', 'axe_after_content_id', 'axe_after_content_outerwrapper', 'axe_after_content_innerwrapper', 'axe_after_content_bgstyle', 'axe_after_content_bgposx', 'axe_after_content_bgposy', 'axe_after_content_autopara', 'axe_after_content_type', 'axe_after_content_enabled', 'axe_after_content_subtitle', 'axe_after_content_containerwidth','axe_after_content_transparent_color'));
	}

	$fieldstosave = apply_filters('filter_axe_aftercontent_before_save',$fieldstosave);

	foreach($fieldstosave as $k => $v){
		$val = '';
		if(isset($_POST[$v['posted']])){
			$val =  $_POST[$v['posted']] ;
		}

		switch($v['expected']){
			case 'int':
			$val = intval($val);
			break;
			case 'array':
			if(isset($v['toadd'])){
				$vx = null;
				$ix = 0;
				if(isset($_POST[$v['posted']])){
					foreach($_POST[$v['posted']] as $vval){
						foreach($v['toadd'] as $toadd){
							$vaddx = '';
							if(isset($_POST[$toadd])){
								if(isset($_POST[$toadd][$ix])){
									$vaddx = $_POST[$toadd][$ix];
								}
							}
							$vaddx = apply_filters('axe-admin_after_content_posted_value',str_replace("\r\n","\n",$vaddx),$toadd,$_POST);
							$vx[$ix][$toadd] = wp_kses_post($vaddx);
						}
						$ix++;
					}
				}
				/*$val = json_encode($vx);*/
				$val = $vx;
			}
			break;
			default:
			$val = sanitize_text_field($val);
			break;
		}

		update_post_meta( $post_id, $k, $val );
	}
}

function themeaxe_yesnoWrapper($val ='no', $def = 'no'){
	$val = trim($val) ? $val : $def;
	$selno = $val == 'no' ? ' selected="selected"' : '';
	$selyes = $val !== 'no' ?  ' selected="selected"' : '';
	return '<option value="no"'.$selno.'>'.__('No', 'light-axe').'</option><option value="wrapwidth"'.$selyes.'>'.__('Yes', 'light-axe').'</option>';
}

function themeaxe_yesnoField($val ='no', $def = 'no'){
	$val = trim($val) ? $val : $def;
	$selno = $val == 'no' ? ' selected="selected"' : '';
	$selyes = $val !== 'no' ?  ' selected="selected"' : '';
	return '<option value="no"'.$selno.'>'.__('No', 'light-axe').'</option><option value="yes"'.$selyes.'>'.__('Yes', 'light-axe').'</option>';
}

/* After Content Type: Rich Text */
function themeaxe_admin_ContentType_Richtext($aft,$allvalues){
	extract($allvalues);

	$fields = array(
		'id'=>array('id'=>'id', 'val'=>trim(esc_attr($aft['axe_after_content_id'])), 'label'=>__( 'ID', 'light-axe' ), 'placeholder'=>__( 'ID', 'light-axe' ), 'priority'=>1),
		'title'=>array('id'=>'title', 'val'=>trim(esc_attr($aft['axe_after_content_title'])), 'label'=>__( 'Title', 'light-axe' ), 'placeholder'=>__( 'Title', 'light-axe' ), 'priority'=>10),
		'subtitle'=>array('id'=>'subtitle', 'val'=>trim(esc_attr($aft['axe_after_content_subtitle'])), 'label'=>__( 'Subtitle', 'light-axe' ), 'placeholder'=>__( 'Subtitle', 'light-axe' ), 'priority'=>15),
		'autopara'=>array('id'=>'autopara', 'val'=>'yes', 'type'=>'yesno', 'label'=>__('Add Auto Paragraphs', 'light-axe'), 'placeholder'=>'', 'priority'=>50),
	);
	$fields = apply_filters('axe_aftercontent_common_fields',$fields,$aft, $allvalues);
	$fields = apply_filters('axe_admin_contenttype_richtext_fields',$fields,$aft);
	$fields = wp_list_sort($fields, 'priority','ASC',true);

	echo themeaxe_MetaFormGenerator($fields,$ix);

	$fcontent = array('id'=>'content', 'val'=>$aft['axe_after_content'], 'type'=>'editor', 'placeholder'=>'', 'label'=>__('Content', 'light-axe' ));
	$fcontent = apply_filters('axe_admin_contenttype_richtext_content_field',$fcontent);

	if(axeHelper::isValidArray($fcontent)){
		/* Content */
		echo '<div id="'.$fcontent['id'].'_'.$ix.'" class="clear axemetaeditorrow">';
		echo '<label for="axe_after_content">';
		echo $fcontent['label'];
		echo '</label> ';
		wp_editor(($fcontent['val']), 'axec'.$ix,array('textarea_name'=>'axe_after_content[]'));
		echo '</div>';
		/* Content */
	}
}
/* After Content Type: Rich Text */

/* After Content Type: Text */
function themeaxe_admin_ContentType_Text($aft,$allvalues){
	extract($allvalues);

	$fields = array(
		'id'=>array('id'=>'id', 'val'=>trim(esc_attr($aft['axe_after_content_id'])), 'label'=>__( 'ID', 'light-axe' ), 'placeholder'=>__( 'ID', 'light-axe' ), 'priority'=>1),
		'title'=>array('id'=>'title', 'val'=>trim(esc_attr($aft['axe_after_content_title'])), 'label'=>__( 'Title', 'light-axe' ), 'placeholder'=>__( 'Title', 'light-axe' ), 'priority'=>10),
		'subtitle'=>array('id'=>'subtitle', 'val'=>trim(esc_attr($aft['axe_after_content_subtitle'])), 'label'=>__( 'Subtitle', 'light-axe' ), 'placeholder'=>__( 'Subtitle', 'light-axe' ), 'priority'=>15),
		'autopara'=>array('id'=>'autopara', 'val'=>'yes', 'type'=>'yesno', 'label'=>__('Add Auto Paragraphs', 'light-axe'), 'placeholder'=>'', 'priority'=>50),
		'content'=>array('id'=>'content', 'val'=>$aft['axe_after_content'], 'type'=>'textarea', 'placeholder'=>'', 'label'=>__('Content', 'light-axe' ), 'priority'=>100),
	);
	$fields = apply_filters('axe_aftercontent_common_fields',$fields,$aft, $allvalues);
	$fields = apply_filters('axe_admin_contenttype_text_fields',$fields,$aft);
	$fields = wp_list_sort($fields, 'priority','ASC',true);

	echo themeaxe_MetaFormGenerator($fields,$ix);
}
/* After Content Type: Rich Text */

/* After Content Type: Separator */
function themeaxe_admin_ContentType_Separator($aft,$allvalues){
	extract($allvalues);
	$html = '';
	$hidden = array('id'=>'separator', 'title'=>'', 'subtitle'=>'',  'content'=>'', 'autopara'=>'no');
	$hidden = apply_filters('axe_admin_contenttype_clear_hidden',$hidden);
	foreach($hidden as $key => $val){
		$key = $key == 'content' ? '' : '_'.$key;
		$html .= '<input type="hidden" name="axe_after_content'.$key.'[]" value="'.$val.'" />';
	}
	echo $html;

	$fields = array();
	$fields = apply_filters('axe_aftercontent_common_fields',$fields,$aft, $allvalues);
	$fields = apply_filters('axe_admin_contenttype_separator_fields',$fields, $aft);
	$fields = wp_list_sort($fields, 'priority','ASC',true);

	echo themeaxe_MetaFormGenerator($fields,$ix);
}
/* After Cntent Type: Separator */

/* After Content Type: Clear */
function themeaxe_admin_ContentType_Clear($aft,$allvalues){
	extract($allvalues);
	$html = '';
	$hidden = array('id'=>'clear-div', 'title'=>'', 'subtitle'=>'', 'outerwrapper'=>'0', 'innerwrapper'=>'0', 'content'=>'', 'autopara'=>'no');
	$hidden = apply_filters('axe_admin_contenttype_clear_hidden',$hidden);
	foreach($hidden as $key => $val){
		$key = $key == 'content' ? '' : '_'.$key;
		$html .= '<input type="hidden" name="axe_after_content'.$key.'[]" value="'.$val.'" />';
	}
	echo $html;

	$fields = array();
	$fields = apply_filters('axe_aftercontent_common_fields',$fields,$aft, $allvalues);
	$fields = apply_filters('axe_admin_contenttype_clear_fields',$fields, $aft);
	$fields = wp_list_sort($fields, 'priority','ASC',true);

	echo themeaxe_MetaFormGenerator($fields,$ix);
}
/* After Cntent Type: Clear */

/* After Cntent Type: Section */
function themeaxe_admin_ContentType_Sectionstart($aft,$allvalues){
	extract($allvalues);
	$html = '';
	$hidden = array('content'=>'', 'autopara'=>'no');
	$hidden = apply_filters('axe_admin_contenttype_sectionstart_hidden',$hidden);
	foreach($hidden as $key => $val){
		$key = $key == 'content' ? '' : '_'.$key;
		$html .= '<input type="hidden" name="axe_after_content'.$key.'[]" value="'.$val.'" />';
	}
	echo $html;

	$fields = array(
		'id'=>array('id'=>'id', 'val'=>trim(esc_attr($aft['axe_after_content_id'])), 'label'=>__( 'ID', 'light-axe' ), 'placeholder'=>__( 'ID', 'light-axe' ), 'priority'=>1),
		'title'=>array('id'=>'title', 'val'=>trim(esc_attr($aft['axe_after_content_title'])), 'label'=>__( 'Title', 'light-axe' ), 'placeholder'=>__( 'Title', 'light-axe' ), 'priority'=>10),
		'subtitle'=>array('id'=>'subtitle', 'val'=>trim(esc_attr($aft['axe_after_content_subtitle'])), 'label'=>__( 'Subtitle', 'light-axe' ), 'placeholder'=>__( 'Subtitle', 'light-axe' ), 'priority'=>15),
	);
	$fields = apply_filters('axe_aftercontent_common_fields',$fields,$aft, $allvalues);
	$fields = apply_filters('axe_admin_contenttype_sectionstart_fields',$fields, $aft);
	$fields = wp_list_sort($fields, 'priority','ASC',true);

	echo themeaxe_MetaFormGenerator($fields,$ix);
}
function themeaxe_admin_ContentType_Sectionend($aft,$allvalues){
	extract($allvalues);
	$html = '';
	$hidden = array('id'=>'section-end', 'title'=>'', 'subtitle'=>'', 'outerwrapper'=>'0', 'innerwrapper'=>'0', 'content'=>'', 'autopara'=>'no', 'containerclass'=>'', 'class'=>'', 'bg'=>'', 'bgcolor'=>'', 'bgstyle'=>'', 'bgposx'=>'', 'bgposy'=>'','transparent_color'=>'yes');
	$hidden = apply_filters('axe_admin_contenttype_sectionend_hidden',$hidden);
	foreach($hidden as $key => $val){
		$key = $key == 'content' ? '' : '_'.$key;
		$html .= '<input type="hidden" name="axe_after_content'.$key.'[]" value="'.$val.'" />';
	}
	echo $html;

	$fields = array();
	$fields = apply_filters('axe_admin_contenttype_sectionend_fields',$fields, $aft);

	echo themeaxe_MetaFormGenerator($fields,$ix);
}
/* After Cntent Type: Section */

/* common background and container fields */
function themeaxe_commonBGAndContainerFields($fields, $aft, $allvalues){
	extract($allvalues);
	$common = array(
		'mrowwrap'=>array('id'=>'mrowwrap', 'val'=>'', 'type'=>'', 'label'=>'', 'placeholder'=>'', 'priority'=>20, 'children'=>array(
			'containerclass'=>array('id'=>'containerclass', 'val'=>trim(esc_attr($aft['axe_after_content_containerclass'])), 'containerclass'=>'w w4 axepadright', 'label'=>__( 'After Content Container Class(es)', 'light-axe' ), 'placeholder'=>__( 'Container Class(es)', 'light-axe' )),
			'outerwrapper'=>array('id'=>'outerwrapper', 'val'=>trim(esc_attr($aft['axe_after_content_outerwrapper'])), 'type'=>'yesnowrapper', 'containerclass'=>'w w2 axepad', 'label'=>__( 'Within Wrapper', 'light-axe' ), 'placeholder'=>__( 'Within Wrapper', 'light-axe' )),
			'class'=>array('id'=>'class', 'val'=>trim(esc_attr($aft['axe_after_content_class'])), 'containerclass'=>'w w4 axepad', 'label'=>__( 'After Content Class(es)', 'light-axe' ), 'placeholder'=>__( 'Class(es)', 'light-axe' )),
			'innerwrapper'=>array('id'=>'innerwrapper', 'val'=>trim(esc_attr($aft['axe_after_content_innerwrapper'])), 'type'=>'yesnowrapper', 'class'=>'widefat', 'containerclass'=>'w w2 axepadleft', 'label'=>__( 'Within Wrapper', 'light-axe' ), 'placeholder'=>__( 'Within Wrapper', 'light-axe' )),
		),),
		'mrowbg'=>array('id'=>'mrowbg', 'val'=>'', 'type'=>'', 'class'=>'', 'label'=>'', 'placeholder'=>'', 'priority'=>30, 'children'=>array(
			'bg'=>array('id'=>'bg', 'val'=>trim(esc_attr($aft['axe_after_content_bg'])), 'class'=>'widefat themeaxemedialoader', 'containerclass'=>'w w5 axepadright', 'label'=>__( 'Background Image', 'light-axe' ), 'placeholder'=>__( 'Background Image URL', 'light-axe' )),
			'bgcolor'=>array('id'=>'bgcolor', 'val'=>trim(esc_attr($aft['axe_after_content_bgcolor'])), 'class'=>'widefat color', 'containerclass'=>'w w5 axepad', 'label'=>__( 'Background Color', 'light-axe' ), 'placeholder'=>__( 'Background Color', 'light-axe' )),
			'transparent_color'=>array('id'=>'transparent_color', 'val'=>trim(esc_attr($aft['axe_after_content_transparent_color'])), 'type'=>'yesnowrapper',  'class'=>'widefat', 'containerclass'=>'w w2 axepadleft', 'label'=>__( 'Transparent Color', 'light-axe' ), 'placeholder'=>__( 'Transparent Color', 'light-axe' )),
		),),
		'mrowpos'=>array('id'=>'mrowpos', 'val'=>'', 'type'=>'', 'label'=>'', 'placeholder'=>'', 'priority'=>40, 'children'=>array(
			'bgstyle'=>array('id'=>'bgstyle', 'val'=>trim(esc_attr($aft['axe_after_content_bgstyle'])), 'type'=>'select', 'containerclass'=>'w w4 axepadright', 'label'=>__( 'Background Style', 'light-axe' ), 'placeholder'=>__( 'Background Style', 'light-axe' ), 'options'=>$bgstyles),
			'bgposx'=>array('id'=>'bgposx', 'val'=>trim(esc_attr($aft['axe_after_content_bgposx'])), 'type'=>'assoselect', 'containerclass'=>'w w4 axepad', 'label'=>__( 'Background Position-X', 'light-axe' ), 'placeholder'=>__( 'Background Position-X', 'light-axe' ), 'options'=>$bgposx),
			'bgposy'=>array('id'=>'bgposy', 'val'=>trim(esc_attr($aft['axe_after_content_bgposy'])), 'type'=>'assoselect', 'containerclass'=>'w w4 axepadleft', 'label'=>__( 'Background Position-Y', 'light-axe' ), 'placeholder'=>__( 'Background Position-Y', 'light-axe' ), 'options'=>$bgposy),
		),),
	);

	$fields = array_merge($fields,$common);

	return $fields;
}
/* common background and container fields */

/* Take in an array of fields and create field rows accordingly */
function themeaxe_MetaFormGenerator($fields,$ix =''){
	$html = '';
	if(axeHelper::isValidArray($fields)){
		foreach($fields as $key => $mfield){
			$mfield = axeHelper::themeaxe_FormFieldDefaults($mfield);
			$key = $key == 'content' ? '' : '_'.$key;
			$key = 'axe_after_content'.$key;
			$fix = intval($ix) ? '_'.intval($ix) : '';
			$fid = $mfield['id'].$fix;
			if($mfield['type'] !== 'hidden'){
				$html .= 	'<div id="'.$fid.'" class="'.$mfield['containerclass'].'">';
				$html .= '<label for="'.$key.'" class="">'.$mfield['label'].'</label>';
			}
			$key .=  '[]';
			$val = $mfield['val'];
			if($mfield['children']){
				$html .= themeaxe_MetaFormGenerator($mfield['children'],$ix);
			}else{
				$fieldfunction = 'themeaxe_FormGet'.ucfirst($mfield['type']).'Field';
				if(method_exists('axeHelper', $fieldfunction)){
					$html .= axeHelper::$fieldfunction($key,$mfield);
				}else{
					$html .= axeHelper::themeaxe_FormGetTextField($key,$mfield);
				}
			}
			if($mfield['type'] !== 'hidden'){
				$html .= '</div>';
			}
		}
	}
	return $html;
}
function themeaxe_AfterContentContainerWidth($id = ''){
	$widths = array(
		'12' => __('Full Width', 'light-axe'),
		'10' => __('5/6', 'light-axe'),
		'9' => __('3/4', 'light-axe'),
		'8' => __('2/3', 'light-axe'),
		'7' => __('7/12', 'light-axe'),
		'6' => __('1/2', 'light-axe'),
		'5' => __('5/12', 'light-axe'),
		'4' => __('1/3', 'light-axe'),
		'3' => __('1/4', 'light-axe'),
		'2' => __('1/6', 'light-axe'),
		'1' => __('1/12', 'light-axe'),
	);

	return $widths;

}
?>