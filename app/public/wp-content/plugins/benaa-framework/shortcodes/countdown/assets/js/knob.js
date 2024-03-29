(function(a) {
	if (typeof define === "function" && define.amd) {
		define(["jquery"], a)
	} else {
		a(jQuery)
	}
})(function(c) {
	var a = {},
		d = Math.max,
		b = Math.min;
	a.c = {};
	a.c.d = c(document);
	a.c.t = function(f) {
		return f.originalEvent.touches.length - 1
	};
	a.o = function() {
		var e = this;
		this.o = null;
		this.$ = null;
		this.i = null;
		this.g = null;
		this.v = null;
		this.cv = null;
		this.x = 0;
		this.y = 0;
		this.w = 0;
		this.h = 0;
		this.$c = null;
		this.c = null;
		this.t = 0;
		this.isInit = false;
		this.fgColor = null;
		this.pColor = null;
		this.dH = null;
		this.cH = null;
		this.eH = null;
		this.rH = null;
		this.scale = 1;
		this.relative = false;
		this.relativeWidth = false;
		this.relativeHeight = false;
		this.$div = null;
		this.run = function() {
			var f = function(i, g) {
				var h;
				for (h in g) {
					e.o[h] = g[h]
				}
				e._carve().init();
				e._configure()._draw()
			};
			if (this.$.data("kontroled")) {
				return
			}
			this.$.data("kontroled", true);
			this.extend();
			this.o = c.extend({
				min: this.$.data("min") !== undefined ? this.$.data("min") : 0,
				max: this.$.data("max") !== undefined ? this.$.data("max") : 100,
				stopper: true,
				readOnly: this.$.data("readonly") || this.$.attr("readonly") === "readonly",
				cursor: this.$.data("cursor") === true && 30 || this.$.data("cursor") || 0,
				thickness: this.$.data("thickness") && Math.max(Math.min(this.$.data("thickness"), 1), 0.01) || 0.35,
				lineCap: this.$.data("linecap") || "butt",
				width: this.$.data("width") || 185,
				height: this.$.data("height") || 185,
				displayInput: this.$.data("displayinput") == null || this.$.data("displayinput"),
				displayPrevious: this.$.data("displayprevious"),
				fgColor: this.$.data("fgcolor") || "#3f51b5",
				inputColor: this.$.data("inputcolor"),
				font: this.$.data("font") || "Arial",
				fontWeight: this.$.data("font-weight") || "normal",
				inline: false,
				step: this.$.data("step") || 1,
				rotation: this.$.data("rotation"),
				draw: null,
				change: null,
				cancel: null,
				release: null,
				format: function(g) {
					return g
				},
				parse: function(g) {
					return parseFloat(g)
				}
			}, this.o);
			this.o.flip = this.o.rotation === "anticlockwise" || this.o.rotation === "acw";
			if (!this.o.inputColor) {
				this.o.inputColor = this.o.fgColor
			}
			if (this.$.is("fieldset")) {
				this.v = {};
				this.i = this.$.find("input");
				this.i.each(function(g) {
					var h = c(this);
					e.i[g] = h;
					e.v[g] = e.o.parse(h.val());
					h.bind("change blur", function() {
						var i = {};
						i[g] = h.val();
						e.val(e._validate(i))
					})
				});
				this.$.find("legend").remove()
			} else {
				this.i = this.$;
				this.v = this.o.parse(this.$.val());
				this.v === "" && (this.v = this.o.min);
				this.$.bind("change blur", function() {
					e.val(e._validate(e.o.parse(e.$.val())))
				})
			}!this.o.displayInput && this.$.hide();
			this.$c = c(document.createElement("canvas")).attr({
				width: this.o.width,
				height: this.o.height
			});
			this.$div = c('<div style="' + (this.o.inline ? "display:block;" : "") + "width:" + this.o.width + "px;height:" + this.o.height + 'px;"></div>');
			this.$.wrap(this.$div).before(this.$c);
			this.$div = this.$.parent();
			if (typeof G_vmlCanvasManager !== "undefined") {
				G_vmlCanvasManager.initElement(this.$c[0])
			}
			this.c = this.$c[0].getContext ? this.$c[0].getContext("2d") : null;
			if (!this.c) {
				throw {
					name: "CanvasNotSupportedException",
					message: "Canvas not supported. Please use excanvas on IE8.0.",
					toString: function() {
						return this.name + ": " + this.message
					}
				}
			}
			this.scale = (window.devicePixelRatio || 1) / (this.c.webkitBackingStorePixelRatio || this.c.mozBackingStorePixelRatio || this.c.msBackingStorePixelRatio || this.c.oBackingStorePixelRatio || this.c.backingStorePixelRatio || 1);
			this.relativeWidth = this.o.width % 1 !== 0 && this.o.width.indexOf("%");
			this.relativeHeight = this.o.height % 1 !== 0 && this.o.height.indexOf("%");
			this.relative = this.relativeWidth || this.relativeHeight;
			this._carve();
			if (this.v instanceof Object) {
				this.cv = {};
				this.copy(this.v, this.cv)
			} else {
				this.cv = this.v
			}
			this.$.bind("configure", f).parent().bind("configure", f);
			this._listen()._configure()._xy().init();
			this.isInit = true;
			this.$.val(this.o.format(this.v));
			this._draw();
			return this
		};
		this._carve = function() {
			if (this.relative) {
				var g = this.relativeWidth ? this.$div.parent().width() * parseInt(this.o.width) / 100 : this.$div.parent().width(),
					f = this.relativeHeight ? this.$div.parent().height() * parseInt(this.o.height) / 100 : this.$div.parent().height();
				this.w = this.h = Math.min(g, f)
			} else {
				this.w = this.o.width;
				this.h = this.o.height
			}
			this.$div.css({
				width: this.w + "px",
				height: this.h + "px"
			});
			this.$c.attr({
				width: this.w,
				height: this.h
			});
			if (this.scale !== 1) {
				this.$c[0].width = this.$c[0].width * this.scale;
				this.$c[0].height = this.$c[0].height * this.scale;
				this.$c.width(this.w);
				this.$c.height(this.h)
			}
			return this
		};
		this._draw = function() {
			var f = true;
			e.g = e.c;
			e.clear();
			e.dH && (f = e.dH());
			f !== false && e.draw()
		};
		this._touch = function(g) {
			var f = function(i) {
				var h = e.xy2val(i.originalEvent.touches[e.t].pageX, i.originalEvent.touches[e.t].pageY);
				if (h == e.cv) {
					return
				}
				if (e.cH && e.cH(h) === false) {
					return
				}
				e.change(e._validate(h));
				e._draw()
			};
			this.t = a.c.t(g);
			f(g);
			a.c.d.bind("touchmove.k", f).bind("touchend.k", function() {
				a.c.d.unbind("touchmove.k touchend.k");
				e.val(e.cv)
			});
			return this
		};
		this._mouse = function(g) {
			var f = function(i) {
				var h = e.xy2val(i.pageX, i.pageY);
				if (h == e.cv) {
					return
				}
				if (e.cH && e.cH(h) === false) {
					return
				}
				e.change(e._validate(h));
				e._draw()
			};
			f(g);
			a.c.d.bind("mousemove.k", f).bind("keyup.k", function(h) {
				if (h.keyCode === 27) {
					a.c.d.unbind("mouseup.k mousemove.k keyup.k");
					if (e.eH && e.eH() === false) {
						return
					}
					e.cancel()
				}
			}).bind("mouseup.k", function(h) {
				a.c.d.unbind("mousemove.k mouseup.k keyup.k");
				e.val(e.cv)
			});
			return this
		};
		this._xy = function() {
			var f = this.$c.offset();
			this.x = f.left;
			this.y = f.top;
			return this
		};
		this._listen = function() {
			if (!this.o.readOnly) {
				this.$c.bind("mousedown", function(f) {
					f.preventDefault();
					e._xy()._mouse(f)
				}).bind("touchstart", function(f) {
					f.preventDefault();
					e._xy()._touch(f)
				});
				this.listen()
			} else {
				this.$.attr("readonly", "readonly")
			}
			if (this.relative) {
				c(window).resize(function() {
					e._carve().init();
					e._draw()
				})
			}
			return this
		};
		this._configure = function() {
			if (this.o.draw) {
				this.dH = this.o.draw
			}
			if (this.o.change) {
				this.cH = this.o.change
			}
			if (this.o.cancel) {
				this.eH = this.o.cancel
			}
			if (this.o.release) {
				this.rH = this.o.release
			}
			if (this.o.displayPrevious) {
				this.pColor = this.h2rgba(this.o.fgColor, "1");
				this.fgColor = this.h2rgba(this.o.fgColor, "1");
			} else {
				this.fgColor = this.o.fgColor;
			}
			return this
		};
		this._clear = function() {
			this.$c[0].width = this.$c[0].width
		};
		this._validate = function(g) {
			var f = ~~((g < 0 ? -0.5 : 0.5) + g / this.o.step) * this.o.step;
			return Math.round(f * 100) / 100
		};
		this.listen = function() {};
		this.extend = function() {};
		this.init = function() {};
		this.change = function(f) {};
		this.val = function(f) {};
		this.xy2val = function(g, f) {};
		this.draw = function() {};
		this.clear = function() {
			this._clear()
		};
		this.h2rgba = function(g, f) {
			var h;
			g = g.substring(1, 7);
			h = [parseInt(g.substring(0, 2), 16), parseInt(g.substring(2, 4), 16), parseInt(g.substring(4, 6), 16)];
			return "rgba(" + h[0] + "," + h[1] + "," + h[2] + "," + f + ")"
		};
		this.copy = function(g, f) {
			for (var h in g) {
				f[h] = g[h]
			}
		}
	};
	a.Dial = function() {
		a.o.call(this);
		this.startAngle = null;
		this.xy = null;
		this.radius = null;
		this.lineWidth = null;
		this.cursorExt = null;
		this.w2 = null;
		this.PI2 = 2 * Math.PI;
		this.extend = function() {
			this.o = c.extend({
				bgColor: this.$.data("bgcolor") || "#EEEEEE",
				angleOffset: this.$.data("angleoffset") || 0,
				angleArc: this.$.data("anglearc") || 360,
				inline: true
			}, this.o)
		};
		this.val = function(g, f) {
			if (null != g) {
				g = this.o.parse(g);
				if (f !== false && g != this.v && this.rH && this.rH(g) === false) {
					return
				}
				this.cv = this.o.stopper ? d(b(g, this.o.max), this.o.min) : g;
				this.v = this.cv;
				this.$.val(this.o.format(this.v));
				this._draw()
			} else {
				return this.v
			}
		};
		this.xy2val = function(j, g) {
			var f, h;
			f = Math.atan2(j - (this.x + this.w2), -(g - this.y - this.w2)) - this.angleOffset;
			if (this.o.flip) {
				f = this.angleArc - f - this.PI2
			}
			if (this.angleArc != this.PI2 && f < 0 && f > -0.5) {
				f = 0
			} else {
				if (f < 0) {
					f += this.PI2
				}
			}
			h = f * (this.o.max - this.o.min) / this.angleArc + this.o.min;
			this.o.stopper && (h = d(b(h, this.o.max), this.o.min));
			return h
		};
		this.listen = function() {
			var k = this,
				j, m, p = function(r) {
					r.preventDefault();
					var s = r.originalEvent,
						l = s.detail || s.wheelDeltaX,
						i = s.detail || s.wheelDeltaY,
						q = k._validate(k.o.parse(k.$.val())) + (l > 0 || i > 0 ? k.o.step : l < 0 || i < 0 ? -k.o.step : 0);
					q = d(b(q, k.o.max), k.o.min);
					k.val(q, false);
					if (k.rH) {
						clearTimeout(j);
						j = setTimeout(function() {
							k.rH(q);
							j = null
						}, 100);
						if (!m) {
							m = setTimeout(function() {
								if (j) {
									k.rH(q)
								}
								m = null
							}, 200)
						}
					}
				},
				h, g, n = 1,
				e = {
					37: -k.o.step,
					38: k.o.step,
					39: k.o.step,
					40: -k.o.step
				};
			this.$.bind("keydown", function(f) {
				var l = f.keyCode;
				if (l >= 96 && l <= 105) {
					l = f.keyCode = l - 48
				}
				h = parseInt(String.fromCharCode(l));
				if (isNaN(h)) {
					l !== 13 && l !== 8 && l !== 9 && l !== 189 && (l !== 190 || k.$.val().match(/\./)) && f.preventDefault();
					if (c.inArray(l, [37, 38, 39, 40]) > -1) {
						f.preventDefault();
						var q = k.o.parse(k.$.val()) + e[l] * n;
						k.o.stopper && (q = d(b(q, k.o.max), k.o.min));
						k.change(k._validate(q));
						k._draw();
						g = window.setTimeout(function() {
							n *= 2
						}, 30)
					}
				}
			}).bind("keyup", function(f) {
				if (isNaN(h)) {
					if (g) {
						window.clearTimeout(g);
						g = null;
						n = 1;
						k.val(k.$.val())
					}
				} else {
					k.$.val() > k.o.max && k.$.val(k.o.max) || k.$.val() < k.o.min && k.$.val(k.o.min)
				}
			});
			this.$c.bind("mousewheel DOMMouseScroll", p);
			this.$.bind("mousewheel DOMMouseScroll", p)
		};
		this.init = function() {
			if (this.v < this.o.min || this.v > this.o.max) {
				this.v = this.o.min
			}
			this.$.val(this.v);
			this.w2 = this.w / 2;
			this.cursorExt = this.o.cursor / 100;
			this.xy = this.w2 * this.scale;
			this.lineWidth = this.xy * this.o.thickness;
			this.lineCap = this.o.lineCap;
			this.radius = this.xy - this.lineWidth / 2;
			this.o.angleOffset && (this.o.angleOffset = isNaN(this.o.angleOffset) ? 0 : this.o.angleOffset);
			this.o.angleArc && (this.o.angleArc = isNaN(this.o.angleArc) ? this.PI2 : this.o.angleArc);
			this.angleOffset = this.o.angleOffset * Math.PI / 180;
			this.angleArc = this.o.angleArc * Math.PI / 180;
			this.startAngle = 1.5 * Math.PI + this.angleOffset;
			this.endAngle = 1.5 * Math.PI + this.angleOffset + this.angleArc;
			var f = d(String(Math.abs(this.o.max)).length, String(Math.abs(this.o.min)).length, 2) + 2;
			this.o.displayInput && this.i.css({
				width: (this.w / 2 + 4 >> 0) + "px",
				height: (this.w / 3 >> 0) + "px",
				position: "absolute",
				"vertical-align": "middle",
				"margin-top": (this.w / 3 >> 0) + "px",
				"margin-left": "-" + (this.w * 3 / 4 + 2 >> 0) + "px",
				border: 0,
				background: "none",
				font: this.o.fontWeight + " " + (this.w / f >> 0) + "px " + this.o.font,
				"text-align": "center",
				color: this.o.inputColor || this.o.fgColor,
				padding: "0px",
				"-webkit-appearance": "none"
			}) || this.i.css({
				width: "0px",
				visibility: "hidden"
			})
		};
		this.change = function(f) {
			this.cv = f;
			this.$.val(this.o.format(f))
		};
		this.angle = function(f) {
			return (f - this.o.min) * this.angleArc / (this.o.max - this.o.min)
		};
		this.arc = function(g) {
			var f, h;
			g = this.angle(g);
			if (this.o.flip) {
				f = this.endAngle + 0.00001;
				h = f - g - 0.00001
			} else {
				f = this.startAngle - 0.00001;
				h = f + g + 0.00001
			}
			this.o.cursor && (f = h - this.cursorExt) && (h = h + this.cursorExt);
			return {
				s: f,
				e: h,
				d: this.o.flip && !this.o.cursor
			}
		};
		this.draw = function() {
			var i = this.g,
				g = this.arc(this.cv),
				k, h = 1;
			i.lineWidth = this.lineWidth;
			i.lineCap = this.lineWidth;
			if (this.o.bgColor !== "none") {
				i.beginPath();
				i.strokeStyle = this.o.bgColor;
				i.arc(this.xy, this.xy, this.radius - 12.5, this.endAngle - 0.00001, this.startAngle + 0.00001, true);
				i.stroke()
			}
			if (this.o.displayPrevious) {
				k = this.arc(this.v);
				i.beginPath();
				i.strokeStyle = this.pColor;
				i.arc(this.xy, this.xy, this.radius - 12.5, k.s, k.e, k.d);
				i.stroke();
				h = this.cv == this.v
			}
			i.beginPath();
			i.strokeStyle = h ? this.o.fgColor : this.fgColor;
			i.arc(this.xy, this.xy, this.radius - 12.5, g.s, g.e, g.d);
			i.stroke();
		};
		this.cancel = function() {
			this.val(this.v)
		}
	};
	c.fn.dial = c.fn.knob = function(e) {
		return this.each(function() {
			var f = new a.Dial;
			f.o = e;
			f.$ = c(this);
			f.run()
		}).parent()
	}
});