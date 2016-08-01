(function () {
	$('.hamburger-menu').on('click', function() {
    $('.nav-sidebar').toggleClass('show');
    $('.partial-modal').toggleClass('darken');
		$('.bar').toggleClass('animate');
    $('body').toggleClass('darken');
	});
})();

$(function() {
  // AJAX Event Sort
  $( ".sortable-event" ).sortable({
    axis: 'y',
    items: 'li[id!=disabled]',
    update: function (event, ui) {
      var info = $(this).sortable('serialize');
      $.ajax({
        data: {'event': info},
        type: 'POST',
        url: '/include/budget/sidebarQueries/sidebarReorder.php'
      });
    }
  });
  $('.peak-card').not('.empty').click(function(){
    var id = $(this).attr('id').substring(6);
    $.ajax({
      data: {'event_id': id},
      type: 'POST',
      url: '/include/budget/event-card.php',
      success: function(data) {
        $('.event-section').html(data);
				$('.option-nav').hide();
        $( ".sortable-expend" ).sortable({
          axis: 'y',
          handle: '.top'
        }); // END .sortable-expend
        (function() {
            ! function(n) {
                "use strict";
                n.fn.paperCollapse = function(i) {
                    var o;
                    return o = n.extend({}, n.fn.paperCollapse.defaults, i), n(".collapse-card .top").click(function() {
                        var thingy = this.closest('.collapse-card');
                        n(thingy).hasClass("active") ? (o.onHide.call(thingy), n(thingy).removeClass("active"), n(thingy).find(".body").slideUp(o.animationDuration, o.onHideComplete)) : (o.onShow.call(thingy), n(thingy).addClass("active"), n(thingy).find(".body").slideDown(o.animationDuration, o.onShowComplete))
                    }), this
                }, n.fn.paperCollapse.defaults = {
                    animationDuration: 400,
                    easing: "swing",
                    onShow: function() {
                      $(this).find('span.collapse-card-title').html('<i class="material-icons">expand_less</i>');
                    },
                    onHide: function() {
                      $(this).find('span.collapse-card-title').html('<i class="material-icons">expand_more</i>');
                    },
                    onShowComplete: function() {},
                    onHideComplete: function() {}
                }
            }(jQuery),
            function(n) {
                n(function() {
                    n(".collapse-card").paperCollapse({})
                })
            }(jQuery)
        }).call(this);
				$('.editable-input').editable(function(value, settings) {
					value = escapeHtml(value);
					var field = $(this).attr("id");
					var number = $(this).attr("number");
					$.ajax({
							data: {
								'field'   : field,
								'number'  : number,
								'value'   : value
							},
							type: 'POST',
							url: '/include/budget/jeditableQuery.php',
							success: function(data) {
								if ( field == "event_name" ) {
									$(".event-card .card-top-column.card-title").text(value);
									$("li#event_" + number + " .event-name").text(value);
								}
							}
					});
					return value;
				}, {
					cssclass : 'editable',
					onblur : "submit"
				}); // editable input
				$('.editable-textarea').editable(function(value, settings) {
					value = escapeHtml(value);
					var field = $(this).attr("id");
					var number = $(this).attr("number");
					$.ajax({
							data: {
								'field'   : field,
								'number'  : number,
								'value'   : value
							},
							type: 'POST',
							url: '/include/budget/jeditableQuery.php',
					});
					return value;
				}, {
					type			: 'autogrow',
					cssclass 	: 'editable',
					width			: "100%",
					onblur : "submit"
				}); // editable textarea
				$(".editable-masked").editable(function(value, settings) {
					value = escapeHtml(value);
					var field = $(this).attr("id");
					var number = $(this).attr("number");
					$.ajax({
							data: {
								'field'   : field,
								'number'  : number,
								'value'   : value
							},
							type: 'POST',
							url: '/include/budget/jeditableQuery.php',
					});
					return value;
				}, {
	        type      : "masked",
					cssclass	: 'editable',
	        mask      : "99/99/9999",
					placeholder: "MM/DD/YYYY",
					onblur : "submit"
		    }); // editable masked
				$('.editable-select').editable(function(value, settings) {
					value = escapeHtml(value);
					var field = $(this).attr("id");
					var number = $(this).attr("number");
					$.ajax({
							data: {
								'field'   : field,
								'number'  : number,
								'value'   : value
							},
							type: 'POST',
							url: '/include/budget/jeditableQuery.php',
							success: function(data) {
								if ( field == "event_type" ) {
									var icon_name;
									switch ( value ) {
							      case 'Conference':
							          icon_name = "people";
							          break;
							      case 'Event':
							          icon_name = "event";
							          break;
							      case 'Performance':
							          icon_name = "music_note";
							          break;
							      case 'Travel':
							          icon_name = "flight_takeoff";
							          break;
							      case 'Athletic':
							          icon_name = "fitness_center";
							          break;
							      case 'Food':
							          icon_name = "kitchen";
							          break;
							      case 'Office Supplies/Printing/Ads':
							          icon_name = "print";
							          break;
							      case 'Capital Purchase':
							          icon_name = "attach_money";
							          break;
							      default:
							          icon_name = 'help';
							    }
									$("li#event_" + number + " .event-icon").text(icon_name);
								}
							}
					});
					return value;
				}, {
					data	    : "{'Click to edit':'Click to edit', 'Event':'Event','Performance':'Performance','Conference':'Conference','Travel':'Travel','Athletic':'Athletic','Food':'Food','Office Supplies/Printing/Ads':'Office Supplies/Printing/Ads','Capital Purchase':'Capital Purchase','Misc':'Misc', 'selected':'Click to Edit'}",
					type      : "select",
					cssclass	: 'editable',
					onblur : "submit"
				}); // editable select
				// SORTABLE EXPENDITURES
				$( ".sortable-expend" ).sortable({
			    axis: 'y',
			    items: 'li[id!=disabled]',
			    update: function (event, ui) {
			      var info = $(this).sortable('serialize');
			      $.ajax({
			        data: {'expend': info},
			        type: 'POST',
			        url: '/include/budget/expenditureQueries/expenditureReorder.php',
			      }); // ajax sortable
			    },
			  });
				$("#add-expenditure-button").on('click', function() {
					alert("Hello");
				});
      } // END SUCCESS
    }); // END AJAX
  }); // END .peak-card
}); // END $FUNCTION

var entityMap = {
    "&": "&amp;",
    "<": "&lt;",
    ">": "&gt;",
    '"': '&quot;',
    "'": '&#39;',
    "/": '&#x2F;'
  };

function escapeHtml(string) {
  return String(string).replace(/[&<>"'\/]/g, function (s) {
    return entityMap[s];
  });
}
