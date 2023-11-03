<!-- Modal -->
<div class="modal fade" id="modal_adjuntos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle" style="color:rgb(234,81,70);font-weight:bold;">
                    Adjuntos</h5>
            </div>
            <div class="modal-body" style="background-color: rgb(43,51,60)">
                <div class="container">
                    <div class="row" id="modal_body_adjuntos">
                        <div class="col-md-4 p-1">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRuRg7db1rmZHvFv0kUV_PoKvYJ6oCb29kT9Hd_TkqG&s"
                                alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form action="POST" id="form_nuevo_adjunto" style="width: 100%;" enctype="multipart/form-data">
                    <input type="file" id="file_nuevo_adjunto" class="form-control"
                        accept="image/jpg, image/jpeg, image/png">
                    <br>
                    <button class="btn btn-primary"
                        style="float:right; background-color: rgb(234,81,70);">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
