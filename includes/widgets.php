<?php
if(!defined('THEMEAXE')){
	exit('What are you doing here??');
}


function themeaxe_get_dynamic_sidebar($index = 1){
	$sidebar_contents = "";
	ob_start();
	dynamic_sidebar($index);
	$sidebar_contents = ob_get_clean();
	return $sidebar_contents;
}

function themeaxe_get_sidebar($name='',$calldefault = false){
	if ( is_active_sidebar( 'sidebar-'.$name ) ) {
		return themeaxe_get_dynamic_sidebar( 'sidebar-'.$name );
	}else if(is_active_sidebar( $name )){
		return themeaxe_get_dynamic_sidebar( $name );
	}else if($calldefault){
		return themeaxe_get_dynamic_sidebar( 'sidebar-default' );
	}else{
		/* Sidebar not found */
	}
}


function themeaxe_sidebar($name='',$calldefault = false){
	if ( is_active_sidebar( 'sidebar-'.$name ) ) {
		dynamic_sidebar( 'sidebar-'.$name );
	}else if(is_active_sidebar( $name )){
		dynamic_sidebar( $name );
	}else if($calldefault){
		dynamic_sidebar( 'sidebar-default' );
	}else{
		/* Sidebar not found */
	}
}

function themeaxe_getAxePrdefinedLayouts($pkey, $predefinedlayout){
	$arr = array();
	$arr = apply_filters('axepredefined_layouts_array',$arr);
	if($arr){
		if(is_array($arr)){
			foreach($arr as $key=>$val){
				$ch = '';
				if($key == $predefinedlayout){
					$ch = ' checked="checked" ';
				}
				?>
				<span class="predefinedlayout-preview" style="width:32%;max-width:90px;display:inline-block;vertical-align:top;"><input type="radio" name="<?php echo $pkey; ?>" value="<?php echo $key; ?>" style="float:left;" <?php echo $ch; ?> /><img src="<?php echo $val['img'];?>" style="max-width:75%;float:left;" /></span>
				<?php
			}
		}
	}
}
function themeaxe_predefined_layouts_array($array){
	$array['ihc'] = array('img'=>THEMEAXEADMINIMAGESPATH.'ihc.jpg','order'=>array('i'=>'','h'=>'','c'=>''));
	$array['hic'] = array('img'=>THEMEAXEADMINIMAGESPATH.'hic.jpg','order'=>array('h'=>'','i'=>'','c'=>''));
	$array['hci'] = array('img'=>THEMEAXEADMINIMAGESPATH.'hci.jpg','order'=>array('h'=>'','c'=>'','i'=>''));
	return $array;
}
add_filter('axepredefined_layouts_array','themeaxe_predefined_layouts_array',9999,1);

function themeaxe_getPredefinedLayout($id){
	$arr = array();
	$arr = apply_filters('axepredefined_layouts_array',$arr);
	if($arr){
		if(is_array($arr)){
			if(isset($arr[$id])){
				return $arr[$id]['order'];
			}
		}
	}
	return array('i'=>'','h'=>'','c'=>'');
}
?>