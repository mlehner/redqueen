var $letters, $symbol_spans;
jQuery(function(){
	$write = jQuery('input:not([type=hidden]), select, textarea').eq(0);
	shift = false,
	capslock = false;

	$keyboard = jQuery('#keyboard, #keypad');
	$letters = jQuery('#keyboard .letter, #keypad .letter');
	$symbol_spans = jQuery('#keyboard .symbol span, #keypad .symbol span');

	$write.focus();

	jQuery('input:not([type=hidden]), select, textarea').click(function(){
		$write = jQuery(this);
		$write.focus();
	});

	jQuery('#keyboard li, #keypad li').click(function(){
		var $this = jQuery(this),
		character = $this.html(); // If it's a lowercase letter, nothing happens to this variable

		// show button down state
		$this.addClass('click').animate({opacity: 1.0}, 100, function(){ jQuery(this).removeClass('click') });

		// Shift keys
		if ($this.hasClass('left-shift') || $this.hasClass('right-shift')) {
			$keyboard.toggleClass('uppercase').toggleClass('symbols');
			shift = (shift === true) ? false : true;
			capslock = false;
			$write.focus();
			return false;
		}
		
		// Caps lock
		if ($this.hasClass('capslock')) {
			$keyboard.toggleClass('uppercase');
			capslock = true;
			$write.focus();
			return false;
		}

		// Delete
		if ($this.hasClass('delete')) {
			if ($this.attr('tagName') == 'TEXTAREA') {
				var html = $write.html();
				$write.html(html.substr(0, html.length - 1));
			} else if ($this.attr('tagName') == 'SELECT') {
				// jump to the first element with the letter
			} else {
				if ($this.hasClass('delete_all')) {
					$write.val('');
				} else {
					var val = $write.val();
					$write.val(val.substr(0, val.length - 1));
				}					
			}
			$write.focus();
			return false;
		}
		
		// Special characters
		if ($this.hasClass('symbol')) character = jQuery('span:visible', $this).html();
		if ($this.hasClass('space')) character = ' ';
		if ($this.hasClass('tab')) character = "\t";
		if ($this.hasClass('return')) character = "\n";
		
		// Uppercase letter
		if ($keyboard.hasClass('uppercase')) character = character.toUpperCase();
		
		// Remove shift once a key is clicked.
		if (shift === true) {
			$keyboard.toggleClass('symbols');
			if (capslock === false) {
				$keyboard.toggleClass('uppercase');
			}
			shift = false;
		}

		// tab through the inputs
		if (character == "\t") {
			var next = false;
			var done = false;
			$write.parents('form').eq(0).children('input:not([type=hidden]), select, textarea').each(function(){
				if (done) {
					return;
				}
				if (jQuery(this).attr('name') == $write.attr('name')) {
					next = true;
					return;
				}
				if (next) {
					$write = jQuery(this);
					$write.focus();
					done = true;
				}
			});
			if (!done) {
				$write = $write.parents('form').eq(0).children('input:not([type=hidden]), select, textarea').eq(0);
				$write.focus();
			}
			return;
		}

		if ($this.attr('tagName') == 'TEXTAREA') {
			$write.html($write.html() + character);
		} else if ($this.attr('tagName') == 'SELECT') {
			// jump to the first element with the letter
		} else {
			// submit the form
			if (character == "\n") {
				$write.parents('form').eq(0).submit();
			}
			$write.val($write.val() + character);
		}
		$write.focus();
	});
});
