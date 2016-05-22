$(document).ready(function(){
	// compare passwords on registration
	$('[name="password2"]').keyup(function(){
		var pw1 = $('[name="password"]').val();
		var pw2 = $('[name="password2"]').val();

		if (pw1 != pw2) {
			$("#pwfeedback").html("Lösenorden måste vara lika");
		} else {
			$("#pwfeedback").html("")
		}
	});
	

	// AJAX vote
	$( ".arrow" ).click(function() {

		if ($(this).hasClass('[class^="hasVoted"]')) {
			alert("Du har redan röstat");
		} else {
			var thisarrow = $(this);
			var classes = $(this).attr("class");
			var response = $.ajax({
				url: "forms/vote.php",
				type: "POST",
				data: {classes: classes},
				success: function(blabla) { 
					if (thisarrow.hasClass('up')) {
						var vote = "1";
					} else {
						var vote = "-1"
					}
					$(thisarrow).addClass("hasVoted_" + vote);
					$(thisarrow).siblings(".arrow").addClass("hasVoted_" + vote);
				}
			});
		}
	});

}); // document.ready