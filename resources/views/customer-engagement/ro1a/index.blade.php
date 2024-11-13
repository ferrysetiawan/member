@extends('layouts.global')

@section('title')
    RO1A
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>HALAMAN DATA R01.A</h1>
    </div>

    <div class="section-body">
        <div class="row my-5">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <h3 class="text-light">TABEL R01.A</h3>
                        <span>
                            <a href="{{ route('r01a.create') }}" class="btn btn-light">Tambah R01.A</a>
                        </span>
                    </div>
                    <div class="">
                        <div class="card-body">
                                <!-- Tambahkan ID pada tabel -->
                                <table class="table table-bordered" id="tableR01A" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Customer</th>
                                            <th>Waktu Terakhir Pengiriman</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Tabel akan diisi oleh DataTables secara dinamis -->
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Inisialisasi DataTables dengan AJAX
        $('#tableR01A').DataTable({
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            processing: true, // Menampilkan indikator loading saat data diproses
            serverSide: true, // Menggunakan server-side processing
            ajax: {
                url: 'api/r01a', // Endpoint yang mengembalikan data dalam JSON
                type: 'GET'
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'customer_name', name: 'customer_name' },
                { data: 'latest_delivery_date', name: 'latest_delivery_date' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection
