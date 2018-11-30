import * as feather from "feather-icons";
import * as imageEdit from "./imageEdit";

(function () {
	let btnEventImg = $(".btn-action-img");
	let imageView = document.getElementById("imageUploadView");
	
	btnEventImg.click(function () {
		let imgEvent = this.dataset.imgEvent;
		if(imgEvent === 'download'){
			imageEdit.imageUploadAjax(this.dataset.pathUpload, imageView);
		}
		if (imgEvent === 'delete') {
			imageEdit.imageDelete(this.dataset.pathDelete, imageView);
		}
	});
})();

feather.replace({ width: 16, height: 16 });
