$('#checkIn').click(function() {
	var bookingID = $('#bookingID').text();
    var formdata = new FormData();
    formdata.append('bookingID', bookingID);
    
    $.ajax({
		type: "POST",
		data: formdata,
		url: "timetable/checkIN.php",
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function(data) {
			console.log(data);
			loadTT();
			$('#checkIn').hide();
			$('#cancel').hide();
			$('#checkOut').show();
		}
	});
});

$('#checkOut').click(function() {
	var bookingID = $('#bookingID').text();
    var formdata = new FormData();
    formdata.append('bookingID', bookingID);

    $.ajax({
		type: "POST",
		data: formdata,
		url: "timetable/checkOUT.php",
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function(data) {
			console.log(data);
			loadTT();
			$('#reservationModal').modal('toggle');
		}
	});

});

$('#extend').click(function() {
	var bookingID = $('#bookingID').text();
    var formdata = new FormData();
	formdata.append('bookingID', bookingID);
	
	$.ajax({
		type: "POST",
		data: formdata,
		url: "timetable/extendReservation.php",
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function(data) {
			console.log(data);
			loadTT();
			//$('#reservationModal').modal('toggle');
		}
	});
});

$('#cancel').click(function() {
	var bookingID = $('#bookingID').text();
    var formdata = new FormData();
    formdata.append('bookingID', bookingID);
    
    $.ajax({
		type: "POST",
		data: formdata,
		url: "timetable/cancelTable.php",
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function(data) {
			console.log(data);
			loadTT();
			$('#reservationModal').modal('toggle');
		}
	});
});