<link href="../uploadFile/style.css" rel="stylesheet">
<script src="../uploadFile/hayageek.js"></script>

<div class="popup hidden" id="popupUploadImage">

	<div class="content">

		<div class="medium blue textCenter bottomSpacer">Upload your image here</div>

		<div class="closeBtn clickable"></div>

		<div id="fileuploader">Upload</div>

		<div class="micro greyDark">(Allowed extensions: Jpg, Jpeg, Png) <br />(Max upload size: 1 MB)</div>

	</div>

</div>

<script>

	$(document).ready(function(){

		$("#popupUploadImage").find(".closeBtn").click(function(){
			$("#popupUploadImage").addClass("hidden");
		});

		$("#fileuploader").uploadFile({
			url:"../../update/uploadFile/uploadimage.php",
			multiple:false,
			dragDrop:true,
			maxFileCount:100,
			maxFileSize:1*1024*1024,
			allowedTypes:"jpg, jpeg, png",
			fileName:"myfile",
			showDelete: true,
			onSubmit:function(files){
				$("#popupUploadImage").find(".closeBtn").addClass("hidden");
			},
			onAbort:function(){
				$("#popupUploadImage").find(".closeBtn").removeClass("hidden");
			},
			onSuccess:function(files,data,xhr,pd){

				var filename=data.replace('["','');
				filename=filename.replace('"]','');

				$("#popupUploadImage").addClass("hidden");
				$(".ajax-file-upload-container").html("");
				$("#popupUploadImage").find(".closeBtn").removeClass("hidden");

				$("#image").val(filename);
				$("#imageTxt").val("Image uploaded");
				$("#imageViewDelete").removeClass("hidden");
				$("#imageViewDelete").find("#imageView").attr("href","../../publication-images/images/"+filename);
			},
			onError: function(files,status,errMsg,pd){
				$("#popupUploadImage").find(".closeBtn").removeClass("hidden");
				alert("Error,unable to upload your file.")
			}
		});


	});

</script>