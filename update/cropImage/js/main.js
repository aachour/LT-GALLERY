(function (factory) {
if (typeof define === 'function' && define.amd) {
	// AMD. Register as anonymous module.
	define(['jquery'], factory);
}
else if (typeof exports === 'object') {
	// Node / CommonJS
	factory(require('jquery'));
}
else {
	// Browser globals.
	factory(jQuery);
}
})(function ($) {


'use strict';

var console = window.console || { log: function () {} };

function CropAvatar($element) {
	this.$container = $element;
	this.$avatarView = this.$container.find('.avatar-view');
	this.$avatar = this.$avatarView.find('img');
	this.$avatarModal = this.$container.find('#avatar-modal');
	this.$loading = this.$container.find('.cropImageLoading');
	this.$avatarForm = this.$avatarModal.find('.avatar-form');
	this.$avatarUpload = this.$avatarForm.find('.avatar-upload');
	this.$avatarSrc = this.$avatarForm.find('.avatar-src');
	this.$avatarData = this.$avatarForm.find('.avatar-data');
	this.$avatarInput = this.$avatarForm.find('.avatar-input');
	this.$avatarSave = this.$avatarForm.find('.avatar-save');
	this.$avatarBtns = this.$avatarForm.find('.avatar-btns');
	this.$avatarWrapper = this.$avatarModal.find('.avatar-wrapper');
	this.$avatarPreview = this.$avatarModal.find('.avatar-preview');
	this.init();
}

CropAvatar.prototype = {

	constructor: CropAvatar,

	support: {
	fileList: !!$('<input type="file">').prop('files'),
	blobURLs: !!window.URL && URL.createObjectURL,
	formData: !!window.FormData
	},

	init: function () {
	this.support.datauri = this.support.fileList && this.support.blobURLs;

	if (!this.support.formData) {
		this.initIframe();
	}

	this.initTooltip();
	this.initModal();
	this.addListener();
	},

	addListener: function () {
	this.$avatarView.on('click', $.proxy(this.click, this));
	this.$avatarInput.on('change', $.proxy(this.change, this));
	this.$avatarForm.on('submit', $.proxy(this.submit, this));
	this.$avatarBtns.on('click', $.proxy(this.rotate, this));
	},

	removeListener: function () {
	this.$avatarView.off('click', $.proxy(this.click, this));
	this.$avatarInput.off('change', $.proxy(this.change, this));
	this.$avatarForm.off('submit', $.proxy(this.submit, this));
	this.$avatarBtns.off('click', $.proxy(this.rotate, this));
	},

	initTooltip: function () {
	this.$avatarView.tooltip({
		placement: 'bottom'
	});
	},

	initModal: function () {
	this.$avatarModal.modal({
		show: true
	});
	},

	initPreview: function () {
	var url = this.$avatar.attr('src');

	this.$avatarPreview.html('<img src="' + url + '">');
	},

	initIframe: function () {
	var target = 'upload-iframe-' + (new Date()).getTime();
	var $iframe = $('<iframe>').attr({
			name: target,
			src: ''
		});
	var _this = this;

	// Ready ifrmae
	$iframe.one('load', function () {

		// respond response
		$iframe.on('load', function () {
		var data;

		try {
			data = $(this).contents().find('body').text();
		} catch (e) {
			console.log(e.message);
		}

		if (data) {
			try {
			data = $.parseJSON(data);
			} catch (e) {
			console.log(e.message);
			}

			_this.submitDone(data);
		} else {
			_this.submitFail('Image upload failed!');
		}

		_this.submitEnd();

		});
	});

	this.$iframe = $iframe;
	this.$avatarForm.attr('target', target).after($iframe.hide());
	},

	click: function () {
	this.$avatarModal.modal('show');
	this.initPreview();
	},

	change: function () {
	var files;
	var file;
	if (this.support.datauri) {
		files = this.$avatarInput.prop('files');

		if (files.length > 0) {
		file = files[0];

		if (this.isImageFile(file)) {
			if (this.url) {
			URL.revokeObjectURL(this.url); // Revoke the old one
			}

			this.url = URL.createObjectURL(file);
			this.startCropper();
		}
		}
	} else {
		file = this.$avatarInput.val();

		if (this.isImageFile(file)) {
		this.syncUpload();
		}
	}

	},

	submit: function () {
	if (!this.$avatarSrc.val() && !this.$avatarInput.val()) {
		return false;
	}

	if (this.support.formData) {
		this.ajaxUpload();
		return false;
	}
	},

	rotate: function (e) {
	var data;

	if (this.active) {
		data = $(e.target).data();

		if (data.method) {
		this.$img.cropper(data.method, data.option);
		}
	}
	},

	isImageFile: function (file) {
	if (file.type) {
		return /^image\/\w+$/.test(file.type);
	} else {
		return /\.(jpg|jpeg|png|gif)$/.test(file);
	}
	},

	startCropper: function () {
	var _this = this;

	if (this.active) {
		this.$img.cropper('replace', this.url);
	}
	else {
		if(aspectRatioValue!="0"){
			this.$img = $('<img src="' + this.url + '">');
			this.$avatarWrapper.empty().html(this.$img);
			this.$img.cropper({
				aspectRatio: aspectRatioValue,
				preview: this.$avatarPreview.selector,
				crop: function (e) {
					var json = [
						'{"x":' + e.x,
						'"y":' + e.y,
						'"height":' + e.height,
						'"width":' + e.width,
						'"rotate":' + e.rotate + '}'
						].join();

					_this.$avatarData.val(json);
				}
			});
		}
		else{
			this.$img = $('<img src="' + this.url + '">');
			this.$avatarWrapper.empty().html(this.$img);
			this.$img.cropper({
				autoCrop: true,
			    aspectRatio: NaN,
			    viewMode: 3,
				preview: this.$avatarPreview.selector,
				crop: function (e) {
					var json = [
						'{"x":' + e.x,
						'"y":' + e.y,
						'"height":' + e.height,
						'"width":' + e.width,
						'"rotate":' + e.rotate + '}'
						].join();

					_this.$avatarData.val(json);
				}
			});
		}

		this.active = true;
	}

	this.$avatarModal.one('hidden.bs.modal', function () {
		_this.$avatarPreview.empty();
		_this.stopCropper();
	});
	},

	stopCropper: function () {
		if (this.active) {
		this.$img.cropper('destroy');
		this.$img.remove();
		this.active = false;
		this.removeListener();
	}
	},

	ajaxUpload: function () {

		if(cropImageOption==1){
			$(".avatar-directory").val("aboutus");
			$(".avatar-width").val("");
			$(".avatar-height").val("");
		}
		else if(cropImageOption==2){
			$(".avatar-directory").val("exhibitions");
			$(".avatar-width").val("1000");
			$(".avatar-height").val("625");
		}
		else if(cropImageOption==3){
			$(".avatar-directory").val("artists");
			$(".avatar-width").val("");
			$(".avatar-height").val("");
		}
		else if(cropImageOption==4){
			$(".avatar-directory").val("topbanner");
			$(".avatar-width").val("2000");
			$(".avatar-height").val("650");
		}
		else if(cropImageOption==5){
			$(".avatar-directory").val("podcasts");
			$(".avatar-width").val("1000");
			$(".avatar-height").val("1000");
		}
		else if(cropImageOption==6){
			$(".avatar-directory").val("exhibitions");
			$(".avatar-width").val("");
			$(".avatar-height").val("");
		}else if(cropImageOption==7){
			$(".avatar-directory").val("news");
			$(".avatar-width").val("");
			$(".avatar-height").val("");
		}

		var url = this.$avatarForm.attr('action');
		var data = new FormData(this.$avatarForm[0]);

		
		var _this = this;

		$.ajax(url, {
			type: 'post',
			data: data,
			dataType: 'json',
			processData: false,
			contentType: false,

			beforeSend: function () {
				_this.submitStart();
			},

			success: function (data) {
				_this.submitDone(data);
			},

			error: function (XMLHttpRequest, textStatus, errorThrown) {
				_this.submitFail(textStatus || errorThrown);
				alert(textStatus); 
				alert(texerrorThrowntStatus);
			},

			complete: function () {
				_this.submitEnd();
			}
		});


	},

	syncUpload: function () {
	this.$avatarSave.click();
	},

	submitStart: function () {
	this.$loading.fadeIn();
	},

	submitDone: function (data) {
	if ($.isPlainObject(data) && data.state === 200) {
		if (data.result) {
			this.url = data.result;

			if (this.support.datauri || this.uploaded) {
			this.uploaded = false;
			this.cropDone();
			} else {
			this.uploaded = true;
			this.$avatarSrc.val(this.url);
			this.startCropper();
			}

			this.$avatarInput.val('');
		} else if (data.message) {
			this.alert(data.message);
		}
	}
	else {
		this.alert('Failed to response');
	}
	},

	submitFail: function (msg) {
	//this.alert(msg);
	this.$avatarPreview.html("");
	},

	submitEnd: function () {
	this.$loading.fadeOut();
	},

	cropDone: function () {

		this.$avatarForm.get(0).reset();
		this.$avatar.attr('src', this.url);
		this.stopCropper();
		this.$avatarModal.modal('hide');

		var imageUrl=this.url;

		this.$avatarPreview.html("");

		if(cropImageOption=="1"){
			var image=imageUrl.replace("../../aboutus/images/","");
			$("#imageTxt").val("Image uploaded");
			$("#image").val(image);
			$("#imageViewDelete").removeClass("hidden");
			$("#imageViewDelete").find("#imageView").attr("href","../../aboutus/images/"+image);
		}
		else if(cropImageOption=="2" || cropImageOption=="6"){
			var image=imageUrl.replace("../../exhibitions/images/",""); 
			$("#imageTxt").val("Image uploaded");
			$("#image").val(image);
			$("#imageViewDelete").removeClass("hidden");
			$("#imageViewDelete").find("#imageView").attr("href","../../exhibitions/images/"+image);
		}
		else if(cropImageOption=="3"){
			var image=imageUrl.replace("../../artists/images/",""); 
			$("#imageTxt").val("Image uploaded");
			$("#image").val(image);
			$("#imageViewDelete").removeClass("hidden");
			$("#imageViewDelete").find("#imageView").attr("href","../../artists/images/"+image);
		}
		if(cropImageOption=="4"){
			var image=imageUrl.replace("../../topbanner/images/","");
			$("#imageTxt").val("Image uploaded");
			$("#image").val(image);
			$("#imageViewDelete").removeClass("hidden");
			$("#imageViewDelete").find("#imageView").attr("href","../../topbanner/images/"+image);
		}
		if(cropImageOption=="5"){
			var image=imageUrl.replace("../../podcasts/images/","");
			$("#imageTxt").val("Image uploaded");
			$("#image").val(image);
			$("#imageViewDelete").removeClass("hidden");
			$("#imageViewDelete").find("#imageView").attr("href","../../podcasts/images/"+image);
		}if(cropImageOption=="7"){
			var image=imageUrl.replace("../../news/images/","");
			$("#imageTxt").val("Image uploaded");
			$("#image").val(image);
			$("#imageViewDelete").removeClass("hidden");
			$("#imageViewDelete").find("#imageView").attr("href","../../news/images/"+image);
		}
	},

	alert: function (msg) {
		var $alert = [
			'<div class="alert alert-danger avatar-alert alert-dismissable">',
			'<button type="button" class="close" data-dismiss="alert">&times;</button>',
			msg,
			'</div>'
		].join('');

		this.$avatarUpload.after($alert);
	}

};

	var cropImageOption;
	var aspectRatioValue;

	$(function () {

		$("#aboutusBrowseBtn").click(function(){
			cropImageOption="1";
			aspectRatioValue="0";
			return new CropAvatar($("#crop-avatar"));
		});

		$("#newsBrowseBtn").click(function(){
			cropImageOption="7";
			aspectRatioValue="0";
			return new CropAvatar($("#crop-avatar"));
		});

		$("#exhibitionBrowseBtn").click(function(){
			cropImageOption="2";
			aspectRatioValue="1.6";
			return new CropAvatar($("#crop-avatar"));
		});

		$("#galleryBrowseBtn").click(function(){
			cropImageOption="6";
			aspectRatioValue="0";
			return new CropAvatar($("#crop-avatar"));
		});

		$("#artistBrowseBtn").click(function(){
			cropImageOption="3";
			aspectRatioValue="0";
			return new CropAvatar($("#crop-avatar"));
		});

		$("#topBannerBrowseBtn").click(function(){
			cropImageOption="4";
			aspectRatioValue="2";
			return new CropAvatar($("#crop-avatar"));
		});

		$("#podcastBrowseBtn").click(function(){
			cropImageOption="5";
			aspectRatioValue="1";
			return new CropAvatar($("#crop-avatar"));
		});

		
	});

});


