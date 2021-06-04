<?php
if(!defined('THEMEAXE')){
	exit('What are you doing here??');
}

function themeaxe_Axesettingsblock_General($axethemesettings){
	?>
	<table>
		<tbody>
			<?php
			$general = $axethemesettings->general;
			foreach($general as $key => $val){
				echo '<tr class="themeaxe-form-row">';
				echo '<td width="25%"><label>'.ucfirst(str_replace('-',' ',$val->key)).'</label></td>';
				echo '<td>'.themeaxe_fieldgenerator($val).'</td>';
				echo '</tr>';
			}
			?>
		</tbody>
	</table>
	<?php
}

function themeaxe_Axesettingsblock_Blog($axethemesettings){
	$blog = $axethemesettings->blog;
	$blogstyle = $blog->blogstyle;
	$blogstyle->values = explode(',',$blogstyle->values);
	?>
	<ul class="clear">
		<?php
		foreach($blogstyle->values as $val){
			$sel = '';
			if($blogstyle->value == $val){
				$sel = ' checked="checked" ';
			}
			?>
			<li class="col3"><input type="radio" name="<?php echo $blogstyle->key; ?>" value="<?php echo $val; ?>" <?php echo $sel; ?>/><?php echo str_replace('-',' ',$val); ?></li>
			<?php
		}
		?>
	</ul>
	<?php
}

