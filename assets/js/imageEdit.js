const axios = require("axios");

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
	},
	
	imageDelete: function (pathDelete, imageOutput) {
		axios.post(pathDelete)
			.then(function () {
				imageOutput.src = '/files/images/no-foto.jpg';
			}).catch(function (response) {
				console.log(response);
		});
	}
};

module.exports = imageEdit;