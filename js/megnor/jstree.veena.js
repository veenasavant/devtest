
(function(a) {
    a.extend(a.fn, {
        swapClass: function(e, d) {
            var c = this.filter("." + e);
            this.filter("." + d).removeClass(d).addClass(e);
            c.removeClass(e).addClass(d);
            return this
        },
        replaceClass: function(d, c) {
            return this.filter("." + d).removeClass(d).addClass(c).end()
        },
        hoverClass: function(c) {
            c = c || "hover";
            return this.hover(function() {
                a(this).addClass(c)
            }, function() {
                a(this).removeClass(c)
            })
        },
        heightToggle: function(c, d) {
            c ? this.animate({
                height: "toggle"
            }, c, d) : this.each(function() {
                jQuery(this)[jQuery(this).is(":hidden") ? "show" : "hide"]();
                if (d) {
                    d.apply(this, arguments)
                }
            })
        },
        heightHide: function(c, d) {
            if (c) {
                this.animate({
                    height: "hide"
                }, c, d)
            } else {
                this.hide();
                if (d) {
                    this.each(d)
                }
            }
        },
        prepareBranches: function(c) {
            if (!c.prerendered) {
                this.filter(":last-child:not(ul)").addClass(b.last);
                this.filter((c.collapsed ? "" : "." + b.closed) + ":not(." + b.open + ")").find(">ul").hide()
            }
            return this.filter(":has(>ul)")
        },
        applyClasses: function(c, d) {
            this.filter(":has(>ul):not(:has(>a))").find(">span").click(function(e) {
                d.apply(a(this).next())
            }).add(a("a", this)).hoverClass();
            if (!c.prerendered) {
				
              window.alert("prerendered -veena");
			  
                this.filter(":has(>ul:hidden)").addClass(b.expandable).replaceClass(b.last, b.lastExpandable);
                this.not(":has(>ul:hidden)").addClass(b.collapsable).replaceClass(b.last, b.lastCollapsable);
								
				 // create hitarea if not present
				
				var hitarea = this.find("div." + b.hitarea);
				if (!hitarea.length)
					hitarea = this.prepend("<div class=\"" + b.hitarea + "\"/>").find("div." + b.hitarea);
				
				window.alert("after htarea find and prepend -veena" + hitarea.length);
				var hitarea = this.find("div." + b.hitarea);
				window.alert("hitarea length -veena" + hitarea.length);
				
				hitarea.removeClass().addClass(b.hitarea).each(function() {
					var e = "";
					window.alert("hitarea prepend -veena");
					a.each(a(this).parent().attr("class").split(" "), function() {
                        e += this + "-hitarea "
                    });
                    a(this).addClass(e);
				
                /*this.prepend('<div class="' + b.hitarea + '"/>').find("div." + b.hitarea).each(function() {
                    var e = "";
					window.alert("hitarea prepend -veena");
                    a.each(a(this).parent().attr("class").split(" "), function() {
                        e += this + "-hitarea "
                    });
                    a(this).addClass(e)*/
                })
            }
            this.find("div." + b.hitarea).click(d)
        },
        treeview: function(d) {
            d = a.extend({
                cookieId: "treeview"
            }, d);
            if (d.add) {
                return this.trigger("add", [d.add])
            }
            if (d.toggle) {
                var i = d.toggle;
                d.toggle = function() {
                    return i.apply(a(this).parent()[0], arguments)
                }
            }

            function c(l, n) {
                function m(o) {
                    return function() {
                        window.alert("veena- fapply line 87");
                        f.apply(a("div." + b.hitarea, l).filter(function() {
                            return o ? a(this).parent("." + o).length : true
                        }));
                        return false
                    }
                }
                a("a:eq(0)", n).click(m(b.collapsable));
                a("a:eq(1)", n).click(m(b.expandable));
                a("a:eq(2)", n).click(m())
            }

            function f() {
                a(this).parent().find(">.hitarea").swapClass(b.collapsableHitarea, b.expandableHitarea).swapClass(b.lastCollapsableHitarea, b.lastExpandableHitarea).end().swapClass(b.collapsable, b.expandable).swapClass(b.lastCollapsable, b.lastExpandable).find(">ul").heightToggle(d.animated, d.toggle);
                if (d.unique) {
                    a(this).parent().siblings().find(">.hitarea").replaceClass(b.collapsableHitarea, b.expandableHitarea).replaceClass(b.lastCollapsableHitarea, b.lastExpandableHitarea).end().replaceClass(b.collapsable, b.expandable).replaceClass(b.lastCollapsable, b.lastExpandable).find(">ul").heightHide(d.animated, d.toggle)
                }
            }

            function k() {
                function m(n) {
                    return n ? 1 : 0
                }
                var l = [];
                j.each(function(n, o) {
                    l[n] = a(o).is(":has(>ul:visible)") ? 1 : 0
                });
                a.cookie(d.cookieId, l.join(""))
            }

            function e() {
                var l = a.cookie(d.cookieId);
                if (l) {
                    var m = l.split("");
                    j.each(function(n, o) {
                        a(o).find(">ul")[parseInt(m[n]) ? "show" : "hide"]()
                    })
                }
            }
            this.addClass("treeview");
			window.alert("treeview");
            var j = this.find("li").prepareBranches(d);
            switch (d.persist) {
                case "cookie":
                    var h = d.toggle;
                    d.toggle = function() {
                        k();
                        if (h) {
                            h.apply(this, arguments)
                        }
                    };
                    e();
                    break;
                case "location":
                    var g = this.find("a").filter(function() {
                        return this.href.toLowerCase() == location.href.toLowerCase()
                    });
                    if (g.length) {
                        g.addClass("selected").parents("ul, li").add(g.next()).show()
                    }
                    break
            }
            j.applyClasses(d, f);
            if (d.control) {
                c(this, d.control);
                a(d.control).show()
            }
            return this.bind("add", function(m, l) {
                a(l).prev().removeClass(b.last).removeClass(b.lastCollapsable).removeClass(b.lastExpandable).find(">.hitarea").removeClass(b.lastCollapsableHitarea).removeClass(b.lastExpandableHitarea);
                a(l).find("li").andSelf().prepareBranches(d).applyClasses(d, f)
            })
        }
    });
    var b = a.fn.treeview.classes = {
        open: "open",
        closed: "closed",
        expandable: "expandable",
        expandableHitarea: "expandable-hitarea",
        lastExpandableHitarea: "lastExpandable-hitarea",
        collapsable: "collapsable",
        collapsableHitarea: "collapsable-hitarea",
        lastCollapsableHitarea: "lastCollapsable-hitarea",
        lastCollapsable: "lastCollapsable",
        lastExpandable: "lastExpandable",
        last: "last",
        hitarea: "hitarea"
    };
    a.fn.Treeview = a.fn.treeview
})(jQuery);