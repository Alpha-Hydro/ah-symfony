let checkModifications = document.getElementById('checkAll');
checkModifications.addEventListener('click', function () {
	checkAll(this);
});

function checkAll(e) {
	console.log(e.checked);
	let form = document.getElementById('printPassport');
	
	let checkboxes = [].slice.call(form.querySelectorAll("input[type='checkbox']"));
	checkboxes.map(function(c) {
		c.checked = e.checked;
	});
}
