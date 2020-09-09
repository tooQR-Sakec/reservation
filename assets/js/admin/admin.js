function editTable(tableID){
	console.log(tableID);
	/* $.ajax({
		url: "fetchTables.php",
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function (data) {}
	});
} */

function deleteTable(tableID){
	console.log(tableID);}

function checkStatus(tableID){
	console.log(tableID);}

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
							<h5 class="card-title">Table no: `+element.tableID+`</h5>
						</div>
						<div class="row no-gutters">
							<p class="card-text">Capacity: `+element.capacity+`</p>
						</div>
						<div class="form-btn" style="text-align: center;">
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit-table"
								style="margin-top: 5%; width: 175px" onclick="editTable(`+element.tableID+`)">
								Edit Table
							</button>
						</div>
						<div class="form-btn" style="text-align: center;">
							<button type="button" class="btn btn-primary" style="margin-top: 5%; width: 175px" onclick="deleteTable(`+element.tableID+`)">
								Delete Table
							</button>
						</div>
						<div class="form-btn" style="text-align: center;">
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#slot-info"
								style="margin-top: 5%; width: 175px" onclick="checkStatus(`+element.tableID+`)">
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