!function(a){a.fn.jRating=function(b){var c={bigStarsPath:"jquery/icons/stars.png",smallStarsPath:"jquery/icons/small.png",phpPath:"#",type:"big",step:!1,isDisabled:!1,showRateInfo:!0,canRateAgain:!1,length:5,decimalLength:0,rateMax:20,rateInfosX:-45,rateInfosY:5,nbRates:1,onSuccess:null,onError:null};if(this.length>0)return this.each(function(){function s(a){var b=parseFloat(100*a/o*d.rateMax/100);switch(d.decimalLength){case 1:var c=Math.round(10*b)/10;break;case 2:var c=Math.round(100*b)/100;break;case 3:var c=Math.round(1e3*b)/1e3;break;default:var c=Math.round(1*b)/1}return c}function t(){switch(d.type){case"small":f=12,g=10,h=d.smallStarsPath;break;default:f=43,g=42,h=d.bigStarsPath}}function u(a){return a?a.offsetLeft+u(a.offsetParent):0}var d=a.extend(c,b),e=0,f=0,g=0,h="",i=!1,j=0,k=d.nbRates;if(a(this).hasClass("jDisabled")||d.isDisabled)var l=!0;else var l=!1;t(),a(this).height(g);var m=parseFloat(a(this).attr("data-average")),n=parseInt(a(this).attr("data-id")),o=f*d.length,p=m/d.rateMax*o,m=(a("<div>",{class:"jRatingColor",css:{width:p}}).appendTo(a(this)),a("<div>",{class:"jRatingAverage",css:{width:0,top:-g}}).appendTo(a(this)));a("<div>",{class:"jStar",css:{width:o,height:g,top:-2*g,background:"url("+h+") repeat-x"}}).appendTo(a(this));a(this).css({width:o,overflow:"hidden",zIndex:1,position:"relative"}),l||a(this).unbind().bind({mouseenter:function(b){var c=u(this),e=b.pageX-c;if(d.showRateInfo){a("<p>",{class:"jRatingInfos",html:s(e)+' <span class="maxRate">/ '+d.rateMax+"</span>",css:{top:b.pageY+d.rateInfosY,left:b.pageX+d.rateInfosX}}).appendTo("body").show()}},mouseover:function(b){a(this).css("cursor","pointer")},mouseout:function(){a(this).css("cursor","default"),i?m.width(j):m.width(0)},mousemove:function(b){var c=u(this),g=b.pageX-c;e=d.step?Math.floor(g/f)*f+f:g,m.width(e),d.showRateInfo&&a("p.jRatingInfos").css({left:b.pageX+d.rateInfosX}).html(s(e)+' <span class="maxRate">/ '+d.rateMax+"</span>")},mouseleave:function(){a("p.jRatingInfos").remove()},click:function(b){var c=this;i=!0,j=e,k--,(!d.canRateAgain||parseInt(k)<=0)&&a(this).unbind().css("cursor","default").addClass("jDisabled"),d.showRateInfo&&a("p.jRatingInfos").fadeOut("fast",function(){a(this).remove()}),b.preventDefault();var f=s(e);m.width(e),a(".datasSent p").html("<strong>idBox : </strong>"+n+"<br /><strong>rate : </strong>"+f+"<br /><strong>action :</strong> rating"),a(".serverResponse p").html("<strong>Loading...</strong>"),a.post(d.phpPath,{idBox:n,rate:f,action:"rating"},function(b){b.error?(a(".serverResponse p").html(b.server),d.onError&&d.onError(c,f)):(d.onSuccess&&d.onSuccess(c,f),a(".serverResponse p").html(b.server))},"json")}})})}}(jQuery);