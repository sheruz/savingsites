!function($){function Timepicker(){this.regional=[],this.regional[""]={currentText:"Now",closeText:"Done",ampm:!1,amNames:["AM","A"],pmNames:["PM","P"],timeFormat:"hh:mm tt",timeSuffix:"",timeOnlyTitle:"Choose Time",timeText:"Time",hourText:"Hour",minuteText:"Minute",secondText:"Second",millisecText:"Millisecond",timezoneText:"Time Zone"},this._defaults={showButtonPanel:!0,timeOnly:!1,showHour:!0,showMinute:!0,showSecond:!1,showMillisec:!1,showTimezone:!1,showTime:!0,stepHour:1,stepMinute:1,stepSecond:1,stepMillisec:1,hour:0,minute:0,second:0,millisec:0,timezone:null,useLocalTimezone:!1,defaultTimezone:"+0000",hourMin:0,minuteMin:0,secondMin:0,millisecMin:0,hourMax:23,minuteMax:59,secondMax:59,millisecMax:999,minDateTime:null,maxDateTime:null,onSelect:null,hourGrid:0,minuteGrid:0,secondGrid:0,millisecGrid:0,alwaysSetTime:!0,separator:" ",altFieldTimeOnly:!0,altSeparator:null,altTimeSuffix:null,showTimepicker:!0,timezoneIso8601:!1,timezoneList:null,addSliderAccess:!1,sliderAccessArgs:null,defaultValue:null},$.extend(this._defaults,this.regional[""])}function extendRemove(a,b){$.extend(a,b);for(var c in b)null!==b[c]&&void 0!==b[c]||(a[c]=b[c]);return a}if($.ui.timepicker=$.ui.timepicker||{},!$.ui.timepicker.version){$.extend($.ui,{timepicker:{version:"1.0.4"}}),$.extend(Timepicker.prototype,{$input:null,$altInput:null,$timeObj:null,inst:null,hour_slider:null,minute_slider:null,second_slider:null,millisec_slider:null,timezone_select:null,hour:0,minute:0,second:0,millisec:0,timezone:null,defaultTimezone:"+0000",hourMinOriginal:null,minuteMinOriginal:null,secondMinOriginal:null,millisecMinOriginal:null,hourMaxOriginal:null,minuteMaxOriginal:null,secondMaxOriginal:null,millisecMaxOriginal:null,ampm:"",formattedDate:"",formattedTime:"",formattedDateTime:"",timezoneList:null,units:["hour","minute","second","millisec"],setDefaults:function(a){return extendRemove(this._defaults,a||{}),this},_newInst:function($input,o){var tp_inst=new Timepicker,inlineSettings={};for(var attrName in this._defaults)if(this._defaults.hasOwnProperty(attrName)){var attrValue=$input.attr("time:"+attrName);if(attrValue)try{inlineSettings[attrName]=eval(attrValue)}catch(a){inlineSettings[attrName]=attrValue}}if(tp_inst._defaults=$.extend({},this._defaults,inlineSettings,o,{beforeShow:function(a,b){if($.isFunction(o.beforeShow))return o.beforeShow(a,b,tp_inst)},onChangeMonthYear:function(a,b,c){tp_inst._updateDateTime(c),$.isFunction(o.onChangeMonthYear)&&o.onChangeMonthYear.call($input[0],a,b,c,tp_inst)},onClose:function(a,b){!0===tp_inst.timeDefined&&""!==$input.val()&&tp_inst._updateDateTime(b),$.isFunction(o.onClose)&&o.onClose.call($input[0],a,b,tp_inst)},timepicker:tp_inst}),tp_inst.amNames=$.map(tp_inst._defaults.amNames,function(a){return a.toUpperCase()}),tp_inst.pmNames=$.map(tp_inst._defaults.pmNames,function(a){return a.toUpperCase()}),null===tp_inst._defaults.timezoneList){var timezoneList=["-1200","-1100","-1000","-0930","-0900","-0800","-0700","-0600","-0500","-0430","-0400","-0330","-0300","-0200","-0100","+0000","+0100","+0200","+0300","+0330","+0400","+0430","+0500","+0530","+0545","+0600","+0630","+0700","+0800","+0845","+0900","+0930","+1000","+1030","+1100","+1130","+1200","+1245","+1300","+1400"];tp_inst._defaults.timezoneIso8601&&(timezoneList=$.map(timezoneList,function(a){return"+0000"==a?"Z":a.substring(0,3)+":"+a.substring(3)})),tp_inst._defaults.timezoneList=timezoneList}return tp_inst.timezone=tp_inst._defaults.timezone,tp_inst.hour=tp_inst._defaults.hour,tp_inst.minute=tp_inst._defaults.minute,tp_inst.second=tp_inst._defaults.second,tp_inst.millisec=tp_inst._defaults.millisec,tp_inst.ampm="",tp_inst.$input=$input,o.altField&&(tp_inst.$altInput=$(o.altField).css({cursor:"pointer"}).focus(function(){$input.trigger("focus")})),0!==tp_inst._defaults.minDate&&0!==tp_inst._defaults.minDateTime||(tp_inst._defaults.minDate=new Date),0!==tp_inst._defaults.maxDate&&0!==tp_inst._defaults.maxDateTime||(tp_inst._defaults.maxDate=new Date),void 0!==tp_inst._defaults.minDate&&tp_inst._defaults.minDate instanceof Date&&(tp_inst._defaults.minDateTime=new Date(tp_inst._defaults.minDate.getTime())),void 0!==tp_inst._defaults.minDateTime&&tp_inst._defaults.minDateTime instanceof Date&&(tp_inst._defaults.minDate=new Date(tp_inst._defaults.minDateTime.getTime())),void 0!==tp_inst._defaults.maxDate&&tp_inst._defaults.maxDate instanceof Date&&(tp_inst._defaults.maxDateTime=new Date(tp_inst._defaults.maxDate.getTime())),void 0!==tp_inst._defaults.maxDateTime&&tp_inst._defaults.maxDateTime instanceof Date&&(tp_inst._defaults.maxDate=new Date(tp_inst._defaults.maxDateTime.getTime())),tp_inst.$input.bind("focus",function(){tp_inst._onFocus()}),tp_inst},_addTimePicker:function(a){var b=this.$altInput&&this._defaults.altFieldTimeOnly?this.$input.val()+" "+this.$altInput.val():this.$input.val();this.timeDefined=this._parseTime(b),this._limitMinMaxDateTime(a,!1),this._injectTimePicker()},_parseTime:function(a,b){if(this.inst||(this.inst=$.datepicker._getInst(this.$input[0])),b||!this._defaults.timeOnly){var c=$.datepicker._get(this.inst,"dateFormat");try{var d=parseDateTimeInternal(c,this._defaults.timeFormat,a,$.datepicker._getFormatConfig(this.inst),this._defaults);if(!d.timeObj)return!1;$.extend(this,d.timeObj)}catch(a){return!1}return!0}var e=$.datepicker.parseTime(this._defaults.timeFormat,a,this._defaults);return!!e&&($.extend(this,e),!0)},_injectTimePicker:function(){var a=this.inst.dpDiv,b=this.inst.settings,c=this,d="",e="",f={},g={},h=null;if(0===a.find("div.ui-timepicker-div").length&&b.showTimepicker){for(var i=' style="display:none;"',j='<div class="ui-timepicker-div"><dl><dt class="ui_tpicker_time_label"'+(b.showTime?"":i)+">"+b.timeText+'</dt><dd class="ui_tpicker_time"'+(b.showTime?"":i)+"></dd>",k=0,l=this.units.length;k<l;k++){if(d=this.units[k],e=d.substr(0,1).toUpperCase()+d.substr(1),f[d]=parseInt(b[d+"Max"]-(b[d+"Max"]-b[d+"Min"])%b["step"+e],10),g[d]=0,j+='<dt class="ui_tpicker_'+d+'_label"'+(b["show"+e]?"":i)+">"+b[d+"Text"]+'</dt><dd class="ui_tpicker_'+d+'"><div class="ui_tpicker_'+d+'_slider"'+(b["show"+e]?"":i)+"></div>",b["show"+e]&&b[d+"Grid"]>0){if(j+='<div style="padding-left: 1px"><table class="ui-tpicker-grid-label"><tr>',"hour"==d)for(var m=b[d+"Min"];m<=f[d];m+=parseInt(b[d+"Grid"],10)){g[d]++;var n=b.ampm&&m>12?m-12:m;n<10&&(n="0"+n),b.ampm&&(0===m?n="12a":n+=m<12?"a":"p"),j+='<td data-for="'+d+'">'+n+"</td>"}else for(var o=b[d+"Min"];o<=f[d];o+=parseInt(b[d+"Grid"],10))g[d]++,j+='<td data-for="'+d+'">'+(o<10?"0":"")+o+"</td>";j+="</tr></table></div>"}j+="</dd>"}j+='<dt class="ui_tpicker_timezone_label"'+(b.showTimezone?"":i)+">"+b.timezoneText+"</dt>",j+='<dd class="ui_tpicker_timezone" '+(b.showTimezone?"":i)+"></dd>",j+="</dl></div>";var p=$(j);!0===b.timeOnly&&(p.prepend('<div class="ui-widget-header ui-helper-clearfix ui-corner-all"><div class="ui-datepicker-title">'+b.timeOnlyTitle+"</div></div>"),a.find(".ui-datepicker-header, .ui-datepicker-calendar").hide()),this.hour_slider=p.find(".ui_tpicker_hour_slider").prop("slide",null).slider({orientation:"horizontal",value:this.hour,min:b.hourMin,max:f.hour,step:b.stepHour,slide:function(a,b){c.hour_slider.slider("option","value",b.value),c._onTimeChange()},stop:function(a,b){c._onSelectHandler()}}),this.minute_slider=p.find(".ui_tpicker_minute_slider").prop("slide",null).slider({orientation:"horizontal",value:this.minute,min:b.minuteMin,max:f.minute,step:b.stepMinute,slide:function(a,b){c.minute_slider.slider("option","value",b.value),c._onTimeChange()},stop:function(a,b){c._onSelectHandler()}}),this.second_slider=p.find(".ui_tpicker_second_slider").prop("slide",null).slider({orientation:"horizontal",value:this.second,min:b.secondMin,max:f.second,step:b.stepSecond,slide:function(a,b){c.second_slider.slider("option","value",b.value),c._onTimeChange()},stop:function(a,b){c._onSelectHandler()}}),this.millisec_slider=p.find(".ui_tpicker_millisec_slider").prop("slide",null).slider({orientation:"horizontal",value:this.millisec,min:b.millisecMin,max:f.millisec,step:b.stepMillisec,slide:function(a,b){c.millisec_slider.slider("option","value",b.value),c._onTimeChange()},stop:function(a,b){c._onSelectHandler()}});for(var k=0,l=c.units.length;k<l;k++)d=c.units[k],e=d.substr(0,1).toUpperCase()+d.substr(1),b["show"+e]&&b[d+"Grid"]>0&&(h=100*g[d]*b[d+"Grid"]/(f[d]-b[d+"Min"]),p.find(".ui_tpicker_"+d+" table").css({width:h+"%",marginLeft:h/(-2*g[d])+"%",borderCollapse:"collapse"}).find("td").click(function(a){var d=$(this),e=d.html(),f=d.data("for");if("hour"==f&&b.ampm){var g=e.substring(2).toLowerCase(),h=parseInt(e.substring(0,2),10);e="a"==g?12==h?0:h:12==h?12:h+12}c[f+"_slider"].slider("option","value",parseInt(e,10)),c._onTimeChange(),c._onSelectHandler()}).css({cursor:"pointer",width:100/g[d]+"%",textAlign:"center",overflow:"hidden"}));if(this.timezone_select=p.find(".ui_tpicker_timezone").append("<select></select>").find("select"),$.fn.append.apply(this.timezone_select,$.map(b.timezoneList,function(a,b){return $("<option />").val("object"==typeof a?a.value:a).text("object"==typeof a?a.label:a)})),void 0!==this.timezone&&null!==this.timezone&&""!==this.timezone){var q=new Date(this.inst.selectedYear,this.inst.selectedMonth,this.inst.selectedDay,12);$.timepicker.timeZoneOffsetString(q)==this.timezone?selectLocalTimeZone(c):this.timezone_select.val(this.timezone)}else void 0!==this.hour&&null!==this.hour&&""!==this.hour?this.timezone_select.val(b.defaultTimezone):selectLocalTimeZone(c);this.timezone_select.change(function(){c._defaults.useLocalTimezone=!1,c._onTimeChange()});var s=a.find(".ui-datepicker-buttonpane");if(s.length?s.before(p):a.append(p),this.$timeObj=p.find(".ui_tpicker_time"),null!==this.inst){var t=this.timeDefined;this._onTimeChange(),this.timeDefined=t}if(this._defaults.addSliderAccess){var u=this._defaults.sliderAccessArgs;setTimeout(function(){if(0===p.find(".ui-slider-access").length){p.find(".ui-slider:visible").sliderAccess(u);var a=p.find(".ui-slider-access:eq(0)").outerWidth(!0);a&&p.find("table:visible").each(function(){var b=$(this),c=b.outerWidth(),d=b.css("marginLeft").toString().replace("%",""),e=c-a,f=d*e/c+"%";b.css({width:e,marginLeft:f})})}},10)}}},_limitMinMaxDateTime:function(a,b){var c=this._defaults,d=new Date(a.selectedYear,a.selectedMonth,a.selectedDay);if(this._defaults.showTimepicker){if(null!==$.datepicker._get(a,"minDateTime")&&void 0!==$.datepicker._get(a,"minDateTime")&&d){var e=$.datepicker._get(a,"minDateTime"),f=new Date(e.getFullYear(),e.getMonth(),e.getDate(),0,0,0,0);null!==this.hourMinOriginal&&null!==this.minuteMinOriginal&&null!==this.secondMinOriginal&&null!==this.millisecMinOriginal||(this.hourMinOriginal=c.hourMin,this.minuteMinOriginal=c.minuteMin,this.secondMinOriginal=c.secondMin,this.millisecMinOriginal=c.millisecMin),a.settings.timeOnly||f.getTime()==d.getTime()?(this._defaults.hourMin=e.getHours(),this.hour<=this._defaults.hourMin?(this.hour=this._defaults.hourMin,this._defaults.minuteMin=e.getMinutes(),this.minute<=this._defaults.minuteMin?(this.minute=this._defaults.minuteMin,this._defaults.secondMin=e.getSeconds(),this.second<=this._defaults.secondMin?(this.second=this._defaults.secondMin,this._defaults.millisecMin=e.getMilliseconds()):(this.millisec<this._defaults.millisecMin&&(this.millisec=this._defaults.millisecMin),this._defaults.millisecMin=this.millisecMinOriginal)):(this._defaults.secondMin=this.secondMinOriginal,this._defaults.millisecMin=this.millisecMinOriginal)):(this._defaults.minuteMin=this.minuteMinOriginal,this._defaults.secondMin=this.secondMinOriginal,this._defaults.millisecMin=this.millisecMinOriginal)):(this._defaults.hourMin=this.hourMinOriginal,this._defaults.minuteMin=this.minuteMinOriginal,this._defaults.secondMin=this.secondMinOriginal,this._defaults.millisecMin=this.millisecMinOriginal)}if(null!==$.datepicker._get(a,"maxDateTime")&&void 0!==$.datepicker._get(a,"maxDateTime")&&d){var g=$.datepicker._get(a,"maxDateTime"),h=new Date(g.getFullYear(),g.getMonth(),g.getDate(),0,0,0,0);null!==this.hourMaxOriginal&&null!==this.minuteMaxOriginal&&null!==this.secondMaxOriginal||(this.hourMaxOriginal=c.hourMax,this.minuteMaxOriginal=c.minuteMax,this.secondMaxOriginal=c.secondMax,this.millisecMaxOriginal=c.millisecMax),a.settings.timeOnly||h.getTime()==d.getTime()?(this._defaults.hourMax=g.getHours(),this.hour>=this._defaults.hourMax?(this.hour=this._defaults.hourMax,this._defaults.minuteMax=g.getMinutes(),this.minute>=this._defaults.minuteMax?(this.minute=this._defaults.minuteMax,this._defaults.secondMax=g.getSeconds()):this.second>=this._defaults.secondMax?(this.second=this._defaults.secondMax,this._defaults.millisecMax=g.getMilliseconds()):(this.millisec>this._defaults.millisecMax&&(this.millisec=this._defaults.millisecMax),this._defaults.millisecMax=this.millisecMaxOriginal)):(this._defaults.minuteMax=this.minuteMaxOriginal,this._defaults.secondMax=this.secondMaxOriginal,this._defaults.millisecMax=this.millisecMaxOriginal)):(this._defaults.hourMax=this.hourMaxOriginal,this._defaults.minuteMax=this.minuteMaxOriginal,this._defaults.secondMax=this.secondMaxOriginal,this._defaults.millisecMax=this.millisecMaxOriginal)}if(void 0!==b&&!0===b){var i=parseInt(this._defaults.hourMax-(this._defaults.hourMax-this._defaults.hourMin)%this._defaults.stepHour,10),j=parseInt(this._defaults.minuteMax-(this._defaults.minuteMax-this._defaults.minuteMin)%this._defaults.stepMinute,10),k=parseInt(this._defaults.secondMax-(this._defaults.secondMax-this._defaults.secondMin)%this._defaults.stepSecond,10),l=parseInt(this._defaults.millisecMax-(this._defaults.millisecMax-this._defaults.millisecMin)%this._defaults.stepMillisec,10);this.hour_slider&&this.hour_slider.slider("option",{min:this._defaults.hourMin,max:i}).slider("value",this.hour),this.minute_slider&&this.minute_slider.slider("option",{min:this._defaults.minuteMin,max:j}).slider("value",this.minute),this.second_slider&&this.second_slider.slider("option",{min:this._defaults.secondMin,max:k}).slider("value",this.second),this.millisec_slider&&this.millisec_slider.slider("option",{min:this._defaults.millisecMin,max:l}).slider("value",this.millisec)}}},_onTimeChange:function(){var a=!!this.hour_slider&&this.hour_slider.slider("value"),b=!!this.minute_slider&&this.minute_slider.slider("value"),c=!!this.second_slider&&this.second_slider.slider("value"),d=!!this.millisec_slider&&this.millisec_slider.slider("value"),e=!!this.timezone_select&&this.timezone_select.val(),f=this._defaults;"object"==typeof a&&(a=!1),"object"==typeof b&&(b=!1),"object"==typeof c&&(c=!1),"object"==typeof d&&(d=!1),"object"==typeof e&&(e=!1),!1!==a&&(a=parseInt(a,10)),!1!==b&&(b=parseInt(b,10)),!1!==c&&(c=parseInt(c,10)),!1!==d&&(d=parseInt(d,10));var g=f[a<12?"amNames":"pmNames"][0],h=a!=this.hour||b!=this.minute||c!=this.second||d!=this.millisec||this.ampm.length>0&&a<12!=(-1!==$.inArray(this.ampm.toUpperCase(),this.amNames))||null===this.timezone&&e!=this.defaultTimezone||null!==this.timezone&&e!=this.timezone;h&&(!1!==a&&(this.hour=a),!1!==b&&(this.minute=b),!1!==c&&(this.second=c),!1!==d&&(this.millisec=d),!1!==e&&(this.timezone=e),this.inst||(this.inst=$.datepicker._getInst(this.$input[0])),this._limitMinMaxDateTime(this.inst,!0)),f.ampm&&(this.ampm=g),this.formattedTime=$.datepicker.formatTime(this._defaults.timeFormat,this,this._defaults),this.$timeObj&&this.$timeObj.text(this.formattedTime+f.timeSuffix),this.timeDefined=!0,h&&this._updateDateTime()},_onSelectHandler:function(){var a=this._defaults.onSelect||this.inst.settings.onSelect,b=this.$input?this.$input[0]:null;a&&b&&a.apply(b,[this.formattedDateTime,this])},_formatTime:function(a,b){a=a||{hour:this.hour,minute:this.minute,second:this.second,millisec:this.millisec,ampm:this.ampm,timezone:this.timezone};var c=(b||this._defaults.timeFormat).toString();if(c=$.datepicker.formatTime(c,a,this._defaults),arguments.length)return c;this.formattedTime=c},_updateDateTime:function(a){a=this.inst||a;var b=$.datepicker._daylightSavingAdjust(new Date(a.selectedYear,a.selectedMonth,a.selectedDay)),c=$.datepicker._get(a,"dateFormat"),d=$.datepicker._getFormatConfig(a),e=null!==b&&this.timeDefined;this.formattedDate=$.datepicker.formatDate(c,null===b?new Date:b,d);var f=this.formattedDate;if(!0===this._defaults.timeOnly?f=this.formattedTime:!0!==this._defaults.timeOnly&&(this._defaults.alwaysSetTime||e)&&(f+=this._defaults.separator+this.formattedTime+this._defaults.timeSuffix),this.formattedDateTime=f,this._defaults.showTimepicker)if(this.$altInput&&!0===this._defaults.altFieldTimeOnly)this.$altInput.val(this.formattedTime),this.$input.val(this.formattedDate);else if(this.$altInput){this.$input.val(f);var g="",h=this._defaults.altSeparator?this._defaults.altSeparator:this._defaults.separator,i=this._defaults.altTimeSuffix?this._defaults.altTimeSuffix:this._defaults.timeSuffix;g=this._defaults.altFormat?$.datepicker.formatDate(this._defaults.altFormat,null===b?new Date:b,d):this.formattedDate,g&&(g+=h),this._defaults.altTimeFormat?g+=$.datepicker.formatTime(this._defaults.altTimeFormat,this,this._defaults)+i:g+=this.formattedTime+i,this.$altInput.val(g)}else this.$input.val(f);else this.$input.val(this.formattedDate);this.$input.trigger("change")},_onFocus:function(){if(!this.$input.val()&&this._defaults.defaultValue){this.$input.val(this._defaults.defaultValue);var a=$.datepicker._getInst(this.$input.get(0)),b=$.datepicker._get(a,"timepicker");if(b&&b._defaults.timeOnly&&a.input.val()!=a.lastVal)try{$.datepicker._updateDatepicker(a)}catch(a){$.datepicker.log(a)}}}}),$.fn.extend({timepicker:function(a){a=a||{};var b=Array.prototype.slice.call(arguments);return"object"==typeof a&&(b[0]=$.extend(a,{timeOnly:!0})),$(this).each(function(){$.fn.datetimepicker.apply($(this),b)})},datetimepicker:function(a){a=a||{};var b=arguments;return"string"==typeof a?"getDate"==a?$.fn.datepicker.apply($(this[0]),b):this.each(function(){var a=$(this);a.datepicker.apply(a,b)}):this.each(function(){var b=$(this);b.datepicker($.timepicker._newInst(b,a)._defaults)})}}),$.datepicker.parseDateTime=function(a,b,c,d,e){var f=parseDateTimeInternal(a,b,c,d,e);if(f.timeObj){var g=f.timeObj;f.date.setHours(g.hour,g.minute,g.second,g.millisec)}return f.date},$.datepicker.parseTime=function(a,b,c){var j,d=function(a,b){var c=[];return a&&$.merge(c,a),b&&$.merge(c,b),c=$.map(c,function(a){return a.replace(/[.*+?|()\[\]{}\\]/g,"\\$&")}),"("+c.join("|")+")?"},e=function(a){var b=a.toLowerCase().match(/(h{1,2}|m{1,2}|s{1,2}|l{1}|t{1,2}|z)/g),c={h:-1,m:-1,s:-1,l:-1,t:-1,z:-1};if(b)for(var d=0;d<b.length;d++)-1==c[b[d].toString().charAt(0)]&&(c[b[d].toString().charAt(0)]=d+1);return c},f=extendRemove(extendRemove({},$.timepicker._defaults),c||{}),g="^"+a.toString().replace(/h{1,2}/gi,"(\\d?\\d)").replace(/m{1,2}/gi,"(\\d?\\d)").replace(/s{1,2}/gi,"(\\d?\\d)").replace(/l{1}/gi,"(\\d?\\d?\\d)").replace(/t{1,2}/gi,d(f.amNames,f.pmNames)).replace(/z{1}/gi,"(z|[-+]\\d\\d:?\\d\\d|\\S+)?").replace(/\s/g,"\\s?")+f.timeSuffix+"$",h=e(a),i="";j=b.match(new RegExp(g,"i"));var k={hour:0,minute:0,second:0,millisec:0};if(j){if(-1!==h.t&&(void 0===j[h.t]||0===j[h.t].length?(i="",k.ampm=""):(i=-1!==$.inArray(j[h.t].toUpperCase(),f.amNames)?"AM":"PM",k.ampm=f["AM"==i?"amNames":"pmNames"][0])),-1!==h.h&&("AM"==i&&"12"==j[h.h]?k.hour=0:"PM"==i&&"12"!=j[h.h]?k.hour=parseInt(j[h.h],10)+12:k.hour=Number(j[h.h])),-1!==h.m&&(k.minute=Number(j[h.m])),-1!==h.s&&(k.second=Number(j[h.s])),-1!==h.l&&(k.millisec=Number(j[h.l])),-1!==h.z&&void 0!==j[h.z]){var l=j[h.z].toUpperCase();switch(l.length){case 1:l=f.timezoneIso8601?"Z":"+0000";break;case 5:f.timezoneIso8601&&(l="0000"==l.substring(1)?"Z":l.substring(0,3)+":"+l.substring(3));break;case 6:f.timezoneIso8601?"00:00"==l.substring(1)&&(l="Z"):l="Z"==l||"00:00"==l.substring(1)?"+0000":l.replace(/:/,"")}k.timezone=l}return k}return!1},$.datepicker.formatTime=function(a,b,c){c=c||{},c=$.extend({},$.timepicker._defaults,c),b=$.extend({hour:0,minute:0,second:0,millisec:0,timezone:"+0000"},b);var d=a,e=c.amNames[0],f=parseInt(b.hour,10);return c.ampm&&(f>11&&(e=c.pmNames[0],f>12&&(f%=12)),0===f&&(f=12)),d=d.replace(/(?:hh?|mm?|ss?|[tT]{1,2}|[lz]|('.*?'|".*?"))/g,function(a){switch(a.toLowerCase()){case"hh":return("0"+f).slice(-2);case"h":return f;case"mm":return("0"+b.minute).slice(-2);case"m":return b.minute;case"ss":return("0"+b.second).slice(-2);case"s":return b.second;case"l":return("00"+b.millisec).slice(-3);case"z":return null===b.timezone?c.defaultTimezone:b.timezone;case"t":case"tt":return c.ampm?(1==a.length&&(e=e.charAt(0)),"T"===a.charAt(0)?e.toUpperCase():e.toLowerCase()):"";default:return a.replace(/\'/g,"")||"'"}}),d=$.trim(d)},$.datepicker._base_selectDate=$.datepicker._selectDate,$.datepicker._selectDate=function(a,b){var c=this._getInst($(a)[0]),d=this._get(c,"timepicker");d?(d._limitMinMaxDateTime(c,!0),c.inline=c.stay_open=!0,this._base_selectDate(a,b),c.inline=c.stay_open=!1,this._notifyChange(c),this._updateDatepicker(c)):this._base_selectDate(a,b)},$.datepicker._base_updateDatepicker=$.datepicker._updateDatepicker,$.datepicker._updateDatepicker=function(a){var b=a.input[0];if(!($.datepicker._curInst&&$.datepicker._curInst!=a&&$.datepicker._datepickerShowing&&$.datepicker._lastInput!=b||"boolean"==typeof a.stay_open&&!1!==a.stay_open)){this._base_updateDatepicker(a);var c=this._get(a,"timepicker");if(c&&(c._addTimePicker(a),c._defaults.useLocalTimezone)){var d=new Date(a.selectedYear,a.selectedMonth,a.selectedDay,12);selectLocalTimeZone(c,d),c._onTimeChange()}}},$.datepicker._base_doKeyPress=$.datepicker._doKeyPress,$.datepicker._doKeyPress=function(a){var b=$.datepicker._getInst(a.target),c=$.datepicker._get(b,"timepicker");if(c&&$.datepicker._get(b,"constrainInput")){var d=c._defaults.ampm,e=$.datepicker._possibleChars($.datepicker._get(b,"dateFormat")),f=c._defaults.timeFormat.toString().replace(/[hms]/g,"").replace(/TT/g,d?"APM":"").replace(/Tt/g,d?"AaPpMm":"").replace(/tT/g,d?"AaPpMm":"").replace(/T/g,d?"AP":"").replace(/tt/g,d?"apm":"").replace(/t/g,d?"ap":"")+" "+c._defaults.separator+c._defaults.timeSuffix+(c._defaults.showTimezone?c._defaults.timezoneList.join(""):"")+c._defaults.amNames.join("")+c._defaults.pmNames.join("")+e,g=String.fromCharCode(void 0===a.charCode?a.keyCode:a.charCode);return a.ctrlKey||g<" "||!e||f.indexOf(g)>-1}return $.datepicker._base_doKeyPress(a)},$.datepicker._base_doKeyUp=$.datepicker._doKeyUp,$.datepicker._doKeyUp=function(a){var b=$.datepicker._getInst(a.target),c=$.datepicker._get(b,"timepicker");if(c&&c._defaults.timeOnly&&b.input.val()!=b.lastVal)try{$.datepicker._updateDatepicker(b)}catch(a){$.datepicker.log(a)}return $.datepicker._base_doKeyUp(a)},$.datepicker._base_gotoToday=$.datepicker._gotoToday,$.datepicker._gotoToday=function(a){var b=this._getInst($(a)[0]),c=b.dpDiv;this._base_gotoToday(a);var d=this._get(b,"timepicker");selectLocalTimeZone(d);var e=new Date;this._setTime(b,e),$(".ui-datepicker-today",c).click()},$.datepicker._disableTimepickerDatepicker=function(a){var b=this._getInst(a);if(b){var c=this._get(b,"timepicker");$(a).datepicker("getDate"),c&&(c._defaults.showTimepicker=!1,c._updateDateTime(b))}},$.datepicker._enableTimepickerDatepicker=function(a){var b=this._getInst(a);if(b){var c=this._get(b,"timepicker");$(a).datepicker("getDate"),c&&(c._defaults.showTimepicker=!0,c._addTimePicker(b),c._updateDateTime(b))}},$.datepicker._setTime=function(a,b){var c=this._get(a,"timepicker");if(c){var d=c._defaults;c.hour=b?b.getHours():d.hour,c.minute=b?b.getMinutes():d.minute,c.second=b?b.getSeconds():d.second,c.millisec=b?b.getMilliseconds():d.millisec,c._limitMinMaxDateTime(a,!0),c._onTimeChange(),c._updateDateTime(a)}},$.datepicker._setTimeDatepicker=function(a,b,c){var d=this._getInst(a);if(d){var e=this._get(d,"timepicker");if(e){this._setDateFromField(d);var f;b&&("string"==typeof b?(e._parseTime(b,c),f=new Date,f.setHours(e.hour,e.minute,e.second,e.millisec)):f=new Date(b.getTime()),"Invalid Date"==f.toString()&&(f=void 0),this._setTime(d,f))}}},$.datepicker._base_setDateDatepicker=$.datepicker._setDateDatepicker,$.datepicker._setDateDatepicker=function(a,b){var c=this._getInst(a);if(c){var d=b instanceof Date?new Date(b.getTime()):b;this._updateDatepicker(c),this._base_setDateDatepicker.apply(this,arguments),this._setTimeDatepicker(a,d,!0)}},$.datepicker._base_getDateDatepicker=$.datepicker._getDateDatepicker,$.datepicker._getDateDatepicker=function(a,b){var c=this._getInst(a);if(c){var d=this._get(c,"timepicker");if(d){void 0===c.lastVal&&this._setDateFromField(c,b);var e=this._getDate(c);return e&&d._parseTime($(a).val(),d.timeOnly)&&e.setHours(d.hour,d.minute,d.second,d.millisec),e}return this._base_getDateDatepicker(a,b)}},$.datepicker._base_parseDate=$.datepicker.parseDate,$.datepicker.parseDate=function(a,b,c){var d;try{d=this._base_parseDate(a,b,c)}catch(e){d=this._base_parseDate(a,b.substring(0,b.length-(e.length-e.indexOf(":")-2)),c)}return d},$.datepicker._base_formatDate=$.datepicker._formatDate,$.datepicker._formatDate=function(a,b,c,d){var e=this._get(a,"timepicker");return e?(e._updateDateTime(a),e.$input.val()):this._base_formatDate(a)},$.datepicker._base_optionDatepicker=$.datepicker._optionDatepicker,$.datepicker._optionDatepicker=function(a,b,c){var d=this._getInst(a);if(!d)return null;var e=this._get(d,"timepicker");if(e){var f=null,g=null,h=null;"string"==typeof b?"minDate"===b||"minDateTime"===b?f=c:"maxDate"===b||"maxDateTime"===b?g=c:"onSelect"===b&&(h=c):"object"==typeof b&&(b.minDate?f=b.minDate:b.minDateTime?f=b.minDateTime:b.maxDate?g=b.maxDate:b.maxDateTime&&(g=b.maxDateTime)),f?(f=0===f?new Date:new Date(f),e._defaults.minDate=f,e._defaults.minDateTime=f):g?(g=0===g?new Date:new Date(g),e._defaults.maxDate=g,e._defaults.maxDateTime=g):h&&(e._defaults.onSelect=h)}return void 0===c?this._base_optionDatepicker(a,b):this._base_optionDatepicker(a,b,c)};var splitDateTime=function(a,b,c,d){try{var e=d&&d.separator?d.separator:$.timepicker._defaults.separator,f=d&&d.timeFormat?d.timeFormat:$.timepicker._defaults.timeFormat,g=d&&d.ampm?d.ampm:$.timepicker._defaults.ampm,h=f.split(e),i=h.length,j=b.split(e),k=j.length;if(g||(h=$.trim(f.replace(/t/gi,"")).split(e),i=h.length),k>1)return[j.splice(0,k-i).join(e),j.splice(0,i).join(e)]}catch(a){if(a.indexOf(":")>=0){var l=b.length-(a.length-a.indexOf(":")-2);b.substring(l);return[$.trim(b.substring(0,l)),$.trim(b.substring(l))]}throw a}return[b,""]},parseDateTimeInternal=function(a,b,c,d,e){var f,g=splitDateTime(a,c,d,e);if(f=$.datepicker._base_parseDate(a,g[0],d),""!==g[1]){var h=g[1],i=$.datepicker.parseTime(b,h,e);if(null===i)throw"Wrong time format";return{date:f,timeObj:i}}return{date:f}},selectLocalTimeZone=function(a,b){if(a&&a.timezone_select){a._defaults.useLocalTimezone=!0;var c=void 0!==b?b:new Date,d=$.timepicker.timeZoneOffsetString(c);a._defaults.timezoneIso8601&&(d=d.substring(0,3)+":"+d.substring(3)),a.timezone_select.val(d)}};$.timepicker=new Timepicker,$.timepicker.timeZoneOffsetString=function(a){var b=-1*a.getTimezoneOffset(),c=b%60,d=(b-c)/60;return(b>=0?"+":"-")+("0"+(101*d).toString()).substr(-2)+("0"+(101*c).toString()).substr(-2)},$.timepicker.timeRange=function(a,b,c){return $.timepicker.handleRange("timepicker",a,b,c)},$.timepicker.dateTimeRange=function(a,b,c){$.timepicker.dateRange(a,b,c,"datetimepicker")},$.timepicker.dateRange=function(a,b,c,d){d=d||"datepicker",$.timepicker.handleRange(d,a,b,c)},$.timepicker.handleRange=function(a,b,c,d){function e(a,d,e){d.val()&&new Date(b.val())>new Date(c.val())&&d.val(e)}function f(b,c,d){if($(b).val()){var e=$(b)[a].call($(b),"getDate");e.getTime&&$(c)[a].call($(c),"option",d,e)}}return $.fn[a].call(b,$.extend({onClose:function(a,b){e(this,c,a)},onSelect:function(a){f(this,c,"minDate")}},d,d.start)),$.fn[a].call(c,$.extend({onClose:function(a,c){e(this,b,a)},onSelect:function(a){f(this,b,"maxDate")}},d,d.end)),"timepicker"!=a&&d.reformat&&$([b,c]).each(function(){var b=$(this)[a].call($(this),"option","dateFormat"),c=new Date($(this).val());$(this).val()&&c&&$(this).val($.datepicker.formatDate(b,c))}),e(b,c,b.val()),f(b,c,"minDate"),f(c,b,"maxDate"),$([b.get(0),c.get(0)])},$.timepicker.version="1.0.4"}}(jQuery);