import * as feather from "feather-icons";
import * as selectCategory from "./modalSelectCategory";

const $ = require("jquery");

require("bootstrap");
require("./categories.datatable");
require("./image.event");

(function () {
	let selectButton = $("#selectCategory");
	
	selectButton.click(function () {
		selectCategory.select();
	});
	
	let replaceButton = $(".replace-category");
	
	replaceButton.click(function () {
		selectCategory.replace(this);
	});
})();

feather.replace();