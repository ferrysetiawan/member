<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PelangganImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Validasi untuk kolom wajib (nama_pelanggan dan no_telp)
        if (empty($row['nama_pelanggan']) || empty($row['no_telp'])) {
            // Jika nama_pelanggan atau no_telp kosong, lewati baris ini
            return null;
        }

        // Atur kolom opsional agar menjadi null jika kosong
        $tanggal_lahir = !empty($row['tanggal_lahir']) ? $row['tanggal_lahir'] : null;
        $alamat = !empty($row['alamat']) ? $row['alamat'] : null;
        $email = !empty($row['email']) ? $row['email'] : null;

        // Cek jika nomor telepon atau email sudah ada di database
        $existingPelanggan = Customer::where('no_telp', $row['no_telp'])
            ->first();

        if ($existingPelanggan) {
            // Update data jika sudah ada
            $existingPelanggan->update([
                'nama_pelanggan' => $row['nama_pelanggan'],
                'tanggal_lahir' => $tanggal_lahir,
                'alamat' => $alamat,
                'no_telp' => $row['no_telp'],
                'email' => $email,
            ]);

            // Return null karena kita hanya melakukan update
            return null;
        }

        // Jika data belum ada, buat baru
        return new Customer([
            'nama_pelanggan' => $row['nama_pelanggan'],
            'tanggal_lahir' => $tanggal_lahir,
            'alamat' => $alamat,
            'no_telp' => $row['no_telp'],
            'email' => $email,
        ]);
    }
}
