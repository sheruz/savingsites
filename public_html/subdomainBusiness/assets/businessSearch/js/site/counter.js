var cbpe = '';
// Prototype class to keep track of counters and update them.
function CountBidster() { 
this.counters = new Array();
}

CountBidster.prototype.registerCounter = function(name) {
		this.counters.push(name);
	}
	
CountBidster.prototype.unregisterCounter = function(name) {
		var newarr = this.counters.without(name);
		this.counters = newarr.clone();
	}
	
CountBidster.prototype.updateCounters = function() {
		if (!this.counters) {
			cbpe.stop();
			return;
		}
		$.each(this.counters,function(index,item) {
			eval(item + '.updateTime()');
		});
	}
	
CountBidster.prototype.updateServerTime = function(time) {
		//console.log(time);
		if (!this.counters) {
			cbpe.stop();
			return;
		}
		//console.log(this.counters);
		$.each(this.counters,function(index,item) {
			//console.log(item + '.setServerTime("' + time + '")');
			eval(item + '.setServerTime("' + time + '")');
		});
	}

// Prototype class to create a single counter.
function cbCounter(divname, objname, serverdate, targetdate, mode, auctionended, days, hours, minutes, seconds){
		if (!document.getElementById || !document.getElementById(divname)) return;
		if (serverdate == "" || targetdate == "") return;

		if (!document.getElementById(divname)) return;
		this.container  = document.getElementById(divname);

		this.serverdate = new Date(serverdate);
		this.targetdate = new Date(targetdate);
		this.startdate  = new Date();
		this.timesup = false;
		this.objname = objname;
		this.mode = mode;
		this.auctionended = auctionended;
		this.days = days;
		this.hours = hours;
		this.minutes = minutes;
		this.seconds = seconds;
		this.divname1=divname;

		// Maximum seconds this counter will run before it is turned off.
		this.maxtime = (this.targetdate - this.serverdate) / 1000;

		// Register this counter to be updated.
		cbobj.registerCounter(objname);
	
}
	
cbCounter.prototype.setServerTime = function(time) {
		this.serverdate = new Date(time);
		//console.log(this.serverdate);
	}
	
cbCounter.prototype.updateTime = function() {
		if (!this.startdate || this.timesup == true) {
			return;
		}

		// How much time (in seconds) has elapsed since the start?
		var currentdate = new Date();
		this.timediff = (currentdate - this.startdate) / 1000;
		//$('testid').innerHTML=this.timediff;
		this.countdown = this.maxtime - this.timediff;
        //$('testid').innerHTML=this.divname1;
		//my logic
		if(parseInt(this.countdown)<=86400 && $(this.divname1).className!="TIME1" )
		{
		  $(this.divname1).className="TIME1";
		}
		
		// Check if time is up.
		if (this.timediff > this.maxtime) {
			this.timesup = true;
			this.container.innerHTML = this.formatresults();

			// Unregister this counter so it won't be updated anymore.
			var obj = this.objname;
			cbobj.unregisterCounter(obj);
		} else {
			this.displayCountdown();
		}
	}	
cbCounter.prototype.displayCountdown = function() {	

		// Divide seconds into days, hours, minutes and seconds.
		var oneMinute   = 60 //minute unit in seconds
		var oneHour     = oneMinute * 60 //hour unit in seconds
		var oneDay      = oneHour * 24 //day unit in seconds
		var dayfield    = Math.floor(this.countdown / oneDay)
		var hourfield   = String(Math.floor((this.countdown - dayfield * oneDay) / oneHour))
		var minutefield = String(Math.floor((this.countdown - dayfield * oneDay - hourfield * oneHour) / oneMinute))
		var secondfield = String(Math.floor((this.countdown - dayfield * oneDay - hourfield * oneHour - minutefield * oneMinute)))
		
		
		if (dayfield.length < 2) dayfield = "0" + dayfield;
		if (hourfield.length < 2) hourfield = "0" + hourfield;
		if (minutefield.length < 2) minutefield = "0" + minutefield;
		if (secondfield.length < 2) secondfield = "0" + secondfield;

		
		// Display the counter.
		this.container.innerHTML = this.formatresults(dayfield, hourfield, minutefield, secondfield);
	 	
}

cbCounter.prototype.formatresults = function() {
	
		if (this.timesup == false) { //if target date/time not yet met
			var displaystring = "<span>";
			if ((arguments[0] == 0) && (arguments[1] == 0)) {
				displaystring += "<font class='red_text'>"
			}
			if (arguments[0] > 0 || this.mode != "hideempty") {
				displaystring += arguments[0] + this.days + " "
			}
			if (((arguments[0] > 0) || (arguments[1] > 0)) || this.mode != "hideempty") {
				displaystring += arguments[1] + this.hours + " "
			}
			displaystring += arguments[2] + this.minutes + " " + arguments[3] + this.seconds
			if ((arguments[0] == 0) && (arguments[1] == 0)) {
				displaystring += "</font>"
			}
			displaystring += "</span>"
		}
		else { //else if target date/time met
			var displaystring = "<font class='red_text'>" + this.auctionended + "</font>"
		}
		return displaystring
		
}

// Runs the updateCounters on the astafastaCount object.
function startCounters()
{
	cbobj.updateCounters();
}

function PeriodicalExecuter(callback,frequency) {
  this.callback=callback;
  this.frequency=frequency;
  this.currentlyExecuting=false;
  this.registerCallback()
}

PeriodicalExecuter.prototype.registerCallback = function (){
	this.timer=setInterval(this.onTimerEvent.bind(this),this.frequency*1000);	
	}
PeriodicalExecuter.prototype.execute = function (){
	this.callback(this);
}

PeriodicalExecuter.prototype.stop = function (){
	if(!this.timer)return;clearInterval(this.timer);this.timer=null;
}

PeriodicalExecuter.prototype.onTimerEvent = function (){
	if(!this.currentlyExecuting){try{this.currentlyExecuting=true;this.execute()}finally{this.currentlyExecuting=false}}}

// Create a counter object.
var cbobj = new CountBidster();

$.ajax({'url':'servertime.php','success':function(transport) {		
			cbobj.updateServerTime(transport);
		}
		
		})
cbpe = new PeriodicalExecuter(startCounters, 0.2);		
		
		
// When DOM is fully loaded, start the counters.