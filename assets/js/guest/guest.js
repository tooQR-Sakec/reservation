$(document).ready(function () {
	loadSlots();
});

$("#reserveTableForm").submit(reserveTable);
$("#reserveStatusForm").submit(reserveStatusButton);

function loadSlots() {
	$.ajax({
		url: "loadSlots.php",
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function (data) {
			data = JSON.parse(data);
			var guestSlot = document.getElementById('guestSlot');
			data.forEach(element => {
				guestSlot.options[guestSlot.options.length] = new Option(element.time, element.slot);
			});
		},
		//Other options
	});
}

function reserveTable(event) {
	event.preventDefault();

	var guestName = $('#guestName').val();
	var guestEmail = $('#guestEmail').val();
	var guestCapacity = $('#guestCapacity').val();
	var guestDate = $('#guestDate').val();
	var guestSlot = $('#guestSlot').val();
	var roomID = $('#guestRoomId').val();

	var formdata = new FormData();
	formdata.append("guestName", guestName);
	formdata.append("guestEmail", guestEmail);
	formdata.append("guestCapacity", guestCapacity);
	formdata.append("guestDate", guestDate);
	formdata.append("guestSlot", guestSlot);
	formdata.append("roomID", roomID);

	$.ajax({
		type: "POST",
		url: "reserveTable.php",
		data: formdata,
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function (data) {
			console.log(data);
			if(data != "full") {
				document.getElementById("bookingStatus").innerHTML = "Reserved!";
			} else {
				document.getElementById("bookingStatus").innerHTML = "Sorry! All the tables have been booked!";
			}
		},
		//Other options
	});
}

function cancelBooking(guestEmail, date, slot){
	var formdata = new FormData();
	formdata.append('guestEmail', guestEmail);
	formdata.append('date', date);
	formdata.append('slot', slot);

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
			if(data) {
				data = JSON.parse(data);
				data.forEach(element => {
					html += `
					<table class="table table-bordered">
						<tbody>
							<tr>
								<th scope="row">Name</th>
								<td>`+element.guestName+`</td>
							</tr>
							<tr>
								<th scope="row">No of people</th>
								<td>`+element.numberOfPeople+`</td>
							</tr>
							<tr>
								<th scope="row">Date</th>
								<td>`+element.date+`</td>
							</tr>
							<tr>
								<th scope="row">Time Slot</th>
								<td>`+element.slot+`</td>
							</tr>`;
					if(element.roomID) {
						html +=  `
							<tr>
								<th scope="row">Room no</th>
								<td>`+element.roomID+`</td>
							</tr>`;
					}
					html +=`
							<tr>
								<td colspan="2">
									<button class="btn btn-secondary" onclick="cancelBooking('`+statusEmail+`', '`+element.date+`', '`+element.slot+`')">
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