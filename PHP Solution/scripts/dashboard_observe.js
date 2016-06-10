$(document).ready(function(){	
	// compare passwords on registration
	$('[name="password2"]').blur(function(){
		var pw1 = $('[name="password"]').val();
		var pw2 = $('[name="password2"]').val();
		
		if (pw1 != pw2) {
			$("#pwfeedback").html("Passwords must be the same.");
		} else {
			$("#pwfeedback").html("");
		}
	}); // password match
	
	// Event Click Effect
	$( ".event-list-item" ).click(function() {
		var event_id = $(this).attr("id");
		$.ajax({
				data: {'event_id': event_id},
				type: 'POST',
				url: 'posts/eventquery.php',
				success: function(data) {
					$('.aboutEvent').html(data);
					$.ajax({
						url: 'posts/update_total_price.php',
						success: function(data) {
							$('.total-event-price').html(data);
						}
					});
					$(document).ready(function(){
						
						$( ".expenditure-list-item" ).click(function() {
							var expend_id = $(this).attr("id");
							$.ajax({
									data: {'expend_id': expend_id},
									type: 'POST',
									url: 'posts/expenditurequery.php',
									success: function(data) {
										$(".aboutExpenditure").show();
										$('.aboutExpenditure').html(data);
										$(document).ready(function(){
											
											$.ajax({
												url: 'posts/update_total_price.php',
												success: function(data) {
													$('.total-event-price').html(data);
												}
											});										
										});
									}
							});
						}); // html add expenditure						
					});
				}
			});
	}); // event click effect
	
}); // document.ready