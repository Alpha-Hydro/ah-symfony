const $ = require("jquery");
// JS is equivalent to the normal "bootstrap" package
// no need to set this to a variable, just require it
require("bootstrap");

$(function () {
	let selectButton = $("#selectCategory");
	let parentCategoryName = $("#parentCategoryName");
	let parentCategoryId = $("#categories_parent");
	let modal = $("#categoriesList");

	selectButton.click(function () {
		document.getElementsByName("category").forEach(function(e){
			if (e.checked){
				parentCategoryId.val(e.value);
				parentCategoryName.val(e.nextElementSibling.innerHTML);
			}
		});
		modal.modal('hide');
	})
});