@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <b style="color:rgb(234,81,70);">Editar usuario {{ $usuario->email }}</b>
                    </div>
                    <div class="card-body" style="background-color: rgb(43,51,60);">
                        <form action="{{ url('update_usuarios', $usuario->id) }}" method="POST" class="form">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="centro_costo" style="font-weight:bold;color:rgb(251,199,0)">Centro de
                                            costo</label>
                                        <input type="text" name="centro_costo"
                                            value="{{ old('centro_costo', $usuario->centro_costo) }}" class="form-control">
                                        @error('centro_costo')
                                            <span style="color:red">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="user_rol_id" style="font-weight:bold;color:rgb(251,199,0)">Rol</label>
                                        <select name="user_rol_id" id="user_rol_id" class="form-select">
                                            <option value>--Seleccione una opción--</option>
                                            @foreach ($roles as $rol)
                                                @if (old('user_rol_id', $usuario->user_rol_id) == $rol->id)
                                                    <option value="{{ $rol->id }}" selected>{{ $rol->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('user_rol_id')
                                            <span style="color:red">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="status" style="font-weight:bold;color:rgb(251,199,0)">Estatus</label>
                                        <select name="status" id="status" class="form-select">
                                            <option value>--Seleccione una opción--</option>
                                            @if ($usuario->status == 'Activo')
                                                <option value="Activo" selected>Activo</option>
                                                <option value="Inactivo">Inactivo</option>
                                            @else
                                                <option value="Activo">Activo</option>
                                                <option value="Inactivo" selected>Inactivo</option>
                                            @endif
                                        </select>
                                        @error('status')
                                            <span style="color:red">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name"
                                                style="font-weight:bold;color:rgb(251,199,0)">Nombre</label>
                                            <input type="text" name="name" value="{{ old('name', $usuario->name) }}"
                                                class="form-control">
                                            @error('name')
                                                <span style="color:red">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="middle_name" style="font-weight:bold;color:rgb(251,199,0)">A.
                                                patermo</label>
                                            <input type="text" name="middle_name"
                                                value="{{ old('middle_name', $usuario->middle_name) }}"
                                                class="form-control">
                                            @error('middle_name')
                                                <span style="color:red">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name" style="font-weight:bold;color:rgb(251,199,0)">A.
                                                materno</label>
                                            <input type="text" name="last_name"
                                                value="{{ old('last_name', $usuario->last_name) }}" class="form-control">
                                            @error('last_name')
                                                <span style="color:red">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email"
                                                style="font-weight:bold;color:rgb(251,199,0)">Email</label>
                                            <input type="email" value="{{ $usuario->email }}" class="form-control"
                                                readonly>
                                            @error('email')
                                                <span style="color:red">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone"
                                                style="font-weight:bold;color:rgb(251,199,0)">Teléfono</label>
                                            <input type="text" name="phone"
                                                value="{{ old('phone', $usuario->phone) }}" class="form-control">
                                            @error('phone')
                                                <span style="color:red">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="address"
                                                style="font-weight:bold;color:rgb(251,199,0)">Dirección</label>
                                            <textarea name="address" class="form-control">{{ old('address', $usuario->address) }}</textarea>
                                            @error('address')
                                                <span style="color:red">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 p-3">
                                        <button type="submit" class="btn btn-primary"
                                            style="float:right; background-color: rgb(234,81,70);">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
