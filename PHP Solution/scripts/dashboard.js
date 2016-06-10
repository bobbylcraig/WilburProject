$(document).ready(function(){
	$('[name="president-email"]').blur(function(){
		var dad = $('[name="president-email"]').val();
		var check = /^[a-z]{1,6}_[a-z]\d{1,2}/.test(dad);
		if (check || dad == "") $('#president-email-fail').hide();
		else $('#president-email-fail').show();
	});
	$('[name="treasurer-email"]').blur(function(){
		var dad = $('[name="treasurer-email"]').val();
		var check = /^[a-z]{1,6}_[a-z]\d{1,2}/.test(dad);
		if (check || dad == "") $('#treasurer-email-fail').hide();
		else $('#treasurer-email-fail').show();
	});
	
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

	// AJAX Event Sort Event
	$( ".event-sort" ).sortable({
		axis: 'y',
		items: 'li[id!=disabled]',
		placeholder: "sortable-placeholder",
		update: function (event, ui) {
			var info = $(this).sortable('serialize');
			$.ajax({
				data: {'item': info},
				type: 'POST',
				url: 'posts/eventreorder.php'
			});
		}
	}); // ajax sort
	
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
						
						// Click Add New Link Item
						$(".add-line-item").click(function(){
							$.ajax({
								url: 'posts/get_event.php',
								success: function(data) {
									var newdata = "#item_" + data;
									newdata = newdata.replace(/\s+/g, '');
									$.ajax({
											url: 'forms/check_for_expend.php',
											success: function(data) {
												if ( data == 1 ) {
													$.ajax({
														url: 'posts/newexpenditure.php'
													});
													$(newdata).trigger("click");
												} // if statement
												else {
													alert("Please finish the event information before adding any line items.");
												}
											} // success
									}); // ajax
								}
							});
						});
						
						// AJAX Expenditure Sort Event
						$( ".expenditure-sort" ).sortable(function(){
							alert('hi');
							},{
							axis: 'y',
							placeholder: "sortable-placeholder",
							items: 'li[id!=disabled]',
							update: function (event, ui) {
								var info = $(this).sortable('serialize');
								$.ajax({
									data: {'item': info},
									type: 'POST',
									url: 'posts/expenditurereorder.php'
								});
							}
						}); // ajax sort
						
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
											
											// delete expenditure
											$( ".delete-button-expenditure" ).click(function() {
												bool = confirm("Are you sure you want to delete this line item?");
												if (bool) {
													$.ajax({
															url: 'posts/delete_expenditure.php',
															success: function(data) {
																var newdata = "#expenditure_" + data;
																$(newdata).remove();
																$(".aboutExpenditure").hide();
																$.ajax({
																	url: 'posts/update_total_price.php',
																	success: function(data) {
																		$('.total-event-price').html(data);
																	}
																});
															}
													});
												}
											});
											
											// change words expenditure
											$('.expenditure-edit-title').editable(function(value, settings) {
												var field = $(this).attr("id");
												if (value.length < 1) value = "Empty Expenditure Title";
												$.ajax({
														data: {'field': field, 'value': value},
														type: 'POST',
														url: 'forms/expenditure_save.php',
														success: function(data) {
															var oldData = data;
															console.log(oldData);
															$.ajax({
																	url: 'posts/get_expenditure.php',
																	success: function(data) {
																		var dad = ("#expenditure_").concat(data);
																		dad = dad.replace(/\s+/g, '');
																		$(dad).text(oldData);
																	}
															});
														}
												});
												return(value);
											}, {
												type    : 'text',
												submit  : 'Ok',
												onblur	: "submit",
												tooltip : 'Click to edit...',
												width: "70%",
												height:($("expenditure-edit").height()) + "px",
											});
											
											$('.expenditure-edit').editable(function(value, settings) {
												var field = $(this).attr("id");
												$.ajax({
														data: {'field': field, 'value': value},
														type: 'POST',
														url: 'forms/expenditure_save.php',
														success: function(data) {
															// QUANTITY
															if ( field == "quantity" ) {
																var price = $('#price').text();
																if ( price.charAt(0) == "$" ) {
																	price = price.slice(1);
																}
																var quantity = data;
															}
															// PRICE
															else if ( field == "price" ) {
																var price = data;
																var quantity = $('#quantity').text();
															}
															else {
																$.ajax({
																	url: 'posts/update_total_price.php',
																	success: function(data) {
																		$('.total-event-price').html(data);
																	}
																});
																return;
															}
															var newPrice = (quantity * price);
															var num = '$' + newPrice.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
															$('#calculated-price').text(num);
															$.ajax({
																url: 'posts/update_total_price.php',
																success: function(data) {
																	$('.total-event-price').html(data);
																}
															});
														}
												});
												if ( field == "allocated" ) {
													$.ajax({
														url: 'incl/total_cost.php',
														success: function(data) {
															$('.totalCost').html(data);
														}
													});
												}
												return(value);
											}, {
												type    : 'text',
												submit  : 'Ok',
												onblur	: "submit",
												tooltip   : 'Click to edit...',
												width: "50%",
												height:($("expenditure-edit").height()) + "px",
											});
											
											$('.expenditure-edit-textarea').editable(function(value, settings) {
												var field = $(this).attr("id");
												$.ajax({
														data: {'field': field, 'value': value},
														type: 'POST',
														url: 'forms/expenditure_save.php',
												});
												return(value);
											}, {
												type    : 'textarea',
												submit  : 'Ok',
												onblur	: "submit",
												tooltip   : 'Click to edit...',
												width: "60%",
												height:($("expenditure-edit-textarea").height()) + "px",
											});											
										});
									}
							});
						}); // html add expenditure
						
						$('.event-edit-title').editable(function(value, settings) {
							var field = $(this).attr("id");
							if (value.length < 1) value = "Empty Event Title";
							$.ajax({
									data: {'field': field, 'value': value},
									type: 'POST',
									url: 'forms/event_save.php',
									success: function(data) {
										if (data != "") var oldData = data;
										else var oldData = "Left Empty";
										$.ajax({
												url: 'posts/get_event.php',
												success: function(data) {
													var dad = ("#item_").concat(data);
													dad = dad.replace(/\s+/g, '');
													$(dad).text(oldData);
												}
										});
									}
							});
							return(value);
						}, {
							type    : 'text',
							submit  : 'Ok',
							onblur	: "submit",
							tooltip   : 'Click to edit...',
							width: "65%",
							height:($("event-edit").height()) + "px",
						}); // change words event
						
						$('.event-edit').editable(function(value, settings) {
							var field = $(this).attr("id");
							$.ajax({
									data: {'field': field, 'value': value},
									type: 'POST',
									url: 'forms/event_save.php',
							});
							return(value);
						}, {
							type    : 'text',
							submit  : 'Ok',
							onblur	: "submit",
							tooltip   : 'Click to edit...',
							width: "75%",
							height:($("event-edit").height()) + "px",
						}); // change words event
						
						$('.event-edit-date').editable(function(value, settings) {
							var field = $(this).attr("id");
							$.ajax({
									data: {'field': field, 'value': value},
									type: 'POST',
									url: 'forms/event_save_date.php',
							});
							return(value);
						}, {
							type: 'datepicker',
							tooltip: 'Click to edit...',
							submit: 'OK',
							onblur	: "cancel",
							width: "75%",
						}); // change words event
						
						$('.event-edit-textarea').editable(function(value, settings) {
							var field = $(this).attr("id");
							$.ajax({
									data: {'field': field, 'value': value},
									type: 'POST',
									url: 'forms/event_save.php',
							});
							return(value);
						}, {
							type      : "textarea",
							submit    : 'OK',
							onblur	: "submit",
							tooltip   : "Click to edit..."
						}); // change words event
						
						$('.event-edit-select').editable(function(value, settings) {
							var field = $(this).attr("id");
							$.ajax({
									data: {'field': field, 'value': value},
									type: 'POST',
									url: 'forms/event_save.php'
							});
							return(value);
						}, {
							data	  : "{'Click to edit':'Click to edit', 'Event':'Event','Performance':'Performance','Conference':'Conference','Travel':'Travel','Athletic':'Athletic','Food':'Food','Office Supplies/Printing/Ads':'Office Supplies/Printing/Ads','Capital Purchase':'Capital Purchase','Misc':'Misc', 'selected':'Click to Edit'}",
							type      : "select",
							submit    : 'OK',
							onblur	  : "submit",
							width: "75%",
							tooltip   : "Click to edit..."
						}); // change words event
						
						$( ".delete-button-event" ).click(function() {
							bool = confirm("Are you sure you want to delete this event?");
							if (bool) {
								$.ajax({
										url: 'posts/delete_event.php',
										success: function(data) {
											location.reload();
										}
								});
							}
						});
						
					});
				}
			});
	}); // event click effect
	
}); // document.ready

$.editable.addInputType('datepicker', {
element : function(settings, original) {
    var input = $('<input>');
    if (settings.width  != 'none') { input.width(settings.width);  }
    if (settings.height != 'none') { input.height(settings.height); }
    input.attr('autocomplete','off');
    $(this).append(input);
    return(input);
},
plugin : function(settings, original) {
    /* Workaround for missing parentNode in IE */
    var form = this;
    settings.onblur = 'ignore';
    $(this).find('input').datepicker({
        firstDay: 1,
        dateFormat: 'yy/mm/dd',
        closeText: 'X',
        onSelect: function(dateText) { $(this).hide(); $(form).trigger("submit"); },
        onClose: function(dateText) {
            original.reset.apply(form, [settings, original]);
            $(original).addClass( settings.cssdecoration );
            },
    });
}});