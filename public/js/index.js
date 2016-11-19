var clicks = 0;
var resclicks = 0;
var shopclicks = 0;

function delete_input_string(){
	$('#searchPlacesList').html(" ");
}

function getInfoModal(title){
	$.post("info_modal.php", {place_name: ""+title+""}, function(data){
            console.log(title);
            console.log(data);
            if(data.length >0) {
            
                $("#info_modal").html(data);
                GalleryOn();
            }
            var el = document.getElementById('arrowBack');
            if(el){
            	el.addEventListener("click",function(){
                $("#info_modal").html("");
            })
            }
             
        });
            

}
//slider js 
function slider(minPrice,maxPrice){
    
}

$('#sliderDouble').noUiSlider({
    start: [0, 1000] ,
    connect: true,
    tooltips: true,
    range: {
        min: 0,
        max: 1000
    }
});


//locations & directions 

function getLocation(end_cord_bin_lat, end_cord_bin_long) {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
        function (position) {
        var start = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
        var end = new google.maps.LatLng(end_cord_bin_lat,end_cord_bin_long);
        //var end = end_cord;
        console.log(start+","+end);
        var request = {
        origin: start,
        destination: end,
        // Note that Javascript allows us to access the constant
        // using square brackets and a string value as its
        // "property."
        travelMode: google.maps.TravelMode.DRIVING
        };
        directionsService.route(request, function(response, status) {
          if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
            directionsDisplay.setMap(map);
            directionsDisplay.setOptions({ suppressMarkers: true });
          }
        });
        }, 
        function () {
            handleNoGeolocation(true);
        });
    } 
    else
    {
        return "not supported";
    }
}
function getDirections(end_cord_lat, end_cord_long){
    $("#info_modal").html("");
    getLocation(end_cord_lat, end_cord_long);	
}



//////// MAPS JS 

     
     var iconBase = 'https://loret.mvm.bg/';
     var icons = {
              
                Càfe:iconBase + 'images/2coffees.svg',
                Disco:iconBase + 'images/3discotecs.svg',
                Bar:iconBase + 'images/4bars.svg',
                Attraction:iconBase + 'images/6attractions.svg',
                Monuments: iconBase + 'images/7monuments.svg',
                "Clothes Shop":iconBase + 'images/shopicons/1clothes.svg',
                "Shoes Shop":iconBase + 'images/shopicons/2shoes.svg',
                "Accessories Shop":iconBase + 'images/shopicons/3accessories.svg',
                "Customization Shop":iconBase + 'images/shopicons/4customization.svg',
                "Supermarket":iconBase + 'images/shopicons/5supermarket.svg',
                "Tabacs shop":iconBase + 'images/shopicons/6tabacs.svg',
                "Phones shop":iconBase + 'images/shopicons/7phones.svg',
                "Spanish Food":iconBase + 'images/restauranticons/spain.svg',
                "Argentine food":iconBase + 'images/restauranticons/argentina.svg',
                "Italian Food":iconBase + 'images/restauranticons/italy.svg',
                "Mexican Food":iconBase + 'images/restauranticons/mexico.svg',
                "Holand Food":iconBase + 'images/restauranticons/holand.svg',
                "Chinese Food":iconBase + 'images/restauranticons/china.svg',
                "Vegetarian Food":iconBase + 'images/restauranticons/other.svg',
                "Fast Food":iconBase + 'images/restauranticons/other.svg',
                "Other Foods":iconBase + 'images/restauranticons/other.svg',
                "Gas station":iconBase + 'images/8gasstations.svg',
                "Bus station":iconBase + 'images/8busstations.svg',
                "Taxis":iconBase + 'images/8taxis.svg',
                "Parking":iconBase + 'images/8parkings.svg',
                //Emergency
                "Police":iconBase + 'images/Emergency/police.svg',
                "Hospital":iconBase + 'images/Emergency/hospital.svg',
                "Fire Fighters":iconBase + 'images/Emergency/firefighters.svg',
                "Pharmacy":iconBase + 'images/Emergency/pharmacy.svg',
                //Bank
                "Bank":iconBase + 'images/Bank/banks.svg'
            };

