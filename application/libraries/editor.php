<?php 

class Editor {
	
	public static function outputEditor() {
		$buttons = array(
				array('b', 'icon-bold'),
				array('i', 'icon-italic'),
				array('u', 'icon-underline'),
				array('url', 'icon-link'),
				array('img', 'icon-picture'),
				array('align_left', 'icon-align-left'),
				array('align_center', 'icon-align-center'),
				array('align_right', 'icon-align-right'),
				array('code', 'icon-list-alt'),
				array('quote', 'icon-quote-right'),
				
			);
		echo '<div class="btn-group">';
		foreach ($buttons as $button) {
			echo '<a name="editor_'.$button[0].'" id="editor_'.$button[0].'" class="btn"><i class="'.$button[1].'"></i></a>';
		}
		echo '</div>';
	}

	public static function loadEditorJS() {
		echo HTML::script('js/editor.js');
		echo HTML::script('js/rangyinputs_jquery.min.js');
	}

}

?>