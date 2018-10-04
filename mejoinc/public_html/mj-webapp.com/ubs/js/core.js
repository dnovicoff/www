$(document).ready(function(){
	//	Reset Balances
	$('#resetall').click(function() {
		$('#lot-balances').find(':input').each(function() {
			switch(this.type) {
				case 'text':
				$(this).val('0.00');
				break;
			}
		});
	});


	//	Bug Reporter
	var $dialog = $('#bugForm').dialog({ autoOpen: false, modal: true, height: 306, width: 600, title: 'Report A Bug', resizable: false });
	$('#bugLink').click(function() {
		$dialog.dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});
	
	//	Date pickers
	$('#record-date').datepicker();
	$('#read-date').datepicker();
	$('#bill-date').datepicker();
	$('#due-date').datepicker();
	//	UI
	$('#rate-example-link').click(function() { $("#rate-examples").show('blind');  setTimeout(function(){ $("#rate-examples:visible").removeAttr('style').hide().fadeOut(); }, 50000); });
	
	//	Form validation
	$("#park-information").validate({
		rules:	{
			name: "required",
			address: "required",
			city: "required",
			state: {
				required:true,
				minlength:2,
				maxlength:2
			},
			zip: {
				required:true,
				digits:true,
				minlength:5
			},
			unit: "required",
			taxrate: "required",
			taxwater: "required",
			taxsewer: "required",
			admin: {
				required:true,
				number:true
			},
			service: {
				required:true,
				number:true
			},
			fuel: {
				required:true,
				number:true
			}
		},
		messages:	{
			name: "Please enter a Park Name",
			address: "Please enter an address",
			city: "Please enter a city",
			state:	{
				required: "Please enter a state",
				minlength: "State must be longer than 2 characters",
				maxlength: "State cannot be longer than 2 characters"
			},
			zip:	{
				required: "Please enter a zip code",
				digits: "This field must be a number",
				minlength: "Zip codes must be at least 5 digits long"
			},
			unit: "Please select a billing unit",
			taxrate: "Please select a tax rate",
			taxwater: "Please choose whether or not to tax water",
			taxsewer: "Please choose whether or not to tax sewer",
			admin:	{
				required: "This field is required",
				number: "This field must be a number",
			},
			service:{
				required: "This field is required",
				number: "This field must be a number",
			},
			fuel:	{
				required: "This field is required",
				number: "This field must be a number",
			}
		}
	});	
	
	$("#lot-information").validate({
		rules:	{
			lot: "required",
			vacant: "required",
			tenant: "required",
			state: {
				minlength:2,
				maxlength:2
			},
			zip: {
				digits:true,
				minlength:5
			},
			chargewater: "required",
			chargesewer: "required",
			rent: {
				required:true,
				number:true
			},
			pet: {
				required:true,
				number:true
			},
			person: {
				required:true,
				number:true
			},
			vehicle: {
				required:true,
				number:true
			},
			lease: {
				required:true,
				number:true
			}
		},
		messages:	{
			lot: "Please enter a lot number",
			vacant: "Please select a vacancy",
			name: "Please enter a tenant",
			state:	{
				required: "Please enter a state",
				minlength: "State must be longer than 2 characters",
				maxlength: "State cannot be longer than 2 characters"
			},
			zip:	{
				required: "Please enter a zip code",
				digits: "This field must be a number",
				minlength: "Zip codes must be at least 5 digits long"
			},
			taxwater: "Please choose whether or not to charge for water",
			taxsewer: "Please choose whether or not to charge for sewer",
			admin:	{
				required: "This field is required",
				number: "This field must be a number",
			},
			rent:{
				required: "This field is required",
				number: "This field must be a number",
			},
			pet:	{
				required: "This field is required",
				number: "This field must be a number",
			},
			person:	{
				required: "This field is required",
				number: "This field must be a number",
			},
			vehicle:{
				required: "This field is required",
				number: "This field must be a number",
			},
			lease:	{
				required: "This field is required",
				number: "This field must be a number",
			}
		}
	});	
});