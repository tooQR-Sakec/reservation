$(document).ready(function () {
	$("#reserveTableForm").submit(reserveTable);
	$("#reserveStatusForm").submit(reserveStatusButton);
});

function reserveTable(event) {
	event.preventDefault();

	var guestName = $('#guestName').val();
	var guestEmail = $('#guestEmail').val();
	var guestCapacity = $('#guestCapacity').val();
	var guestStartTime = Date.parse($('#guestDateTime').val()) / 1000;
	var guestFoodType = parseInt($('#guestFoodType').val());
	var roomID = $('#guestRoomId').val();
	var guestEndTime = guestStartTime;
	switch (guestFoodType) {
		case 1: guestEndTime += 60 * 60; //breakfast 60 minutes
			break;
		case 2: guestEndTime += 60 * 90; //lunch 90 minutes
			break;
		case 3: guestEndTime += 60 * 120; //dinner 2 hours
			break;
	}

	var formdata = new FormData();
	formdata.append("guestName", guestName);
	formdata.append("guestEmail", guestEmail);
	formdata.append("guestCapacity", guestCapacity);
	formdata.append("guestStartTime", guestStartTime);
	formdata.append("guestEndTime", guestEndTime);
	formdata.append("roomID", roomID);

	$.ajax({
		type: "POST",
		url: "reserveTable.php",
		data: formdata,
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function (data) {
			console.log(data);
			if(data == "full") {
				document.getElementById("bookingStatus").innerHTML = "Sorry! All the tables have been booked!";
			} else if(data == "Closed"){
				document.getElementById("bookingStatus").innerHTML = "Closed!";
			} else {
				document.getElementById("bookingStatus").innerHTML = "Reserved!";
			}
		},
		//Other options
	});
}

function cancelBooking(guestEmail, startTime) {
	var formdata = new FormData();
	formdata.append('guestEmail', guestEmail);
	formdata.append('startTime', startTime);

	$.ajax({
		type: "POST",
		url: "cancelBooking.php",
		data: formdata,
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function (data) {
			reserveStatus();
		},
		//Other options
	});
}

function clearStatusModal() {
	$('#reservationStatus').html('');
	$('#statusModal').find('form').trigger('reset');
}

function reserveStatusButton(event) {
	event.preventDefault();
	reserveStatus();
}

function reserveStatus() {
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
			var html = '';
			if (data) {
				data = JSON.parse(data);
				data.forEach(element => {
					html += `
					<table class="table table-bordered">
						<tbody>
							<tr>
								<th scope="row">Name</th>
								<td>`+ element.guestName + `</td>
							</tr>
							<tr>
								<th scope="row">No of people</th>
								<td>`+ element.numberOfPeople + `</td>
							</tr>
							<tr>
								<th scope="row">From</th>
								<td>`+ new Date(parseInt(element.startTime)*1000) + `</td>
							</tr>
							<tr>
								<th scope="row">To</th>
								<td>`+ new Date(parseInt(element.endTime)*1000) + `</td>
							</tr>`;
					if (element.roomID) {
						html += `
							<tr>
								<th scope="row">Room no</th>
								<td>`+ element.roomID + `</td>
							</tr>`;
					}
					html += `
							<tr>
								<td colspan="2">
									<button class="btn btn-secondary" onclick="cancelBooking('`+ statusEmail + `', '` + element.startTime + `')">
										Cancel Booking
									</button>
								</td>
							</tr>
						</tbody>
					</table>`;
					document.getElementById('reservationStatus').innerHTML = html;
				});
			} else {
				html += `
				<div class="row">
					<div class="col-md-12">
						<div class="row mb-2" style="margin-left: 2px; font-weight: bold;">No Reservations</div>
					</div>
				</div>`;
				document.getElementById('reservationStatus').innerHTML = html;
			}
		},
		//Other options
	});
}