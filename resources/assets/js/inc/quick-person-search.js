Vue.component('quick-person-search', {
	props: ['url'],

	data: function() {
		return {
			loading: false,
			disable: false,
			isOpen: false,
			code: '',
			error: '',
			timeout: null,
			canIOpenIt: false
		}
	},

	mounted: function() {
		$(window).on('keydown', this.openOnDoubleBtn);
		$(window).on('keyup', this.escBtn);
		$(this.$el).on('show.bs.modal', this.modalShow);
		$(this.$el).on('shown.bs.modal', this.modalShown);
		$(this.$el).on('hide.bs.modal', this.modalHide);
		$(this.$el).on('hidden.bs.modal', this.modalHidden);
	},

	methods: {
		openOnDoubleBtn: function(e) {
			var that = this;

			if (e.keyCode != 192) {
				return;
			}

			if (that.isOpen) {
				return;
			}

			if (that.canIOpenIt) {
				if (that.timeout !== null) {
					that.timeout = null;
					clearTimeout(that.timeout);
				}

				that.canIOpenIt = false;
				return $(that.$el).modal('show');
			}

			that.canIOpenIt = true;
			that.timeout = setTimeout(function(){
				that.canIOpenIt = false;
			}, 800);
		},

		escBtn: function(e) {
			var that = this;

			if (e.keyCode != 27) {
				return;
			}

			if (!that.isOpen) {
				return;
			}

			return $(that.$el).modal('hide');
		},

		modalShow: function() {
			this.isOpen = true;
		},

		modalShown: function() {
			this.$refs.code.focus();
		},

		modalHide: function() {
			this.isOpen = false;
		},

		modalHidden: function() {
		},

		submit: function() {
			var that = this;

			if (that.loading || that.disable) {
				return;
			}

		    $.ajax({
		        type: 'post',
		        url: that.url,
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