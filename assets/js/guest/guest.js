$("#reserveTableForm").submit(reserveTable);
$("#reserveStatusForm").submit(reserveStatus);

function reserveTable(event) {
	event.preventDefault();

	var guestName = $('#guestName').val();
	var guestEmail = $('#guestEmail').val();
	var guestCapacity = $('#guestCapacity').val();
	var guestDate = $('#guestDate').val();
	var guestSlot = $('#guestSlot').val();

	var formdata = new FormData();
	formdata.append("guestName", guestName);
	formdata.append("guestEmail", guestEmail);
	formdata.append("guestCapacity", guestCapacity);
	formdata.append("guestDate", guestDate);
	formdata.append("guestSlot", guestSlot);

	$.ajax({
		type: "POST",
		url: "reserveTable.php",
		data: formdata,
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function (data) {
			console.log(data);
		},
		//Other options
	});
}

function reserveStatus(event) {
	event.preventDefault();

	var statusName = $('#statusName').val();
	var statusEmail = $('#statusEmail').val();

	var formdata = new FormData();
	formdata.append("statusName", statusName);
	formdata.append("statusEmail", statusEmail);

	$.ajax({
		type: "POST",
		url: "checkStatus.php",
		data: formdata,
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function (data) {
			console.log(data);
		},
		//Other options
	});
}