<!DOCTYPE html>
<html>
<head>
	<title>Leaflet debug page</title>

	<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.6.2/leaflet.css" />
	<!--[if lte IE 8]><link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.6.2/leaflet.ie.css" /><![endif]-->
	<script src="http://cdn.leafletjs.com/leaflet-0.6.2/leaflet.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="stylesheet" href="css/mobile.css" />

	<link rel="stylesheet" href="css/MarkerCluster.css" />
	<link rel="stylesheet" href="css/MarkerCluster.Default.css" />
	<!--[if lte IE 8]><link rel="stylesheet" href="css/MarkerCluster.Default.ie.css" /><![endif]-->
	<script src="js/leaflet.markercluster-src.js"></script>
	
	<link rel="stylesheet" href="css/style.css" />
	
	<script src="http://maps.google.co.in/maps/api/js?v=3.exp&sensor=false"></script>
    <script src="http://matchingnotes.com/javascripts/leaflet-google.js"></script>
	
</head>
<body>

	<div id="map"></div>


	<?php 

$con=mysqli_connect("localhost","root","toor","clg");

if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }


echo "<script>

var yyn,yyad,yyweb,yylt,yyln,yypr,yyms,yymd,yybs;
var i,ttle;
var arrad=[];
var arrweb=[]
var arrn=[];
var arrlt=[];
var arrln=[];
var arrp=[];
var arrms=[];
var arrmd=[];
var arrbs=[];

</script>";


$lat=array();
$read=mysqli_query($con,"select * from clg");
while($row=mysqli_fetch_array($read)){

$lat[]=$row['Latitude'];

}


$rname=mysqli_query($con,"select Name from clg");
$rad=mysqli_query($con,"select Address from clg");
$rweb=mysqli_query($con,"select Website from clg");
$rlt=mysqli_query($con,"select Latitude from clg");
$rln=mysqli_query($con,"select Longitude from clg");
$rp=mysqli_query($con,"select Principal from clg");
$rms=mysqli_query($con,"select metrostn from clg");
$rmd=mysqli_query($con,"select metrod from clg");
$rbs=mysqli_query($con,"select bussp from clg");
$i=0;

while($rrname=mysqli_fetch_array($rname))
{
$rrlt=mysqli_fetch_array($rlt);
$rrln=mysqli_fetch_array($rln);
$rrad=mysqli_fetch_array($rad);
$rrweb=mysqli_fetch_array($rweb);
$rrp=mysqli_fetch_array($rp);
$rrms=mysqli_fetch_array($rms);
$rrmd=mysqli_fetch_array($rmd);
$rrbs=mysqli_fetch_array($rbs);
$test=0;

$tmpn=$rrname['Name'];
$tmpad=$rrad['Address'];
$tmpweb=$rrweb['Website'];
$tmplt=$rrlt['Latitude'];
$tmpln=$rrln['Longitude'];
$tmppr=$rrp['Principal'];
$tmpms=$rrms['metrostn'];
$tmpmd=$rrmd['metrod'];
$tmpbs=$rrbs['bussp'];



echo "<script> 
yyn=\"$tmpn\";
yyad=\"$tmpad\";
yyweb=\"$tmpweb\";
yylt=$tmplt;
yyln=$tmpln;
yypr=\"$tmppr\";
yyms=\"$tmpms\";
yymd=$tmpmd;
yybs=\"$tmpbs\";

arrn.push(yyn);
arrad.push(yyad);
arrweb.push(yyweb);
arrlt.push(yylt);
arrln.push(yyln);
arrp.push(yypr);
arrms.push(yyms);
arrmd.push(yymd);
arrbs.push(yybs);
</script>";
}

?>


<script>

var cloudmadeUrl = 'http://{s}.tile.cloudmade.com/5d205a745590448bbb2598e28fd70844/997/256/{z}/{x}/{y}.png',
			cloudmadeAttribution = 'Map data &copy; 2011 OpenStreetMap contributors, Imagery &copy; 2011 CloudMade, Points &copy 2012 LINZ',
			cloudmade = L.tileLayer(cloudmadeUrl, {maxZoom: 18, attribution: cloudmadeAttribution}),
			latlng = L.latLng(21.6, 79);
			
var googleLayer = new L.Google('ROADMAP');

var map = L.map('map', {center: latlng, zoom: 5, layers: [googleLayer]});

		var markers = L.markerClusterGroup();
</script>
<script>	
	
		for(k=0;k<arrn.length;k++)
		{	
			ttle=arrn[k];
			var marker = L.marker(L.latLng(arrlt[k], arrln[k]),{title: ttle});

var popupContent = "<a href=\""+arrweb[k]+"\" target=\"_blank\">"+arrn[k]+"</a>"+"<br>"+"Principal : "+arrp[k]+"<br>"+arrad[k]+"<br>"+"Metro Station:  "+"<button type=\"button\" onclick=\"calcRoute();\">"+arrms[k]+"</button>"+"&nbsp"+"&nbsp"+"&nbsp"+"&nbsp"+"Distance(in kms):  "+arrmd[k]+"<br>"+"Bus Stop:  "+arrbs[k];



function calcRoute() {

var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
directionsDisplay = new google.maps.DirectionsRenderer();
directionsDisplay.setMap(map);

  var request = {
      origin: new google.maps.LatLng(28.5391884,77.2642656),
      destination: new google.maps.LatLng(28.7956118,77.0368364),
      travelMode: google.maps.TravelMode.DRIVING
  };
  directionsService.route(request, function(response, status) {
    
          directionsDisplay.setDirections(response);

    
  });
}

//google.maps.event.addDomListener(window,'load');

//var popupContent = "\""+arrweb[k]+"\"";*/

marker.bindPopup(popupContent);
	markers.addLayer(marker);

		}


		map.addLayer(markers);

</script>
</body>
</html>
