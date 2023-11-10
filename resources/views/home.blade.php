@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <b style="color:rgb(234,81,70);">Mis casos</b>
                        <br>
                        <a href="{{ url('api/api-descargar-android-app') }}" target="_BLANK">Descargar APK</a>
                        @if (Auth::user()->user_rol_id == 3)
                            <a href="{{ url('create_caso') }}" class="btn btn-primary" style="float: right;">Iniciar caso</a>
                        @endif
                    </div>
                    <div class="card-body" style="background-color: rgb(43,51,60)">
                        <div style="float: right;">
                            {{ $casos->links('pagination::bootstrap-4') }}
                        </div>
                        <table class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Estatus</th>
                                    <th>Contacto</th>
                                    <th>Área</th>
                                    <th>Tipo</th>
                                    <th>Descripción</th>
                                    <th>Fecha</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($casos as $caso)
                                    <tr>
                                        <th>{{ $caso->num_case }}</th>
                                        <td>{{ $caso->estatus->name }}</td>
                                        <td>
                                            {{ $caso->contacto->name }}
                                            {{ $caso->contacto->middle_name }}
                                            {{ $caso->contacto->last_name }}
                                            <br>
                                            {{ $caso->contacto->centro_costo }}
                                        </td>
                                        <td>{{ $caso->tipo_servicio->area->name }}</td>
                                        <td>{{ $caso->tipo_servicio->name }}</td>
                                        <td>{{ $caso->description }}</td>
                                        <td>{{ $caso->created_at }}</td>
                                        <td>
                                            <a href="javascript:void(0);" onclick="cargarSeguimientos({{ $caso->id }})"
                                                class="text-primary">({{ count($caso->seguimientos) }})Seguimientos</a>
                                            <br>
                                            <a href="javascript:void(0);" onclick="cargarAdjuntos({{ $caso->id }})"
                                                class="text-info">({{ count($caso->archivos) }})Adjuntos</a>
                                            @if (Auth::user()->user_rol_id == 4)
                                                <br>
                                                <a href="{{ url('edit_caso', $caso->id) }}" class="text-warning">Editar</a>
                                                <br>
                                                <a onclick="eliminarCaso({{ $caso->id }})" href="javascript:void(0)"
                                                    class="text-danger">Eliminar</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div style="float: right;">
                            {{ $casos->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('casos.seguimientos')
    @include('casos.adjuntos')
    <script>
        var caso_actual = 0;
        $(document).ready(function() {
            $("#form_nuevo_seguimiento").submit(function(e) {
                e.preventDefault();
                var texto = $("#txt_nuevo_seguimiento").val();
                if (texto.length > 0) {
                    console.log(texto);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: "{{ url('store_seguimiento') }}",
                        data: {
                            caso_actual: caso_actual,
                            texto: texto
                        }
                    }).done(function(response) {
                        cargarSeguimientos(response.case_id);
                        $("#form_nuevo_seguimiento")[0].reset();
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        console.log("The following error occured: " + textStatus + " " +
                            errorThrown);
                    });
                }
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#form_nuevo_adjunto").submit(function(e) {
                e.preventDefault();
                var formData = new FormData();
                var files = $('#file_nuevo_adjunto')[0].files[0];
                if (document.getElementById("file_nuevo_adjunto").files.length > 0) {
                    formData.append('file', files);
                    formData.append('case_id', caso_actual);
                    $.ajax({
                        url: 'store_adjunto',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {

                            cargarAdjuntos(response.case_id)
                            $("#form_nuevo_adjunto")[0].reset();
                        }
                    });
                }

            });
        });

        function cargarAdjuntos(caso_id) {
            caso_actual = caso_id;
            $.ajax({
                type: 'GET',
                url: "{{ url('cargar_adjuntos') }}",
                data: {
                    caso_id: caso_id
                }
            }).done(function(response) {

                var html = ``;
                $("#modal_body_adjuntos").html(html);
                var counter = 0;
                $.each(response, function(index, item) {
                    counter++;
                    html += `
                    <div class="col-md-4 p-1">
                        <img src="${item}" alt="${item}" style="width:200px;">
                    </div>
                    `;
                });
                if (counter <= 0) {
                    var html = `<center  style="color:white;">Aún no hay adjuntos</center>`;
                }
                $("#modal_body_adjuntos").html(html);
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log("The following error occured: " + textStatus + " " + errorThrown);
            });
            $("#modal_adjuntos").modal('show');
        }

        function cargarSeguimientos(caso_id) {
            caso_actual = caso_id;
            $.ajax({
                type: 'GET',
                url: "{{ url('cargar_seguimientos') }}",
                data: {
                    caso_id: caso_id
                }
            }).done(function(response) {
                var html = ``;
                $("#modal_body_seguimientos").html(html);
                var counter = 0;
                $.each(response, function(index, item) {
                    counter++;
                    html += `
                    <div class="card">
                        <div class="card-header">
                            <b class="text-primary">${item.autor}</b>
                            <br>
                            ${item.body}
                            <br>
                            <span style="float: right;">${item.fecha}</span>
                        </div>
                    </div>
                    `;
                });
                if (counter <= 0) {
                    var html = `<center style="color:white;">Aún no hay seguimientos</center>`;
                }
                $("#modal_body_seguimientos").html(html);
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log("The following error occured: " + textStatus + " " + errorThrown);
            });
            $("#modal_seguimientos").modal('show');
        }

        function eliminarCaso(case_id) {
            alertify.confirm('Aviso', '¿Realmente desea eliminar este registro?', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: "{{ url('delete_caso') }}",
                    data: {
                        _method: 'DELETE',
                        case_id: case_id
                    }
                }).done(function(response) {
                    alertify.success(response.message);
                    if (response.status == 1)
                        window.location.reload();

                }).fail(function(jqXHR, textStatus, errorThrown) {
                    console.log("The following error occured: " + textStatus + " " + errorThrown);
                });
            }, function() {

            });
        }
    </script>
@endsection
