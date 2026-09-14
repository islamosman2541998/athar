
$(document).ready(function () {
	// press check will check all checkbox
	$("#check-all").click(function(){
		$("input[type=checkbox]").prop("checked",$(this).is(':checked'));
	  

	});
	$('.checkbox-check' ).on('click', function(){
		var checked = $('.checkbox-check' ).is(':checked'); 
		if(checked == true){
			$('.bluck-actions' ).show();
		}
		else{
			$('.bluck-actions' ).hide();
		}
		
	});


});