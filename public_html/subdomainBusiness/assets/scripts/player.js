!function(){function c(a,b){var c=document.createElement("script");c.setAttribute("type","text/javascript"),c.setAttribute("src",a);var d=document.getElementsByTagName("head")[0];c.onload=c.onreadystatechange=function(){c.readyState&&!/loaded|complete/.test(c.readyState)||(c.onload=c.onreadystatechange=null,b&&b())},d.appendChild(c)}function d(d){var e=window.YUI&&parseInt(YUI().version.replace(/\./g,""),10);e?e>=340&&d():(b=!0,c(a,d))}var a="192.168.1.29:19547/savingssites_new/assets/scripts/yui-min.js";"undefined"==typeof YAHOO&&(YAHOO={}),void 0===YAHOO.MediaPlayer&&(YAHOO.MediaPlayer=function(){this.controller=null}),YAHOO.MediaPlayer.isAPIReady=!1,YAHOO.MediaPlayer.onAPIReady={subscribers:[],fire:function(){for(var a=0;a<this.subscribers.length;a++)if(!0===YAHOO.MediaPlayer.isAPIReady)try{this.subscribers[a]()}catch(a){}},subscribe:function(a){this.subscribers.push(a)}},YAHOO.WebPlayer=YAHOO.MediaPlayer;var b=!1;d(function(){YUI({injected:b}).use("node-base",function(a){void 0===YAHOO.namespace&&(YAHOO.namespace=a.namespace);var b=3,c=!0,d=["NETSCAPE6","NETSCAPE/7","(IPHONE;","(IPOD;"];if(navigator)for(var e=d.length,f=0;f<e;f++)-1!==navigator.userAgent.toUpperCase().indexOf(d[f])&&(c=!1);if(!0===c){void 0===YAHOO.mediaplayer&&YAHOO.namespace("YAHOO.mediaplayer");var g=function(c,d,e){e=e||window,2===b?YAHOO.util.Event.addListener(e,c,d):a.Event.attach(c,d,e)},h=function(c,d,e){e=e||window,2===b?YAHOO.util.Event.removeListener(e,c,d):a.Event.detach(c,d,e)},i=function(a){var b="#",c=a.indexOf(b);return c<0&&(b="%23",c=a.indexOf(b)),-1===c?"":a.substring(c+b.length)},j=function(a){for(var b=window.location.toString(),c=i(b),d=c.split("-"),e=0,f=d.length;e<f;e++)if(a===d[e].substring(0,a.length))return!0;return!1},k=function(){var a=-1;if("Microsoft Internet Explorer"==navigator.appName){var b=navigator.userAgent;null!=new RegExp("MSIE ([0-9]{1,}[.0-9]{0,})").exec(b)&&(a=parseFloat(RegExp.$1))}return a},l=function(a){for(var b=null,c=0,d=a.length;c<d;c++)if(1===a[c].nodeType){b=a[c];break}return b},m=function(a){var c=document.createElement("DIV");return c.innerHTML=a,l(c.childNodes)},n=function(){var a="cursor:pointer;padding:0;margin:0;position:fixed;top:0;left:0;height:100%;width:100%;background:rgba(0,0,0,0.8);";a+="filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#aa000000,endColorstr=#aa000000);",a+="-ms-filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#aa000000,endColorstr=#aa000000);z-index:2147483647;";var b='<div class="ywp-page-overlay" style="'+a+'"><div style="width:100%; height:100%; *background-color: white; *filter: alpha(opacity=0)"><div style="position:fixed;z-index:2147483647;top:50%;left:50%;height:1px;"><div style="width:100px; height:100px; margin-top:-50px;margin-left:-50px; background-color:transparent;"><img width="100px" height="100px" src="'+YMPParams.assetsroot+'/img/page-overlay/loading.gif"/>';return m(b)},o=function(){var a=n(),b=null,c=null,d=function(a){27===a.keyCode&&e()},e=function(){YAHOO.mediaplayer._vLboxDisabled=!0,c&&clearTimeout(c),a&&a.parentNode.removeChild(a),h("keydown",d,document.documentElement),h("click",e,a),delete YAHOO.mediaplayer._hideOverlay};YAHOO.mediaplayer._hideOverlay=e,document.getElementsByTagName("body")[0].appendChild(a),g("click",e,a),g("keydown",d,document.documentElement);var f=YMPParams.assetsroot;c=setTimeout(function(){b=m('<div style="position:absolute;top:30px;right:30px;cursor:pointer;"><img width="28px" height="28px" src="'+f+'/img/page-overlay/close.png"/></div>'),a.appendChild(b)},1e4)},p=function(){return!!(window.YAHOO&&window.YAHOO.mediaplayer&&window.YAHOO.mediaplayer._isPlayerAlreadyLoaded)},q=k(),r=!(!j("vlbox")||!(-1===q||q>=7||"BackCompat"!==document.compatMode));if(!p()){if(YAHOO.mediaplayer.partnerId="42858483","undefined"==typeof YMPParams&&(window.YMPParams={}),YMPParams.assetsroot=YMPParams.assetsroot||"http://l.yimg.com/pb/webplayer/0.9.76",YMPParams.wsroot=YMPParams.wsroot||"http://ws.webplayer.yahoo.com",YMPParams.wwwroot=YMPParams.wwwroot||"http://webplayer.yahoo.com",YMPParams.build_number="0.9.76","object"==typeof YMPParams&&!0===YMPParams.logging&&("undefined"==typeof YAHOO||void 0===YAHOO.ULT)){var s=document.createElement("script");s.type="text/javascript",s.src="http://us.js2.yimg.com/us.js.yimg.com/ult/ylc_1.9.js",document.getElementsByTagName("head")[0].appendChild(s)}YAHOO.mediaplayer.loadPlayerScript=function(){function a(){return YMPParams.assetsroot+"/js/player-noyui-min.js"}if(!p()){if(Boolean(arguments.callee.bCalled))return void(window.status="asyncLoadPlayer Already Called! (webplayerloader)");arguments.callee.bCalled=!0,r&&o();var b=a();"string"==typeof b&&b.length>0&&(YAHOO.mediaplayer.elPlayerSource=document.createElement("script"),YAHOO.mediaplayer.elPlayerSource.type="text/javascript",YAHOO.mediaplayer.elPlayerSource.src=b,document.getElementsByTagName("head")[0].appendChild(YAHOO.mediaplayer.elPlayerSource),window.YAHOO.mediaplayer._isPlayerAlreadyLoaded=!0)}}}}p()||("complete"!==document.readyState?a.on(r?"domready":"load",YAHOO.mediaplayer.loadPlayerScript,window):YAHOO.mediaplayer.loadPlayerScript())})})}();