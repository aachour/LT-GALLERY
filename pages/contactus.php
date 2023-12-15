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
						</div>

					</div>
					
					<!-- <div class="topSpacerSmall">
						<select class="small black" id="reason">
							<option value=""></div>
							<option value="General Enquiry">General Enquiry</div>
							<option value="Collaboration Opportunities">Collaboration Opportunities</div>
						</select>
					</div> -->

					<!-- <div class="topSpacer small black">Full Name</div>
					<div class="topSpacerSmall">
						<input type="text" class="small black" id="fullname" value="" />
					</div>
					
					<div class="topSpacer small black">Phone Number</div>
					<div class="topSpacerSmall">
						<input type="text" class="small black" id="phone" value="" />
					</div>
					
					<div class="topSpacer small black">Email Address</div>
					<div class="topSpacerSmall">
						<input type="text" class="small black" id="email" value="" />
					</div>
					
					<div class="topSpacer small black">Message</div>
					<div class="topSpacerSmall">
						<textarea class="small black" id="message"></textarea>
					</div>

					<div class="topSpacer textRight">
						<input type="button" class="small blackRedBtn" id="submitBn" value="SUBMIT" />
					</div>

					<div class="topSpacerBigger">&nbsp;</div> -->


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

	function setBackground(){
		var formHeight=$(".form").height();
		$(".image").height(formHeight)
	}

	$(window).resize(function(){
		setBackground();
	});

	$(window).load(function(){
		setBackground();
	});


	$(document).ready(function(){

		$("#submitBn").click(function(){

			var reason=$("#reason").val();
			var fullname=$("#fullname").val(); 
			var phone=$("#phone").val(); 
			var email=$("#email").val(); 
			var message=$("#message").val();

			if(reason=="" || fullname=="" || phone=="" || email=="" || message=="" ){
				showPopupMsg("popupMsg","Please fill all fields","");
			}
			else{
				$.post("contactusSave/",{"reason":reason , "fullname":fullname , "phone":phone , "email":email , "message":message},function(result){
					showPopupMsg("popupMsg","Your message has been sent successfully","contactus/");
				});
			}

		});

	});
	

</script>


