/* var timetable = new Timetable();

timetable.setScope(0, 23);
timetable.useTwelveHour();

timetable.addLocations(['Table 1', 'Table 2', 'Table 3', 'Table 4', 'Table 5', 'Table 6', 'Table 7']);

timetable.addEvent('Booking ID: 9367', 'Table 1', new Date(2015, 7, 17, 9, 00), new Date(2015, 7, 17, 10, 00), { url: '#' });
timetable.addEvent('Booking ID: 2387', 'Table 2', new Date(2015, 7, 17, 12), new Date(2015, 7, 17, 13), { url: '#' });
timetable.addEvent('Booking ID: 7483', 'Table 2', new Date(2015, 7, 17, 13), new Date(2015, 7, 17, 14), { url: '#' });
timetable.addEvent('Booking ID: 2093', 'Table 3', new Date(2015, 7, 17, 17), new Date(2015, 7, 17, 18));
timetable.addEvent('Booking ID: 8367', 'Table 4', new Date(2015, 7, 17, 4), new Date(2015, 7, 17, 5), { url: '#' });
timetable.addEvent('Booking ID: 3452', 'Table 5', new Date(2015, 7, 17, 11), new Date(2015, 7, 17, 12)); // options attribute is not used for this event
timetable.addEvent('Booking ID:1342', 'Table 6', new Date(2015, 7, 17, 22), new Date(2015, 7, 17, 23)); // options attribute is not used for this event
timetable.addEvent('Booking ID: 2345', 'Table 7', new Date(2015, 7, 17, 9), new Date(2015, 7, 17, 10), {
	onClick: function (event) {
		window.alert('You clicked on the ' + event.name + ' event in ' + event.location + '. This is an example of a click handler');
	}
});

timetable.addEvent('Booking ID:1234', 'Table 1', new Date(2015, 7, 18, 00, 00), new Date(2015, 7, 18, 01, 00));

var renderer = new Timetable.Renderer(timetable);
renderer.draw('.timetable'); */
$(document).ready(function () {
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear() + "-" + (month) + "-" + (day);
	$('#date').val(today);

	loadTT();
});

$('#date').change( function() {
	loadTT();
});

function loadTT() {
	var date = new Date($('#date').val()+" ").valueOf()/1000;
	var formdata = new FormData();
	formdata.append('date', date);

	$.ajax({
		type: "POST",
		data: formdata,
		url: "timetable/fetchTables.php",
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function (data) {
			var timetable = new Timetable();
			var tableHeadings = [];
			timetable.setScope(0, 24);
			if(data) {
				data = JSON.parse(data);

				// load table headings
				data["allTables"].forEach(element => {
					var tableID = "Table " + element;
					tableHeadings.push(tableID);
				});
				timetable.addLocations(tableHeadings);

				// load table
				if(data["bookedTables"]) {
					data["bookedTables"].forEach(element => {
						var eventClass = element.status + "Event";
						var table = "Table " + element.tableID;
						timetable.addEvent(element.guestName, table, new Date(element.startTime*1000), new Date(element.endTime*1000), {
							class: eventClass,
							onClick: function (event) {
								$('#reservationModal').modal('show');
									$('#checkIn').hide();
									$('#checkOut').hide();
									$('#cancel').hide();
									$('#extend').hide();
								if(element.status == "checkedIn") {
									$('#checkOut').show();
									$('#extend').show();
								} else if(element.status == "reserved") {
									$('#checkIn').show();
									$('#cancel').show();
									$('#extend').show();
								}
								var html = `
								<table class="table table-bordered">
							<tbody>
								<tr>
									<th scope="row">Booking</th>
									<td id="bookingID">`+ element.bookingID + `</td>
								</tr>
								<tr>
									<th scope="row">Name</th>
									<td>`+ element.guestName + `</td>
								</tr>
								<tr>
									<th scope="row">Mobile</th>
									<td>`+ element.guestMobile + `</td>
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
								$('#reservationStatus').html(html);
							}
						});
					});
				}
			}
			var renderer = new Timetable.Renderer(timetable);
			renderer.draw('.timetable');
		}
	});
}