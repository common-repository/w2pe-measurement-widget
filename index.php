<?php
/*
Plugin Name: w2pe Measurement Widget
Description: w2pe Measurement Widget is especially designed to make your units conversion job a whole lot easier. Here you'll find instant conversions for thousands of various units and measurements.
Version: 1.00
Plugin URI: http://www.webworksbd.com
Author: WebworksBD
Author URI: http://www.webworksbd.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


// general info
if ( function_exists('plugins_url') ){
	$url = plugins_url(plugin_basename(dirname(__FILE__)));
}
else{
	$url = get_option('siteurl') . '/wp-content/plugins/' . plugin_basename(dirname(__FILE__));
}

$plugindir = ABSPATH.'wp-content/plugins/w2pe-measurement-widget/';


// create db table 
function w2pe_measure_widget_table(){
	
	global $wpdb;

	$db_table = $wpdb->prefix . 'w2pe_measure_units';
    
	$sql = "CREATE TABLE IF NOT EXISTS `" . $db_table . "` (
	  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `category` varchar(50) NOT NULL,
	  `unit1` varchar(50) NOT NULL,
	  `param1` float(10,6) NOT NULL,
	  `unit2` varchar(50) NOT NULL,
	  `param2` float(10,6) NOT NULL,
	  PRIMARY KEY (`id`)
      );";
   
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

	//some common data
	$res = mysql_query("SELECT * FROM `". $db_table ."`");
	$row = mysql_num_rows($res);

	if($row == 0){
		mysql_query("INSERT INTO `wp_w2pe_measure_units` (`category`, `unit1`, `param1`, `unit2`, `param2`) VALUES
			('Area', 'kilometer', 1.000000, 'mile', 0.621371),
			('Area', 'kilometer', 1.000000, 'foot', 3280.839844),
			('Area', 'kilometer', 1.000000, 'inch', 10000.000000),
			('Area', 'mile', 1.000000, 'meter', 1609.343994),
			('Area', 'mile', 1.000000, 'foot', 5280.000000),
			('Area', 'mile', 1.000000, 'inch', 10000.000000),
			('Area', 'foot', 1.000000, 'inch', 12.000000),
			('Area', 'foot', 1.000000, 'meter', 0.304800),
			('Area', 'inch', 1.000000, 'meter', 0.025400),
			('Currency', 'US dollar', 1.000000, 'Euro', 0.720700),
			('Currency', 'US dollar', 1.000000, 'British pound', 0.598400),
			('Currency', 'US dollar', 1.000000, 'Japanese Yen', 103.320000),
			('Currency', 'US dollar', 1.000000, 'Indian rupee', 61.231998),
			('Currency', 'Euro', 1.000000, 'British pound', 0.830304),
			('Currency', 'Euro', 1.000000, 'Indian rupee', 84.961845),
			('Currency', 'Euro', 1.000000, 'Japanese Yen', 143.360626),
			('Currency', 'British pound', 1.000000, 'Japanese Yen', 172.660431),
			('Currency', 'British pound', 1.000000, 'Indian rupee', 102.326202),
			('Currency', 'Japanese Yen', 0.592644, 'Indian rupee', 0.592644),
			('Currency', 'US dollar', 1.000000, 'Bangladeshi TK', 77.680000),
			('Currency', 'British pound', 1.000000, 'Bangladeshi TK', 130.000000),
			('Currency', 'Japanese Yen', 1.000000, 'Bangladeshi TK', 0.750000),
			('Currency', 'Euro', 1.000000, 'Bangladeshi TK', 107.820000),
			('Currency', 'Bangladeshi TK', 1.000000, 'Indian rupee', 0.790000),
			('Area', 'Kilometer', 1.000000, 'Meter', 1000.000000),
			('Length and Distance', 'Kilometer', 1.000000, 'Meter', 1000.000000),
			('Length and Distance', 'Kilometer', 1.000000, 'Mile', 0.621371),
			('Length and Distance', 'Kilometer', 1.000000, 'Yard', 1093.613281),
			('Length and Distance', 'Mile', 1.000000, 'Yard', 1760.000000),
			('Length and Distance', 'Mile', 1.000000, 'Meter', 1609.343994),
			('Length and Distance', 'Yard', 1.000000, 'Meter', 0.914400),
			('Mass', 'Kilogram', 1.000000, 'Gram', 1000.000000),
			('Mass', 'Kilogram', 1.000000, 'Pound', 2.204623),
			('Mass', 'Ton', 1.000000, 'Kilogram', 1000.000000),
			('Mass', 'Ton', 1.000000, 'Gram', 10000.000000),
			('Mass', 'Ton', 1.000000, 'Pound', 2204.622559),
			('Mass', 'Pound', 1.000000, 'Gram', 453.592377),
			('Temperature', '[°C]', 1.000000, '[K]', 274.149994),
			('Temperature', '[°C]', 1.000000, '[°F]', 33.799999),
			('Temperature', '[°F]', 1.000000, '[K]', 255.927780),
			('Typography and Digital Imaging', 'pixel', 1.000000, 'en', 1.505625),
			('Typography and Digital Imaging', 'pixel', 1.000000, 'inch', 0.010417),
			('Typography and Digital Imaging', 'inch', 1.000000, 'en', 144.539993);");
	}

	
				
	// common settings
	$measure_category = array ();
	$measure_category = array( 1 => 'Area','Currency','Length and Distance','Mass','Temperature','Typography and Digital Imaging');
	add_option(' w2pe_measure_category', $measure_category);
}

register_activation_hook(__FILE__, 'w2pe_measure_widget_table');


// admin menu for w2pe_measur_widget
add_action('admin_menu', 'w2pe_measure_widget_menu');

function w2pe_measure_widget_menu(){	
	
	add_menu_page( 'w2pe Measurement Widget','w2pe Measurement', 'add_users', 'w2pe_measure_widget_menu', 'w2pe_measure_units',get_option('siteurl').'/wp-content/plugins/w2pe-measurement-widget/images/menu.png');
	
	add_submenu_page( 'w2pe_measure_widget_menu', __('Category - Measurement Widget'), 'Category', 'add_users', 'w2pe_measure_cat', 'w2pe_measure_cat' );

	add_submenu_page( 'w2pe_measure_widget_menu', __('Support - Measurement Widget'), 'Support', 'add_users', 'w2pe_measure_widget_support', 'w2pe_measure_widget_support' );
	
}

function w2pe_measure_units(){
	require_once 'units.php';
	//require_once 'bslider_setting.php';
}

function w2pe_measure_cat(){
	require_once 'category.php';
	//require_once 'bslider_setting.php';
}


//widget code
require_once 'widget.php';


add_action('wp_head','pluginname_ajaxurl');

function pluginname_ajaxurl() {
?>
	<script type="text/javascript">
    	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    </script>
<?php
}

// for logged in users
add_action( 'wp_ajax_w2p_measure_category', 'w2p_measure_category_callback' );
// for non logged in users
add_action( 'wp_ajax_nopriv_w2p_measure_category', 'w2p_measure_category_callback' );

function w2p_measure_category_callback(){
	
	$cat = $_POST['cat'];
	global $wpdb;
	$db_table = $wpdb->prefix . 'w2pe_measure_units';
	
	$result=$wpdb->get_results("SELECT `unit1`, `param1` FROM `$db_table` WHERE `category` = '$cat' GROUP BY `unit1`");
	if(!empty($result)){
		foreach ($result as $r){
		 echo '<option value="'.$r->param1.'">'.$r->unit1.'</option>';
		}
	}else{
		echo '<option>No unit found.Please choose another</option>';
	}	
	die();
}


// for logged in users
add_action( 'wp_ajax_w2p_measure_unit1', 'w2p_measure_unit1_callback' );
// for non logged in users
add_action( 'wp_ajax_nopriv_w2p_measure_unit1', 'w2p_measure_unit1_callback' );

function w2p_measure_unit1_callback(){
	
	$cat = $_POST['cat'];
	$unit1 = $_POST['unit1'];
	global $wpdb;
	$db_table = $wpdb->prefix . 'w2pe_measure_units';
	
	$result2=$wpdb->get_results("SELECT `unit2`, `param2` FROM `$db_table` WHERE `category` = '$cat' AND `unit1` = '$unit1' GROUP BY `unit2`");
	if(!empty($result2)){
		foreach ($result2 as $r2){
		 echo '<option value="'.$r2->param2.'">'.$r2->unit2.'</option>';
		}
	}else{
		echo '<option>No unit found.Please choose another</option>';
	}	
	die();
}

function w2p_measure(){
	require_once 'page.php';
}

function w2pe_measure_widget_support(){
	require_once 'support.php';	
}

//short code
add_shortcode( 'w2pe_measurement', 'w2p_measure' );


// uninstall plugin
if ( function_exists('register_uninstall_hook') )
	register_uninstall_hook(__FILE__, 'uninstall_w2pe_measure_widget');

function uninstall_w2pe_measure_widget() {

	global $wpdb;
	$db_table = $wpdb->prefix . 'w2pe_measure_units';
	
	$wpdb->query( "DROP TABLE IF EXISTS $db_table" );
	
	// common settings
	delete_option(' w2pe_measure_category');
}


//add script
if (!is_admin()) {
	//load script on frontend
	wp_register_style( 'w2pe_measure_css', $url.'/files/w2pe_measure.css');
	wp_enqueue_style( 'w2pe_measure_css');
	wp_enqueue_script('jquery');
	wp_register_script('w2pe_measure_js', $url.'/files/custom_script.js', false, '1.00');
	wp_enqueue_script('w2pe_measure_js');
}else{
	//load script on backend
	wp_register_style( 'w2pe_measure_admin_css', $url.'/files/admin_css.css');
	wp_enqueue_style( 'w2pe_measure_admin_css');
}