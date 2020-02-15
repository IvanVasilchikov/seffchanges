var gmap_inited = false;
var dom_inited = false;
var GMapId = 'GMapDiv';
var GMapDiv = {};
var GMap = {};
var GMarker = {};
var gmAddr = {};
var gmCoords = {};
var form;
var gmBlockZoomUpd = false;

$(document).ready(function() {
  form = $('.map-box');
  dom_inited = true;
  if (gmap_inited) {
    gmInit();
  }
  $('.adm-detail-tab').bind('click', function() {
    if (gmap_inited) {
      gmInit();
    }
  });
});

function initMapNovostroy() {
  gmap_inited = true;
  if (dom_inited) {
    gmInit();
  }
}

function gmInit() {
  $('div[id^=' + GMapId + ']:visible').each(function() {
    var div = $(this);
    if (!div.hasClass('inited')) {
      var id = div.attr('id');
      var ind = id.replace(GMapId, '');
      GMapDiv[ind] = div;
      gmAddr[ind] = form.find('input[id=gmAddr' + ind + ']');
      gmCoords[ind] = form.find('input[id=gmcoords' + ind + ']');
      var tmp = "";
      var coords = gmCoords[ind].val();
      if(undefined !== coords && coords.length )
      	tmp = coords.split(',');


      GMapDiv[ind].show();
      if (!GMap[ind])
        gmInitGmap(ind);
      if (coords && tmp && coords.length < 50 && (tmp.length == 2 || tmp.length == 3)) {
        gmShowMapCoords(coords, ind);
      } else {
        if(ind == 1) {
        }
        GMap[ind].setCenter(new google.maps.LatLng(55, 37));
        GMap[ind].setZoom(6);
        //		gmHideMap(ind);
      }
      div.addClass('inited');
    }
  });
}

function gmInitGmap(ind) {
  if (GMap[ind])
    return;
  var mapOptions = {
    center: new google.maps.LatLng(37.0625, -95.677068),
    zoom: 11,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  GMap[ind] = new google.maps.Map(document.getElementById(GMapId + ind), mapOptions);
  google.maps.event.addListener(GMap[ind], 'click',
    function(event) {
      gmShowPoint(event.latLng, ind);
    }
  );
  google.maps.event.addListener(GMap[ind], 'zoom_changed',
    function(event) {
      if (!gmBlockZoomUpd && GMarker[ind])
        gmShowPoint(GMarker[ind].getPosition());
    }
  );
}

function gmShowPoint(point, ind) {
  GMapDiv[ind].show();
  if (!GMap[ind])
    gmInitGmap(ind);
  c = point.lat() + ',' + point.lng() + ',' + GMap[ind].getZoom();
  gmCoords[ind].val(c);
  gmShowMapCoords(c, ind);
}

// sho map block and set center to coords
function gmShowMapCoords(coords, ind) {
  var tmp = coords.split(',');
  if (tmp.length > 1) {
    //map.addOverlay(new GMarker(point, markerOptions));
    x = parseFloat(tmp[0]);
    y = parseFloat(tmp[1]);
    GMap[ind].setCenter(new google.maps.LatLng(x, y));
    if (tmp[2]) {
      z = parseFloat(tmp[2]);
      if (z <= 21 && z >= 10) {
        gmBlockZoomUpd = true;
        GMap[ind].setZoom(z);
        gmBlockZoomUpd = false;
      }
    }
    if (!GMarker[ind]) {
      GMarker[ind] = new google.maps.Marker( {map: GMap[ind], position: new google.maps.LatLng(tmp[0], tmp[1])} );
    }
    else
      GMarker[ind].setPosition(new google.maps.LatLng(tmp[0], tmp[1]));
  }
}

function gmSearchByAddr(ind) {
  var addr = gmAddr[ind].val();
  t = form.find('div[id=gm' + ind + '_city]').attr('value');
  if (!addr || addr == '') {
    a = form.find('div[id=gm' + ind + '_address]').attr('value');
    if (a.indexOf(t) < 0)
      a = t + ', ' + a;
    gmAddr[ind].val(a);
    addr = a;
  }
  //search
  var geocoder = new google.maps.Geocoder();
  geocoder.geocode({ 'address': t + ' ' + addr}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      var point = results[0].geometry.location;
      gmShowPoint(point, ind);
    } else {
      alert('РђРґСЂРµСЃ РЅРµ РЅР°Р№РґРµРЅ.');
    }
  });
}

// hide map block
function gmHideMap(ind) {
  GMapDiv[ind].hide();
}
