$(document).ready(function() {
    updateCoordinate(function(position) {
        reverseLocation(position.latitude, position.longitude, function(value) {
            $("#adress").text(value['results'][0]['formatted_address']);
        });
        $("#coordinates").text(position.latitude + ' ' + position.longitude);
        $("#latitude").val(position.latitude);
        $("#longitude").val(position.longitude);
    });
});
