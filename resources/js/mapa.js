import { OpenStreetMapProvider } from 'leaflet-geosearch';
const provider = new OpenStreetMapProvider();

document.addEventListener('DOMContentLoaded', () => {

    // Solo se ejecutara si en el documento existe un elemento con la etiqueta 'mapa'
    if(document.querySelector('#mapa')){
        const lat = document.querySelector('#lat').value === '' ? 20.666332695977 : document.querySelector('#lat').value;
        const lng = document.querySelector('#lng').value === '' ? -103.392177745699 : document.querySelector('#lng').value;

        const mapa = L.map('mapa').setView([lat, lng], 16);

        // Eliminar pines previos
        let markers = new L.FeatureGroup().addTo(mapa);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(mapa);

        let marker;

        // agregar el pin
        marker = new L.marker([lat, lng], {
            draggable: true,
            autoPan: true
        }).addTo(mapa);

        // Asignar el contenedor de markers el nuevo pin
        markers.addLayer(marker);

        // GeoCode service
        const geocodeService = L.esri.Geocoding.geocodeService();

        // Buscador de direcciones
        const buscador = document.querySelector('#formbuscador');
        buscador.addEventListener('blur', buscarDireccion);

        // Detectar movimiento del marker
        reubicarPin(marker);
        function reubicarPin(marker) {
            marker.on('moveend', function(e) {
                marker = e.target;
                const position = marker.getLatLng();

                // Centar el mapa donde se soltó el pin
                mapa.panTo( new L.LatLng(position.lat, position.lng));

                // Reverse Geocoding, cuando el user reubica el pin
                geocodeService.reverse().latlng(position, 16).run(function(error, resultado){

                    marker.bindPopup(resultado.address.LongLabel);
                    marker.openPopup();

                    // Llenar campos form
                    llenarInputs(resultado);

                });
            });
        }
        function buscarDireccion(e) {

            if(e.target.value.length > 4){
                provider.search({query: e.target.value })
                    .then( resultado => {

                        if (resultado[0]) {

                            // Limpiar los pines previos
                            markers.clearLayers();

                            // Reverse Geocoding, cuando el user reubica el pin
                            geocodeService.reverse().latlng(resultado[0].bounds[0], 16).run(function(error, resultado){


                                // Llenar inputs
                                llenarInputs(resultado);

                                // Centrar mapa
                                mapa.setView(resultado.latlng);

                                // Agregar pin
                                marker = new L.marker(resultado.latlng, {
                                    draggable: true,
                                    autoPan: true
                                }).addTo(mapa);

                                // Asignar el contenedor de markers el nuevo pin
                                markers.addLayer(marker);

                                // Mover pin
                                reubicarPin(marker);

                            });
                        }

                    }).catch( error => {
                        console.log(error);
                    })
            }


        }

        function llenarInputs(resultado) {
            document.querySelector('#direccion').value = resultado.address.Address || '';
            document.querySelector('#barrio').value = resultado.address.Neighborhood || '';
            document.querySelector('#lat').value = resultado.latlng.lat || '';
            document.querySelector('#lng').value = resultado.latlng.lng || '';
        }
    }


});
