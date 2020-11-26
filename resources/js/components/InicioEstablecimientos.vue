<template>
    <div>
        <listado-categorias></listado-categorias>
        <mapa-establecimientos></mapa-establecimientos>
        <categoria-cafe></categoria-cafe>
        <categoria-restaurante></categoria-restaurante>
        <categoria-hotel></categoria-hotel>
    </div>
</template>

<script>
    import CategoriaCafe from './CategoriaCafe';
    import ListadoCategorias from './ListadoCategorias';
    import MapaEstablecimientos from './MapaEstablecimientos';
    import CategoriaRestaurante from './CategoriaRestaurante';
    import CategoriaHotel from './CategoriaHotel';


    export default {

        components: {
            ListadoCategorias,
            MapaEstablecimientos,
            CategoriaCafe,
            CategoriaRestaurante,
            CategoriaHotel,
        }

    }
</script>
