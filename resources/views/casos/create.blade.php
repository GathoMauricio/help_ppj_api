@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <b style="color:rgb(234,81,70);">Iniciar caso</b>
                    </div>
                    <div class="card-body" style="background-color: rgb(43,51,60)">
                        <form action="{{ url('store_caso') }}" method="POST" class="form">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="area_id" style="font-weight:bold;color:rgb(251,199,0)">Area</label>
                                        <select onchange="selectArea(this.value)" name="area_id" id="area_id"
                                            class="form-select">
                                            <option value>--Seleccione una opción--</option>
                                            @foreach ($areas as $area)
                                                @if (old('area_id') == $area->id)
                                                    <option value="{{ $area->id }}" selected>{{ $area->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('area_id')
                                            <span style="color:red">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="service_id" style="font-weight:bold;color:rgb(251,199,0)">Tipo de
                                            servicio</label>
                                        <select name="service_id" id="service_id" class="form-select">
                                            <option value>--Seleccione una opción--</option>
                                        </select>
                                        @error('service_id')
                                            <span style="color:red">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="priority_case_id"
                                            style="font-weight:bold;color:rgb(251,199,0)">Prioridad</label>
                                        <select name="priority_case_id" id="priority_case_id" class="form-select">
                                            <option value>--Seleccione una opción--</option>
                                            @foreach ($prioridades as $prioridad)
                                                @if (old('priority_case_id') == $prioridad->id)
                                                    <option value="{{ $prioridad->id }}" selected>{{ $prioridad->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $prioridad->id }}">{{ $prioridad->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('priority_case_id')
                                            <span style="color:red">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description"
                                            style="font-weight:bold;color:rgb(251,199,0)">Descripción</label>
                                        <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                                        @error('description')
                                            <span style="color:red">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 p-3">
                                    <button type="submit" class="btn btn-primary"
                                        style="float:right; background-color: rgb(234,81,70);">Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                var area = $("#area_id").val();
                console.log(area);
                if (area.length > 0) {
                    selectArea(area);
                    setTimeout(function() {
                        $("#service_id").val({{ old('service_id') }}).change();;
                    }, 500);
                }
            }, 500);
        });

        function selectArea(value) {
            if (value.length <= 0) {
                $("#service_id").html('<option value>--Seleccione una opción--</option>');
            } else {
                $.ajax({
                    type: 'GET',
                    url: "{{ url('api-obtener-tipos-servicio') }}",
                    data: {
                        service_area_id: value
                    }
                }).done(function(response) {

                    var html = `<option value>--Seleccione una opción--</option>`;
                    $.each(response, function(index, item) {
                        html += `<option value="${item.id}">${item.name}</option>`;
                    });
                    $("#service_id").html(html);
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    console.log("The following error occured: " + textStatus + " " + errorThrown);
                });
            }
        }
    </script>
@endsection
