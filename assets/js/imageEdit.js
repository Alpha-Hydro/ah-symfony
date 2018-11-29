const axios = require("axios");

let imageEdit = {
	imageUpload(inputFile, imageOutput, submit = false) {
		inputFile.click();
		
		inputFile.addEventListener('change', function (event) {
			let input = event.target;
			
			let reader = new FileReader();
			reader.onload = function () {
				imageOutput.src = reader.result;
			};
			reader.readAsDataURL(input.files[0]);
			
			submit && this.form.submit();
		});
	},
	
	imageDelete(pathDelete, imageOutput) {
		axios.post(pathDelete)
			.then(function () {
				imageOutput.src = '/files/images/no-foto.jpg';
			}).catch(function (response) {
				console.log(response);
		});
	}
};

module.exports = imageEdit;