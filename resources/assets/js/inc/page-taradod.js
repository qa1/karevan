Vue.component('page-taradod', {
	props: [],

	data: function() {
		return {
			loading: false,
			disable: false,
			type: 'داخل',
			code: '',
			error: '',
			success: '',
			codeFocused: false
		}
	},

	mounted: function() {
		var that = this;

		$(window).on("keydown", function(evt){
			if( evt.keyCode == 112 ) {
				that.type = 'داخل';
				that.$refs.code.focus();
			} else if( evt.keyCode == 113 ) {
				that.type = 'خارج';
				that.$refs.code.focus();
			}
		});

		setInterval(function(){
			if (!that.codeFocused) {
				that.$refs.code.focus();
				that.codeFocused = true;
			}
		}, 500);
	},

	methods: {
		submit: function() {
			var that = this;

			if (that.loading || that.disable) {
				return;
			}

		    $.ajax({
		        type: 'post',
		        url: '',
		        data: {code: that.code, type: that.type},
		        dataType: 'json',
		        cache: false,
		        timeout: 15000,

		        beforeSend: function() {
		        	that.success = that.error = '';
					that.disable = that.loading = true;
		        	$(that.$refs.result).hide();
		        },

		        error: function(xhr) {
		        	return alert('ارتباط برقرار نشد');
		        },

		        success: function(data) {
		        	that.code = '';

		        	if (data.error) {
		        		that.error = data.error;
		        		$(that.$refs.box).addClass('box-very-danger');
			        }

			        if (data.success) {
			        	that.success = data.success;
			        	$(that.$refs.box).addClass('box-very-success');
			        }

			        if (data.personinfo) {
				        $(that.$refs.result).html(data.personinfo).fadeIn('fast');
			        }
		        }
		    }).always(function(){
		    	that.loading = false;

        		setTimeout(function(){
	                that.disable = false;
	                setTimeout(function(){$(that.$refs.code).focus();}, 100);
	                $(that.$refs.box).removeClass('box-very-success box-very-danger');
	            }, 1000);
		    });
		}
	}
});