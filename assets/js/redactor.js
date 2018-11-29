import * as imageEdit from "./imageEdit";

(function () {
	let btnEventImg = $(".btn-action-img");
	let fileInput = document.getElementById("imageUpload");
	let imageView = document.getElementById("imageUploadView");
	
	btnEventImg.click(function () {
		let imgEvent = this.dataset.imgEvent;
		if(imgEvent === 'download'){
			imageEdit.imageUpload(fileInput, imageView, true);
		}
		if (imgEvent === 'delete') {
			imageEdit.imageDelete(this.dataset.pathDelete, imageView);
		}
	});
})();
