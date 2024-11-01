jQuery(document).ready(function($) {
	
	function load_spinner(){
		 $('#loader').show();
	}
	function remove_spinner(){
		 $('#loader').hide();
	}
	
	$('#w2p-measure-cat').bind('change',function () {
		
		$('#param1').val('0');
		$('#param2').val('0');
		
		var cat_id = $(this).children("option:selected").text();
		//var cat_id = $(this).children("option:selected").attr('value');
		
		if(cat_id != 'Select Category'){
			//step 1
			var data = {
				action: 'w2p_measure_category',
				cat: cat_id
			};

			$.ajaxSetup({
			   beforeSend: load_spinner,
			   complete: remove_spinner
			});			
		
			$.post(ajaxurl, data, function(response) {
				$('#w2p-unit1').html(response);
				
				//step 2
				$('#w2p-unit1').bind('change',function () {
					
					$('#param1').val('0');
					$('#param2').val('0');
					
					var unit1 = $(this).children("option:selected").text();
					var param1 = $(this).children("option:selected").attr('value');

					var data2 = {
						action: 'w2p_measure_unit1',
						cat: cat_id,
						unit1: unit1
					};
					
					$.post(ajaxurl, data2, function(response2) {
						$('#w2p-unit2').html(response2);
						
						
						
					});
					
				}).change();
				
			});
		}
	}).change();
	
	$('#w2p-unit2').bind('change',function () {
		$('#param1').val('0');
		$('#param2').val('0');
					
	}).change();
	
	$('#param1').focusout(function(e) {
        e.preventDefault();
		$('#w2p-measurement-result').html('');
		
		var param2 = $('#w2p-unit2').children("option:selected").attr('value');
		var text1 = $('#w2p-unit1').children("option:selected").text();
		var text2 = $('#w2p-unit2').children("option:selected").text();
		
		var user_input = $(this).val();
		
		var result = user_input * param2;
		
		var res_text = user_input + ' ' + text1 + ' = ' + result.toFixed(2) + ' ' + text2;
		
		$('#param2').val( result.toFixed(2) );
		
		$('#w2p-measurement-result').html(res_text);
		
    });	

	$('#param2').focusout(function(e) {
        e.preventDefault();
		$('#w2p-measurement-result').html('');
		
		var param1 = $('#w2p-unit1').children("option:selected").attr('value');
		var param2 = $('#w2p-unit2').children("option:selected").attr('value');
		var text1 = $('#w2p-unit1').children("option:selected").text();
		var text2 = $('#w2p-unit2').children("option:selected").text();
		
		var user_input = $(this).val();
		
		var result = (param1 / param2 ) * user_input;
		
		var res_text = user_input + ' ' + text2 + ' = ' + result.toFixed(2) + ' ' + text1;
		
		$('#param1').val( result.toFixed(2) );
		
		$('#w2p-measurement-result').html(res_text);
		
    });	
	
});
