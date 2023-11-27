<?php
global $pic_db_version;
$psic_db_version = '1.0';
$psic_settings = 'psic_settings';

function psicSettings_table() {
	global $wpdb, $psic_db_version;
	$charset_collate = $wpdb->get_charset_collate();
	$tablename = $wpdb->prefix.'psic_settings';
	//u-user, c-contestant accounts
	$sql = "CREATE TABLE $tablename (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		tax varchar(30) DEFAULT '10' NULL,
		pa3 varchar(30) DEFAULT '8' NULL,
		pa6 varchar(30) DEFAULT '10' NULL,
		pa9 varchar(30) DEFAULT '12' NULL,
		pa12 varchar(30) DEFAULT '15' NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

	require_once(ABSPATH.'wp-admin/includes/upgrade.php' );
	dbDelta($sql);
	add_option( 'psic_db_version', $psic_db_version);
}
?>