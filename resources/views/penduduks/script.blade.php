<script>
    //fungsi untuk menampilkan data
    $(document).ready(function() {
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $('#tablePenduduk').DataTable({
            // dom: 'Bfrtip', 
            // buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print'],
            ajax: {
                url: '/penduduk/datatables',
                type: 'GET',
                "serverSide": true,
                "processing": true,
                
            },
            columns: [
                { data: 'nik' },
                { data: 'nama' },
                { data: 'usia' },
                { 
                    data: 'alamat',
                    render: function (data, type, row) {
                        // Batasi jumlah karakter alamat menjadi 15 karakter
                        return data.length > 15 ? data.substr(0, 50) + '...' : data;
                    }
                },
                { data: 'pekerjaan' },
                { 
                    data: 'created_at',
                    render: function (data, type, row) {
                        return moment(data).format('YYYY-MM-DD HH:mm:ss');
                    }
                },
                { 
                    data: null,
                    render: function (data, type, row) {
                        return '<i class="fa-solid fa-pen-to-square" onclick="editPenduduk(' + row.id + ')"></i> ' +
                            '<span style="margin-right: 10px;"></span>' +    
                            '<i class="fa-solid fa-trash" onclick="deletePenduduk(' + row.id + ')"></i>';
                    }
                }
            ],
            order: [[0, 'asc']]
        });
    });

    //fungsi untuk menyimpan data yang diinput
    function savePenduduk() {
        var id = $('#id').val();
        var method = (id === '') ? 'POST' : 'PUT';
        var data = {
            nik: $('#nik').val(),
            nama: $('#nama').val(),
            usia: $('#usia').val(),
            alamat: $('#alamat').val(),
            pekerjaan: $('#pekerjaan').val(),
        };
        $.ajax({
            url: '/penduduk' + (method === 'POST' ? '' : '/' + id),
            type: method,
            data:data,
            success: function (response) {
                Swal.fire({
                    title: 'Sukses',
                    text: 'Data berhasil disimpan',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        clearForm();
                        $('#tablePenduduk').DataTable().ajax.reload();
                        $('#pendudukFormModal').modal('hide');
                    }
                });
            },
            error: function (error) {
                Swal.fire({
                    title: 'Error',
                    text: 'Gagal menyimpan data. Periksa kembali input Anda.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    }

    //edit data penduduk
    function editPenduduk(id) {
    $.ajax({
        url: '/penduduk/' + id,
        type: 'GET',
        success: function (response) {
            $('#id').val(response.penduduk.id);
            $('#nik').val(response.penduduk.nik);
            $('#nama').val(response.penduduk.nama);
            $('#usia').val(response.penduduk.usia);
            $('#alamat').val(response.penduduk.alamat);
            $('#pekerjaan').val(response.penduduk.pekerjaan);
            $('#pendudukFormModalLabel').text('Form Edit Data');
            $('#simpan').text('Simpan Perubahan');
            $('#pendudukFormModal').modal('show');
        },
        error: function (error) {
            Swal.fire({
                    title: 'Error',
                    text: 'Gagal mengambil data Penduduk.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
        }
    });
}


    function deletePenduduk(id) {
        // Menampilkan modal konfirmasi penghapusan
        Swal.fire({
            title: 'Konfirmasi Hapus Data',
            text: 'Apakah Anda yakin ingin menghapus data ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika pengguna mengonfirmasi penghapusan
                $.ajax({
                    url: '/penduduk/' + id,
                    type: 'DELETE',
                    success: function (response) {
                        // Menampilkan notifikasi sukses
                        Swal.fire({
                            title: 'Sukses',
                            text: 'Data berhasil dihapus',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Memuat ulang data setelah penghapusan
                            $('#tablePenduduk').DataTable().ajax.reload();
                        });
                    },
                    error: function (xhr, status, error) {
                        // Menampilkan notifikasi kesalahan
                        if (xhr.status == 404) {
                            Swal.fire({
                                title: 'Peringatan',
                                text: 'Data dengan ID tersebut tidak ditemukan.',
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Gagal menghapus data jenjang.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            }
        });
    }

    //fungsi untuk menghapus isi form yang sudah diisi
    function clearForm() {
    $('#nik').val('');
    $('#nama').val('');
    $('#usia').val('');
    $('#alamat').val('');
    $('#pekerjaan').val('');
 }
</script>