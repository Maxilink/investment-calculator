<link href="<?php echo psiclogger_PATH."/assets/css/bootstrap.min.css"; ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo psiclogger_PATH."/assets/fontawesome450/css/font-awesome.min.css"; ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo psiclogger_PATH."/assets/css/style.css"; ?>" type="text/css" rel="stylesheet" />
<style>
body{background:#eee;}
.psconbox{border:#ddd solid 1px; border-bottom:#ddd 2px solid; padding:10px; background:#fff; border-radius:5px; min-height:200px;}
</style>
<?php
global $wpdb, $psic_settings, $rootfolder;
$psicSettings = $wpdb->prefix.$psic_settings;
?>