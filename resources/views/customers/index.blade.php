@extends('layouts.global')

@section('title')
    Data Customer
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Halaman Data Customer</h1>
    </div>

    <div class="section-body">
        <div class="row my-5">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <h3 class="text-light">Tabel Customer</h3>
                        <span>
                            <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#importModal">Import Customer</button>
                            <button type="button" class="btn btn-light" data-toggle="modal" data-target="#addModal">
                                Tambah Customer
                            </button>
                        </span>

                    </div>
                    <div class="">
                        <div class="card-body">
                            <table class="table table-bordered table-md" id="tableCustomer">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Customer</th>
                                        <th>Alamat</th>
                                        <th width="80px">Tgl Lahir</th>
                                        <th>no Telp</th>
                                        <th>Email</th>
                                        <th width="100px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Import Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form untuk menambahkan data -->
                <form autocomplete="off" id="importForm">
                    <div class="form-group">
                        <label for="field_name">File</label>
                        <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file">
                        @error('file')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!-- Tambahkan input lainnya jika diperlukan -->
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form untuk menambahkan data -->
                <form autocomplete="off" id="addForm">
                    <div class="form-group">
                        <label for="field_name">Nama Customer</label>
                        <input type="text" class="form-control @error('nama_pelanggan') is-invalid @enderror" id="nama_pelanggan" name="nama_pelanggan">
                        @error('nama_pelanggan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="field_name">No Whatsapp</label>
                        <input type="text" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp" name="no_telp">
                        @error('no_telp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="field_name">Tanggal Lahir</label>
                        <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir">
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" id="alamat"></textarea>
                        @error('alamat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="field_name">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!-- Tambahkan input lainnya jika diperlukan -->
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form autocomplete="off" id="editForm" data-id="" method="POST">
                    <div class="form-group">
                        <label for="nama_pelangganan">Nama Customer</label>
                        <input type="text" class="form-control" id="nama_pelangganan" name="nama_pelanggan">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="no_telpan">No Whatsapp</label>
                        <input type="text" class="form-control" id="no_telpan" name="no_telp">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahiran">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahiran" name="tanggal_lahir">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="alamatan">Alamat</label>
                        <textarea name="alamat" class="form-control" id="alamatan"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="emailan">Email</label>
                        <input type="email" class="form-control" id="emailan" name="email">
                        <div class="invalid-feedback"></div>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="updateData()">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

    <script>
        function openEditModal(id) {
    // Reset ID untuk menghindari konflik
    $('#editForm').data('id', id); // Mengatur ID yang baru
    $.ajax({
        url: '{{ url("data-customer") }}/' + id + '/edit',
        type: 'GET',
        success: function (response) {
            if (response) {
                // Mengisi form dengan data pelanggan
                $('#nama_pelangganan').val(response.nama_pelanggan);
                $('#no_telpan').val(response.no_telp);
                $('#tanggal_lahiran').val(response.tanggal_lahir);
                $('#alamatan').val(response.alamat);
                $('#emailan').val(response.email);
                $('#editModal').modal('show');
            } else {
                console.error('Data tidak ditemukan atau struktur respons tidak sesuai.');
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Gagal mendapatkan data. Silakan coba lagi.',
            });
        }
    });
}

function updateData() {
    var kategoriId = $('#editForm').data('id'); // Ambil ID dari data form
    var updateUrl = '{{ route("update.pelanggan", "") }}/' + kategoriId;

    var formData = {
        nama_pelanggan: $('#nama_pelangganan').val(),
        no_telp: $('#no_telpan').val(),
        tanggal_lahir: $('#tanggal_lahiran').val(),
        alamat: $('#alamatan').val(),
        email: $('#emailan').val(),
        _method: 'PUT' // Menandakan bahwa ini adalah metode PUT
    };

    // Menghapus kelas error dan pesan
    $(".form-control").removeClass('is-invalid');
    $(".invalid-feedback").remove();

    $.ajax({
        url: updateUrl,
        type: 'POST',
        data: formData,
        success: function (response) {
            if (response.status === "success") {
                Swal.fire({
                    icon: 'success',
                    title: 'BERHASIL!',
                    text: 'DATA BERHASIL DIUBAH!',
                    showConfirmButton: false,
                    timer: 3000
                }).then(function () {
                    // Update data customer di tabel tanpa reload halaman
                    updateCustomerRow(response.data); // Fungsi untuk memperbarui data di tabel
                    var dataTable = $('#tableCustomer').DataTable();
                    dataTable.ajax.reload();
                    $('#editModal').modal('hide');
                    resetEditForm();
                });
            } else {
                console.error('Pembaruan gagal: ' + (response.status || 'Terjadi kesalahan.'));
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: response.message || 'Terjadi kesalahan saat memperbarui data.',
                });
            }
        },
        error: function (xhr) {
            if (xhr.status === 422) {
                var errors = xhr.responseJSON.errors;
                var idMappings = {
                    'nama_pelanggan': 'nama_pelangganan',
                    'no_telp': 'no_telpan',
                    'tanggal_lahir': 'tanggal_lahiran',
                    'alamat': 'alamatan',
                    'email': 'emailan',
                };

                if (typeof errors === 'object' && errors !== null) {
                    for (var key in errors) {
                        if (errors.hasOwnProperty(key)) {
                            var errorMessage = errors[key][0];
                            var fieldId = idMappings[key] || key;
                            $('#' + fieldId).addClass('is-invalid');
                            $('#' + fieldId).after('<div class="invalid-feedback">' + errorMessage + '</div>');
                        }
                    }
                }
            } else {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan. Silakan coba lagi.',
                });
            }
        }
    });
}

