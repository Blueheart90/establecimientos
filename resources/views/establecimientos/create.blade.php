@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
    integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
    crossorigin=""/>
    <!-- Esri Leaflet Geocoder -->
    <link
    rel="stylesheet"
    href="https://unpkg.com/esri-leaflet-geocoder/dist/esri-leaflet-geocoder.css"
    />
@endsection
@section('content')
    <div class="container">
        <h1 class="text-center mt-4">Resgistrar Establecimiento</h1>
        <div class="mt-5 row justify-content-center">
            <form
                action=""
                class="col-md-9 col-xs-12 card card-body"
            >
                <fieldset class="border p-4">
                    <legend class="text-primary">Nombre, Categoría e Imagen Principal</legend>
                    <div class="form-group">
                        <label for="nombre">Nombre Establecimiento</label>
                        <input
                            type="text"
                            id="nombre"
                            class="form-control @error('nombre') is-invalid @enderror"
                            placeholder="Nombre Establecimiento"
                            name="nombre"
                            value="{{ old('nombre') }}"
                        >
                        @error('nombre')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="categoria">Categoria Establecimiento</label>
                        <select
                            class="form-control @error('categoria_id') is-invalid @enderror"
                            name="categoria_id"
                            id="categoria"
                        >
                            <option value="" selected disabled>-- Elige Una Categoria --</option>
                            @foreach($categorias as $categoria)
                                <option
                                    value="{{ $categoria->id}}"
                                    {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}
                                >{{ $categoria->nombre}}</option>
                            @endforeach
                        </select>

                        @error('categoria')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="imagen_principal">Imagen Principal</label>
                        <input
                            type="file"
                            id="imagen_principal"
                            class="form-control @error('imagen_principal') is-invalid @enderror"
                            name="imagen_principal"
                        >
                        @error('imagen_principal')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>


                </fieldset>
                <fieldset class="border p-4">
                    <legend class="text-primary">Ubicacion</legend>
                    <div class="form-group">
                        <label for="nombre">Coloca la dirección del Establecimiento</label>
                        <input
                            type="text"
                            id="formbuscador"
                            placeholder="Calle del Negocio o Establecimiento"
                            name="nombre"
                            class="form-control"
                        >
                        <p class="text-secondary mt-5 mb-3 text-center">El asistente colocará una dirección estimada, mueve el pin hacia el lugar correcto</p>
                    </div>
                    <div class="form-group">
                        <div id="mapa" style="height: 400px"></div>
                    </div>
                    <p class="informacion">Confirma que los siguientes campos son correctos</p>

                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input
                            type="text"
                            id="direccion"
                            class="form-control @error('direccion') is-invalid @enderror"
                            placeholder="Dirección"
                            value="{{ old('direccion') }}"
                        >
                        @error('direccion')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="barrio">Barrio</label>
                        <input
                            type="text"
                            id="barrio"
                            class="form-control @error('barrio') is-invalid @enderror"
                            placeholder="Barrio"
                            value="{{ old('barrio') }}"
                        >
                        @error('barrio')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <input type="hidden" id="lat" name="lat" value="{{ old('lat') }}">
                    <input type="hidden" id="lng" name="lng" value="{{ old('lng') }}">
                </fieldset>
            </form>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""></script>
    {{-- plugin ppal, para ultilizar todos --}}
    <script src="https://unpkg.com/esri-leaflet" defer></script>

    <!-- Esri Leaflet Geocoder -->
    <script src="https://unpkg.com/esri-leaflet-geocoder" defer></script>

@endsection