function xmlParse(str) {
    if (typeof ActiveXObject != 'undefined' && typeof GetObject != 'undefined') {
        var doc = new ActiveXObject('Microsoft.XMLDOM');
        doc.loadXML(str);
        return doc;
    }

    if (typeof DOMParser != 'undefined') {
        return (new DOMParser()).parseFromString(str, 'text/xml');
    }

    return createElement('div', null);
}
var infoWindow = new google.maps.InfoWindow();
var customIcons = {
    monumento: {
        icon: 'http://maps.google.com/mapfiles/ms/icons/blue.png'
    },
    hotel: {
        icon: 'http://maps.google.com/mapfiles/ms/icons/green.png'
    },
    restaurantes: {
        icon: 'http://maps.google.com/mapfiles/ms/icons/yellow.png'
    },
    museus: {
        icon: 'http://maps.google.com/mapfiles/ms/icons/purple.png'
    }
};
/*var clickedMarkerGroups={
        "Càfe":false,
        "Disco":false,
        "Bar":false,
        "Attraction":false,
        "Monuments":false,
        "Clothes Shop":false,
        "Shoes Shop":false,
        "Accessories Shop":false,
        "Customization Shop":false,
        "Supermarket":false,
        "Tabacs shop":false,
        "Phones shop":false,
        "Spanish Food":false,
        "Argentine food":false,
        "Italian Food":false,
        "Mexican Food":false,
        "Holand Food":false,
        "Chinese Food":false,
        "Vegetarian Food":false,
        "Fast Food":false,
        "Other Foods":false,
        "Gas station":false,
        "Bus station":false,
        "Taxis":false,
        "Parking":false,
        // Emergency
        "Police":false,
        "Hospital":false,
        "Fire Fighters":false,
        "Pharmacy":false,
        // Banks
        "Bank":false

};
var markerGroups = {
        
        "Càfe":[],
        "Disco":[],
        "Bar":[],
        "Attraction":[],
        "Monuments":[],
        "Clothes Shop":[],
        "Shoes Shop":[],
        "Accessories Shop":[],
        "Customization Shop":[],
        "Supermarket":[],
        "Tabacs shop":[],
        "Phones shop":[],
        "Spanish Food":[],
        "Argentine food":[],
        "Italian Food":[],
        "Mexican Food":[],
        "Holand Food":[],
        "Chinese Food":[],
        "Vegetarian Food":[],
        "Fast Food":[],
        "Other Foods":[],
        "Gas station":[],
        "Bus station":[],
        "Taxis":[],
        "Parking":[],
        "Police":[],
        "Hospital":[],
        "Fire Fighters":[],
        "Pharmacy":[],
        "Bank":[]
};
        var Càfes=document.getElementById("Càfes");
        var Discoes=document.getElementById("Discoes");
        var Bars=document.getElementById("Bars");
        var Attractions=document.getElementById("Attractions");
        var Monuments=document.getElementById("Monuments");
        var Clothes_Shop=document.getElementById("Clothes Shop");
        var Shoes_Shop=document.getElementById("Shoes Shop");
        var Accessories_Shop=document.getElementById("Accessories Shop");
        var Customization_Shop=document.getElementById("Customization Shop");
        var Supermaket=document.getElementById("Supermarket");
        var Tabacs_Shop=document.getElementById("Tabacs shop");
        var Phones_Shop=document.getElementById("Phones shop");
        var Spanish_Food=document.getElementById("Spanish Food");
        var Argentine_food=document.getElementById("Argentine food");
        var Italian_Food=document.getElementById("Italian Food");
        var Mexican_Food=document.getElementById("Mexican Food");
        var Holand_Food=document.getElementById("Holand Food");
        var Chinese_Food=document.getElementById("Chinese Food");
        var Vegetarian_Food=document.getElementById("Vegetarian Food");
        var Fast_Food=document.getElementById("Fast Food");
        var Other_Foods=document.getElementById("Other Foods");
        var Gas_Station = document.getElementById("Gas station");
        var Bus_Station = document.getElementById("Bus station");
        var Taxis = document.getElementById("Taxis");
        var Parking = document.getElementById("Parking");
        //Emergency
        var Police = document.getElementById("Police");
        var Hospital = document.getElementById("Hospital");
        var Fire_Fighters = document.getElementById("Fire Fighters");
        var Pharmacy = document.getElementById("Pharmacy");
        //Bank
        var Bank = document.getElementById("Bank");*/

        var directionsDisplay;
        var directionsService = new google.maps.DirectionsService();

function initialize() {

        directionsDisplay = new google.maps.DirectionsRenderer();
        var mapCanvas = document.getElementById('map');
        var mapOptions = {
          center: new google.maps.LatLng(42.695347, 23.322564),
          zoom: 13,
          minZoom:13,
          styles: myStyles,
          disableDefaultUI: true,
          mapTypeControl: false,
          scaleControl: false,
          zoomControl: false,
        }
        map = new google.maps.Map(mapCanvas, mapOptions);
        var infoWindow = new google.maps.InfoWindow();

        //gets markers with ajax and calls createMarker() func. in it
        if(estatesJSON){
            JsonWithMarkers('all',map,estatesJSON);
            onsole.log('vliza');
        }
        else{
            JsonWithMarkers('all', map, '[]');
        }

        directionsDisplay.setMap(map);
}

