

function validateSelect(fld)  {
	var regEx = /(Choose)$/;
	var str = fld.value;

	if (str.match(regEx))  {
		$('#div'+fld.name).html("Please select type of service");
		return "fail";
	}
	return "";
}

function validateEmail(fld)  {
	var regEx = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	var str = fld.value;

	if (!str.match(regEx))  {
		$('#div'+fld.name).html("Email address is of incorrect form");
		return "fail";
	}
	return "";
}

function validatePhone(fld)  {
	var regEx = /\d{3}-\d{3}-\d{4}/;
	var str = fld.value;

	if (!str.match(regEx))  {
		$('#div'+fld.name).html("Phone number does not match ###-###-####");
		return "fail";
	}
	return "";
}

function validateCompanyName(fld)  {
	var regEx = /\w+/;
	var str = fld.value;

	if (!str.match(regEx))  {
		$('#div'+fld.name).html("Company name cannot be blank");
		return "fail";
	}
	return "";
}

function validateName(fld)  {
	var regEx = /\D+/;
	var str = fld.value;

	if (!str.match(regEx))  {
		$('#div'+fld.name).html("Name field cannot be blank");
		return "fail";
	}
	return "";
}

function validateForm(theForm)  {
	var reason = "";

	reason += validateName(theForm.contactFirstName);
	reason += validateName(theForm.contactLastName);
	reason += validateCompanyName(theForm.contactCompanyName);
	reason += validatePhone(theForm.contactCompanyPhone);
	reason += validateEmail(theForm.contactEmail);
	reason += validateSelect(theForm.contactSelectService);

	if (reason != "")  {
		alert("Your form has errors. \nPlease correct the fields marked in red.");
		return false;
	}
	return true;
}

function getFile(file)  {
        $.get('./executive-cleaning-solutions/'+file, function (data)  {
       	});
}

function getAJAX(file)  {
	$('#quotecenterleft').html("");
	$('#quotecenterright').html("");

	var patt = /^(services|contact|about|sitemap|footer|careers)(\w+)/;
	var tail = file;
	if (tail.match(patt))  {
		var regex = RegExp.$1;
		var nFile = RegExp.$1+"/"+RegExp.$2+".xml";
		if (file == "footerSitemap")  {
			nFile = "about/Sitemap.xml";
		}
		if (file == "footerContactUs")  {
			nFile = "contact/ContactUs.xml";
		}
		if (file == "footerCareers")  {
			nFile = "careers/Careers.xml";
		}
		if (file == "footerHome")  {
			window.location = "http://www.executive-cleaning-solutions.com/";
		}
		getFile(nFile);
	}
}

$(document).ready(function ()  {
	$('.nav').click(function (data)   {
		getAJAX($(this).attr("id"));
	});

	getFile("main.xml");
});
