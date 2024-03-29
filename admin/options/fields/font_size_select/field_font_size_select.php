<?php
class NHP_Options_font_size_select extends NHP_Options{	
	
	/**
	 * Field Constructor.
	 *
	 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
	 *
	 * @since NHP_Options 1.0
	*/
	function __construct($field = array(), $value ='', $parent){
		
		parent::__construct($parent->sections, $parent->args, $parent->extra_tabs);
		$this->field = $field;
		$this->value = $value;
		
		
		
	
		
	}//function
	


	/**
	 * Field Render Function.
	 *
	 * Takes the vars and outputs the HTML for the field in the settings
	 *
	 * @since NHP_Options 1.0
	*/
	function render(){

		$class = (isset($this->field['class']))?'class="'.$this->field['class'].'" ':'';
		
		
		
		echo '<select id="'.$this->field['id'].'" name="'.$this->args['opt_name'].'['.$this->field['id'].']" '.$class.'rows="6" >
                        <option id="default" name="default">Default</option>';
		
			for($size=1;$size<=100;$size++){
	
				echo '<option value="'.$size.'" '.selected($this->value, $size, false).'>'.$size.'</option>';
			}
		
		echo '</select>';

		echo (isset($this->field['desc']) && !empty($this->field['desc']))?' <span class="description">'.$this->field['desc'].'</span>':'';
	}//function
	
}//class
?>
