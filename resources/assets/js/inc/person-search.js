Vue.component('person-search', {
	props: [],

	data: function() {
		return {
			loading: false,
			disable: false,
			code: '',
			error: ''
		}
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
		        data: {code: that.code},
		        dataType: 'json',
		        cache: false,
		        timeout: 15000,

		        beforeSend: function() {
		        	that.error = '';
					that.disable = that.loading = true;
		        	$(that.$refs.result).hide();
		        },

		        error: function(xhr) {
		        	return alert('ارتباط برقرار نشد');
		        },

		        success: function(data) {
		        	that.code = '';

		        	if (data.error) {
		        		return that.error = data.error;
			        }

			        $(that.$refs.result).html(data.personinfo).fadeIn('fast');
		        }
		    }).always(function(){
		    	that.loading = false;

        		setTimeout(function(){
	                that.disable = false;
	                setTimeout(function(){$(that.$refs.code).focus();}, 100);
	            }, 1000);
		    });
		}
	}
});