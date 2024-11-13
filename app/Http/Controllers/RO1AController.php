<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Menu;
use App\Models\R01A;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RO1AController extends Controller
{
    public function index()
    {
        return view('customer-engagement.ro1a.index');
    }

    public function create()
    {
        return view('customer-engagement.ro1a.create');
    }

    public function getDeliveriesForDataTable()
    {
        // Mengambil data terbaru untuk setiap customer_id berdasarkan delivery_date terbaru
        $deliveries = R01A::with('customer')
            ->select('r01_a.*')
            ->join(
                DB::raw('(SELECT customer_id, MAX(delivery_date) AS latest_delivery_date
                            FROM r01_a
                            GROUP BY customer_id) AS latest_deliveries'),
                'r01_a.customer_id', '=', 'latest_deliveries.customer_id'
            )
            ->whereColumn('r01_a.delivery_date', '=', 'latest_deliveries.latest_delivery_date')  // hanya memilih yang terbaru berdasarkan delivery_date
            ->orderBy('r01_a.customer_id')
            ->orderByDesc('r01_a.delivery_date'); // Menampilkan yang terbaru lebih dulu

        // Menggunakan DataTables untuk menampilkan data
        return datatables()->of($deliveries)
            ->addIndexColumn() // Menambahkan kolom nomor urut
            ->addColumn('customer_name', function($row) {
                return $row->customer->nama_pelanggan ?? 'N/A';
            })
            ->addColumn('latest_delivery_date', function($row) {
                // Format 'time ago' menggunakan Carbon
                return \Carbon\Carbon::parse($row->delivery_date)->diffForHumans();
            })
            ->addColumn('action', function($row) {
                return '<a href="' . route('r01a.show', $row->customer_id) . '" class="btn btn-info">Lihat Detail</a>';
            })
            ->rawColumns(['action']) // Mengizinkan kolom 'action' untuk HTML
            ->make(true);
    }


    public function getMenusForSelect2(Request $request)
    {
        $search = $request->input('search'); // Ambil query parameter pencarian

        // Ambil data menu berdasarkan pencarian
        $menus = Menu::where('nama_produk', 'like', "%{$search}%")
            ->limit(10) // Batasi jumlah hasil untuk performa
            ->get();

        // Format data untuk Select2
        $formatted_menus = [];
        foreach ($menus as $menu) {
            $formatted_menus[] = [
                'id' => $menu->id,
                'text' => $menu->nama_produk // Anda dapat menambahkan informasi lain jika perlu
            ];
        }

        return response()->json($formatted_menus);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'delivery_date' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'menus' => 'required|array|min:1',
            'menus.*.id' => 'required|exists:menu,id',
            'menus.*.quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ], [
            'customer_id.required' => 'Customer wajib dipilih.',
            'customer_id.exists' => 'Customer tidak valid.',
            'delivery_date.required' => 'Tanggal pengiriman wajib diisi.',
            'delivery_date.date' => 'Format tanggal tidak valid.',
            'menus.required' => 'Harap tambahkan minimal satu menu.',
            'menus.array' => 'Format menu tidak valid.',
            'menus.min' => 'Harap tambahkan minimal satu menu.',
            'menus.*.id.required' => 'ID menu tidak boleh kosong.',
            'menus.*.id.exists' => 'Menu tidak valid.',
            'menus.*.quantity.required' => 'Kuantitas menu wajib diisi.',
            'menus.*.quantity.integer' => 'Kuantitas menu harus berupa angka.',
            'menus.*.quantity.min' => 'Kuantitas menu harus minimal 1.',
        ]);

        // Jika validasi lolos, lakukan penyimpanan data
        // Contoh penyimpanan data:
        // Buat objek order baru dan simpan sesuai dengan kebutuhan aplikasi Anda
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            // Menyimpan file gambar di folder 'public/images/' dan mendapatkan path-nya
            $gambarPath = $request->file('gambar')->store('images', 'public');
        }

        $order = new R01A();
        $order->customer_id = $request->customer_id;
        $order->gambar = $gambarPath;
        $order->delivery_date = $request->delivery_date;
        $order->notes = $request->notes;
        $order->save();

        // Simpan menu terkait ke database
        foreach ($request->menus as $menu) {
            $order->menu()->attach($menu['id'], ['quantity' => $menu['quantity']]);
        }

        // Kembalikan respon sukses
        return response()->json(['message' => 'Data berhasil disimpan']);
    }

    public function show(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('customer-engagement.ro1a.show', ['id' => $id, 'customer' => $customer]);
    }

    // Controller method for serving data via AJAX
    public function getDeliveriesData($id)
    {
        // Ambil data deliveries berdasarkan customer ID
        $deliveries = R01A::where('customer_id', $id)->orderBy('delivery_date', 'desc')->with('menu')->get();
        $totalData = $deliveries->count();

        // Format data untuk DataTables
        $data = $deliveries->map(function ($delivery, $index) {
            return [
                'no' => $index + 1,
                'gambar' => $delivery->gambar ? '<img src="' . asset('storage/' . $delivery->gambar) . '" width="150px" alt="" style="cursor: pointer;" class="img-thumbnail" data-toggle="modal" data-target="#imageModal" data-image="' . asset('storage/' . $delivery->gambar) . '">' : '-',
                'delivery_date' => $delivery->delivery_date,
                'menu' => $delivery->menu->map(function ($menu) {
                    return '<li>' . $menu->nama_produk . ' (' . $menu->pivot->quantity . ')</li>';
                })->join(''),
                'notes' => $delivery->notes,
                'aksi' => '', // Tambahkan aksi sesuai kebutuhan
            ];
        });

        // Menambahkan kunci yang dibutuhkan DataTables
        return response()->json([
            'draw' => request('draw'),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalData,
            'data' => $data
        ]);
    }



}
