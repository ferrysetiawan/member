@extends('layouts.global')

@section('title')
    RO1A
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2-bootstrap4.css') }}">
    <style>
        .is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
        }
    </style>

@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>TAMBAH DATA R01.A</h1>
    </div>

    <div class="section-body">
        <div class="row my-5">
            <div class="col-lg-4">
                <div class="card shadow">

                    <div class="">
                        <div class="card-body">
                                <div class="form-group">
                                    <label>Customer</label>
                                    <select class="form-control select2" id="customer_id"></select>
                                </div>
                                <div class="form-group">
                                    <label for="">No Whatsapp</label>
                                    <input type="text" class="form-control" id="no_whatsapp">
                                </div>
                                <div class="form-group">
                                    <label for="">alamat</label>
                                    <textarea name="" class="form-control" cols="30" rows="10" id="alamat"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Gambar</label>
                                    <input type="file" class="form-control" id="gambar">
                                </div>
                                <div class="form-group">
                                    <label for="">Tanggal Pengiriman</label>
                                    <input type="datetime-local" class="form-control" name="delivery_date" id="delivery_date">
                                </div>
                                <div class="form-group">
                                    <label for="">Note</label>
                                    <textarea name="notes" class="form-control" cols="30" rows="10" id="notes"></textarea>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card shadow">

                    <div class="">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label>Menu</label>
                                        <select class="form-control select2" id="menu"></select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="">Quantity</label>
                                        <input type="number" class="form-control" id="quantity">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button class="btn btn-primary btn-block" id="add-menu-btn">Tambah Menu</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow">

                    <div class="">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table teble-bordered" id="menu-table">
                                        <thead>
                                            <tr>
                                                <th>Menu</th>
                                                <th>Qty</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                {{-- <tr data-id="1">
                                                    <td>
                                                        <input type="hidden" name="menus[0][id]" value="1" class="menu-id">
                                                        <span>Nama Menu</span>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="menus[0][quantity]" value="2" class="menu-quantity">
                                                    </td>
                                                    <td><button class="btn btn-danger btn-delete">x</button></td>
                                                </tr> --}}
                                                <td colspan="3" class="text-center">tidak ada menu</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-lg-12">
                                    <button class="btn btn-success btn-block">Simpan Data</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('js')
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
       $(document).ready(function() {
    // Hide the WhatsApp and address fields by default
    $('#no_whatsapp').parent().hide();
    $('#alamat').parent().hide();

    // Initialize Select2 for selecting the customer
    $('#customer_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Pilih Customer',
        ajax: {
            url: '/customer-engagement/api/customers',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return { search: params.term }; // Send the search parameter
            },
            processResults: function(data) {
                return { results: data };
            }
        },
        minimumInputLength: 1,
        templateResult: formatCustomer,
        templateSelection: formatCustomerSelection
    });

    function formatCustomer(customer) {
        if (!customer.id) {
            return customer.text;
        }
        var $customer = $('<div><strong>' + customer.text + ' - ' + customer.phone + ' - ' + customer.address + '</strong></div>');
        return $customer;
    }

    function formatCustomerSelection(customer) {
        return customer.nama_pelanggan || customer.text; // Display only the customer name
    }

    // Event listener for selecting a customer
    $('#customer_id').on('select2:select', function(e) {
        var selectedCustomer = e.params.data;
        $('#no_whatsapp').parent().show();
        $('#alamat').parent().show();
        $('#no_whatsapp').val(selectedCustomer.phone || '');
        $('#alamat').val(selectedCustomer.address || '');
    });

    // Array to store the selected menu items
    let menuData = [];

    // Initialize Select2 for selecting menu
    $('#menu').select2({
        theme: 'bootstrap4',
        placeholder: 'Pilih Menu',
        ajax: {
            url: '/customer-engagement/api/menus',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return { search: params.term }; // Send the search parameter
            },
            processResults: function(data) {
                return { results: data };
            }
        },
        minimumInputLength: 1
    });

    // Event listener to handle adding menu when 'Tambah Menu' button is clicked
    $('#add-menu-btn').on('click', function() {
        var selectedMenu = $('#menu').val(); // Get the selected menu ID
        var selectedMenuText = $('#menu option:selected').text(); // Get the selected menu name
        var quantity = $('#quantity').val(); // Get the quantity value

        if (quantity && selectedMenu) {
            // Check if the menu is already in the table (in menuData array)
            let existingItem = menuData.find(item => item.id === selectedMenu);

            if (existingItem) {
                // If the menu already exists, update the quantity
                existingItem.quantity += parseInt(quantity);
            } else {
                // If the menu doesn't exist, add it to the array
                menuData.push({
                    id: selectedMenu,
                    name: selectedMenuText,
                    quantity: parseInt(quantity)
                });
            }

            console.log(quantity);

            // Update the table display
            updateMenuTable();

            // Clear the input fields
            $('#menu').val(null).trigger('change');
            $('#quantity').val('');
        }
    });

    // Function to update the menu table display
    function updateMenuTable() {
        let tableBody = $('#menu-table tbody');
        tableBody.empty(); // Kosongkan tabel sebelum diisi ulang

        if (menuData.length === 0) {
            // Tambahkan baris dengan pesan jika menuData kosong
            tableBody.append('<tr><td colspan="3" class="text-center">Tidak ada menu</td></tr>');
        } else {
            // Render baris data menu jika ada item
            menuData.forEach(function(item) {
                let row = `<tr data-id="${item.id}">
                    <td>${item.name}</td>
                    <td>${item.quantity}</td>
                    <td><button class="btn btn-danger btn-delete" data-id="${item.id}">x</button></td>
                </tr>`;
                tableBody.append(row);
            });
        }
    }


    // Event listener for deleting a menu item from the table (corrected)
    $(document).on('click', '.btn-delete', function() {
        let itemId = String($(this).data('id')); // Pastikan itemId adalah string
        console.log("Menghapus item dengan ID:", itemId); // Untuk debugging

        // Filter item dari array menuData
        menuData = menuData.filter(item => String(item.id) !== itemId); // Samakan tipe data dengan String()

        console.log("Data setelah penghapusan:", menuData); // Cek apakah array di-update
        updateMenuTable(); // Perbarui tampilan tabel
    });

    // Fungsi untuk menangani kesalahan dari server
    function handleAjaxError(xhr) {
        if (xhr.status === 422) {
            var errors = xhr.responseJSON.errors;
            // Hapus pesan kesalahan sebelumnya
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            // Tampilkan pesan kesalahan validasi
            for (var key in errors) {
                if (errors.hasOwnProperty(key)) {
                    var errorMessage = errors[key][0];

                    // Menangani pesan kesalahan untuk field khusus
                    if (key === 'menus') {
                        // Menambahkan pesan error di dekat tabel menu jika validasi menus gagal
                        $('#menu-table').before('<div class="text-danger mb-2">' + errorMessage + '</div>');
                    } else if (key.startsWith('menus.')) {
                        // Menangani kesalahan untuk item menu tertentu, misalnya 'menus.0.quantity'
                        var index = key.split('.')[1]; // Mendapatkan index dari menus
                        var field = key.split('.')[2]; // Mendapatkan nama field ('id' atau 'quantity')

                        if (field === 'id' || field === 'quantity') {
                            // Menampilkan error pada elemen input berdasarkan indeks
                            $('#menu-table tbody tr').eq(index).find('.' + field).addClass('is-invalid');
                            $('#menu-table tbody tr').eq(index).find('.' + field).after('<div class="invalid-feedback">' + errorMessage + '</div>');
                        }
                    } else {
                        // Menangani error untuk elemen lainnya
                        $('#' + key).addClass('is-invalid');
                        // Hapus pesan kesalahan sebelumnya
                        $('#' + key).next('.invalid-feedback').remove();
                        // Tambahkan pesan kesalahan baru
                        $('#' + key).after('<div class="invalid-feedback">' + errorMessage + '</div>');
                    }
                }
            }
        } else {
            console.error(xhr.responseText);
        }
    }

    // Event listener for saving data when 'Simpan Data' button is clicked
    $('.btn-success').on('click', function() {
        let customer_id = $('#customer_id').val();
        let delivery_date = $('#delivery_date').val();
        let notes = $('#notes').val();
        let gambar = $('#gambar')[0].files[0]; // Ambil file gambar dari input file

        // Buat objek FormData
        let formData = new FormData();
        formData.append('customer_id', customer_id);
        formData.append('delivery_date', delivery_date);
        formData.append('notes', notes);
        formData.append('gambar', gambar); // Menambahkan file gambar

        // Loop untuk menambahkan data menus ke FormData
        menuData.forEach(function(menuItem, index) {
            formData.append(`menus[${index}][id]`, menuItem.id); // Menyertakan ID menu
            formData.append(`menus[${index}][quantity]`, menuItem.quantity); // Menyertakan quantity menu
        });

        formData.append('_token', '{{ csrf_token() }}'); // Menambahkan token CSRF

        // Kirim data ke server menggunakan AJAX
        $.ajax({
            url: '/customer-engagement/r01a/store',
            type: 'POST',
            data: formData,
            processData: false, // Jangan memproses data
            contentType: false, // Jangan set contentType secara manual, biarkan browser menentukannya
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'BERHASIL!',
                    text: 'DATA BERHASIL DISIMPAN!',
                    showConfirmButton: false,
                    timer: 3000
                }).then(function () {
                    location.reload();
                });
            },
            error: function(xhr) {
                handleAjaxError(xhr); // Panggil fungsi untuk menampilkan pesan kesalahan
            }
        });
    });

});




    </script>
@endsection
