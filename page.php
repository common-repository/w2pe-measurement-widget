<?php
		$w2p_widget_content= '<div id="w2p-measurement">';
		$w2p_widget_content.= '<p><label>Select Category</label>';
		$w2p_widget_content.= '<select id="w2p-measure-cat">';
		$all_cat = get_option('w2pe_measure_category');
		if(!empty($all_cat)){
			$w2p_widget_content.= '<option>Select Category</option>';
			foreach($all_cat as $ac){
				$w2p_widget_content.= '<option>'.$ac.'</option>';
            }
		}
                    
		$w2p_widget_content.= '</select></p>';
		$w2p_widget_content.= '<p><label>From</label>';
		$w2p_widget_content.= '<input type="text" id="param1">';
		$w2p_widget_content.= '<select id="w2p-unit1">';
		$w2p_widget_content.= '<option>Select Unit</option>';
		$w2p_widget_content.= '</select></p>';
		$w2p_widget_content.= '<p><label>To</label>';
		$w2p_widget_content.= '<input type="text" id="param2">';
		$w2p_widget_content.= '<select id="w2p-unit2">';
		$w2p_widget_content.= '<option>Select Unit</option>';
		$w2p_widget_content.= '</select></p>';
		$w2p_widget_content.= '<p id="w2p-measurement-result"></p>';
		$w2p_widget_content.= '<button id="measure-submit" title="Measure">Measure</button>';
		$w2p_widget_content.= '<div id="loader"><img src="http://localhost/wordpress/wp-content/plugins/w2pe-measurement-widget/images/spinner.gif" /></div>';
		$w2p_widget_content.= '</div>';

echo $w2p_widget_content;
?>