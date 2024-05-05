<script>
    //fungsi untuk menampilkan data
    $(document).ready(function() {
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $('#tableProduct').DataTable({
            dom: 'Bfrtip',
            buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print'],
            ajax: {
                url: '/product/datatables',
                type: 'GET',
                "serverSide": true,
                "processing": true,

            },
            columns: [
                { data: 'sku' },
                { data: 'deskripsi' },
                {
                    data: 'harga',
                    render: function(data, type, row) {
                        // Ubah angka menjadi format rupiah
                        return formatRupiah(data, 'Rp ');
                    }
                },
                { data: 'stok' },
                    {
                        data: 'categories',
                        render: function (data, type, row) {
                            var categories = data.map(function(category) {
                                return category.nama_kategori;
                            });
                            return categories.join(', '); // Gabungkan nama kategori menjadi satu string
                        }
                    }, 

                                {
                                    "data": "photo",
                                    "render": function(data, type, row, meta) {
                                        return '<img src="{{asset('photos')}}/' + data + '" alt="Product Image" style="width: 100px; height: auto;" />';
                                    }
                                },

                {
                    data: 'created_at',
                    render: function (data, type, row) {
                        return moment(data).format('YYYY-MM-DD HH:mm:ss');
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        return '<i class="fa-solid fa-pen-to-square" onclick="editProduct(' + row.id + ')"></i> ' +
                            '<span style="margin-right: 10px;"></span>' +
                            '<i class="fa-solid fa-trash" onclick="deleteProduct(' + row.id + ')"></i>';
                    }
                }
            ],
            order: [[0, 'asc']]
        });
    });

    //fungsi untuk menyimpan data yang diinput
function saveProduct() {
    var id = $('#id').val();
    var method = (id === '') ? 'POST' : 'POST';
    var categories = $('#category_id').val();

    var formData = new FormData();
    formData.append('id', $('#id').val());
    formData.append('sku', $('#sku').val());
    formData.append('deskripsi', $('#deskripsi').val());
    formData.append('harga', $('#harga').val());
    formData.append('stok', $('#stok').val());

    // Hanya menambahkan file foto ke FormData jika ada file yang dipilih
    var photoFile = $('#photo')[0].files[0];
    if (photoFile) {
        formData.append('photo', photoFile);
    }

    categories.forEach(function(category) {
        formData.append('category_id[]', category);
    });

    $.ajax({
        url: '/product' + (id === '' ? '' : '/' + id),
        type: method,
        data: formData,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        success: function (response) {
            Swal.fire({
                title: 'Sukses',
                text: 'Data berhasil disimpan',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    clearForm();
                    $('#tableProduct').DataTable().ajax.reload();
                    $('#productFormModal').modal('hide');
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


    //edit data product
function editProduct(id) {
    $.ajax({
        url: '/product/' + id,
        type: 'GET',
        success: function (response) {
            // Set nilai-nlai produk ke dalam elemen-elemen formulir
            $('#id').val(response.product.id);
            $('#sku').val(response.product.sku);
            $('#deskripsi').val(response.product.deskripsi);
            $('#harga').val(response.product.harga);
            $('#stok').val(response.product.stok);

            // Set nilai category_id (jika diperlukan)
            var categoryIds = response.product.category_id;
            $('#category_id').val(categoryIds);
            $('#category_id').trigger('change');

            // Set foto jika ada
            if (response.product.photo) {
                $('#photo').attr('src', '/photos/' + response.product.photo); // Atur atribut src untuk menampilkan gambar
            } else {
                $('#photo').removeAttr('src'); // Hapus gambar jika tidak ada
            }

            // Tampilkan modal
            $('#productFormModalLabel').text('Form Edit Data');
            $('#simpanProduct').text('Simpan Perubahan');
            $('#productFormModal').modal('show');
        },
        error: function (error) {
            Swal.fire({
                title: 'Error',
                text: 'Gagal mengambil data Product.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
}



    function deleteProduct(id) {
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
                    url: '/product/' + id,
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
                            $('#tableProduct').DataTable().ajax.reload();
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
    $('#id').val('');
    $('#sku').val('');
    $('#deskripsi').val('');
    $('#harga').val('');
    $('#stok').val('');
    $('#category_id').val('');
    $('#photo').val('');
 }
</script>

