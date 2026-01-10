function initAutocomplete() {
  var direccionInput = document.getElementById("direccion");
  var autocomplete = new google.maps.places.Autocomplete(direccionInput);

  //Cuando se selecciona una sugerencia
  autocomplete.addListener('place_changed', function() {
    var place = autocomplete.getPlace();

    // Llena el campo de dirección con la dirección formateada
    document.getElementById('direccion').value = place.formatted_address;
  });
}

//Función para la búsqueda de la latitud y la longitud de la dirección ingresada
function buscarLatitudLongitud() {

  var direccion = document.getElementById("direccion").value; //Lectura de la dirección ingresada

  var apiKey = "AIzaSyAw2qBynYleldgejZ6JGPjXpkoDMhabqis";
  var apiUrl = `https://maps.googleapis.com/maps/api/geocode/json?address=${encodeURIComponent(direccion)}&key=${apiKey}`;

  fetch(apiUrl)
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "OK") {
        var latitud = data.results[0].geometry.location.lat;
        var longitud = data.results[0].geometry.location.lng;

        trackDaycareComplete();
        console.log("Latitud:", latitud);
        console.log("Longitud:", longitud);
      }
    })
    .catch((error) =>
      console.error("Error al obtener datos de la API:", error)
    );
}

window.addEventListener("load", initAutocomplete);