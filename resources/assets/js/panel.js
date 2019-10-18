var events = new Vue();

var master = new Vue({
  el: "#master"
});

$(document).ready(function() {
  $("body").animate({ scrollTop: $("body").scrollTop() + 1 });
});

$.fn.dataTable.ext.errMode = "none";

window.addEventListener("keydown", e => {
  if (!e.altKey) {
    return;
  }

  if (e.keyCode === 37) {
    window.history.back();
  } else if (e.keyCode === 39) {
    window.history.forward();
  }
});
