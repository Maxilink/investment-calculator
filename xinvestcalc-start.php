<?php
$rootfolder = site_url();

function psiclogger_limitchar($str,$n){
	if (strlen($str) <= $n){
		return $str;
	}else{ 
		return substr($str,0,$n);
	}
}

function psiclogger_HashMyPassword($pass){
	$Encryptkey = '121jmWFOp';
	$hash = md5($pass.$Encryptkey);
	return $hash;
}

function psiclogger_redirectUrl($pg){
echo "<script>window.location.href = '".$pg."'</script>";
}

function psiclogger_emailsender($to,$subject,$m) {
	$servername = $_SERVER['SERVER_NAME'];
	
	add_filter('wp_mail_content_type','psiclogger_set_html_content_type');
	$headers = array('Content-Type: text/html; charset=UTF-8','From: '.$servername.' <noreply@'.$servername.'>');
	wp_mail($to,$subject,$m,$headers);
	remove_filter('wp_mail_content_type','psiclogger_set_html_content_type');
}

function psiclogger_set_html_content_type() {
return 'text/html';
}

///////////////////
////////////////////

function psic_settings_form($atts){
global $wpdb,$psic_settings,$psic_style1,$psic_style2,$psic_btn,$psic_companyemail,$pssign;

$atts = shortcode_atts(array("title" => "","btnlabel" => "SUBMIT", "action" => "", "to" => ""),$atts);
$title = $atts["title"];
$action = $atts["action"];
$to = $atts["to"];
/////////////////////////
$tblsettings = $wpdb->prefix.$psic_settings;
$rows = $wpdb->get_row("SELECT * FROM ".psic_secure($tblsettings)." ORDER BY id LIMIT 1");
//if(count($rows) > 0){}
$tax = $rows->tax;
$pa3 = $rows->pa3;
$pa6 = $rows->pa6;
$pa9 = $rows->pa9;
$pa12 = $rows->pa12;

/////////////////////////

if(isset($_REQUEST["dwat"]) && $_REQUEST["dwat"] == 'psicform'){
	if($_REQUEST["rname"] == ''){$msg .= '<div class="msgbox myerror">How much do you want to invest?</div>';$showform = 1;}
	else{
		//$msg = '<div class="msgbox mysuccess">Message successfully submitted</div>';
	}
}else{
	$showform = 0;
	$msg = '';
}

if($showform == 1){}

$output .= '<form name="frmpsic" id="frmpsic" action="'.$action.'" method="post">'.$title.$description.$msg;
$output .= '<input type="hidden" name="dwat" value="psicform"><input type="hidden" name="psictax" id="psictax" value="'.$tax.'">';
$output .= '<strong>How much do you want to invest?</strong><br><input type="number" name="psciamt" id="psciamt" class="psciamt" value="1000000" style="max-width:99%!important;"><br>';
$output .= '<strong>For how long? </strong><br>';
$output .= '<label class="palbl" for="psic3"><input type="radio" name="psicduration" value="'.$pa3.'" id="psic3" data-yr="3"><span>3</span> Months<hr>'.$pa3.'% PA</label>';
$output .= '<label class="palbl" for="psic6"><input type="radio" name="psicduration" value="'.$pa6.'" data-yr="6" id="psic6"><span>6</span> Months<hr>'.$pa6.'% PA</label>';
$output .= '<label class="palbl" for="psic9"><input type="radio" name="psicduration" value="'.$pa9.'" data-yr="9" id="psic9"><span>9</span> Months<hr>'.$pa9.'% PA</label>';
$output .= '<label class="palbl" for="psic12"><input type="radio" name="psicduration" value="'.$pa12.'" data-yr="12" id="psic12"><span>12</span> Months<hr>'.$pa12.'% PA</label>';
$output .= '<div id="res"><span id="reslbl">Accrued Interest</span>'.$pssign.'<span id="aival"></span></div>';
$output .= '<div id="res"><span id="reslbl">Witholding Tax ('.$tax.'%)</span>'.$pssign.'<span id="taxval"></span></div>';
$output .= '<div id="res"><span id="reslbl">Total Payout</span>'.$pssign.'<span id="tpayval"></span></div>';
//$output .= '<button name="rsubmit" class="pscon-button" style="'.$psic_btn.'">'.$btnlabel.'</button></form>';
return $output;
}
/////////////////////////
function psic_adminset_form($atts){
global $wpdb,$psic_settings,$psic_style1,$psic_style2,$psic_btn,$psic_companyemail;

$atts = shortcode_atts(array("btnlabel" => "UPDATE"),$atts);
$btnlabel = $atts["btnlabel"];
/////////////////////////
$tblsettings = $wpdb->prefix.$psic_settings;

if(isset($_REQUEST["dwat"]) && $_REQUEST["dwat"] == 'psicaform'){
	if($_REQUEST["pscitax"] == ''){$msg .= '<div class="msgbox myerror">Tax is required</div>';$showform = 1;}
	elseif($_REQUEST["psci3"] <= 0){$msg .= '<div class="msgbox myerror">3 months PA is required</div>';$showform = 1;}
	elseif($_REQUEST["psci6"] <= 0){$msg .= '<div class="msgbox myerror">6 months PA is required</div>';$showform = 1;}
	elseif($_REQUEST["psci9"] <= 0){$msg .= '<div class="msgbox myerror">9 months PA is required</div>';$showform = 1;}
	elseif($_REQUEST["psci12"] <= 0){$msg .= '<div class="msgbox myerror">12 months PA is required</div>';$showform = 1;}
	else{
		$data = array('tax' => psic_secure($_REQUEST["pscitax"]), 'pa3' => psic_secure($_REQUEST["psci3"]), 'pa6' => psic_secure($_REQUEST["psci6"]), 'pa9' => psic_secure($_REQUEST["psci9"]), 'pa12' => psic_secure($_REQUEST["psci12"]));
		
		if(psic_secure($_REQUEST["psicid"]) != ""){
			$rows = $wpdb->update($tblsettings,$data,array("id" => psic_secure($_REQUEST["psicid"])));	
		}else{
			$format = array('%s','%s','%s','%s','%s');
			$rows = $wpdb->insert($tblsettings,$data,$format);	
		}
		$msg = '<div class="msgbox mysuccess">Investment calculator settings updated successfully.</div>';
	}
}else{
	$showform = 0;
	$msg = '';
}

if($showform == 1){}

$rows = $wpdb->get_row("SELECT * FROM ".psic_secure($tblsettings)." ORDER BY id LIMIT 1");
//if(count($rows) > 0){}
$psicid = $rows->id;
$tax = $rows->tax;
$pa3 = $rows->pa3;
$pa6 = $rows->pa6;
$pa9 = $rows->pa9;
$pa12 = $rows->pa12;
/////////////////////////

$output .= '<form name="frmaset" id="frmaset" action="'.$action.'" method="post">'.$title.$description.$msg;
$output .= '<input type="hidden" name="dwat" value="psicaform"><input type="hidden" name="psicid" value="'.$psicid.'">';
$output .= '<div class="col-sm-3"><strong>Tax:</strong><br><input type="number" name="pscitax" id="pscitax" class="psciamt" value="'.$tax.'"></div>';
$output .= '<div class="col-sm-3"><strong>3 Months PA (%):</strong><br><input type="number" name="psci3" id="psci3" class="psciamt" value="'.$pa3.'"></div>';
$output .= '<div class="col-sm-3"><strong>6 Months PA (%):</strong><br><input type="number" name="psci6" id="psci6" class="psciamt" value="'.$pa6.'"></div>';
$output .= '<div class="col-sm-3"><strong>9 Months PA (%):</strong><br><input type="number" name="psci9" id="psci9" class="psciamt" value="'.$pa9.'"></div>';
$output .= '<div class="col-sm-3"><strong>12 Months PA (%):</strong><br><input type="number" name="psci12" id="psci12" class="psciamt" value="'.$pa12.'"></div>';
$output .= '<button name="rasubmit" class="pscon-button" style="'.$psic_btn.'">'.$btnlabel.'</button></form>';
return $output;
}
//////////////////////
add_shortcode("ps-invest-calc","psic_settings_form");
?>