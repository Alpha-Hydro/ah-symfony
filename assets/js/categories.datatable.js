const $ = require("jquery");
require( "datatables.net" );
require("datatables.net-bs4");

let ajaxUrl = "/api/categories/";
let datatableApi;

$(function () {
	datatableApi = $("#datatable").DataTable({
		"ajax": {
			"url": ajaxUrl + "all",
			"dataSrc": ""
		},
		"dom": 'irt<"row my-3"<"col-6"l><"col-6"p>>',
		"orderCellsTop": true,
		"paging": true,
		"info": true,
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
				"data": "parent",
				"render": function (data, type, row) {
					if (type === "display" && data) {
						return "<a href='" + data.id + "'>" + data.name + "</a>";
					}
					return data;
				}
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