// Fungsi untuk mereset form dalam modal
function resetEditForm() {
    $('#editForm').find("input[type=text], input[type=email], input[type=date], textarea").val(""); // Kosongkan input
    $(".form-control").removeClass('is-invalid'); // Hapus kelas error
    $(".invalid-feedback").remove(); // Hapus pesan error
}

// Fungsi untuk memperbarui baris customer di tabel
function updateCustomerRow(customerData) {
    // Misalnya, Anda memiliki tabel dan ingin memperbarui baris tertentu
    var row = $('#tableCustomer').find('tr[data-id="' + customerData.id + '"]');
    if (row.length) {
        row.find('.nama_pelanggan').text(customerData.nama_pelanggan);
        row.find('.no_telp').text(customerData.no_telp);
        row.find('.tanggal_lahir').text(customerData.tanggal_lahir);
        row.find('.alamat').text(customerData.alamat);
        row.find('.email').text(customerData.email);
    }
}


// Reset form saat modal ditutup
$('#editModal').on('hidden.bs.modal', function () {
    resetEditForm();
});


        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function handleAjaxError(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    // Display validation errors
                    for (var key in errors) {
                        if (errors.hasOwnProperty(key)) {
                            var errorMessage = errors[key][0];
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).after('<div class="invalid-feedback">' + errorMessage + '</div>');
                        }
                    }
                } else {
                    console.error(xhr.responseText);
                }
            }

            $('#importForm').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('import.pelanggan') }}",
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'BERHASIL!',
                            text: 'DATA BERHASIL DI IMPORT!',
                            showConfirmButton: false,
                            timer: 3000
                        }).then(function() {
                            $('#importModal').modal('hide');
                            var dataTable = $('#tableCustomer').DataTable();
                            dataTable.ajax.reload();
                            $('#file').val('');
                        });
                    },
                    error: function(xhr, status, error) {
                        handleAjaxError(xhr);
                    }
                });
            });

            $('#addForm').submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                // Clear previous styles and error messages
                $(".form-control").removeClass('is-invalid');
                $(".invalid-feedback").remove();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('store.pelanggan') }}',
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'BERHASIL!',
                            text: 'DATA BERHASIL DISIMPAN!',
                            showConfirmButton: false,
                            timer: 3000
                        }).then(function() {
                            $('#addModal').modal('hide');
                            var dataTable = $('#table-menu').DataTable();
                            dataTable.ajax.reload();
                            $('#bahan_baku').val('');
                            $('#harga').val('');
                            $('#kategori_id').val('');
                            $('#satuan').val('');
                        });

                    },
                    error: function(xhr, status, error) {
                        handleAjaxError(xhr);
                    }
                });
            });

            var table = $('#tableCustomer').DataTable({
                serverSide: true,
                responsive: true,
                searching: true,
                paging: true,
                info: false,
                ordering: false,
                ajax: {
                    url: "{{ route('dashboard') }}",
                },
                columns: [
                    {
                        data: null,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { data: 'nama_pelanggan', name: 'nama_pelanggan' },
                    {
                        data: 'alamat',
                        name: 'alamat',
                        render: function (data) {
                            return data ? data : '-'; // tampilkan '-' jika kosong
                        }
                    },
                    {
                        data: 'tanggal_lahir',
                        name: 'tanggal_lahir',
                        render: function (data) {
                            return data ? data : '-'; // tampilkan '-' jika kosong
                        }
                    },
                    {
                        data: 'no_telp',
                        name: 'no_telp',
                        render: function (data) {
                            return data ? data : '-'; // tampilkan '-' jika kosong
                        }
                    },
                    {
                        data: 'email',
                        name: 'email',
                        render: function (data) {
                            return data ? data : '-'; // tampilkan '-' jika kosong
                        }
                    },
                    {
                        data: null,
                        render: function (data) {
                            return '<button class="btn btn-warning mr-1" data-toggle="tooltip" data-placement="bottom" title="ubah" onclick="openEditModal(' + data.id + ')" id="editBtn' + data.id + '"><i class="fas fa-pencil-alt"></i></button>' +
                                '<button class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="hapus" onclick="destroy(' + data.id + ')" id="' + data.id + '"><i class="fas fa-trash"></i></button>';
                        }
                    }
                ]
            });

        })

        function destroy(id) {
            var id = id;
            var token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'APAKAH KAMU YAKIN ?',
                text: "INGIN MENGHAPUS DATA INI!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'BATAL',
                confirmButtonText: 'YA, HAPUS!',
            }).then((result) => {
                if (result.isConfirmed) {
                    //ajax delete
                    jQuery.ajax({
                        url: `data-customer/${id}`,
                        data: {
                            "id": id,
                            "_token": token
                        },
                        type: 'DELETE',
                        success: function (response) {
                            if (response.status == "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'BERHASIL!',
                                    text: 'DATA BERHASIL DIHAPUS!',
                                    showConfirmButton: false,
                                    timer: 3000
                                }).then(function () {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'GAGAL!',
                                    text: 'DATA GAGAL DIHAPUS!',
                                    showConfirmButton: false,
                                    timer: 3000
                                }).then(function () {
                                    location.reload();
                                });
                            }
                        }
                    });
                }
            })
        }
    </script>
@endsection
