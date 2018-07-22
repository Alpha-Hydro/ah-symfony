const feather = require("feather-icons");

let jsonUtils = require("./jsonUtil");
let modal = $("#categoriesList");
let listGroup = modal.find('.list-group');

let selectCategory = {
	select: function () {
		let parentCategoryName = $("#parentCategoryName");
		let parentCategoryId = $("#categories_parent");
		
		document.getElementsByName("category").forEach(function (e) {
			if (e.checked) {
				parentCategoryId.val(e.value);
				parentCategoryName.val(e.nextElementSibling.innerHTML);
			}
		});
		modal.modal('hide');
	},
	
	replace: function (el) {
		let id = el.dataset.replaceCategory;
		console.log(id);
		modal.modal('hide');
		jsonUtils.getCategoriesChildren(id)
			.then(
				(data) => {
					listGroup.html(data.content);
				}
			)
			.then(() => {
				feather.replace();
				$(".replace-category").click((e) => {
					this.replace(e.currentTarget);
				});
			})
			.then(() => {
				modal.modal('show');
			})
		;
	}
};

module.exports = selectCategory;

