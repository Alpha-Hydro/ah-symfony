const axios = require("axios");

let jsonUtil = {
	getCategoriesChildren : function (id) {
		return axios.get("/api/categories/" + id)
			.then(function (response) {
				return response.data;
			})
			.catch(function (response) {
				console.log(response);
			});
	}
};

module.exports = jsonUtil;