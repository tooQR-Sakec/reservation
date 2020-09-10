$("#reserveTableForm").submit(reserveTable);
$("#reserveStatusForm").submit(reserveStatusButton);

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
				console.log("Reserved!");
			} else {
				console.log("Sorry! All the tables have been booked!");
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
					<div class="row">
							<div class="col-md-12">
								<div class="row mb-2" style="margin-left: 2px; font-weight: bold;">Name: `+element.guestName+`<span id="gName"></span></div>
								<div class="row mb-2" style="margin-left: 2px; font-weight: bold;">No of People:<span id="gNoPeople"> `+element.numberOfPeople+`</span></div>
								<div class="row mb-2" style="margin-left: 2px; font-weight: bold;">Date: `+element.date+`<span id="gDate"></span></div>
								<div class="row mb-2" style="margin-left: 2px; font-weight: bold;">Time Slot: `+element.slot+`<span id="gTime"></span></div>`;
					if(element.roomID) {
						html += 
								`<div class="row mb-2" style="margin-left: 2px; font-weight: bold;">Room No: `+element.roomID+`<span id="gRoom"></span></div>`;
					}
					html +=
								`<button class="btn btn-secondary" onclick="cancelBooking('`+statusEmail+`', '`+element.date+`', '`+element.slot+`')">Cancel Booking</button>
							</div>
						</div>`;
					document.getElementById('reservationStatus').innerHTML = html;
				});
			} else {
				console.log("No Reservations!");
			}
		},
		//Other options
	});
}