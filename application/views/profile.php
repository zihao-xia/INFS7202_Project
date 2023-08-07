<div class="container">
    <img src="<?php echo base_url('./uploads/avatar/' . $avatar); ?>" class="img-thumbnail rounded" style="width: 200px;">
    <h1><?php echo $username; ?></h1>
    <table class="table mx-auto">
        <tr>
            <td>Email: <?php echo $email; ?><br>Verified:
                <?php if ($active == 0) {
                    echo 'No';
                    echo '<br>';
                    echo '<a href="' . base_url() . 'profile/send_verification_email">Verify Email</a>';
                    echo $this->session->flashdata('message');
                } else {
                    echo 'Yes';
                } ?></td>
        </tr>
        <tr>
            <td><a href="<?php echo base_url(); ?>favourites" class="text-info text-decoration-none">Favourites</a></td>
        </tr>
        <tr>
            <td>Location</td>
        </tr>
    </table>
    <div id="map" style="width: 600px; height: 400px" class="border border-dark"></div>
</div>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCv9WWs8NrwjgQrFbN9ZiQZafe0wikHMzo&callback=initMap"></script>
<script>
    // google map api https://developers.google.com/maps/documentation/javascript/geolocation
    let map, infoWindow;

    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: -34.397,
                lng: 150.644
            },
            zoom: 6,
        });
        infoWindow = new google.maps.InfoWindow();

        const locationButton = document.createElement("button");

        locationButton.textContent = "Pan to Current Location";
        locationButton.classList.add("custom-map-control-button");
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton);
        locationButton.addEventListener("click", () => {
            // Try HTML5 geolocation.
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                        };

                        infoWindow.setPosition(pos);
                        infoWindow.setContent("Location found.");
                        infoWindow.open(map);
                        map.setCenter(pos);
                    },
                    () => {
                        handleLocationError(true, infoWindow, map.getCenter());
                    }
                );
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow, map.getCenter());
            }
        });
    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(
            browserHasGeolocation ?
            "Error: The Geolocation service failed." :
            "Error: Your browser doesn't support geolocation."
        );
        infoWindow.open(map);
    }

    window.initMap = initMap;
</script>