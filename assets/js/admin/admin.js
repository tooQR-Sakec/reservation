$(document).ready(function () {
	loadTables();
});

$("#addTable").submit(addTable);
$("#editTable").submit(editTable);

function addTable(event) {
	event.preventDefault();

	var tableID = $('#add-table-no').val();
	var capacity = $('#add-table-capacity').val();
	var adjCounter = parseInt($("#adjCounter").val());
	var adjacent = [];
	for(var i=0; i<adjCounter; i++) {
		if($("#adj"+i).val() != "") {
			adjacent.push($("#adj"+i).val());
		}
	}
	adjacent = JSON.stringify(adjacent);

	var formdata = new FormData();
	formdata.append('tableID', tableID);
	formdata.append('capacity', capacity);
	formdata.append('adjacent', adjacent);

	$.ajax({
		type: "POST",
		data: formdata,
		url: "tableView/addTable.php",
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function (data) {
			console.log(data);
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
			if (data.blocked == 1)
				$('#edit-table-reserved').prop("checked", true);
		}
	});
}

function editTable(event) {
	event.preventDefault();

	var tableID = $('#edit-table-ID').val();
	var capacity = $('#edit-table-capacity').val();
	var blocked = 0;
	if ($("#edit-table-reserved").is(':checked')) //tabled blocked for reservation
		blocked = 1;
	var formdata = new FormData();
	formdata.append("tableID", tableID);
	formdata.append("capacity", capacity);
	formdata.append("blocked", blocked);
	$.ajax({
		type: "POST",
		data: formdata,
		url: "tableView/editTable.php",
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function (data) {
			console.log(data);
			loadTables();
			$('#edit-table').modal('toggle');
			$('.modal-backdrop').remove();
		}
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
					<div class="col d-flex justify-content-center mb-5">
						<div class="skill-card">
							<header class="skill-card__header"><div class="skill-card__icon"></div></header>
							<section class="skill-card__body">
								<h2 class="skill-card__title">Table no: `+ element.tableID + `</h2><div class="skill-card__duration">Capacity: ` + element.capacity + `</div>
								<div class="skill-card__knowledge">
									<div class="form-btn" style="text-align: center;">
								<button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#edit-table"
									style="margin-top: 5%; width: 175px" onclick="editTableModal(`+ element.tableID + `)">
									Edit Table
								</button>
							</div>
							<div class="form-btn" style="text-align: center;">
								<button type="button" class="btn btn-outline-dark" style="margin-top: 5%; width: 175px" onclick="deleteTable(`+ element.tableID + `)">
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

$("#adj").keyup(function(){
	var adjCounter = parseInt($("#adjCounter").val());
	if($("#adj"+adjCounter).val() != ""){
		adjCounter += 1;
		var html = `<input type="number" class="form-control mb-2" id=adj`+adjCounter+`>`;
		$('#adj').append(html);
		$("#adjCounter").val(adjCounter);
	}
});