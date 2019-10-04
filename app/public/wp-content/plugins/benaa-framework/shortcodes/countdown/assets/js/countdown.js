(function(c) {
	var b = {
		init: function() {
			b.canvas();
			b.rtlCountDown()
		},
		canvas: function() {
			c(".g5plus-countdown").each(function() {
				var a = c(this);
				var i = a.data("date-end");
				var g = 0;
				a.countdown(i, function(d) {
					h(d, a)
				}).on("update.countdown", function(d) {
					h(d, a)
				}).on("finish.countdown", function(d) {
					c(".countdown-seconds", a).html("00");
					var e = a.attr("data-url-redirect");
					if (typeof e != "undefined" && e != "") {
						window.location.href = e
					}
				});
				
				function h(n, f) {
					var e = parseInt(n.offset.seconds);
					var o = parseInt(n.offset.minutes);
					var p = parseInt(n.offset.hours);
					var d = parseInt(n.offset.totalDays);
					c("#seconds", f).attr("value", e);
					c("#minutes", f).attr("value", o);
					c("#hours", f).attr("value", p);
					c("#days", f).attr("value", d);
					if (g == 0) {
						c("input", f).knob();
						g = 1
					}
					setTimeout(function() {
						f.css("opacity", "1")
					}, 500);
					c("#days", f).val(d).trigger("change");
					c("#hours", f).val(p).trigger("change");
					c("#minutes", f).val(o).trigger("change");
					c("#seconds", f).val(e).trigger("change")
				}
			})
		},
		rtlCountDown: function() {
			if (c("body").hasClass("rtl")) {
				var a = c(".countdown-section", ".g5plus-countdown");
				a.each(function() {
					var d = c(this).find("input");
					d.css("margin-left", "0px");
					d.css("margin-right", "-140px")
				})
			}
		}
	};
	c(document).ready(b.init)
})(jQuery);