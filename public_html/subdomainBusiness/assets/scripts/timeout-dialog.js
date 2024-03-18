String.prototype.format=function(){for(var a=this,b=arguments.length;b--;)a=a.replace(new RegExp("\\{"+b+"\\}","gm"),arguments[b]);return a},function(a){a.timeoutDialog=function(b){var c={timeout:1200,countdown:60,title:"Your session is about to expire!",message:"You will be logged out in {0} seconds.",question:"Do you want to stay signed in?",keep_alive_button_text:"Yes, Keep me signed in",sign_out_button_text:"No, Sign me out",keep_alive_url:"/keep-alive",logout_url:null,logout_redirect_url:"/",restart_on_yes:!0,dialog_width:350};a.extend(c,b),{init:function(){this.setupDialogTimer()},setupDialogTimer:function(){var a=this;window.setTimeout(function(){a.setupDialog()},1e3*(c.timeout-c.countdown))},setupDialog:function(){var b=this;b.destroyDialog(),a('<div id="timeout-dialog"><p id="timeout-message">'+c.message.format('<span id="timeout-countdown">'+c.countdown+"</span>")+'</p><p id="timeout-question">'+c.question+"</p></div>").appendTo("body").dialog({modal:!0,width:c.dialog_width,minHeight:"auto",zIndex:1e4,closeOnEscape:!1,draggable:!1,resizable:!1,dialogClass:"timeout-dialog",title:c.title,buttons:{"keep-alive-button":{text:c.keep_alive_button_text,id:"timeout-keep-signin-btn",click:function(){b.keepAlive()}},"sign-out-button":{text:c.sign_out_button_text,id:"timeout-sign-out-button",click:function(){b.signOut(!0)}}}}),b.startCountdown()},destroyDialog:function(){a("#timeout-dialog").length&&(a(this).dialog("close"),a("#timeout-dialog").remove())},startCountdown:function(){var b=this,d=c.countdown;this.countdown=window.setInterval(function(){d-=1,a("#timeout-countdown").html(d),d<=0&&(window.clearInterval(b.countdown),b.signOut(!1))},1e3)},keepAlive:function(){var b=this;this.destroyDialog(),window.clearInterval(this.countdown),a.get(c.keep_alive_url,function(a){"OK"==a?c.restart_on_yes&&b.setupDialogTimer():b.signOut(!1)})},signOut:function(b){var d=this;this.destroyDialog(),null!=c.logout_url?a.post(c.logout_url,function(a){d.redirectLogout(b)}):d.redirectLogout(b)},redirectLogout:function(a){var b=c.logout_redirect_url+"?next="+encodeURIComponent(window.location.pathname+window.location.search);a||(b+="&timeout=t"),window.location=b}}.init()}}(window.jQuery);