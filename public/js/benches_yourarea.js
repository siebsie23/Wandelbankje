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
        markers.addTo(map);
        last_position = position;
        updateMarkers(position);

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
                benchNameMap = {};
                for(let i = 0; i < response.length; i++) {
                    let marker;
                    markers.addLayer(marker = L.marker([response[i]['latitude'], response[i]['longitude']]));
                    reverseLocation(response[i]['latitude'], response[i]['longitude'], function(value) {
                        benchNameMap[i] = value;
                        marker.bindPopup(benchNameMap[i]['results'][0]['formatted_address']);
                        updateList(response);
                    });
                    markermap[i] = marker;
                }
                map.fitBounds(markers.getBounds(), {padding: [20, 20]});
            }
        });
    }

    function updateList(benches) {
        let benchlist = $('#bench-list');
        benchlist.empty();
        for(let i = 0; i < benches.length; i++) {
            let benchName = 'Onbekende locatie';
            if(benchNameMap[i] != null) {
                benchName = benchNameMap[i]['results'][0]['address_components']['subdistrict'] + ', ' + benchNameMap[i]['results'][0]['address_components']['district']
            }
            benchlist.append('<li>\n' +
                '                                        <div class="px-4 py-4 sm:px-6">\n' +
                '                                            <div class="grid grid-cols-2 flex items-center justify-between">\n' +
                '                                                <a href="#zoombench" markerId="' + i + '" lat="' + benches[i]['latitude'] + '" lon="' + benches[i]['longitude'] + '"><p class="truncate">' + benchName + '</p></a>\n' +
                '                                                <div class="flex justify-end">\n' +
                '                                                    <a href="/details/' + benches[i]['id'] + '" class="ml-1 mr-1 p-2 pl-5 pr-5 transition-colors duration-700 transform bg-indigo-500 hover:bg-blue-400 text-gray-100 text-lg rounded-lg focus:border-4 border-indigo-300"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">\n' +
                '  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />\n' +
                '</svg></a>\n' +
                '                                                    <a target="_blank" href="https://www.google.com/maps/dir/?api=1&travelmode=walking&destination=' + benches[i]['latitude'] + ',' + benches[i]['longitude'] + '" class="ml-1 mr-1 p-2 pl-5 pr-5 transition-colors duration-700 transform bg-red-500 hover:bg-red-400 text-gray-100 text-lg rounded-lg focus:border-4 border-red-300"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">\n' +
                '  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />\n' +
                '  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />\n' +
                '</svg></a>\n' +
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
            highlightLocationId($(this).attr('markerId'));
            zoomendpopup = $(this).attr('markerId');
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


