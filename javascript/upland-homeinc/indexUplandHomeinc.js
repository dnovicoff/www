

function getAJAXLocal(button)  {
	alert("What do you want to do from here "+button);
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}


$(document).ready(function ()  {
	$("[id^=home]").click(function(data)  {
		getPage("index.html");
	});
	$("[id^=about]").click(function(data)  {
		getAJAX("about.xml");
	});
	$("[id^=communities]").click(function(data)  {
		getAJAX("communities.xml");
	});
	$("[id^=photo]").click(function(data)  {
		getAJAX("gallery.xml");
	});
	$("[id^=ready]").click(function(data)  {
		getAJAX("specs.xml");
	});
	$("[id^=contact]").click(function(data)  {
		getAJAX("contact.xml");
	});

	$("[id^=menu]").click(function(data)  {
		var name = $(this).attr("name");
		var id = $(this).attr("id");
		var newName = name.replace(/:/g,"\/");

		/** p7defmark  **/
		/** p7plusmark  **/
		$("[id^=menu]").removeAttr('style');
		$(this).css("background-color","#c29d4d");
		$(this).css("font-weight","bold");
		getAJAX(newName);
	});

	MM_preloadImages('/img/upland-homeinc/butt_Home_f2.gif',
                        '/img/upland-homeinc/butt_about_f2.gif',
                        '/img/upland-homeinc/butt_comm_f2.gif',
                        '/img/upland-homeinc/butt_photo_f2.gif',
                        '/img/upland-homeinc/butt_homes_f2.gif',
                        '/img/upland-homeinc/butt_contact_f2.gif');
	P7_TMclass();
	getAJAX("home.xml");

	alert($(window).width());
});
