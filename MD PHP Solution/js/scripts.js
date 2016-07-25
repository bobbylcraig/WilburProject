$('.editable-input').editable('http://www.example.com/save.php', {
  cssclass : 'editable',
  submit    : '<button class="btn submit">Submit</button>',
});

$('.editable-textarea').editable('http://www.example.com/save.php', {
  type: 'autogrow',
  cssclass : 'editable',
  submit    : '<button class="btn submit">Submit</button>',
});

(function () {
	$('.hamburger-menu').on('click', function() {
    $('.nav-sidebar').toggleClass('show');
    $('.partial-modal').toggleClass('darken');
		$('.bar').toggleClass('animate');
    $('body').toggleClass('darken');
	})
})();
