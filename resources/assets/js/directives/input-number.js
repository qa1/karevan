Vue.directive('input-number', {
	inserted: function (el) {
		var pattern = "";
		var minlength = $(el).data('minlen') ? $(el).data('minlen') : 0;
		var maxlength = $(el).data('maxlen') ? $(el).data('maxlen') : 10;

		if (maxlength) {
			for(var i = 0; i < maxlength; i++) {
				if (minlength > 0 && i >= minlength) {
					pattern += "p";
				} else {
					pattern += "d";
				}

			}
		}
		
		$(el).mask(pattern, {clearIfNotMatch: true});
		// $(el).css('direction', 'ltr').css('text-align', 'right');
	}
});