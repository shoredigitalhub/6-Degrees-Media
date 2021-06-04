<?php

if(!defined('THEMEAXE')){
	exit('What are you doing here??');
}

class axeHelper{
	public static function isValidArray($arr){
		$result = false;
		if(is_array($arr)){
			if(sizeof($arr)){
				$result = true;
			}
		}
		return $result;
	}

	public static function axeDump($str){
		echo '<pre>';
		var_dump($str);
		echo '</pre>';
	}

	public static function themeaxe_FormGetHiddenField($name,$field){
		$html = '';
		$html .= '<input type="hidden" name="'.$name.'" value="'.$field['val'].'" />';
		return $html;
	}

	public static function themeaxe_FormGetTextField($name, $field){
		$html = '';
		$html .= '<input type="text" name="'.$name.'" value="'.$field['val'].'" class="'.$field['class'].'" />';
		return $html;
	}
	public static function themeaxe_FormGetUrlField($name, $field){
		$html = '';
		$html .= '<input type="url" name="'.$name.'" value="'.$field['val'].'" class="'.$field['class'].'" />';
		return $html;
	}
	public static function themeaxe_FormGetEmailField($name, $field){
		$html = '';
		$html .= '<input type="email" name="'.$name.'" value="'.$field['val'].'" class="'.$field['class'].'" />';
		return $html;
	}
	public static function themeaxe_FormGetTextareaField($name, $field){
		$html = '';
		$html .= '<textarea name="'.$name.'" class="'.$field['class'].'">'.esc_textarea($field['val']).'</textarea>';
		return $html;
	}
	public static function themeaxe_FormGetYesnoField($name, $field, $default = 'no'){
		$html = '';
		$html .= '<select name="'.$name.'" class="'.$field['class'].'">';
		$html .= themeaxe_yesnoField($field['val'], $default);
		$html .= '</select>';
		return $html;
	}
	public static function themeaxe_FormGetYesnowrapperField($name, $field, $default = 'no'){
		$html = '';
		$html .= '<select name="'.$name.'" class="'.$field['class'].'">';
		$html .= themeaxe_yesnoWrapper($field['val'], $default);
		$html .= '</select>';
		return $html;
	}
	public static function themeaxe_FormGetSelectField($name, $field, $default = ''){
		$html = '';
		$html .= '<select name="'.$name.'" class="'.$field['class'].'">';
		$options = $field['options'];
		$val = $field['val'];
		if(self::isValidArray($options)){
			foreach($options as $option){
				$sel = $val == $option ? ' selected="selected" ' : '';
				$html .= '<option value="'.$option.'" '.$sel.'>'.$option.'</option>';
			}
		}
		$html .= '</select>';
		return $html;
	}
	public static function themeaxe_FormGetAssoselectField($name, $field, $default = ''){
		$html = '';
		$html .= '<select name="'.$name.'" class="'.$field['class'].'">';
		$options = $field['options'];
		$val = $field['val'];
		if(self::isValidArray($options)){
			foreach($options as $key => $option){
				$sel = $val == $key ? ' selected="selected" ' : '';
				$html .= '<option value="'.$key.'" '.$sel.'>'.$option.'</option>';
			}
		}
		$html .= '</select>';
		return $html;
	}
	public static function themeaxe_FormFieldDefaults($field){
		$field = shortcode_atts(
			array(
				'id'=>'id',
				'fullkey'=>'',
				'val'=>'',
				'default'=>'',
				'type'=>'text',
				'class'=>'widefat',
				'containerclass'=>'clear axemetaeditorrow',
				'label'=>'Field',
				'placeholder'=>'Field',
				'options' => null,
				'children' => null,
				'priority' => 100
			),
			$field
		);
		return $field;
	}

	public static function themeaxe_WPMLRegisterTranslation(array $wpmlArray, string $type, string $for, array $instance){
		if (function_exists ( 'icl_register_string' )){
			$type = trim($type);
			$for = trim($for);
			if(self::isValidArray($wpmlArray) && self::isValidArray($instance) && !empty($type) && !empty($for)){
				foreach($wpmlArray as $key){
					if(isset($instance[$key])){
						icl_register_string($type, $for . ' - '. $key, $instance[$key]);
					}
				}
			}

		}
	}
}
?>