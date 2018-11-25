const $ = require("jquery");
require( "datatables.net" );
require("datatables.net-bs4");

let ajaxUrl = "/api/categories/all";
let datatableApi;

$(function () {
	datatableApi = $("#datatable").DataTable({
		"ajax": {
			"url": ajaxUrl,
			"dataSrc": ""
		},
		"orderCellsTop": true,
		"paging": true,
		"info": false,
		"columns": [
			{
				"data": "id"
			},
			{
				"data": "sorting"
			},
			{
				"data": "name"
			},
			{
				"data": "parent_id"
			},
			{
				"data": "fullPath"
			},
			{
				"data": "active"
			},
			{
				"data": "deleted"
			},
		]
	});
	
	datatableApi.columns().every(function (index) {
		$('#datatable thead tr:eq(1) td:eq(' + index + ') input').on('keyup change', function () {
			datatableApi.column($(this).parent().index() + ':visible')
				.search(this.value)
				.draw();
		});
	});
	
	$('#datatable-search').on( 'keyup', function () {
		datatableApi.search( this.value ).draw();
	} );
});
