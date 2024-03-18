

<div id="view_jotform">

	<h2>Jot Form</h2>

	<div style="width: 300px !important; align: right">

	<!-- <script type="text/javascript" src="https://form.jotform.me/jsform/71160936526457"></script> -->

	<!-- <iframe id="JotFormIFrame-71160936526457" onload="window.parent.scrollTo(0,0)" allowtransparency="true" src="https://form.jotform.me/71160936526457" frameborder="0" style="width:100%; height:539px; border:none;" scrolling="no"> </iframe> <script type="text/javascript"> var ifr = document.getElementById("JotFormIFrame-71160936526457"); if(window.location.href && window.location.href.indexOf("?") > -1) { var get = window.location.href.substr(window.location.href.indexOf("?") + 1); if(ifr && get.length > 0) { var src = ifr.src; src = src.indexOf("?") > -1 ? src + "&" + get : src + "?" + get; ifr.src = src; } } window.handleIFrameMessage = function(e) { var args = e.data.split(":"); if (args.length > 2) { iframe = document.getElementById("JotFormIFrame-" + args[2]); } else { iframe = document.getElementById("JotFormIFrame"); } if (!iframe) return; switch (args[0]) { case "scrollIntoView": iframe.scrollIntoView(); break; case "setHeight": iframe.style.height = args[1] + "px"; break; case "collapseErrorPage": if (iframe.clientHeight > window.innerHeight) { iframe.style.height = window.innerHeight + "px"; } break; case "reloadPage": window.location.reload(); break; } var isJotForm = (e.origin.indexOf("jotform") > -1) ? true : false; if(isJotForm && "contentWindow" in iframe && "postMessage" in iframe.contentWindow) { var urls = {"docurl":encodeURIComponent(document.URL),"referrer":encodeURIComponent(document.referrer)}; iframe.contentWindow.postMessage(JSON.stringify({"type":"urls","value":urls}), "*"); } }; if (window.addEventListener) { window.addEventListener("message", handleIFrameMessage, false); } else if (window.attachEvent) { window.attachEvent("onmessage", handleIFrameMessage); } </script> -->





	</div>

</div>

<script type="text/javascript">

	$(document).ready(function(){

		$("#zone_data_accordian").click();

		$("#zone_data_accordian").next().slideDown();

		$('#jotform').click();

		$('#jotform').next().slideDown();

		$('#view_jot_form').addClass('active');



	});

	



</script>

