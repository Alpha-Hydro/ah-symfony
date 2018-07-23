let imageEdit = {
	imageUpload: function (inputFile, imageElement, imageText) {
		inputFile.click();

		inputFile.addEventListener('change',function (event) {
			let input = event.target;

			let reader = new FileReader();
			reader.onload = function () {
				imageElement.src = reader.result;
			};
			imageText.value = input.files[0].name;
			reader.readAsDataURL(input.files[0]);
		})
	}
};

module.exports = imageEdit;