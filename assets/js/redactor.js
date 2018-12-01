import * as feather from "feather-icons";
import * as imageEdit from "./imageEdit";

(function () {
	let btnEventImg = $(".btn-action-img");
	let imageViews = document.getElementsByClassName('imageUploadView');
	
	btnEventImg.click(function () {
		let imgEvent = this.dataset.imgEvent;
		if(imgEvent === 'download'){
			imageEdit.imageUploadAjax(this.dataset.pathUpload, imageViews);
		}
		if (imgEvent === 'delete') {
			imageEdit.imageDelete(this.dataset.pathDelete, imageViews, function () {
				document.querySelector("button[data-img-event=delete]").classList.add('hidden');
			});
		}
	});
})();

feather.replace({ width: 16, height: 16 });
