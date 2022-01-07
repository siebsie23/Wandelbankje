$(document).ready(function() {
    let last_position = null;
    let map = null;
    let zoomendpopup = null;
    let markermap = {};
    let benchNameMap = {};
    let markers = L.markerClusterGroup();
    updateCoordinate(function(position) {
        map = L.map('map').setView([position.latitude, position.longitude], 13);
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'sk.eyJ1Ijoic2llYnNpZTIzIiwiYSI6ImNreDRmeXRlajI5ajQybnA4cWpzcWNoMnIifQ.vMunAm-ZN4Qq5hZ-4153CA'
        }).addTo(map);
        var redIcon = new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });
        let yourLocationMarker = L.marker([position.latitude, position.longitude], {icon: redIcon}).addTo(map);
        yourLocationMarker.bindPopup('Je huidige locatie');
        markers.addTo(map);
        last_position = position;
        updateMarkers(position);

        // register map event
        map.on('zoomend', function() {
            highlightLocationId(zoomendpopup);
        })
    });

    function onMapClick(e) {
        let popup = e.target.getPopup();
        let latlng = map.mouseEventToLatLng(e.originalEvent);

        reverseLocation(latlng.lat, latlng.lng, function(value) {
            let i = popup.getContent().split(' - ')[0];
            popup.setContent(value['results'][0]['formatted_address'] + ' - <a href="/details/' + i + '">Details</a>');
            popup.update();
        });
    }

    function updateMarkers(position) {
        $.ajax({
            type: 'GET',
            url: 'get-benches-global/' + position.latitude + '/' + position.longitude,
            success: function(response) {
                markers.clearLayers();
                markermap = {};
                benchNameMap = {};
                for(let i = 0; i < response.length; i++) {
                    let marker;
                    markers.addLayer(marker = L.marker([response[i]['latitude'], response[i]['longitude']]));
                    marker.bindPopup(response[i]['id'] + " - Laden...");
                    marker.on('click', onMapClick );
                    markermap[i] = marker;
                }
            }
        });
    }

    function highlightLocationId(id) {
        if(id == null)
            return;
        var marker = markermap[id];

        if (!marker) { return; }

        marker.openPopup();
        zoomendpopup = null;
    }

});


