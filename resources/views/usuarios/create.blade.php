@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <b style="color:rgb(234,81,70);">Crear usuario</b>
                    </div>
                    <div class="card-body" style="background-color: rgb(43,51,60);">
                        <form action="{{ url('store_usuarios') }}" method="POST" class="form">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="centro_costo" style="font-weight:bold;color:rgb(251,199,0)">Centro de
                                            costo</label>
                                        <input type="text" value="{{ old('centro_costo') }}" name="centro_costo"
                                            class="form-control">
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
                                                @if (old('user_rol_id') == $rol->id)
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
                                            <option value="Activo">Activo</option>
                                            <option value="Inactivo">Inactivo</option>
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
                                            <input type="text" name="name" class="form-control">
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
                                            <input type="text" name="middle_name" class="form-control">
                                            @error('middle_name')
                                                <span style="color:red">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name" style="font-weight:bold;color:rgb(251,199,0)">A.
                                                materno</label>
                                            <input type="text" name="last_name" class="form-control">
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
                                            <input type="email" name="email" class="form-control">
                                            @error('email')
                                                <span style="color:red">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone"
                                                style="font-weight:bold;color:rgb(251,199,0)">Teléfono</label>
                                            <input type="text" name="phone" class="form-control">
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
                                            <textarea name="address" class="form-control"></textarea>
                                            @error('address')
                                                <span style="color:red">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password"
                                                style="font-weight:bold;color:rgb(251,199,0)">Password</label>
                                            <input type="password" name="password" class="form-control">
                                            @error('password')
                                                <span style="color:red">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirmation"
                                                style="font-weight:bold;color:rgb(251,199,0)">Confirmar
                                                password</label>
                                            <input type="password" name="password_confirmation" class="form-control">
                                            @error('password_confirmation')
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
