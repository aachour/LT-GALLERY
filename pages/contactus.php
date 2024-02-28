<?php
	@$PAGE_TITLE="Contact Us | LT Gallery";
	@$CURRENT_SECTION="CONTACT US";
	include ("../includes/top.php");
	include ("../includes/popupMsg.php");
	@extract(@$_GET);
	echo'<input type="hidden" id="arg" value="'.@$arg.'">';
?>

	<!------------------------------------------------------------------------------------------------->
	<!---------------------------------------------Middle---------------------------------------------->
	<!------------------------------------------------------------------------------------------------->

	<div class="fullContainer" id="contactus">

		<!--Section1-->
		<div class="section" id="section1">

			<div class="content">

				<div class="col1">
					<div class="medium gilroyLight">CONTACT US</div>
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
								<select class="small black" id="reason">
									<option value="General Enquiry">General Enquiry</option>
									<option value="Enquiry of an artwork">Enquiry of an artwork</option>
									<option value="Collaboration">Collaboration</option>
								</select>
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

		var arg=$("#arg").val();
		if(arg=="1"){
			$("#reason").val("Enquiry of an artwork");
		}

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


