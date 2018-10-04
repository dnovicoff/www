
var roundRobinCount = 0;

function openModal(obj)  {
	var winWidth = window.innerWidth;
	var percentage = 0;
	var remainder = 0;
	var windHalf = 0;
	var divWidth = 0;

	$.get('./home/'+obj.id+'.xml', function (data)  {
		divWidth = $('.overlaypage').innerWidth();
		remainder = winWidth-divWidth;
		
		windHalf = Math.floor(((remainder/winWidth)*100)/2);
		percentage = Math.floor(Math.ceil(divWidth)/Math.ceil(winWidth));
	});

	$('#overlay').css("visibility","visible");
	$('#unblockUIClose').click(function () {
		$('#overlayPageTitle').html("");
		$('#overlayPage').html("");
		$('#overlay').css("visibility","hidden");
		$.unblockUI();
	});
	$.blockUI({
		message:$('.overlay'),
		css:{
			top:'10%',
			left:'15%',
			width:'70%'
		}
	});
}

function roundRobin(doc)  {
	roundRobinCount++;
	var xmlString = (new XMLSerializer()).serializeToString(doc);
	var children = $('#quotesleft').children();

	children.first().before(xmlString);
	if (roundRobinCount > 10)  {
		children.last().remove();
	}
}

function whoami(you)  {
	var ip = you.IP;
	var ver = you.version;
	var os = you.OS;
	var browser = you.browser;
	var cookie = you.cookie;
	var java = you.java;

	var html =	"<br />"+
			"<div class=\"raisedBox\">"+
			"<div style=\"padding:1%\">"+
			"IP: "+ip+"<br />"+
			"OS: "+os+"<br />"+
			"Version: "+ver+"<br />"+
			"Browser: "+browser+"<br />"+
			"Cookie Enabled: "+cookie+"<br />"+
			"Java Enabled: "+java+"<br />"+
			"</div>"+
			"</div>"+
			"<br />";

	$.post("/home/track.php", { browser: ""+browser, cookie: ""+cookie, java: ""+java, os: ""+os, version: ""+ver }, function (data)  {
	},"text");
}

function whoami2(you,file)  {
	var cookie = you.cookie;
	var java = you.java;

 	$.get('./'+file, { c:""+cookie,java:""+java }, function (data)  {
		var xmlString = (new XMLSerializer()).serializeToString(data);
		$('#quotescenter').html(xmlString);
       	});
}

function showColorbox(file)  {
	$('.resultsImgNav').colorbox({rel:'overlaytest',href:''+file,width:'75%'});
}

function getFile(patt,file)  {
 	$('#quotescenter').html("");

	$.ajax({
		type:"POST",
		url:"./home/"+file,
		success:function (data)  {
			if (patt == "header")  {
 				$('.resultsImgNav').css('cursor','pointer');
 				$('.resultsImgNav').css('cursor','hand');
				$('.resultsImgNav').click(function (data)  {
					var file = "./home/"+$(this).attr('id')+".xml";
					showColorbox(file);
				});
			}
		}
	});

	$("body").height(screen.height);
}

function getAJAX(file)  {
 	$('#overlay').css("visibility","hidden");

	var patt = /^(header|footer)(\w+)/;
	var tail = file;
	if (tail.match(patt))  {
		var nFile = RegExp.$2+".xml";
		getFile(RegExp.$1,nFile);
	}
}

$(document).ready(function ()  {
	BrowserDetect.init();
	$('.nav').click(function (data)  {
		var file = $(this).attr("id");
		getAJAX(file);
	});

	$('#test').click(function (data)  {
		whoami2(BrowserDetect,"cgi-bin/whoami.cgi");
	});

	/*  whoami(BrowserDetect);  */

	getFile("none","main.xml");
});
