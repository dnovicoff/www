

function getLatLong(address,pos){
      var geo = new google.maps.Geocoder();

      geo.geocode({'address':address},function(results, status){
              if (status == google.maps.GeocoderStatus.OK) {
		var LL = results[0].geometry.location;
		var latt = LL.lat();
		var long = LL.lng();
		$.get("/smartbusrouteinsert.php",{ lat : latt,long : long,id : pos  },  function (data)  {
			$('#lat'+pos).html(latt);
			$('#long'+pos).html(long);
		});
                return results[0].geometry.location;
              }
       });
  }


function getStops()  {
	var i=0;
	$('[id^="stop"]').each($).wait(10000,function( index ) {
		getLatLong($(this).text(),i);
		i++;
	});

}


