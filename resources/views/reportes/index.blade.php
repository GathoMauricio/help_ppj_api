@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2><b style="color:rgb(234,81,70);">Reporte</b></h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('generar_reporte') }}" method="POST">
                            @csrf
                            <h4>Seleccione la fecha inicial</h4>
                            <input type="date" class="form-control" name="inicio" required>
                            <h4>Seleccione la fecha final</h4>
                            <input type="date" class="form-control" name="final" required>
                            <br>
                            <input type="submit" class="btn btn-primary" style="width: 100%" value="GENERAR">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
