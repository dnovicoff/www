

function getAJAX(file)  {
 	$('#quotescenter').html("");
 	$('#overlay').css("visibility","hidden");

	$.ajax({
		type:"GET",
		url:"./upland-homeinc/"+file,
		success:function (data)  {}
	});
}

function postAJAX()  {

}

function getPage(file)  {
	window.location.href = file;
}

function setElementHeight(element,direction,amount)  {
	var htmlheight = document.body.parentNode.clientHeight-600; 
	var frame = document.getElementById(element); 
	if (direction=="+")  {
		frame.style.height = amount + "px";
	}

	alert($(window).width());
}


