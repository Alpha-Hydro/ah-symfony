import * as feather from "feather-icons";
import * as selectCategory from "./modalSelectCategory";

const $ = require("jquery");
// JS is equivalent to the normal "bootstrap" package
// no need to set this to a variable, just require it
require("bootstrap");

let greet = require("./greet");
$('body').prepend('<h1>'+greet('john')+'</h1>');

//helpers.help();

feather.replace();

(function () {
	let selectButton = $("#selectCategory");
	
	selectButton.click(function () {
		selectCategory.select();
	});
})();
