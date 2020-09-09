$(document).ready(function () {
	loadTables();
});

$("#addTable").submit(addTable);
$("#editTable").submit(editTable);
$("#tableSlot").change(checkStatus);

function addTable(event) {
	event.preventDefault();

	console.log("running");
	var tableID = $('#add-table-no').val();
	var capacity = $('#add-table-capacity').val();
	var formdata = new FormData();
	formdata.append('tableID', tableID);
	formdata.append('capacity', capacity);

	$.ajax({
		type: "POST",
		data: formdata,
		url: "addTable.php",
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function (data) {
			$('#add-table').modal('toggle');
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
		url: "fetchCapacity.php",
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function (data) {
			$('#edit-table-capacity').val(data);
		}
	});
}

function editTable() {
	var tableID = $('#edit-table-ID').val();
	var capacity = $('#edit-table-capacity').val();
	var formdata = new FormData();
	formdata.append("tableID", tableID);
	formdata.append("capacity", capacity);
	$.ajax({
		type: "POST",
		data: formdata,
		url: "editTable.php",
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
		url: "deleteTable.php",
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function (data) {
			loadTables();
		}
	});
}

function checkStatusModal(tableID) {
	$('#checkStatus-table-ID').val(tableID);
}

function checkStatus() {
	console.log("HI");
	var tableID = $('#checkStatus-table-ID').val();
	var slot = $('#tableSlot').val();
	var formdata = new FormData();
	formdata.append("tableID", tableID);
	formdata.append("slot", slot);
	$.ajax({
		type: "POST",
		data: formdata,
		url: "status.php",
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function (data) {
			if(data != "none") {
				var html = `
				<h2>Booked by: </h2>
				<h5>`+data+`</h5>`;
			} else {
				var html = `
				<h2>Available</h2>`;
			}
			document.getElementById('reservationStatus').innerHTML = html;
		}
	});
}

function loadTables() {
	$.ajax({
		url: "fetchTables.php",
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function (data) {
			var html = '';
			data = JSON.parse(data);
			data.forEach(element => {
				html += `
			<div class="col mb-4 search-card">
				<div class="card h-100">
					<div class="card-body">
						<div class="row no-gutters justify-content-center">
							<h5 class="card-title">Table no: `+ element.tableID + `</h5>
						</div>
						<div class="row no-gutters">
							<p class="card-text">Capacity: `+ element.capacity + `</p>
						</div>
						<div class="form-btn" style="text-align: center;">
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit-table"
								style="margin-top: 5%; width: 175px" onclick="editTableModal(`+ element.tableID + `)">
								Edit Table
							</button>
						</div>
						<div class="form-btn" style="text-align: center;">
							<button type="button" class="btn btn-primary" style="margin-top: 5%; width: 175px" onclick="deleteTable(`+ element.tableID + `)">
								Delete Table
							</button>
						</div>
						<div class="form-btn" style="text-align: center;">
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#slot-info"
								style="margin-top: 5%; width: 175px" onclick="checkStatusModal(`+ element.tableID + `)">
								Check Status
							</button>
						</div>
					</div>
				</div>
			</div>`;
				document.getElementById('tableCard').innerHTML = html;
			});
		},
		//Other options
	});
}