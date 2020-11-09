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
			$('#sundayStartTime').val(data.sundayStart);
			$('#sundayEndTime').val(data.sundayEnd);
			$('#mondayStartTime').val(data.mondayStart);
			$('#mondayEndTime').val(data.mondayEnd);
			$('#tuesdayStartTime').val(data.tuesdayStart);
			$('#tuesdayEndTime').val(data.tuesdayEnd);
			$('#wednesdayStartTime').val(data.wednesdayStart);
			$('#wednesdayEndTime').val(data.wednesdayEnd);
			$('#thursdayStartTime').val(data.thursdayStart);
			$('#thursdayEndTime').val(data.thursdayEnd);
			$('#fridayStartTime').val(data.fridayStart);
			$('#fridayEndTime').val(data.fridayEnd);
			$('#saturdayStartTime').val(data.saturdayStart);
			$('#saturdayEndTime').val(data.saturdayEnd);
			//Extend Ducation
			$('#extendMin').val(Math.floor(data.extendDuration/60));
			// buffer times
			var bufferTime = data.bufferTime;
			var min = Math.floor(bufferTime/60);
			$('#bufferMin').val(min);
			var sec = bufferTime%60;
			$('#bufferSec').val(sec);
			//booking Limit
			$('#bLimitDay').val(data.bookingPerDay);
			//foodType
			$('#breakfast').val(data.breakfast/60);
			$('#lunch').val(data.lunch/60);
			$('#dinner').val(data.dinner/60);
		}
	});
}

$('#timing').click(function () {
	var sundayStartTime = $('#sundayStartTime').val();
	var sundayEndTime = $('#sundayEndTime').val();
	var mondayStartTime = $('#mondayStartTime').val();
	var mondayEndTime = $('#mondayEndTime').val();
	var tuesdayStartTime = $('#tuesdayStartTime').val();
	var tuesdayEndTime = $('#tuesdayEndTime').val();
	var wednesdayStartTime = $('#wednesdayStartTime').val();
	var wednesdayEndTime = $('#wednesdayEndTime').val();
	var thursdayStartTime = $('#thursdayStartTime').val();
	var thursdayEndTime = $('#thursdayEndTime').val();
	var fridayStartTime = $('#fridayStartTime').val();
	var fridayEndTime = $('#fridayEndTime').val();
	var saturdayStartTime = $('#saturdayStartTime').val();
	var saturdayEndTime = $('#saturdayEndTime').val();
	var formdata = new FormData;
	console.log(sundayStartTime);
	formdata.append('sundayStartTime', sundayStartTime);
	formdata.append('sundayEndTime', sundayEndTime);
	formdata.append('mondayStartTime', mondayStartTime);
	formdata.append('mondayEndTime', mondayEndTime);
	formdata.append('tuesdayStartTime', tuesdayStartTime);
	formdata.append('tuesdayEndTime', tuesdayEndTime);
	formdata.append('wednesdayStartTime', wednesdayStartTime);
	formdata.append('wednesdayEndTime', wednesdayEndTime);
	formdata.append('thursdayStartTime', thursdayStartTime);
	formdata.append('thursdayEndTime', thursdayEndTime);
	formdata.append('fridayStartTime', fridayStartTime);
	formdata.append('fridayEndTime', fridayEndTime);
	formdata.append('saturdayStartTime', saturdayStartTime);
	formdata.append('saturdayEndTime', saturdayEndTime);
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

$('#extendDuration').click(function () {
	var min = parseInt($('#extendMin').val());
	var totalSec = min*60;
	var formdata = new FormData;
	formdata.append('extendDuration', totalSec);
	$.ajax({
		type: "POST",
		data: formdata,
		url: "settings/extendDuration.php",
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function (data) {
			console.log(data);
			loadTimings();
		}
	});
});

$('#bufferTime').click(function () {
	var min = parseInt($('#bufferMin').val());
	var sec = parseInt($('#bufferSec').val());
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


$('#bookingLimit').click(function(){
	var bLimitDay = $('#bLimitDay').val();
	var formdata = new FormData;
	formdata.append('bLimitDay', bLimitDay);
	$.ajax({
		type: "POST",
		data: formdata,
		url: "settings/bookLimit.php",
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function (data) {
			console.log(data);
			loadTimings();
		}
	});

});

$('#bookingDuration').click(function(){
	var breakfast = parseInt($('#breakfast').val())*60;
	var lunch = parseInt($('#lunch').val())*60;
	var dinner = parseInt($('#dinner').val())*60;
	var formdata = new FormData;
	formdata.append('breakfast', breakfast);
	formdata.append('lunch', lunch);
	formdata.append('dinner', dinner);
	$.ajax({
		type: "POST",
		data: formdata,
		url: "settings/bookDuration.php",
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function (data) {
			console.log(data);
			loadTimings();
		}
	});

});