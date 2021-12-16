$(document).ready(function() {
    let last_position = null;
    let map = null;
    let zoomendpopup = null;
    let markermap = {};
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
        markers.addTo(map);
        updateCoordinate(function(position) {
            last_position = position;
            updateMarkers(position);
        })

        // register map event
        map.on('zoomend', function() {
            highlightLocationId(zoomendpopup);
        })
    });

    //Update location every 5 seconds.
    window.setInterval(function() {
        updateCoordinate(function(position) {
            if(Math.abs(calcCrow(last_position.latitude, last_position.longitude, position.latitude, position.longitude)) > 0) {
                updateMarkers(position);
            }
            last_position = position;
        });
    }, 5000);

    function updateMarkers(position) {
        $.ajax({
            type: 'GET',
            url: 'get-benches-area/' + position.latitude + '/' + position.longitude,
            success: function(response) {
                markers.clearLayers();
                markermap = {};
                for(let i = 0; i < response.length; i++) {
                    let marker;
                    markers.addLayer(marker = L.marker([response[i]['latitude'], response[i]['longitude']]));
                    marker.bindPopup("Dit is een test popup");
                    markermap[i] = marker;
                }
                map.fitBounds(markers.getBounds(), {padding: [20, 20]});
                updateList(response);
            }
        });
    }

    function updateList(benches) {
        let benchlist = $('#bench-list');
        benchlist.empty();
        for(let i = 0; i < benches.length; i++) {
            benchlist.append('<li>\n' +
                '                                        <div class="px-4 py-4 sm:px-6">\n' +
                '                                            <div class="flex items-center justify-between">\n' +
                '                                                <a href="#zoombench" markerId="' + i + '" lat="' + benches[i]['latitude'] + '" lon="' + benches[i]['longitude'] + '"><p class="truncate">Bankje</p></a>\n' +
                '                                                <div class="ml-2 flex-shrink-0 flex">\n' +
                '                                                    <button class="ml-1 mr-1 p-2 pl-5 pr-5 transition-colors duration-700 transform bg-indigo-500 hover:bg-blue-400 text-gray-100 text-lg rounded-lg focus:border-4 border-indigo-300">Details</button>\n' +
                '                                                    <a target="_blank" href="https://www.google.com/maps/dir/?api=1&travelmode=walking&destination=' + benches[i]['latitude'] + ',' + benches[i]['longitude'] + '" class="ml-1 mr-1 p-2 pl-5 pr-5 transition-colors duration-700 transform bg-red-500 hover:bg-red-400 text-gray-100 text-lg rounded-lg focus:border-4 border-red-300">Navigeren</a>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                            <div class="mt-2 sm:flex sm:justify-between">\n' +
                '                                                <div class="sm:flex">\n' +
                '                                                    <p class="flex items-center text-sm font-light text-gray-500">\n' +
                '                                                        ' + benches[i]['latitude'] + ' ' + benches[i]['longitude'] +
                '                                                    </p>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                </li>')
        }
        $('a[href="#zoombench"]').click(function() {
            map.flyTo([$(this).attr('lat'), $(this).attr('lon')], 18)
            zoomendpopup = $(this).attr('markerId');
        });
    }

    function highlightLocationId(id) {
        if(id == null)
            return;
        let marker = markermap[id];

        if (!marker) { return; }

        marker.openPopup();
        zoomendpopup = null;
    }

});


