$(document).ready(function () {
	loadTimings();
});

function loadTimings() {
	$.ajax({
		url: "settings/loadTimings.php",
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function (data) {
			data = JSON.parse(data);
			// restaurant timmings
			$('#hotelStartTime').val(data.startTime);
			$('#hotelEndTime').val(data.endTime);
			
			// buffer times
			var bufferTime = data.bufferTime;
			var min = Math.floor(bufferTime/60);
			$('#min').val(min);
			var sec = bufferTime%60;
			$('#sec').val(sec);
		}
	});
}

$('#timing').click(function () {
	var hotelStartTime = $('#hotelStartTime').val();
	var hotelEndTime = $('#hotelEndTime').val();
	var formdata = new FormData;
	formdata.append('hotelStartTime', hotelStartTime);
	formdata.append('hotelEndTime', hotelEndTime);
	$.ajax({
		type: "POST",
		data: formdata,
		url: "settings/timings.php",
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function (data) {
			console.log(data);
			loadTimings();
		}
	});

});

$('#bufferTime').click(function () {
	var min = parseInt($('#min').val());
	var sec = parseInt($('#sec').val());
	var totalSec = min*60 + sec;
	var formdata = new FormData;
	formdata.append('bufferTime', totalSec);
	$.ajax({
		type: "POST",
		data: formdata,
		url: "settings/buffer.php",
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function (data) {
			console.log(data);
			loadTimings();
		}
	});
});