import * as feather from "feather-icons";
import * as selectCategory from "./modalSelectCategory";

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
})();
