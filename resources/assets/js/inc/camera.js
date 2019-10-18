Vue.component('camera-screenshot', {
	props: [],

	data: function() {
		return {
			showCanvas: ''
		}
	},

	mounted: function() {
		var that = this;

		this.camera = new Camera(this.$refs.video);

		events.$on('takeScreenshot', function(){
			that.takeScreenshot();
		});

		events.$on('clearScreenshot', function(){
			that.clear();
		});
	},

	methods: {
		takeScreenshot: function() {
			this.camera.ss(this.$refs.input, this.$refs.canvas);
			this.showCanvas = true;
		},

		clear: function() {
			this.$refs.input.value = '';
			this.showCanvas = false;
		}
	}
});