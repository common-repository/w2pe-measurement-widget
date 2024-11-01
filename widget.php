<?php
// Creating the widget
if ( function_exists('plugins_url') ){
	$url = plugins_url(plugin_basename(dirname(__FILE__)));
}
else{
	$url = get_option('siteurl') . '/wp-content/plugins/' . plugin_basename(dirname(__FILE__));
}

class w2pe_measure_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'w2pe_measure_widget',
			__('w2pe Measurement Widget', 'w2pe_measure'), 
			array( 'description' => __( 'Description: w2pe Measurement Widget is especially designed to make your units conversion job a whole lot easier', 'w2pe_measure' ), ) 
		);
		
	}
	
	// front-end
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		
		if ( ! empty( $title ) ){
			echo $args['before_title'] . $title . $args['after_title'];
		}
		
		// This is where you run the code and display the output
		
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
		
		echo __( $w2p_widget_content, 'w2pe_measure' );
		echo $args['after_widget'];
	}
			
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Measure Tool', 'w2pe_measure' );
		}
		// Widget admin form
		?>
		<p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}
		
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
} 
// Class wpb_widget ends here

// Register and load the widget
function wpb_load_widget() {
	register_widget( 'w2pe_measure_widget' );
}

add_action( 'widgets_init', 'wpb_load_widget' );

?>
