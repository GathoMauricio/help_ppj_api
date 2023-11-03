@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <b style="color:rgb(234,81,70);">Editar password usuario {{ $usuario->email }}</b>
                    </div>
                    <div class="card-body" style="background-color: rgb(43,51,60);">
                        <form action="{{ url('update_password_usuarios', $usuario->id) }}" method="POST" class="form">
                            @csrf
                            @method('PUT')
                            <div class="row">
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
