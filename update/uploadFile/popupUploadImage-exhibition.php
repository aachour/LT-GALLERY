<link href="../uploadFile/style.css" rel="stylesheet">
<script src="../uploadFile/hayageek.js"></script>

<div class="popup hidden" id="popupUploadExhibitionImage">

	<div class="content">

		<div class="medium blue textCenter bottomSpacer">Upload your images here</div>

		<div class="closeBtn clickable"></div>

		<div id="fileuploader">Upload</div>

		<div class="micro greyDark">(Allowed extensions: Jpg, Jpeg, Png) <br />(Max upload size: 1 MB)</div>

	</div>

</div>

<script>

	$(document).ready(function(){

		$("#popupUploadExhibitionImage").find(".closeBtn").click(function(){
			$("#popupUploadExhibitionImage").addClass("hidden");
		});

		$("#fileuploader").uploadFile({
			url:"../../update/uploadFile/uploadimage-exhibitions.php",
			multiple:false,
			dragDrop:true,
			maxFileCount:5,
			maxFileSize:1*1024*1024,
			allowedTypes:"jpg, jpeg, png",
			fileName:"myfile",
			showDelete: true,
			onSubmit:function(files){
				$("#popupUploadExhibitionImage").find(".closeBtn").addClass("hidden");
			},
			onAbort:function(){
				$("#popupUploadExhibitionImage").find(".closeBtn").removeClass("hidden");
			},
			onSuccess:function(files,data,xhr,pd){

				var filename=data.replace('["',''); 
				filename=filename.replace('"]','');

				$("#popupUploadExhibitionImage").addClass("hidden");
				$(".ajax-file-upload-container").html("");
				$("#popupUploadExhibitionImage").find(".closeBtn").removeClass("hidden");

				$("#image").val(filename);
				$("#imageTxt").val("Image uploaded");
				$("#imageViewDelete").removeClass("hidden");
				$("#imageViewDelete").find("#imageView").attr("href","../../exhibitions/images/"+filename);
				count++;
			},
			onError: function(files,status,errMsg,pd){
				$("#popupUploadExhibitionImage").find(".closeBtn").removeClass("hidden");
				alert("Error,unable to upload your file.")
			}
		});


	});

</script>