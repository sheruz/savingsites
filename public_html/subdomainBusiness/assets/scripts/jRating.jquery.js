! function(a) {
    a.fn.jRating = function(b) {
        var c = {
            bigStarsPath: "../../assets/stylesheets/icons/stars.png",
            smallStarsPath: "../../assets/stylesheets/icons/stars.png",
            phpPath: "ads/ratead",
            type: "big",
            step: !1,
            isDisabled: !1,
            showRateInfo: !0,
            canRateAgain: !1,
            length: 5,
            decimalLength: 0,
            rateMax: 20,
            rateInfosX: -45,
            rateInfosY: 5,
            nbRates: 1,
            zone_id: 0,
            user_id: 0,
            bus_id: 0,
            onSuccess: null,
            onError: null
        };
        if (this.length > 0) return this.each(function() {
            function u(a) {
                var b = parseFloat(100 * a / q * e.rateMax / 100);
                switch (e.decimalLength) {
                    case 1:
                        var c = Math.round(10 * b) / 10;
                        break;
                    case 2:
                        var c = Math.round(100 * b) / 100;
                        break;
                    case 3:
                        var c = Math.round(1e3 * b) / 1e3;
                        break;
                    default:
                        var c = Math.round(1 * b) / 1
                }
                return c
            }

            function v() {
                switch (e.type) {
                    case "small":
                        g = 12, h = 10, i = e.smallStarsPath;
                        break;
                    default:
                        g = 43, h = 42, i = e.bigStarsPath
                }
            }

            function w(a) {
                return a ? a.offsetLeft + w(a.offsetParent) : 0
            }
            var d = a(this),
                e = a.extend(c, b),
                f = 0,
                g = 0,
                h = 0,
                i = "",
                j = !1,
                k = 0,
                l = e.nbRates;
            if (a(this).hasClass("jDisabled") || e.isDisabled) var m = !0;
            else var m = !1;
            v(), a(this).height(h);
            var n = parseFloat(a(this).attr("data-average")),
                o = a(this).attr("rel"),
                p = parseInt(a(this).attr("data-id")),
                q = g * e.length,
                r = n / e.rateMax * q,
                n = (a("<div>", {
                    class: "jRatingColor",
                    css: {
                        width: r
                    }
                }).appendTo(a(this)), a("<div>", {
                    class: "jRatingAverage",
                    css: {
                        width: 0,
                        top: -h
                    }
                }).appendTo(a(this)));
            a("<div>", {
                class: "jStar",
                css: {
                    width: q,
                    height: h,
                    top: -2 * h,
                    background: "url(" + i + ") repeat-x"
                }
            }).appendTo(a(this));
            a(this).css({
                width: q,
                overflow: "hidden",
                zIndex: 1,
                position: "relative"
            }), m || a(this).unbind().bind({
                mouseenter: function(b) {
                    var c = w(this),
                        d = b.pageX - c;
                    if (e.showRateInfo) {
                        a("<p>", {
                            class: "jRatingInfos",
                            html: u(d) + ' <span class="maxRate">/ ' + e.rateMax + "</span>",
                            css: {
                                top: b.pageY + e.rateInfosY,
                                left: b.pageX + e.rateInfosX
                            }
                        }).appendTo("body").show()
                    }
                },
                mouseover: function(b) {
                    a(this).css("cursor", "pointer")
                },
                mouseout: function() {
                    a(this).css("cursor", "default"), j ? n.width(k) : n.width(0)
                },
                mousemove: function(b) {
                    var c = w(this),
                        d = b.pageX - c;
                    f = e.step ? Math.floor(d / g) * g + g : d, n.width(f), e.showRateInfo && a("p.jRatingInfos").css({
                        left: b.pageX + e.rateInfosX
                    }).html(u(f) + ' <span class="maxRate">/ ' + e.rateMax + "</span>")
                },
                mouseleave: function() {
                    a("p.jRatingInfos").remove()
                },
                click: function(b) {
                    if (e.user_id) {
                        var c = this;
                        j = !0, k = f, l--, (!e.canRateAgain || parseInt(l) <= 0) && a(this).unbind().css("cursor", "default").addClass("jDisabled"), e.showRateInfo && a("p.jRatingInfos").fadeOut("fast", function() {
                            a(this).remove()
                        }), b.preventDefault();
                        var g = u(f);
                        n.width(f), a(this).parent().find(".datasSent span:not(.avg_rating1)").html("You rated " + g + "/5"), a.post(e.phpPath, {
                            zone_id: e.zone_id,
                            user_id: e.user_id,
                            bus_id: o,
                            idBox: p,
                            rate: g,
                            action: "rating"
                        }, function(a) {
                            console.log(a), a.error ? e.onError && e.onError(c, g) : e.onSuccess && e.onSuccess(a, d)
                        }, "json")
                    } else clicksnapsignup(e.bus_id, e.zone_id, "2", "", "", u(f))
                }
            })
        })
    }
}(jQuery);