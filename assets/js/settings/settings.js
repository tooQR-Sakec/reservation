$('#timing').click(function(){
    var hotelStartTime= $('#hotelStartTime').val();
    var hotelEndTime= $('#hotelEndTime').val();
    var formdata= new FormData;
    formdata.append('hotelStartTime',hotelStartTime);
    formdata.append('hotelEndTime',hotelEndTime);
    $.ajax({
		type: "POST",
		data: formdata,
		url: "settings/timings.php",
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function(data) {
			console.log(data);
			
		}
	});
    
});

$('#bufferTime').click(function(){
    var buffer = $('#buffer').val();
    var formdata = new FormData;
    formdata.append('buffer',buffer);
    $.ajax({
		type: "POST",
		data: formdata,
		url: "settings/buffer.php",
		contentType: false, // Dont delete this (jQuery 1.6+)
		processData: false, // Dont delete this
		success: function(data) {
			console.log(data);
			
		}
	});
});