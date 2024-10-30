<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Imports\PelangganImport;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Customer::get();
            return datatables()->of($data)->make(true);
        }
        return view('customers.index');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new PelangganImport, $request->file('file'));

        return response()->json(['message' => 'Data Imported Successfully']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama_pelanggan' => 'required',
                'no_telp' => 'required',
                'alamat' => 'nullable',
                'tanggal_lahir' => 'nullable',
                'email' => 'nullable',
            ],[
                'required' => ':attribute harus diisi',
                'unique' => ':attribute sudah ada',
            ], [
                'nama_pelanggan' => 'Nama Customer',
                'no_telp' => 'No Whatsapp',
            ]);
        } catch (ValidationException $e) {
            // Tangani error validasi
            $errors = $e->validator->errors()->toArray();

            return response()->json(['errors' => $errors], 422);
        }

        $customer = Customer::create([
            'nama_pelanggan' => $validatedData['nama_pelanggan'],
            'no_telp' => $validatedData['no_telp'],
            'tanggal_lahir' => $validatedData['tanggal_lahir'],
            'alamat' => $validatedData['alamat'],
            'email' => $validatedData['email'],
        ]);

        return response()->json(['message' => 'Data berhasil disimpan', 'data' => $customer]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::find($id);
        return response()->json($customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    // Temukan data pelanggan berdasarkan ID
    $customer = Customer::findOrFail($id);

    // Ambil nomor telepon yang sekarang
    $currentNoTelp = $customer->no_telp;

    try {
        // Validasi input dari permintaan
        $validatedData = $request->validate([
            'no_telp' => [
                'required',
                'string',
                Rule::unique('customers')->ignore($customer->id), // Abaikan ID yang sedang diupdate
            ],
            'nama_pelanggan' => 'required|string',
            'alamat' => 'nullable|string',
            'email' => 'nullable|email',
            'tanggal_lahir' => 'nullable|date',
        ], [
            'required' => ':attribute harus diisi',
            'unique' => ':attribute sudah ada',
        ], [
            'no_telp' => 'No Whatsapp',
            'nama_pelanggan' => 'Nama Customer',
        ]);
    } catch (ValidationException $e) {
        // Tangani error validasi
        $errors = $e->validator->errors()->toArray();
        return response()->json(['errors' => $errors], 422);
    }

    // Pembaruan data pelanggan
    $customer->update([
        'nama_pelanggan' => $validatedData['nama_pelanggan'],
        'no_telp' => $validatedData['no_telp'],
        'tanggal_lahir' => $validatedData['tanggal_lahir'],
        'alamat' => $validatedData['alamat'],
        'email' => $validatedData['email'],
    ]);

    return response()->json(['status' => 'success', 'data' => $customer]);
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        if ($customer) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
