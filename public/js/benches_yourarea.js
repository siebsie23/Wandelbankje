$(document).ready(function() {
    updateCoordinate(function(position) {

        $.ajax({
            type: 'GET',
            url: 'get-benches-area/' + position.latitude + '/' + position.longitude,
            success: function(response) {
                const map = L.map('map').setView([position.latitude, position.longitude], 13);
                L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                    maxZoom: 18,
                    id: 'mapbox/streets-v11',
                    tileSize: 512,
                    zoomOffset: -1,
                    accessToken: 'sk.eyJ1Ijoic2llYnNpZTIzIiwiYSI6ImNreDRmeXRlajI5ajQybnA4cWpzcWNoMnIifQ.vMunAm-ZN4Qq5hZ-4153CA'
                }).addTo(map);

                var markers = L.markerClusterGroup();
                for(let i = 0; i < response.length; i++) {
                    var marker;
                    markers.addLayer(marker = L.marker([response[i]['latitude'], response[i]['longitude']]));
                    marker.bindPopup("Dit is een test popup");
                }
                map.addLayer(markers);
            }
        });
    })
});


