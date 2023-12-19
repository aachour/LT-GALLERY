<link href="../uploadFile/style.css" rel="stylesheet">
<script src="../uploadFile/hayageek.js"></script>

<div class="popup hidden" id="popupUploadArtistImages">

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

		$("#popupUploadArtistImages").find(".closeBtn").click(function(){
			$("#popupUploadArtistImages").addClass("hidden");
		});

		$("#fileuploader").uploadFile({
			url:"../../update/uploadFile/uploadimage-artist.php",
			multiple:true,
			dragDrop:true,
			maxFileCount:5,
			maxFileSize:1*1024*1024,
			allowedTypes:"jpg, jpeg, png",
			fileName:"myfile",
			showDelete: true,
			onSubmit:function(files){
				$("#popupUploadArtistImages").find(".closeBtn").addClass("hidden");
			},
			onAbort:function(){
				$("#popupUploadArtistImages").find(".closeBtn").removeClass("hidden");
			},
			onSuccess:function(files,data,xhr,pd){

				var filename=data.replace('["',''); 
				filename=filename.replace('"]','');

				$("#popupUploadArtistImages").addClass("hidden");
				$(".ajax-file-upload-container").html("");
				$("#popupUploadArtistImages").find(".closeBtn").removeClass("hidden");

				$(".image"+count+"Container").removeClass("hidden");
				$("#image"+count).val(filename);
				$("#image"+count+"Txt").val("Image uploaded");
				$("#image"+count+"ViewDelete").removeClass("hidden");
				$("#image"+count+"ViewDelete").find("#image"+count+"View").attr("href","../../artists/images/"+filename);
				count++;
			},
			onError: function(files,status,errMsg,pd){
				$("#popupUploadArtistImages").find(".closeBtn").removeClass("hidden");
				alert("Error,unable to upload your file.")
			}
		});


	});

</script>