import * as imageEdit from "./imageEdit";

(function () {
	let btnEventImg = $(".btn-action-img");
	let fileInputImg = document.getElementById("imageUpload");
	
	imageEdit.imageEvent(btnEventImg, fileInputImg);
	
	let btnEventDraft = $(".btn-action-draft");
	let fileInputDraft = document.getElementById("draftUpload");
	
	imageEdit.imageEvent(btnEventDraft, fileInputDraft);
})();
