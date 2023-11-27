<script type="text/javascript" src="<?php echo psinvestcalc_PATH.'assets/js/jq110.min.js'; ?>"></script>
<!--<script type="text/javascript" src="<?php //echo psinvestcalc_PATH.'assets/js/bootstrap.min.js'; ?>"></script>-->
<script>
jQuery(document).ready(function($) {
	$(document).on("click","input[name='psicduration']",function() {
		var pa = $("input[name='psicduration']:checked").val();
		var yr = $("input[name='psicduration']:checked").data("yr");
		var amt = $("input[name='psciamt']").val();
		var tax = $("input[name='psictax']").val();
		if(tax == ""){ tax = 0; }
		if(amt == "" || amt < 1){
			alert("How much do you want to invest?");
		}else{
			var t = parseFloat(yr)/12;
			var result = (parseFloat(amt)*parseFloat(pa)*parseFloat(t)) / parseFloat(100);
			var taxper = parseFloat(result)*(parseFloat(tax)/100);
			var total = parseFloat(amt) + (parseFloat(result) - parseFloat(taxper));
			$("#aival").html(digits(result.toFixed(2)));
			$("#taxval").html(digits(taxper.toFixed(2)));
			$("#tpayval").html(digits(total.toFixed(2)));
		}
	});	
	
	$("#psciamt").on("change keyup",function(){
		var pa = $("input[name='psicduration']:checked").val();
		var yr = $("input[name='psicduration']:checked").data("yr");
		var amt = $("input[name='psciamt']").val();
		var tax = $("input[name='psictax']").val();
		if(tax == ""){ tax = 0; }
		if(amt > 0 && pa > 0 && yr > 0){
			var t = parseFloat(yr)/12;
			var result = (parseFloat(amt)*parseFloat(pa)*parseFloat(t)) / parseFloat(100);
			var taxper = parseFloat(result)*(parseFloat(tax)/100);
			var total = parseFloat(amt) + (parseFloat(result) - parseFloat(taxper));
			$("#aival").html(digits(result.toFixed(2)));
			$("#taxval").html(digits(taxper.toFixed(2)));
			$("#tpayval").html(digits(total.toFixed(2)));
		}
	});
	
	$("input[type='radio']").on("focus blur",function(){ 
    	$(".palbl").removeClass("palblfocus");
		$(this).parent().addClass("palblfocus"); //toggleClass
	});

	digits = function(x){ 
		return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
	};
});
</script>
<?php //mysqli_free_result(); ?>