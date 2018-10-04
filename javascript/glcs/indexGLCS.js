

$(document).ready(function ()  {
	$('#home').click(function(data)  {
		getAJAX("main.xml");
	});
	$('#services').click(function(data)  {
		getAJAX("services.xml");
	});
	$('#benefits').click(function(data)  {
		getAJAX("benefits.xml");
	});
	$('#contact').click(function(data)  {
		getAJAX("contact.xml");
	});
	$('#about').click(function(data)  {
		getAJAX("about.xml");
	});

	getAJAX("main.xml");
});
