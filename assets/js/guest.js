$("#reserveTableForm").submit(reserveTable);

function reserveTable(event) {
	event.preventDefault();

	var guestName = $('#guestName').val();
	var guestEmail = $('#guestEmail').val();
	var guestCapacity = $('#guestCapacity').val();
	var guestDate = $('#guestDate').val();
	var guestSlot = $('#guestSlot').val();

	console.log(guestName);
	console.log(guestEmail);
	console.log(guestCapacity);
	console.log(guestDate);
	console.log(guestSlot);
}