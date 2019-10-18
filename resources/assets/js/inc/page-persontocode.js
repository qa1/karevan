Vue.component('page-persontocode', {
	props: [],

	data: function() {
		return {
			loading: false,
			disable: false,
			type: '',
			code: '',
			father: '',
			error: '',
			success: '',
			persons: []
		}
	},

	mounted: function() {
		var that = this;

		$(window).on("keydown", function(evt){
			if( evt.keyCode == 112 ) {
				that.type = 'داخل';
			} else if( evt.keyCode == 113 ) {
				that.type = 'خارج';
			} else if( evt.keyCode == 114 ) {
				that.type = '';
			}
		});
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
		        data: {
	                father: that.father,
	                code: that.code
	            },
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
		        		that.persons = [];
			        }

			        if (data.success) {
			        	that.success = data.success;
			        	$(that.$refs.box).addClass('box-very-success');
			        }

			        if (data.persons) {
			        	that.persons = data.persons;
			        }
		        }
		    }).always(function(){
		    	that.loading = false;

        		that.disable = false;
                setTimeout(function(){$(that.$refs.code).focus();}, 100);
                setTimeout(function(){$(that.$refs.box).removeClass('box-very-success box-very-danger');}, 500);
		    });
		}
	}
});















Vue.component('page-persontocode-person', {
	props: ['index', 'url', 'camera', 'type'],

	data: function() {
		return {
			loading: false,
			code: ''
		}
	},

	mounted: function() {

	},

	methods: {
		submit: function(id, code) {
			var that = this;

			if (that.loading) {
				return;
			}

			if ($('#autoss').prop('checked')) {
				events.$emit('takeScreenshot');
			}

		    $.ajax({
		        type: 'post',
		        url: that.url,
		        data: {
	                id: id,
	                code: code,
	                taradod: that.type,
	                image: $("#person_camera_data").val()
	            },
		        dataType: 'json',
		        cache: false,
		        timeout: 15000,

		        beforeSend: function() {
					that.loading = true;
					that.$parent.error = that.$parent.success = '';
		        },

		        error: function(xhr) {
		        	return alert('ارتباط برقرار نشد');
		        },

		        success: function(data) {
		        	if (data.error) {
		        		that.$parent.error = data.error;
			        }

			        if (data.success) {
			        	that.$parent.success = data.success;
			        	that.$parent.persons.splice(that.index, 1);

			        	var nextInput = $("#list-group").find('input');
			        	if(nextInput[0]) {
			        		nextInput[0].focus();
			        	}
			        }
		        }
		    }).always(function(){
		    	that.loading = false;
		    	events.$emit('clearScreenshot');
		    });
		}
	}
});