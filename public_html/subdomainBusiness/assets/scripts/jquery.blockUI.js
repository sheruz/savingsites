!function(){function a(a){function h(c,h){var j=c==window,l=h&&void 0!==h.message?h.message:void 0;h=a.extend({},a.blockUI.defaults,h||{}),h.overlayCSS=a.extend({},a.blockUI.defaults.overlayCSS,h.overlayCSS||{});var p=a.extend({},a.blockUI.defaults.css,h.css||{}),q=a.extend({},a.blockUI.defaults.themedCSS,h.themedCSS||{});if(l=void 0===l?h.message:l,j&&f&&i(window,{fadeOut:0}),l&&"string"!=typeof l&&(l.parentNode||l.jquery)){var r=l.jquery?l[0]:l,s={};a(c).data("blockUI.history",s),s.el=r,s.parent=r.parentNode,s.display=r.style.display,s.position=r.style.position,s.parent&&s.parent.removeChild(r)}a(c).data("blockUI.onUnblock",h.onUnblock);var w,x,t=h.baseZ,u=a(a.browser.msie||h.forceIframe?'<iframe class="blockUI" style="z-index:'+t+++';display:none;border:none;margin:0;padding:0;position:absolute;width:100%;height:100%;top:0;left:0" src="'+h.iframeSrc+'"></iframe>':'<div class="blockUI" style="display:none"></div>'),v=a(h.theme?'<div class="blockUI blockOverlay ui-widget-overlay" style="z-index:'+t+++';display:none"></div>':'<div class="blockUI blockOverlay" style="z-index:'+t+++';display:none;border:none;margin:0;padding:0;width:100%;height:100%;top:0;left:0"></div>');x=h.theme&&j?'<div class="blockUI '+h.blockMsgClass+' blockPage ui-dialog ui-widget ui-corner-all" style="z-index:'+(t+10)+';display:none;position:fixed"><div class="ui-widget-header ui-dialog-titlebar ui-corner-all blockTitle">'+(h.title||"&nbsp;")+'</div><div class="ui-widget-content ui-dialog-content"></div></div>':h.theme?'<div class="blockUI '+h.blockMsgClass+' blockElement ui-dialog ui-widget ui-corner-all" style="z-index:'+(t+10)+';display:none;position:absolute"><div class="ui-widget-header ui-dialog-titlebar ui-corner-all blockTitle">'+(h.title||"&nbsp;")+'</div><div class="ui-widget-content ui-dialog-content"></div></div>':j?'<div class="blockUI '+h.blockMsgClass+' blockPage" style="z-index:'+(t+10)+';display:none;position:fixed"></div>':'<div class="blockUI '+h.blockMsgClass+' blockElement" style="z-index:'+(t+10)+';display:none;position:absolute"></div>',w=a(x),l&&(h.theme?(w.css(q),w.addClass("ui-widget-content")):w.css(p)),h.theme||h.applyPlatformOpacityRules&&a.browser.mozilla&&/Linux/.test(navigator.platform)||v.css(h.overlayCSS),v.css("position",j?"fixed":"absolute"),(a.browser.msie||h.forceIframe)&&u.css("opacity",0);var y=[u,v,w],z=a(j?"body":c);a.each(y,function(){this.appendTo(z)}),h.theme&&h.draggable&&a.fn.draggable&&w.draggable({handle:".ui-dialog-titlebar",cancel:"li"});var A=d&&(!a.boxModel||a("object,embed",j?null:c).length>0);if(e||A){if(j&&h.allowBodyStretch&&a.boxModel&&a("html,body").css("height","100%"),(e||!a.boxModel)&&!j)var B=o(c,"borderTopWidth"),C=o(c,"borderLeftWidth"),D=B?"(0 - "+B+")":0,E=C?"(0 - "+C+")":0;a.each([u,v,w],function(a,b){var c=b[0].style;if(c.position="absolute",a<2)j?c.setExpression("height","Math.max(document.body.scrollHeight, document.body.offsetHeight) - (jQuery.boxModel?0:"+h.quirksmodeOffsetHack+') + "px"'):c.setExpression("height",'this.parentNode.offsetHeight + "px"'),j?c.setExpression("width",'jQuery.boxModel && document.documentElement.clientWidth || document.body.clientWidth + "px"'):c.setExpression("width",'this.parentNode.offsetWidth + "px"'),E&&c.setExpression("left",E),D&&c.setExpression("top",D);else if(h.centerY)j&&c.setExpression("top",'(document.documentElement.clientHeight || document.body.clientHeight) / 2 - (this.offsetHeight / 2) + (blah = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop) + "px"'),c.marginTop=0;else if(!h.centerY&&j){var d=h.css&&h.css.top?parseInt(h.css.top):0,e="((document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop) + "+d+') + "px"';c.setExpression("top",e)}})}if(l&&(h.theme?w.find(".ui-widget-content").append(l):w.append(l),(l.jquery||l.nodeType)&&a(l).show()),(a.browser.msie||h.forceIframe)&&h.showOverlay&&u.show(),h.fadeIn){var F=h.onBlock?h.onBlock:b,G=h.showOverlay&&!l?F:b,H=l?F:b;h.showOverlay&&v._fadeIn(h.fadeIn,G),l&&w._fadeIn(h.fadeIn,H)}else h.showOverlay&&v.show(),l&&w.show(),h.onBlock&&h.onBlock();if(k(1,c,h),j?(f=w[0],g=a(":input:enabled:visible",f),h.focusInput&&setTimeout(m,20)):n(w[0],h.centerX,h.centerY),h.timeout){var I=setTimeout(function(){j?a.unblockUI(h):a(c).unblock(h)},h.timeout);a(c).data("blockUI.timeout",I)}}function i(b,c){var d=b==window,e=a(b),h=e.data("blockUI.history"),i=e.data("blockUI.timeout");i&&(clearTimeout(i),e.removeData("blockUI.timeout")),c=a.extend({},a.blockUI.defaults,c||{}),k(0,b,c),null===c.onUnblock&&(c.onUnblock=e.data("blockUI.onUnblock"),e.removeData("blockUI.onUnblock"));var l;l=d?a("body").children().filter(".blockUI").add("body > .blockUI"):a(".blockUI",b),d&&(f=g=null),c.fadeOut?(l.fadeOut(c.fadeOut),setTimeout(function(){j(l,h,c,b)},c.fadeOut)):j(l,h,c,b)}function j(b,c,d,e){b.each(function(a,b){this.parentNode&&this.parentNode.removeChild(this)}),c&&c.el&&(c.el.style.display=c.display,c.el.style.position=c.position,c.parent&&c.parent.appendChild(c.el),a(e).removeData("blockUI.history")),"function"==typeof d.onUnblock&&d.onUnblock(e,d)}function k(b,c,d){var e=c==window,g=a(c);if((b||(!e||f)&&(e||g.data("blockUI.isBlocked")))&&(e||g.data("blockUI.isBlocked",b),d.bindEvents&&(!b||d.showOverlay))){var h="mousedown mouseup keydown keypress";b?a(document).bind(h,d,l):a(document).unbind(h,l)}}function l(b){if(b.keyCode&&9==b.keyCode&&f&&b.data.constrainTabKey){var c=g,d=!b.shiftKey&&b.target===c[c.length-1],e=b.shiftKey&&b.target===c[0];if(d||e)return setTimeout(function(){m(e)},10),!1}var h=b.data;return a(b.target).parents("div."+h.blockMsgClass).length>0||0==a(b.target).parents().children().filter("div.blockUI").length}function m(a){if(g){var b=g[!0===a?g.length-1:0];b&&b.focus()}}function n(a,b,c){var d=a.parentNode,e=a.style,f=(d.offsetWidth-a.offsetWidth)/2-o(d,"borderLeftWidth"),g=(d.offsetHeight-a.offsetHeight)/2-o(d,"borderTopWidth");b&&(e.left=f>0?f+"px":"0"),c&&(e.top=g>0?g+"px":"0")}function o(b,c){return parseInt(a.css(b,c))||0}if(/1\.(0|1|2)\.(0|1|2)/.test(a.fn.jquery)||/^1.1/.test(a.fn.jquery))return void alert("blockUI requires jQuery v1.2.3 or later!  You are using v"+a.fn.jquery);a.fn._fadeIn=a.fn.fadeIn;var b=function(){},c=document.documentMode||0,d=a.browser.msie&&(a.browser.version<8&&!c||c<8),e=a.browser.msie&&/MSIE 6.0/.test(navigator.userAgent)&&!c;a.blockUI=function(a){h(window,a)},a.unblockUI=function(a){i(window,a)},a.growlUI=function(b,c,d,e){var f=a('<div class="growlUI"></div>');b&&f.append("<h1>"+b+"</h1>"),c&&f.append("<h2>"+c+"</h2>"),void 0==d&&(d=3e3),a.blockUI({message:f,fadeIn:700,fadeOut:1e3,centerY:!1,timeout:d,showOverlay:!1,onUnblock:e,css:a.blockUI.defaults.growlCSS})},a.fn.block=function(b){return this.unblock({fadeOut:0}).each(function(){"static"==a.css(this,"position")&&(this.style.position="relative"),a.browser.msie&&(this.style.zoom=1),h(this,b)})},a.fn.unblock=function(a){return this.each(function(){i(this,a)})},a.blockUI.version=2.41,a.blockUI.defaults={message:"<h1>Please wait...</h1>",title:null,draggable:!0,theme:!1,css:{padding:0,margin:0,width:"30%",top:"40%",left:"35%",textAlign:"center",color:"#000",border:"3px solid #aaa",backgroundColor:"#fff",cursor:"wait"},themedCSS:{width:"30%",top:"40%",left:"35%"},overlayCSS:{backgroundColor:"#000",opacity:.6,cursor:"wait"},growlCSS:{width:"350px",top:"10px",left:"",right:"10px",border:"none",padding:"5px",opacity:.6,cursor:"default",color:"#fff",backgroundColor:"#000","-webkit-border-radius":"10px","-moz-border-radius":"10px","border-radius":"10px"},iframeSrc:/^https/i.test(window.location.href||"")?"javascript:false":"about:blank",forceIframe:!1,baseZ:1e3,centerX:!0,centerY:!0,allowBodyStretch:!0,bindEvents:!0,constrainTabKey:!0,fadeIn:200,fadeOut:400,timeout:0,showOverlay:!0,focusInput:!0,applyPlatformOpacityRules:!0,onBlock:null,onUnblock:null,quirksmodeOffsetHack:4,blockMsgClass:"blockMsg"};var f=null,g=[]}"function"==typeof define&&define.amd&&define.amd.jQuery?define(["jquery"],a):a(jQuery)}();