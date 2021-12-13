updateCoordinate(function(position) {
    const map = L.map('map').setView([position.latitude, position.longitude], 13);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'sk.eyJ1Ijoic2llYnNpZTIzIiwiYSI6ImNreDRmeXRlajI5ajQybnA4cWpzcWNoMnIifQ.vMunAm-ZN4Qq5hZ-4153CA'
    }).addTo(map);

    var marker = L.marker([51.5, -0.09]).addTo(map);
    marker.bindPopup("Dit is een test popup");
})
