<?php
/*
Plugin Name: PS-Investment Calculator
Plugin URI: https://www.progmatech.com
Description: This is investment calculator plugin to calculate interest on customer's fixed deposit.
Version: 0.1
Author: Progmatech Solutions
Author URI: http://www.progmatech.com
*/
define('psinvestcalc_PATH', plugins_url('/', __FILE__)); 
define('psinvestcalc_CPATH', 'client/');
define('psinvestcalc_PLUGINDIR',plugin_dir_path( __DIR__ ));
define('psinvestcalc_WPCPATH','wp-content/plugins/psinvestcalc/');
define('psinvestcalc_ARCHIVES', plugins_url('/archives/', __FILE__));

function psinvestcalc_fxn(){
add_menu_page('psinvestcalc','Investment Calc','','psinvestcalc','psinvestcalc_init_fxn','',7); //documentation functions
add_submenu_page('psinvestcalc','Settings', 'Settings', 'manage_options','psicset','psinvestcalc_menu1_fxn');
//add_submenu_page('psinvestcalc','Testimonials', 'Testimonials', 'manage_options','psb_testimony','psinvestcalc_menu2_fxn');
//add_submenu_page('psinvestcalc','Documentation', 'Payments', 'manage_options','pscon_payments','PSCONTESTER_menu8_fxn');
}

function psinvestcalc_init_fxn(){
	
}

function psinvestcalc_menu1_fxn(){
	if($_GET["page"] == 'psicset'){
		include("icsettings.php");
	}else{
		//include("testimony.php");
	}
}

function psinvestcalc_formatcurrency($amt){
	$pssign = '&#8358; '; //dollar - &#36;
	$amount = $pssign.number_format($amt,2);
	return $amount;
}

function psinvestcalc_hook_files(){
	wp_register_style('psinvestcalc_css',psinvestcalc_PATH.'assets/css/style.css');
	wp_enqueue_style('psinvestcalc_css', array(), false, true);
	//wp_enqueue_script('psinvestcalc_jqjs',psinvestcalc_PATH.'assets/js/jq110.min.js', array(), false, true);
	//wp_enqueue_script('psinvestcalc_btjs',psinvestcalc_PATH.'assets/js/bootstrap.min.js', array(), false, true);
}
function psic_addFiles(){
	include("psinvestcalc-footer.php");
}

add_action('admin_menu','psinvestcalc_fxn');
add_action( 'wp_enqueue_scripts', 'psinvestcalc_hook_files' );

//Set database.....
include("psinvestcalc-dbm.php");
register_activation_hook( __FILE__, 'psicSettings_table');

include("psinvestcalc-allfxns.php");
//Shortcode
include("psinvestcalc-start.php");
add_action( 'wp_footer', 'psic_addFiles' );
?>