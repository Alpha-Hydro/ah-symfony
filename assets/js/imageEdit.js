let imageEdit = {
	imageUpload: function (inputFile, imageOutput) {
		inputFile.click();
		
		inputFile.addEventListener('change', function (event) {
			let input = event.target;
			
			let reader = new FileReader();
			reader.onload = function () {
				imageOutput.src = reader.result;
			};
			reader.readAsDataURL(input.files[0]);
		})
	}
};

module.exports = imageEdit;