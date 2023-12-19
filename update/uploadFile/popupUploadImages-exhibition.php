<link href="../uploadFile/style.css" rel="stylesheet">
<script src="../uploadFile/hayageek.js"></script>

<div class="popup hidden" id="popupUploadExhibitionImages">

	<div class="content">

		<div class="medium blue textCenter bottomSpacer">Upload your images here [Max 5 images]</div>

		<div class="closeBtn clickable"></div>

		<div id="fileuploader">Upload</div>

		<div class="micro greyDark">(Allowed extensions: Jpg, Jpeg, Png) <br />(Max upload size: 1 MB)</div>

	</div>

</div>

<script>

	$(document).ready(function(){

		var count = 1;

		$("#popupUploadExhibitionImages").find(".closeBtn").click(function(){
			$("#popupUploadExhibitionImages").addClass("hidden");
		});

		$("#fileuploader").uploadFile({
			url:"../../update/uploadFile/uploadimage-exhibitions.php",
			multiple:true,
			dragDrop:true,
			maxFileCount:5,
			maxFileSize:1*1024*1024,
			allowedTypes:"jpg, jpeg, png",
			fileName:"myfile",
			showDelete: true,
			onSubmit:function(files){
				$("#popupUploadExhibitionImages").find(".closeBtn").addClass("hidden");
			},
			onAbort:function(){
				$("#popupUploadExhibitionImages").find(".closeBtn").removeClass("hidden");
			},
			onSuccess:function(files,data,xhr,pd){

				var filename=data.replace('["',''); 
				filename=filename.replace('"]','');

				$("#popupUploadExhibitionImages").addClass("hidden");
				$(".ajax-file-upload-container").html("");
				$("#popupUploadExhibitionImages").find(".closeBtn").removeClass("hidden");

				$(".image"+count+"Container").removeClass("hidden");
				$("#image"+count).val(filename);
				$("#image"+count+"Txt").val("Image uploaded");
				$("#image"+count+"ViewDelete").removeClass("hidden");
				$("#image"+count+"ViewDelete").find("#image"+count+"View").attr("href","../../exhibitions/images/"+filename);
				count++;
			},
			onError: function(files,status,errMsg,pd){
				$("#popupUploadExhibitionImages").find(".closeBtn").removeClass("hidden");
				alert("Error,unable to upload your file.")
			}
		});


	});

</script>