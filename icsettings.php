<?php include("psinvestcalc-headinc.php"); ?>
<div style=" width:98%;">
<h1 style="border-bottom:#ccc dotted 1px; margin-bottom:20px;">Investment Calculator Settings</h1>

<div id="msgbox"></div>
<div style="display:block; margin:10px 0; width:65%;">
<?php 
//echo do_shortcode('[psic-settings title="" description="" btnlabel="Submit"]'); 
echo psic_adminset_form([]);
?>
</div>

<br clear="all" /><br clear="all" />
</div>
<?php include("psinvestcalc-footer.php"); ?>
<style>
.col-sm-3{text-align:left; padding:0px 10px 10px 0px;}
</style>