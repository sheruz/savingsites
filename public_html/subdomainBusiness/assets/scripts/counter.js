function CountBidster(){this.counters=new Array}function cbCounter(a,b,c,d,e,f,g,h,i,j){document.getElementById&&document.getElementById(a)&&""!=c&&""!=d&&document.getElementById(a)&&(this.container=document.getElementById(a),this.serverdate=new Date(c),this.targetdate=new Date(d),this.startdate=new Date,this.timesup=!1,this.objname=b,this.mode=e,this.auctionended=f,this.days=g,this.hours=h,this.minutes=i,this.seconds=j,this.divname1=a,this.maxtime=(this.targetdate-this.serverdate)/1e3,cbobj.registerCounter(b))}function startCounters(){cbobj.updateCounters()}function PeriodicalExecuter(a,b){this.callback=a,this.frequency=b,this.currentlyExecuting=!1,this.registerCallback()}var cbpe="";CountBidster.prototype.registerCounter=function(a){this.counters.push(a)},CountBidster.prototype.unregisterCounter=function(a){var b=this.counters.without(a);this.counters=b.clone()},CountBidster.prototype.updateCounters=function(){if(!this.counters)return void cbpe.stop();$.each(this.counters,function(index,item){eval(item+".updateTime()")})},CountBidster.prototype.updateServerTime=function(time){if(!this.counters)return void cbpe.stop();$.each(this.counters,function(index,item){eval(item+'.setServerTime("'+time+'")')})},cbCounter.prototype.setServerTime=function(a){this.serverdate=new Date(a)},cbCounter.prototype.updateTime=function(){if(this.startdate&&1!=this.timesup){var a=new Date;if(this.timediff=(a-this.startdate)/1e3,this.countdown=this.maxtime-this.timediff,parseInt(this.countdown)<=86400&&"TIME1"!=$(this.divname1).className&&($(this.divname1).className="TIME1"),this.timediff>this.maxtime){this.timesup=!0,this.container.innerHTML=this.formatresults();var b=this.objname;cbobj.unregisterCounter(b)}else this.displayCountdown()}},cbCounter.prototype.displayCountdown=function(){var a=60,b=60*a,c=24*b,d=Math.floor(this.countdown/c),e=String(Math.floor((this.countdown-d*c)/b)),f=String(Math.floor((this.countdown-d*c-e*b)/a)),g=String(Math.floor(this.countdown-d*c-e*b-f*a));d.length<2&&(d="0"+d),e.length<2&&(e="0"+e),f.length<2&&(f="0"+f),g.length<2&&(g="0"+g),this.container.innerHTML=this.formatresults(d,e,f,g)},cbCounter.prototype.formatresults=function(){if(0==this.timesup){var a="<span>";0==arguments[0]&&0==arguments[1]&&(a+="<font class='red_text'>"),(arguments[0]>0||"hideempty"!=this.mode)&&(a+=arguments[0]+this.days+" "),(arguments[0]>0||arguments[1]>0||"hideempty"!=this.mode)&&(a+=arguments[1]+this.hours+" "),a+=arguments[2]+this.minutes+" "+arguments[3]+this.seconds,0==arguments[0]&&0==arguments[1]&&(a+="</font>"),a+="</span>"}else var a="<font class='red_text'>"+this.auctionended+"</font>";return a},PeriodicalExecuter.prototype.registerCallback=function(){this.timer=setInterval(this.onTimerEvent.bind(this),1e3*this.frequency)},PeriodicalExecuter.prototype.execute=function(){this.callback(this)},PeriodicalExecuter.prototype.stop=function(){this.timer&&(clearInterval(this.timer),this.timer=null)},PeriodicalExecuter.prototype.onTimerEvent=function(){if(!this.currentlyExecuting)try{this.currentlyExecuting=!0,this.execute()}finally{this.currentlyExecuting=!1}};var cbobj=new CountBidster;$.ajax({url:"servertime.php",success:function(a){cbobj.updateServerTime(a)}}),cbpe=new PeriodicalExecuter(startCounters,.2);