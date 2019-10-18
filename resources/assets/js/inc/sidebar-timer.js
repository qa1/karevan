Vue.component('sidebar-timer', {
	props: [],

	data: function() {
		return {
			timer: ''
		}
	},

	mounted: function() {
		var that = this;
		setInterval(function(){
			var mydate = new Date();
			that.timer = ('0' + mydate.getHours()).slice(-2) + ":" + ('0' + mydate.getMinutes()).slice(-2) + ":" + ('0' + mydate.getSeconds()).slice(-2);
		}, 1000);
	}
});