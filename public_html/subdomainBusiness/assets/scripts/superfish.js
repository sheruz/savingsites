!function(a){a.fn.superfish=function(b){var c=a.fn.superfish,d=c.c,e=a(['<span class="',d.arrowClass,'"></span>'].join("")),f=function(){var b=a(this),c=h(b);clearTimeout(c.sfTimer),b.showSuperfishUl().siblings().hideSuperfishUl()},g=function(){var b=a(this),d=h(b),e=c.op;clearTimeout(d.sfTimer),d.sfTimer=setTimeout(function(){e.retainPath=a.inArray(b[0],e.$path)>-1,b.hideSuperfishUl(),e.$path.length&&b.parents(["li.",e.hoverClass].join("")).length<1&&f.call(e.$path)},e.delay)},h=function(a){var b=a.parents(["ul.",d.menuClass,":first"].join(""))[0];return c.op=c.o[b.serial],b},i=function(a){a.addClass(d.anchorClass).append(e.clone())};return this.each(function(){var e=this.serial=c.o.length,h=a.extend({},c.defaults,b);h.$path=a("li."+h.pathClass,this).slice(0,h.pathLevels).each(function(){a(this).addClass([h.hoverClass,d.bcClass].join(" ")).filter("li:has(ul)").removeClass(h.pathClass)}),c.o[e]=c.op=h,a("li:has(ul)",this)[a.fn.hoverIntent&&!h.disableHI?"hoverIntent":"hover"](f,g).each(function(){h.autoArrows&&i(a(">a:first-child",this))}).not("."+d.bcClass).hideSuperfishUl();var j=a("a",this);j.each(function(a){j.eq(a).parents("li")}),h.onInit.call(this)}).each(function(){var b=[d.menuClass];!c.op.dropShadows||a.browser.msie&&a.browser.version<7||b.push(d.shadowClass),a(this).addClass(b.join(" "))})};var b=a.fn.superfish;b.o=[],b.op={},b.IE7fix=function(){var c=b.op;a.browser.msie&&a.browser.version>6&&c.dropShadows&&void 0!=c.animation.opacity&&this.toggleClass(b.c.shadowClass+"-off")},b.c={bcClass:"sf-breadcrumb",menuClass:"sf-js-enabled",anchorClass:"sf-with-ul",arrowClass:"menu-arrow",shadowClass:"sf-shadow"},b.defaults={hoverClass:"sfHover",pathClass:"overideThisToUse",pathLevels:2,delay:1e3,animation:{height:"show"},speed:"normal",autoArrows:!1,dropShadows:!1,disableHI:!1,onInit:function(){},onBeforeShow:function(){},onShow:function(){},onHide:function(){}},a.fn.extend({hideSuperfishUl:function(){var c=b.op,d=!0===c.retainPath?c.$path:"";c.retainPath=!1;var e=a(["li.",c.hoverClass].join(""),this).add(this).not(d).removeClass(c.hoverClass).find(">ul").hide();return c.onHide.call(e),this},showSuperfishUl:function(){var a=b.op,d=(b.c.shadowClass,this.not(".accorChild").addClass(a.hoverClass).find(">ul:hidden"));return b.IE7fix.call(d),a.onBeforeShow.call(d),d.animate(a.animation,a.speed,function(){b.IE7fix.call(d),a.onShow.call(d)}),this}})}(jQuery),$(function(){$(".sf-menu").superfish({autoArrows:!0})});