function JsonWithMarkers(filter,map,json) {

        enableLoader();
        if(filter=='all'){
            if(json){
                console.log(json);
                 data=json;
                    console.log('vliza');
                    data.forEach(function(item,index){
                                    var address = item.grad+ ","+item.orientir ;
                                    console.log(address+' sad');
                                    $.getJSON("https://maps.googleapis.com/maps/api/geocode/json?&address='"+address+"'&sensor=false",function(data){
                                        
                                        if(data.status=="OK"){
                                            
                                            point=new google.maps.LatLng(data.results[0].geometry.location.lat,data.results[0].geometry.location.lng);
                                            console.log(data);
                                            //var icon = customIcons[type] || {};
                                            var marker = createMarker(point,map, item,data);
                                            console.log(marker);
                                            //bindInfoWindow(marker, map, infoWindow, html);
                                        }
                                        else
                                        {
                                            console.log('Error! Cannot find the location by the address in function codeAddress(address)');
                                        }
                                        
                                    });
                                    
                                });
            }
            else{
        $.ajax('/имоти', {
            type: 'POST',
            data: {},
            dataType: 'json',
            success: function(data) {
                console.log(data);
                data.forEach(function(item,index){
                    var address = item.grad+ ", "+item.orientir ;
                    $.getJSON("https://maps.googleapis.com/maps/api/geocode/json?&address='"+address+"'&sensor=false",function(data){
                        console.log(address);
                        if(data.status=="OK"){
                            
                            point=new google.maps.LatLng(data.results[0].geometry.location.lat,data.results[0].geometry.location.lng);
                            console.log(data);
                            //var icon = customIcons[type] || {};
                            var marker = createMarker(point,map, item,data);
                            console.log(marker);
                            //bindInfoWindow(marker, map, infoWindow, html);
                        }
                        else
                        {
                            console.log('Error! Cannot find the location by the address in function codeAddress(address)');
                        }
                        
                    });
                    
                });

                
            },
            complete: function() {
                disableLoader();

            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Handle the error.
            }
        });
     }
    }
    /*else{
         $.ajax('/filterestates', {
            type: 'POST',
            data: {},
            headers : { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
            dataType: 'json',
            success: function(data) {
                console.log(data);
                data.forEach(function(item,index){
                    var address = item.grad+ ","+item.orientir ;
                    $.getJSON("https://maps.googleapis.com/maps/api/geocode/json?&address='"+address+"'&sensor=false",function(data){
                        
                        if(data.status=="OK"){
                            
                            point=new google.maps.LatLng(data.results[0].geometry.location.lat,data.results[0].geometry.location.lng);
                            console.log(data);
                            //var icon = customIcons[type] || {};
                            var marker = createMarker(point,map, item,data);
                            console.log(marker);
                            //bindInfoWindow(marker, map, infoWindow, html);
                        }
                        else
                        {
                            console.log('Error! Cannot find the location by the address in function codeAddress(address)');
                        }
                        
                    });
                    
                });

                
            },
            complete: function() {
                disableLoader();

            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Handle the error.
            }
        });
    }*/
}

