<?php
	@$PAGE_TITLE="CONTACT US | LT GALLERY";
	@$CURRENT_SECTION="CONTACT US";
	include ("../includes/top.php");
	include ("../includes/popupMsg.php");
?>

	<!------------------------------------------------------------------------------------------------->
	<!---------------------------------------------Middle---------------------------------------------->
	<!------------------------------------------------------------------------------------------------->

	<div class="fullContainer" id="contactus">

		<!--Section1-->
		<div class="section" id="section1">

			<div class="content">

				<div class="col1">
					<div class="medium gilroyMedium">CONTACT US</div>
				</div>

				<div class="col2">

					<div class="small black">LT Gallery is open for collaborations,<br />enquiries of interests</div>

					<div class="row">

						<div class="topSpacer col-lg-6 col-12">
							<div class="topSpacer">
								<input type="text" class="small black" placeholder="First Name" id="fname" value="" />
							</div>
							<div class="topSpacer">
								<input type="text" class="small black" placeholder="Last Name" id="lname" value="" />
							</div>
							<div class="topSpacer">
								<input type="text" class="small black" placeholder="Email Address" id="email" value="" />
							</div>
							<div class="topSpacer">
								<input type="text" class="small black" placeholder="Phone Number" id="phone" value="" />
							</div>
						</div>

						<div class="topSpacer col-lg-6 col-12">
							<div class="topSpacer">
								<input type="text" class="small black" placeholder="Enquiry Reason" id="reason" value="" />
							</div>
							<div class="topSpacer">
								<textarea class="small black" placeholder="Message" id="message"></textarea>
							</div>
						
							<div class="topSpacerBig">
								<input type="button" class="small" id="submitBtn" value="SUBMIT" />
							</div>

						</div>

					</div>

				</div>

				<div class="clear"></div>
				
			</div>

			
			
		</div>

	</div>

	<!------------------------------------------------------------------------------------------------->
	<!---------------------------------------------Middle---------------------------------------------->
	<!------------------------------------------------------------------------------------------------->


<?php
	include ("../includes/bottom.php");
?>

<script>


	$(document).ready(function(){

		$("#submitBtn").click(function(){

			var fname=$("#fname").val();
			var lname=$("#lname").val(); 
			var email=$("#email").val(); 
			var phone=$("#phone").val(); 
			var reason=$("#reason").val(); 
			var message=$("#message").val();

			if(fname=="" || lname=="" || email=="" || phone=="" || reason=="" || message=="" ){
				showPopupMsg("popupMsg","Please fill all fields","");
			}
			else{
				$.post("contactusSave/",{"fname":fname , "lname":lname , "email":email , "phone":phone , "reason":reason , "message":message},function(result){
					showPopupMsg("popupMsg","Your message has been sent successfully","contactus/");
				});
			}

		});

	});
	

</script>


