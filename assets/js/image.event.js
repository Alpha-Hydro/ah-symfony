import * as imageEdit from "./imageEdit";

(function () {
	let btnEventImg = $(".btn-action-img");
	let fileInput = document.getElementById("imageUpload");
	// let imageView = document.getElementById("imageUploadView");
	
	btnEventImg.click(function (e) {
		e.preventDefault();
		
		let imgEvent = this.dataset.imgEvent;
		let imageOutId = this.dataset.target;
		let imageView = document.getElementById(imageOutId);
		
		console.log(this);
		console.log(imageOutId);
		console.log(imageView);
		
		if(imgEvent === 'download'){
			imageEdit.imageUpload(fileInput, imageView);
		}
		if (imgEvent === 'delete') {
			imageEdit.imageDelete(this.dataset.pathDelete, imageView);
		}
	});
})();