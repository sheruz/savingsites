!function(a){a.History?window.console.warn("$.History has already been defined..."):(a.History={options:{debug:!1},state:"",$window:null,$iframe:null,handlers:{generic:[],specific:{}},extractHash:function(a){return a.replace(/^[^#]*#/,"").replace(/^#+|#+$/,"")},getState:function(){return a.History.state},setState:function(b){var c=a.History;return b=c.extractHash(b),c.state=b,c.state},getHash:function(){return a.History.extractHash(window.location.hash||location.hash)},setHash:function(b){return b=a.History.extractHash(b),void 0!==window.location.hash?window.location.hash!==b&&(window.location.hash=b):location.hash!==b&&(location.hash=b),b},go:function(b){var c=a.History;b=c.extractHash(b);var d=c.getHash(),e=c.getState();return b!==d?c.setHash(b):(b!==e&&c.setState(b),c.trigger()),!0},hashchange:function(b){var c=a.History,d=c.getHash();if(""==d)return void window.location.reload();if(a("#"+d).attr("rel")){var e=a("#"+d).attr("rel").split(",");"ch"==e[0]&&show_ads_specific_subcatparentid_category(e[1]),"scl"==e[0]&&show_ads_specific_startupcostlimit(e[1],e[2]),"dfc"==e[0]?directory_feature(e[1]):"fa"==e[0]?show_favorites_ads(e[1],e[2],e[3]):"sao"==e[0]?show_all_ads(e[1],e[2],e[3],e[4]):"adb"==e[0]?advertise_business(e[1],e[2]):"-99"==e[0]&&"cc"!=e[0]?show_temp_ads(e[0],e[1],e[2],e[3]):"-99"!=e[0]&&"cc"!=e[0]?show_ads_specific_sub_category(e[0]):"cc"==e[0]&&show_ads_specific_category(e[1])}return!0},bind:function(b,c){var d=a.History;return c?(void 0===d.handlers.specific[b]&&(d.handlers.specific[b]=[]),d.handlers.specific[b].push(c)):(c=b,d.handlers.generic.push(c)),!0},trigger:function(b){var c=a.History;void 0===b&&(b=c.getState());var d,e,g;if(void 0!==c.handlers.specific[b])for(g=c.handlers.specific[b],d=0,e=g.length;d<e;++d)(0,g[d])(b);for(g=c.handlers.generic,d=0,e=g.length;d<e;++d)(0,g[d])(b);return!0},construct:function(){var b=a.History;return a(document).ready(function(){b.domReady()}),!0},configure:function(b){var c=a.History;return c.options=a.extend(c.options,b),!0},domReadied:!1,domReady:function(){var b=a.History;if(!b.domRedied)return b.domRedied=!0,b.$window=a(window),b.$window.bind("hashchange",this.hashchange),setTimeout(b.hashchangeLoader,200),!0},nativeSupport:function(b){b=b||a.browser;var c=b.version,d=parseInt(c,10),e=c.split(/[^0-9]/g),f=parseInt(e[0],10),g=parseInt(e[1],10),h=parseInt(e[2],10),i=!1;return b.msie&&d>=8?i=!0:b.webkit&&d>=528?i=!0:b.mozilla?f>1?i=!0:1===f&&(g>9?i=!0:9===g&&h>=2&&(i=!0)):b.opera&&(f>10?i=!0:10===f&&g>=60&&(i=!0)),i},hashchangeLoader:function(){var b=a.History;if(b.nativeSupport())b.getHash()&&b.$window.trigger("hashchange");else{var d;if(a.browser.msie){b.$iframe=a('<iframe id="jquery-history-iframe" style="display: none;"></$iframe>').prependTo(document.body)[0],b.$iframe.contentWindow.document.open(),b.$iframe.contentWindow.document.close();var e=!1;d=function(){var a=b.getHash(),c=b.getState(),d=b.extractHash(b.$iframe.contentWindow.document.location.hash);c!==a?(e||(b.$iframe.contentWindow.document.open(),b.$iframe.contentWindow.document.close(),b.$iframe.contentWindow.document.location.hash=a),e=!1,b.$window.trigger("hashchange")):c!==d&&(e=!0,b.setHash(d))}}else d=function(){var a=b.getHash();b.getState()!==a&&b.$window.trigger("hashchange")};setInterval(d,200)}return!0}},a.History.construct())}(jQuery);