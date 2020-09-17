$(document).ready(function () {
	loadTables();
});

$("#addTable").submit(addTable);
$("#editTable").submit(editTable);

function addTable(event) {
	event.preventDefault();

	var tableID = $('#add-table-no').val();
	var capacity = $('#add-table-capacity').val();
	var formdata = new FormData();
	formdata.append('tableID', tableID);
	formdata.append('capacity', capacity);

	$.ajax({
		type: "POST",
		data: formdata,
		url: "tableView/addTable.php",
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function (data) {
			$('#add-table').modal('toggle');
			$('.modal-backdrop').remove();
			loadTables();
		}
	});
}

function editTableModal(tableID) {
	$('#edit-table-ID').val(tableID);
	var formdata = new FormData();
	formdata.append('tableID', tableID);
	$.ajax({
		type: "POST",
		data: formdata,
		url: "tableView/fetchTableInfo.php",
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function (data) {
			console.log(data);
			data = JSON.parse(data);
			$('#edit-table-capacity').val(data.capacity);
			$('#edit-table-reserved').prop("checked", false);
			if (data.reserved == 1)
				$('#edit-table-reserved').prop("checked", true);
		}
	});
}

function editTable() {
	var tableID = $('#edit-table-ID').val();
	var capacity = $('#edit-table-capacity').val();
	var reserved = 0;
	if ($("#edit-table-reserved").is(':checked'))
		reserved = 1;
	var formdata = new FormData();
	formdata.append("tableID", tableID);
	formdata.append("capacity", capacity);
	formdata.append("reserved", reserved);
	$.ajax({
		type: "POST",
		data: formdata,
		url: "tableView/editTable.php",
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
	});
}

function deleteTable(tableID) {
	var formdata = new FormData();
	formdata.append("tableID", tableID);
	$.ajax({
		type: "POST",
		data: formdata,
		url: "tableView/deleteTable.php",
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function (data) {
			loadTables();
		}
	});
}

function loadTables() {
	$.ajax({
		url: "tableView/fetchTables.php",
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function (data) {
			var html = '';
			if (data) {
				data = JSON.parse(data);
				data.forEach(element => {
					html += `
					<div class="col-md-6 mb-5">
						<div class="skill-card">
							<header class="skill-card__header"><div class="skill-card__icon"></div></header>
							<section class="skill-card__body">
								<h2 class="skill-card__title">Table no: `+ element.tableID + `</h2><div class="skill-card__duration">Capacity: ` + element.capacity + `</div>
								<div class="skill-card__knowledge">
									<div class="form-btn" style="text-align: center;">
								<button type="button" class="btn btn-dark" data-toggle="modal" data-target="#edit-table"
									style="margin-top: 5%; width: 175px" onclick="editTableModal(`+ element.tableID + `)">
									Edit Table
								</button>
							</div>
							<div class="form-btn" style="text-align: center;">
								<button type="button" class="btn btn-dark" style="margin-top: 5%; width: 175px" onclick="deleteTable(`+ element.tableID + `)">
									Delete Table
								</button>
							</div>
								</div>
							</section>
						</div>
					</div>`;
					$('#tableCard').html(html);
				});
			}
		},
		//Other options
	});
}