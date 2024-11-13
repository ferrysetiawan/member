@extends('layouts.global')

@section('title')
    {{ $customer->nama_pelanggan }}
@endsection

@section('style')

@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>DETAIL DATA R01.A</h1>
    </div>

    <div class="section-body">
        <div class="row my-5">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="">
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="20px" style="padding: 0 20px 0 0 !important; "><i class="fas fa-user"></i></td>
                                    <td width="5px" style="padding: 0 20px 0 0 !important; ">:</td>
                                    <td style="padding: 0 !important;">{{ $customer->nama_pelanggan }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0 20px 0 0 !important; "><i class="fab fa-whatsapp"></i></td>
                                    <td style="padding: 0 20px 0 0 !important; ">:</td>
                                    <td style="padding: 0 20px 0 0 !important; ">{{ $customer->no_telp }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0 20px 0 0 !important; "><i class="fas fa-map-marker-alt"></i></td>
                                    <td style="padding: 0 20px 0 0 !important; ">:</td>
                                    <td style="padding: 0 20px 0 0 !important; ">{{ $customer->alamat }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="">
                        <div class="card-body">
                            <table id="deliveriesTable" class="table table-bordered" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Gambar</th>
                                        <th>Tanggal Kirim</th>
                                        <th>Menu</th>
                                        <th>Note</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Isi tbody akan dikelola oleh DataTables -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Gambar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Gambar" class="img-fluid">
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>

    // JavaScript to update modal image source on image click
    $(document).on('click', '[data-toggle="modal"]', function() {
        let imageUrl = $(this).data('image');
        $('#modalImage').attr('src', imageUrl);
    });

    $(document).ready(function() {
        $('#deliveriesTable').DataTable({
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: '/customer-engagement/r01a/data/' + '{{ $id }}', // Pastikan endpoint URL sesuai
                type: 'GET'
            },
            columns: [
                { data: 'no', name: 'no' },
                { data: 'gambar', name: 'gambar', orderable: false, searchable: false },
                { data: 'delivery_date', name: 'delivery_date' },
                { data: 'menu', name: 'menu', orderable: false, searchable: false },
                { data: 'notes', name: 'notes' },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
            ],
            rowCallback: function(row, data) {
                // Pasang klik event pada gambar untuk menampilkan modal (opsional)
                $(row).find('.img-thumbnail').on('click', function() {
                    $('#modalImage').attr('src', $(this).data('image'));
                });
            }
        });
    });
</script>
@endsection
