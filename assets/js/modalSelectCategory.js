let selectCategory = {
	select: function () {
		let parentCategoryName = $("#parentCategoryName");
		let parentCategoryId = $("#categories_parent");
		let modal = $("#categoriesList");
		
		document.getElementsByName("category").forEach(function(e){
			if (e.checked){
				parentCategoryId.val(e.value);
				parentCategoryName.val(e.nextElementSibling.innerHTML);
			}
		});
		modal.modal('hide');
	}
};

module.exports = selectCategory;

