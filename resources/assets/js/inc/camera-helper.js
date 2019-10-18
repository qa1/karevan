function Camera(video) {
    var that = this;
    this.video = video;
    this.stream = null;

    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;

    navigator.getUserMedia({ video: true }, function (stream) {
        that.stream = stream;
        that.video.srcObject = stream;
    }, function(){
        alert("ناتوان در فعال سازی دوربین");
    });

    // Screenshot
    this.ss = function(input, canvas) {
        if( that.video == null )
        {
            alert("لطفا ابتدا دوربین را روشن کنید");
            return;
        }

        if (!$(canvas).data('nopreview')) {
            $(canvas).fadeIn("fast");
        }
        var ctx    = canvas.getContext("2d");
        ctx.drawImage(that.video, 0, 0, canvas.width, canvas.height);
        var img    = canvas.toDataURL("image/jpeg");
        $(input).val(img);
    };
}