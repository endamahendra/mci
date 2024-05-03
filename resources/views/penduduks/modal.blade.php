<!-- Modal untuk Form Jenjang -->
<div class="modal fade" id="pendudukFormModal" tabindex="-1" role="dialog" aria-labelledby="pendudukFormModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pendudukFormModalLabel">Form Tambah penduduk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> 
            <div class="modal-body">
                <form class="row g-3" id="pendudukForm">
                    @csrf
                    <input type="hidden" id="id">
                    <div class="col-md-12">
                        <input type="number" id="nik" class="form-control" placeholder="Nomor Induk Kependudukan">
                    </div>
                    <div class="col-md-12">
                        <input type="text" id="nama" class="form-control" placeholder="Nama Lengkap">
                    </div>
                    <div class="col-md-12">
                        <input type="number" id="usia" class="form-control" placeholder="Usia">
                    </div>
                    <div class="col-md-12">
                        <textarea name="alamat" class="form-control" id="alamat" cols="30" rows="4" placeholder="Alamat"></textarea>
                    </div>
                    <div class="col-md-12">
                        <input type="text" id="pekerjaan" class="form-control" placeholder="Pekerjaan">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="button" onclick="savePenduduk()" id="simpanPenduduk" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>