const axios = require("axios");

let jsonUtil = {
	getCategoriesChildren : function (id, currentId) {
		return axios.get("/api/categories/" + id + '?current=' + currentId)
			.then(function (response) {
				return response.data;
			})
			.catch(function (response) {
				console.log(response);
			});
	}
};

module.exports = jsonUtil;