function themeaxe_Axesettingsblock_Typography($axethemesettings){
	?>
	<table>
		<thead class="vtop">
			<tr>
				<th>&nbsp</th>
				<th><?php _e('Font', 'light-axe'); ?></th>
				<th>
					<?php _e('Size', 'light-axe'); ?> <span style="font-size:11px;font-weight:normal;">(px)</span>
					<table>
						<tr>
							<th><?php _e('Desktop', 'light-axe'); ?></th>
							<th><?php _e('Tablet', 'light-axe'); ?> <span style="font-size:11px;font-weight:normal;">(@ 1024px)</span></th>
							<th><?php _e('Mobile', 'light-axe'); ?> <span style="font-size:11px;font-weight:normal;">(@ 680px)</span></th>
						</tr>
					</table>
				</th>
				<th><?php _e('Color', 'light-axe'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$typography = $axethemesettings->typography;
			$fonts = themeaxe_fonts();
			foreach($typography as $key=> $val){
				echo '<tr class="themeaxe-form-row">';
				echo '<td><label>'.ucfirst(str_replace('-',' ',$key)).'</label></td>';
				echo '<td><select name="'.$key.'-font" value="'.$val->font.'">';
				foreach($fonts as $k=>$v){
					$selected = '';
					if($k == $val->font){
						$selected = 'selected="selected"';
					}
					echo '<option value="'.$k.'" '.$selected.'>'.$v['font'].'</option>';
				}
				echo '</select></td>';
				echo '<td><table><tr>';
				echo '<td><input type="number" class="widefat" name="'.$key.'-size"  value="'.intval($val->size).'" min="8" max="999" /></td>';
				echo '<td><input type="number" class="widefat" name="'.$key.'-tablet"  value="'.intval($val->tablet).'" min="8" max="999" /></td>';
				echo '<td><input type="number" class="widefat" name="'.$key.'-mobile"  value="'.intval($val->mobile).'" min="8" max="999" /></td>';
				echo '</tr></table></td>';
				echo '<td><input type="text" placeholder="'. __('Color', 'light-axe'). '" class="color" name="'.$key.'-color" value="'.$val->color.'" /><input type="hidden" name="'.$key.'-alias" value="'.$val->alias.'" /></td>';
				echo '</tr>';
			}
			?>
		</tbody>
	</table>
	<?php
}

function themeaxe_Axesettingsblock_Sidebars($axethemesettings){
	?>
	<table>
		<thead>
			<tr>
				<th width="10px">&nbsp;</th>
				<th><?php _e('Title', 'light-axe'); ?></th>
				<th><?php _e('Id', 'light-axe'); ?></th>
				<th><?php _e('Classes', 'light-axe'); ?></th>
				<th><?php _e('Shortcode', 'light-axe'); ?></th>
				<th width="10px">&nbsp;</th>
			</tr>
		</thead>
		<tbody id="axewidgetgroup" class="axesortme">
			<?php

			$axesidebars = $axethemesettings->sidebars;
			if(is_array($axesidebars)){
				foreach($axesidebars as $key => $val){
					echo '<tr class="themeaxe-form-row axesortable ui-sortable">';
					/*echo '<p><label>'.ucfirst($val[0]).'</label></p>';*/
					echo '<td align="center" class="axesorthandle">=</td>';
					echo '<td><input type="text" placeholder="Title" name="widgettitle[]" required value="'.$val[0].'" /></td>';
					echo '<td><input type="text" placeholder="Id" name="widgetid[]" required value="'.$val[1].'" /></td>';
					echo '<td><input type="text" placeholder="Class(es)" name="widgetclass[]" required value="'.$val[2].'" /></td>';
					echo '<td align="center" width="20%"><input type="text" class="selectallforcopy" readonly value="[sidebox id=\''.$val[1].'\' class=\'\']" title="Ctrl + C to copy"/></td>';
					echo '<td align="center" class="axeclosehandle">x</td>';
					echo '</tr>';
				}
			}
			?>
		</tbody>
	</table>
	<span id="axeaddwidgetbtn" class="axeadminbtn btnmargintop"><?php _e('Add New Sidebar', 'light-axe'); ?></span>
	<?php
}

function themeaxe_Axesettingsblock_Socialmedia($axethemesettings){
	?>
	<table>
		<thead>
			<tr>
				<th width="10px">&nbsp;</th>
				<th><?php _e('Title', 'light-axe'); ?></th>
				<th><?php _e('Link', 'light-axe'); ?></th>
				<th><?php _e('Icon', 'light-axe'); ?></th>
				<th><?php _e('Classes', 'light-axe'); ?></th>
				<th><?php _e('Use Fontawesome', 'light-axe'); ?></th>
				<th><?php _e('Item Classes', 'light-axe'); ?></th>
				<th width="10px">&nbsp;</th>
			</tr>
		</thead>
		<tbody id="axesocialgroup" class="axesortme">
			<?php

			$socialmedia = $axethemesettings->socialmedia;
			$yesnoarr = array('yes'=>'Yes','no'=>'No');
			if(is_array($socialmedia)){
				foreach($socialmedia as $key => $val){
					echo '<tr class="themeaxe-form-row axesortable ui-sortable">';
					echo '<td align="center" class="axesorthandle">=</td>';
					echo '<td><input type="text" placeholder="Title" name="socialmediatitle[]" required value="'.$val[0].'" /></td>';
					echo '<td><input type="url" placeholder="Link" name="socialmedialink[]" required value="'.$val[1].'" /></td>';
					echo '<td><input type="url" placeholder="Icon Link" class="themeaxemedialoader" name="socialmediaicon[]" value="'.$val[2].'" /></td>';
					echo '<td><input type="text" placeholder="Class(es)" class="" name="socialmediaclasses[]" value="'.$val[3].'" /></td>';
					echo '<td><select name="socialmediafontawesome[]">';
					foreach($yesnoarr as $ynk => $ynval){
						$selected = '';
						if($val[4] == $ynk){
							$selected = 'selected="selected"';
						}
						echo '<option value="'.$ynk.'" '.$selected.'>'.$ynval.'</option>';
					}
					echo '</select></td>';
					echo '<td><input type="text" placeholder="Item Class(es)" class="" name="socialmediaitemclasses[]" value="'.$val[5].'" /></td>';
					echo '<td align="center" class="axeclosehandle">x</td>';
					echo '</tr>';
				}
			}
			?>
		</tbody>
	</table>
	<span id="axeaddsocialmediabtn" class="axeadminbtn btnmargintop"><?php _e('Add New Social Media', 'light-axe'); ?></span>
	<?php
}

function themeaxe_Axesettingsblock_Contact($axethemesettings){
	?>
	<table>
		<tbody>
			<?php
			$contact = $axethemesettings->contact;
			foreach($contact as $key => $val){
				echo '<tr class="themeaxe-form-row">';
				echo '<td width="25%"><label>'.ucfirst(str_replace('-',' ',$val->key)).'</label></td>';
				echo '<td>'.themeaxe_fieldgenerator($val).'</td>';
				echo '</tr>';
			}
			?>
		</tbody>
	</table>
	<?php
}

function themeaxe_Axesettingsblock_Columns($axethemesettings){
	?>
	<table>
		<tbody>
			<?php
			$footercols = $axethemesettings->columns;
			foreach($footercols as $key => $val){
				echo '<tr class="themeaxe-form-row">';
				echo '<td width="25%"><label>'.ucfirst(str_replace('-',' ',$val->key)).'</label></td>';
				echo '<td><select name="'.$val->key.'" >';
				for($fc = 0; $fc <= 4; $fc++){
					$selected = '';
					if($fc == $val->value){
						$selected = 'selected="selected"';
					}
					echo '<option value="'.$fc.'" '.$selected.'>'.$fc.'</option>';
				}
				echo '</select></td>';
				echo '</tr>';
			}
			?>
		</tbody>
	</table>
	<?php
}

function themeaxe_Axesettingsblock_GMap($axethemesettings){
	?>
	<table>
		<tbody>
			<?php
			$gmap = $axethemesettings->gmaps;
			foreach($gmap as $key => $val){
				echo '<tr class="themeaxe-form-row">';
				echo '<td width="25%"><label>'.ucfirst(str_replace('-',' ',$val->key)).'</label></td>';
				echo '<td>'.themeaxe_fieldgenerator($val).'</td>';
				echo '</tr>';
			}
			?>
		</tbody>
	</table>
	<?php
}

function themeaxe_Axesettingsblock_Analytics($axethemesettings){
	?>
	<table>
		<tbody>
			<?php
			$analytic = $axethemesettings->analytics;
			foreach($analytic as $key => $val){
				echo '<tr class="themeaxe-form-row">';
				echo '<td width="25%"><label>'.ucfirst(str_replace('-',' ',$val->key)).'</label></td>';
				echo '<td>'.themeaxe_fieldgenerator($val).'</td>';
				echo '</tr>';
			}
			?>
		</tbody>
	</table>
	<?php
}

function themeaxe_Axesettingsblock_GFonts($axethemesettings){
	?>
	<table>
		<tbody id="axegfontgroup" class="axesortme">
			<?php
			$gfonts = $axethemesettings->gfonts;
			if($gfonts){
				foreach($gfonts as $key => $val){
					$fname = isset($val[0]) ? trim($val[0]) : '';
					$ffamily = isset($val[1]) ? trim($val[1]) : '';
					$flink = isset($val[2]) ? trim($val[2]) : '';
					$ffallback = isset($val[3]) ? trim($val[3]) : '';
					echo '<tr class="themeaxe-form-row axesortable ui-sortable">';
					echo '<td align="center" class="axesorthandle">=</td>';
					echo '<td><input type="text" placeholder="Name" name="gfontname[]" required value="'.$fname.'" /></td>';
					echo '<td><input type="text" placeholder="Font Family" name="gfontfamily[]" required value="'.$ffamily.'" /></td>';
					echo '<td><input type="url" placeholder="Font Link" class="" name="gfontlink[]" required value="'.$flink.'" /></td>';
					echo '<td><input type="fallback" placeholder="Fallback Font Family" class="" name="gfontfallback[]" value="'.$ffallback.'" /></td>';
					echo '<td align="center" class="axeclosehandle">x</td>';
					echo '</tr>';
				}
			}
			?>
		</tbody>
	</table>
	<span id="axeaddgfontbtn" class="axeadminbtn btnmargintop"><?php _e('Add New Google Font', 'light-axe'); ?></span>
	<?php
}

function themeaxe_Axesettingsblock_Import($axethemesettings){
	echo __('Paste the settings below:', 'light-axe');
	?>
	<textarea name="axeimportsettings" style="width:100%;height:150px;resize:none;"></textarea>
	<?php
}

function themeaxe_Axesettingsblock_Export($axethemesettings){
	echo __('Copy the settings below:', 'light-axe');
	?>
	<textarea readonly style="width:100%;height:150px;resize:none;" class="selectallforcopy"><?php echo json_encode($axethemesettings);?></textarea>
	<?php
}

function themeaxe_Settings_MenuItems(){
	return apply_filters('filter_axe_settings_menu_items',array(
		'generalsettings' => __('General', 'light-axe'),
		'blogsettings' => __('Blog', 'light-axe'),
		'typographysettings' => __('Typography', 'light-axe'),
		'widgetsettings' => __('Sidebars', 'light-axe'),
		'socialmediasettings' => __('Social Media', 'light-axe'),
		'contactsettings' => __('Contact', 'light-axe'),
		'columnsettings' => __('Columns', 'light-axe'),
		'gmapssettings' => __('Google Maps', 'light-axe'),
		'analyticssettings' => __('Google Analytics', 'light-axe'),
		'googlefontssettings' => __('Google Fonts', 'light-axe'),
		'importsettings' => __('Import', 'light-axe'),
		'exportsettings' => __('Export', 'light-axe'),
	));
}

function themeaxe_Settings_BlocksFunctions(){
	return apply_filters('filter_axe_settings_blocks',array(
		'generalsettings' => 'themeaxe_Axesettingsblock_General',
		'blogsettings' => 'themeaxe_Axesettingsblock_Blog',
		'typographysettings' => 'themeaxe_Axesettingsblock_Typography',
		'widgetsettings' => 'themeaxe_Axesettingsblock_Sidebars',
		'socialmediasettings' => 'themeaxe_Axesettingsblock_Socialmedia',
		'contactsettings' => 'themeaxe_Axesettingsblock_Contact',
		'columnsettings' => 'themeaxe_Axesettingsblock_Columns',
		'gmapssettings' => 'themeaxe_Axesettingsblock_GMap',
		'analyticssettings' => 'themeaxe_Axesettingsblock_Analytics',
		'googlefontssettings' => 'themeaxe_Axesettingsblock_GFonts',
		'importsettings' => 'themeaxe_Axesettingsblock_Import',
		'exportsettings' => 'themeaxe_Axesettingsblock_Export',
	));
}

function themeaxe_GetSettingsActiveTabIs(){
	$default = 'generalsettings';
	$tab = isset($_POST['activetabis']) ?  urlencode($_POST['activetabis']) : '';
	if(empty($tab)){
		$tab = isset($_GET['activetabis']) ?  urldecode($_GET['activetabis']) : $default;
	}
	return $tab;
}
?>