function createMarker(point, map,item,data) {
    var name =item.tip_sdelka+ " "+item.vid_imot;
    var address = item.grad+ ","+item.orientir ;
    var type = item.vid_imot ;
    var id=item.kartoteka_n ;
    var icon = icons[type] || {};
    //console.log(icon);
    var html = '<div class="infobox-inner"><a href="http://estatemap.mvm.bg/%D0%B8%D0%BC%D0%BE%D1%82/'+item.estate_name+'"><div class="infobox-image" style="position: relative"><img src="http://themes.fruitfulcode.com/zoner/wp-content/uploads/2014/09/thumbnail_11.jpg"><div><span class="infobox-price">'+item.naem+'EUR</span></div></div></a><div class="infobox-description"><div class="infobox-title"><a href="http://estatemap.mvm.bg/%D0%B8%D0%BC%D0%BE%D1%82/'+item.estate_name+'">'+name+'</a></div><div class="infobox-location"> <a href="http://estatemap.mvm.bg/%D0%B8%D0%BC%D0%BE%D1%82/'+item.estate_name+'" title="'+item.estate_name+'">'+data.results[0].formatted_address+'</a></div></div></div>';

    var marker = new google.maps.Marker({
        map: map,
        position: point,
        //icon: new google.maps.MarkerImage(icons[type], null, null, null, new google.maps.Size(40, 40)),
        // shadow: icon.shadow,
        type: type,
        price: '123'
    });
    console.log(marker);
    /*if (!markerGroups[type]) markerGroups[type] = [];
    markerGroups[type].push(marker);*/

    InfoWindow_func(marker,name,address, id);
    bindInfoWindow(marker, map, infoWindow, html);
    return marker;
}
function getMarkersVisibility(){
   
    var visible=true;
    $.each(markerGroups,function(key,value) {
        for(var i=0;i<value.length;i++)
            if(!markerGroups[key][i].getVisible())visible=false;
        
    });
    return visible;
}
function hideAllMarkers(){
    
    $.each(markerGroups,function(key,value) {
        for(var i=0;i<value.length;i++)
            markerGroups[key][i].setVisible(false);
        
    });
}
function showAllMarkers(){
    $.each(markerGroups,function(key,value) {
        for(var i=0;i<value.length;i++)
            markerGroups[key][i].setVisible(true);
        
    });
}
function checkUncheck(type){
    var checkedAll=false;
    $.each(markerGroups,function(key,value) {
        
        if(key==type){
            if(clickedMarkerGroups[key]==true)clickedMarkerGroups[key]=false;
            else clickedMarkerGroups[key]=true;
    }
    });
    $.each(markerGroups,function(key,value) {
        if(clickedMarkerGroups[key]==true)checkedAll=true;
    });
    
    return checkedAll;
}
function toggleGroup(type) {
    if(getMarkersVisibility(markerGroups))hideAllMarkers(markerGroups);

    for (var i = 0; i < markerGroups[type].length; i++) {
        var marker = markerGroups[type][i];
        if (!marker.getVisible()) {
            marker.setVisible(true);
        } else {
            marker.setVisible(false);
        }
    }
    if (!checkUncheck(type)) {
        showAllMarkers(markerGroups);
    };
}
function InfoWindow_func(marker,name,address, id){

    google.maps.event.addListener(marker, 'click', function () {
        $.post("info_modal.php", {place_name: ""+name+"",address: ""+address+"",id: ""+id+""}, function(data){            
            console.log(name+' '+ address+' id:'+id);
            console.log(data);
            if(data.length >0) {
            
                $("#info_modal").html(data);
                GalleryOn();
            }
            document.getElementById("arrowBack").addEventListener("click",function(){
                $("#info_modal").html("");
            }) 
        });
            

    });

}

function bindInfoWindow(marker, map, infoWindow, html) {
    google.maps.event.addListener(marker, 'click', function () {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);

    });
}


function enableLoader(){
    $('#circle_div').css('display','block');
}
function disableLoader(){
    $('#circle_div').css('display', 'none');
}

function setFilter(filter){

}

function doNothing() {}



     
 

    google.maps.event.addDomListener(window, 'load', initialize);

    var initial = true;
    google.maps.event.addListener(map, "zoom_changed", function() {
            if (initial == true){
               if (map.getZoom() < 14) {
                 map.setZoom(14);
                 initial = false;
               }
            }
        });
var myStyles =[
            {
                featureType: "poi",
                elementType: "labels",
                stylers: [
                      { visibility: "off" }
                ]
            },
             // Map Style
                     {
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#34495e"
                    },
                    {
                        "lightness": 17
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#dcdcdc"
                    },
                    {
                        "lightness": 20
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#ffffff"
                    },
                    {
                        "lightness": 17
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "color": "#494949"
                    },
                    {
                        "lightness": 29
                    },
                    {
                        "weight": 0.2
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#ffffff"
                    },
                    {
                        "lightness": 18
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#ffffff"
                    },
                    {
                        "lightness": 16
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "dcdcdc"
                    },
                    {
                        "lightness": 21
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "dcdcdc"
                    },
                    {
                        "lightness": 21
                    }
                ]
            },
            {
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#ffffff"
                    },
                    {
                        "lightness": 16
                    }
                ]
            },
            {
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "saturation": 36
                    },
                    {
                        "color": "#000000"
                    },
                    {
                        "lightness": 40
                    }
                ]
            },
            {
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#f2f2f2"
                    },
                    {
                        "lightness": 19
                    }
                ]
            },
            {
                "featureType": "administrative",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#fefefe"
                    },
                    {
                        "lightness": 20
                    }
                ]
            },
            {
                "featureType": "administrative",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "color": "#fefefe"
                    },
                    {
                        "lightness": 17
                    },
                    {
                        "weight": 1.2
                    }
                ]
            }
        ];