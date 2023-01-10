var placeSearch, autocomplete;
var componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    country: 'long_name',
    postal_code: 'short_name'
};

function initialize() {
    autocomplete = new google.maps.places.Autocomplete(
        (document.getElementById('location')),
        { types: ['geocode'] });
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        fillInAddress();
    });
}

function fillInAddress() {
    var place = autocomplete.getPlace();
    console.log(place);
    var latitude = place.geometry.location.lat();
    var longitude = place.geometry.location.lng();
    $("#latitude").val(latitude);
    $("#longitude").val(longitude);

}

function geolocate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var geolocation = new google.maps.LatLng(
                position.coords.latitude, position.coords.longitude);
            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
        });
    }
}

$("#location").keyup(function(){
    if($("#location").val()==''){
        $("#latitude").val('');
        $("#longitude").val('');
    }
});