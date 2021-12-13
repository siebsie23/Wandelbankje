function updateCoordinate(callback) {
    navigator.geolocation.getCurrentPosition(
        function (position) {
            var returnValue = {
                latitude: position.coords.latitude,
                longitude: position.coords.longitude
            }
            callback(returnValue);
        }
    )
}
