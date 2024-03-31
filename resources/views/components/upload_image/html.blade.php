{{-- CARA PAKAI --}}
{{-- Tambahkan 

    <textarea id="image-dropify-send" class="d-none" name="image" required></textarea> 
    
    untuk hasil dari imagenya, name sesuaikan dengan attribut database
    --}}


<label for="image-dropify" class="col-form-label" style="font-weight: 500">Upload Item</label>
<input id="image-dropify" type="file" class="form-control dropify" data-width="200" data-height="200" accept="image/*"
    data-max-file-size="2M">
<p class="text-danger text-small font-weight-bold m-0">*Ukuran gambar max 2MB</p>
<div class="modal " tabindex="-1" data-backdrop="static" data-keyboard="false" id="myModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white text-center">
                <h5 class="modal-title ">Sesuaikan Gambar <i class="fas fa-crop-alt"></i></h5>
            </div>
            <div class="modal-body">
                <div id="cropie-demo"></div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" id="crop" class="btn btn-success col-6">Potong</button>
            </div>
        </div>
    </div>
</div>
