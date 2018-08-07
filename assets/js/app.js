import * as feather from "feather-icons";
import * as selectCategory from "./modalSelectCategory";
import * as imageEdit from "./imageEdit";

const $ = require("jquery");
// JS is equivalent to the normal "bootstrap" package
// no need to set this to a variable, just require it
require("bootstrap");

feather.replace();

(function () {
	let selectButton = $("#selectCategory");
	
	selectButton.click(function () {
		selectCategory.select();
	});
	
	let replaceButton = $(".replace-category");
	
	replaceButton.click(function () {
		selectCategory.replace(this);
	});

	let btnEventImg = $(".btn-action-img");
	let fileInput = document.getElementById("imageUpload");
	let imageView = document.getElementById("imageUploadView");

	btnEventImg.click(function () {
		let imgEvent = this.dataset.imgEvent;
		if(imgEvent === 'download'){
			imageEdit.imageUpload(fileInput, imageView);
		}
		if (imgEvent === 'delete') {
				imageEdit.imageDelete(this.dataset.pathDelete, imageView);
		}
	});
})();
