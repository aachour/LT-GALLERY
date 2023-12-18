<link href="../uploadFile/style.css" rel="stylesheet">
<script src="../uploadFile/hayageek.js"></script>

<div class="popup hidden" id="popupUploadFile">

	<div class="content">

		<div class="medium blue textCenter bottomSpacer">Upload your file here</div>

		<div class="closeBtn clickable"></div>

		<div id="fileuploader">Upload</div>

		<div class="micro greyDark">(Allowed extensions: PDF) <br />(Max upload size: 15 MB)</div>

	</div>

</div>

<script>

	$(document).ready(function(){

		$("#popupUploadFile").find(".closeBtn").click(function(){
			$("#popupUploadFile").addClass("hidden");
		});

		$("#fileuploader").uploadFile({
			url:"../../update/uploadFile/uploadfile.php",
			multiple:false,
			dragDrop:true,
			maxFileCount:100,
			maxFileSize:15*1024*1024,
			allowedTypes:"pdf",
			fileName:"myfile",
			showDelete: true,
			onSubmit:function(files){
				$("#popupUploadFile").find(".closeBtn").addClass("hidden");
			},
			onAbort:function(){
				$("#popupUploadFile").find(".closeBtn").removeClass("hidden");
			},
			onSuccess:function(files,data,xhr,pd){

				var filename=data.replace('["','');
				filename=filename.replace('"]','');

				$("#popupUploadFile").addClass("hidden");
				$(".ajax-file-upload-container").html("");
				$("#popupUploadFile").find(".closeBtn").removeClass("hidden");

				$("#file").val(filename);
				$("#fileTxt").val("File uploaded");
				$("#fileViewDelete").removeClass("hidden");
				$("#fileViewDelete").find("#fileView").attr("href","../../exhibitions/files/"+filename);
			},
			onError: function(files,status,errMsg,pd){
				$("#popupUploadFile").find(".closeBtn").removeClass("hidden");
				alert("Error,unable to upload your file.")
			}
		});


	});

</script>