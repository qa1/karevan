Vue.component('person-register', {
	props: [],

	data: function() {
		return {
			loading: false,
			disable: false,
			errors: {},
			result: {}
		}
	},

	methods: {
		submit: function() {
			var that = this;

			if (that.loading || that.disable) {
				return;
			}

			that.errors = {};
			that.disable = that.loading = true;
			that.result = {};

			if ($(that.$refs.autoss).prop("checked")) {
		        that.$refs.camera.takeScreenshot();
		    }

		    $.ajax({
		        type: 'post',
		        url: '',
		        data: $(that.$refs.form).serialize(),
		        dataType: 'json',
		        cache: false,
		        timeout: 15000,

		        error: function(xhr) {
		        	$(".content-wrapper").css('background-color', 'red');

		        	if (xhr.status != 422) {
			        	return alert('ارتباط برقرار نشد');
		        	}

		        	that.errors = xhr.responseJSON.errors;
		        },

		        success: function(data) {
		        	that.result = data;

		        	if (that.result.type == 'success') {
		        		that.$refs.code.value = that.$refs.name.value = that.$refs.father.value = that.$refs.melli.value = '';
		        		$(".content-wrapper").css('background-color', 'green');
		        		that.$refs.code.focus();
		        	} else {
		        		$(".content-wrapper").css('background-color', 'red');
		        	}
		        }
		    }).always(function(){
		        that.$refs.camera.clear();
        		that.loading = false;

		        setTimeout(function(){
	        		$(".content-wrapper").css('background-color', '#ecf0f5');
	        		that.disable = false;
	        	}, 1000);
		    });
		}
	}
});