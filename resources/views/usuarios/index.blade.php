@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <b style="color:rgb(234,81,70);">Usuarios</b>
                        <a href="{{ url('create_usuarios') }}" class="btn btn-primary" style="float: right;">Agregar
                            usuario</a>
                    </div>
                    <div class="card-body" style="background-color: rgb(43,51,60);">
                        {{ $usuarios->links('pagination::bootstrap-4') }}
                        <table class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>Centro de costo</th>
                                    <th>Rol</th>
                                    <th>Estatus</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $key => $usuario)
                                    <tr>
                                        <td>{{ $usuario->centro_costo }}</td>
                                        <td>{{ $usuario->rol->name }}</td>
                                        <td>{{ $usuario->status }}</td>
                                        <td>{{ $usuario->name }} {{ $usuario->middle_name }} {{ $usuario->last_name }}</td>
                                        <td>{{ $usuario->email }}</td>
                                        <td>{{ $usuario->phone }}</td>
                                        <td>{{ $usuario->address }}</td>
                                        <td>
                                            <a href="{{ url('edit_usuarios', $usuario->id) }}" class="text-info">Editar</a>
                                            <br>
                                            <a href="{{ url('edit_password_usuarios', $usuario->id) }}"
                                                class="text-warning">Password</a>
                                            <br>
                                            <a href="javascript:void(0)" onclick="eliminarUsuario({{ $usuario->id }})"
                                                class="text-danger">Eliminar</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $usuarios->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function eliminarUsuario(usuario_id) {
            alertify.confirm('Aviso', '¿Realmente desea eliminar este registro?', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: "{{ url('delete_usuarios') }}",
                    data: {
                        _method: 'DELETE',
                        usuario_id: usuario_id
                    }
                }).done(function(response) {
                    alertify.success(response.message);
                    if (response.status == 1)
                        window.location.reload();

                }).fail(function(jqXHR, textStatus, errorThrown) {
                    console.log("The following error occured: " + textStatus + " " + errorThrown);
                });
            }, function() {});
        }
    </script>
@endsection
