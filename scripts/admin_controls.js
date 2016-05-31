$(document).ready(function(){
    $(".organizationDelete").click(function(){
        var bool = confirm("Are you sure you want to deactivate this organization?");
        if (bool) {
            var org = $(this).attr('org');
            $.ajax({
				data: {'org': org},
				type: 'POST',
				url: 'admin_controls/deactivate_org.php',
                success: function(data) {
                    location.reload();
                }
			});
        }
    });
    $(".userDelete").click(function(){
        var bool = confirm("Are you sure you want to delete this user?");
        if (bool) {
            var org = $(this).attr('org');
            $.ajax({
				data: {'org': org},
				type: 'POST',
				url: 'admin_controls/deactivate_org.php',
                success: function(data) {
                    location.reload();
                }
			});
        }
    });
    $(".orgAdd").click(function(){
        var bool = confirm("Are you sure you want to reactivate this organization?");
        if (bool) {
            var org = $(this).attr('org');
            $.ajax({
				data: {'org': org},
				type: 'POST',
				url: 'admin_controls/activate_org.php',
                success: function(data) {
                    location.reload();
                }
			});
        }
    });
    $('#new-year').keyup(function(){
        var value = $('#new-year').val();
        if( /\d{4}-\d{4}/.test(value) ) {
            $('#new-year-button').removeAttr('disabled');
            $('#new-year-button').click(function(){
                var money = $('#new-year-money').val();
                var email = $('#new-year-email').val();
                var bool = confirm("Proceed with caution. Only add a new year if starting a new budgeting season (around February). Adding a year in the middle of a budgeting season could mess up current budgets.");
                if (bool) {
                    $.ajax({
                        data: {'new_year': value, 'new_year_money': money, 'new_year_email': email},
                        type: 'POST',
                        url: 'admin_controls/add_year.php',
                        success: function() {
                            location.reload();
                        }
                    });
                }
            });
        }
        else {
            $('#new-year-button').attr('disabled', 'disabled');
        }
    });
    $('#done_allocating_button').click(function(){
        var bool = confirm("Are you sure you're done allocating? If you click yes, all allocations will be made public to organizations.");
        if ( bool ) {
            $.ajax({
                url: 'admin_controls/done_allocating.php',
                success: function() {
                    location.reload();
                }
            });
        }
    });
});