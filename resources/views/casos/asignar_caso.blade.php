<!-- Modal -->
<div class="modal fade" id="modal_asignar_caso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle" style="color:rgb(234,81,70);font-weight:bold;">
                    Asignar caso</h5>
            </div>
            <form action="{{ url('asignar_caso') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="caso_id" id="txt_caso_id">
                <div class="modal-body" id="modal_body_seguimientos" style="background-color: rgb(43,51,60)">
                    <div class="card">
                        <div class="form-group p-2">
                            <label for="tecnico_id" class="p-1" style="font-weight: bold;">Seleccione una
                                opción</label>
                            <select name="tecnico_id" id="tecnico_id" class="form-select" required>
                                <option value>--Seleccione una opción--</option>
                                @foreach ($tecnicos as $key => $tecnico)
                                    <option value="{{ $tecnico->id }}">{{ $tecnico->name }} {{ $tecnico->middle_name }}
                                        {{ $tecnico->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit"
                        style="float:right; background-color: rgb(234,81,70);">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
