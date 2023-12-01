
	<div class="popup hidden" id="popupMsg" style="z-index:9999999;">

		<div class="content textCenter">

			<div class="closeBtn clickable" href=""></div>

			<div class="topSpacer text small black"></div>

		</div>

	</div>

	<script>

		function showPopupMsg(popupid,text,href){ 
			var popup="#"+popupid;
			$(popup).removeClass("hidden");
			$(popup).find(".text").html(text);
			$(popup).find(".closeBtn").attr("href",href);
		}

		$(document).ready(function(e){ 

			$("#popupMsg").find(".closeBtn").click(function(){
				var href=$(this).attr("href");
				if(href==""){
					$("#popupMsg").find(".text").html("");
					$("#popupMsg").addClass("hidden");
				}
				else{
					window.location.href=href;
				}
			});
		
		});

	</script>
