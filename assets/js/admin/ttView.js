$('#checkIn').click(function() {
	var guestEmail = $('#guestEmail').text();
    var startTime = Date.parse($('#startTime').text())/1000;
    var formdata = new FormData();
    formdata.append('guestEmail', guestEmail);
    formdata.append('startTime', startTime);
    
    $.ajax({
		type: "POST",
		data: formdata,
		url: "timetable/checkIN.php",
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function(data) {
			console.log(data);
			loadTT();
			$('#reservationModal').modal('toggle');
		}
	});
});

$('#checkOut').click(function() {
	var guestEmail = $('#guestEmail').text();
    var startTime = Date.parse($('#startTime').text())/1000;
    var formdata = new FormData();
    formdata.append('guestEmail', guestEmail);
    formdata.append('startTime', startTime);

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
	var guestEmail = $('#guestEmail').text();
    var startTime = Date.parse($('#startTime').text())/1000;
});