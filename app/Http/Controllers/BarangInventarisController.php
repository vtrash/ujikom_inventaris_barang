<?php

namespace App\Http\Controllers;

use App\Helpers\GenerateID;
use App\Models\BarangInventaris;
use Auth;
use Exception;
use Illuminate\Http\Request;

class BarangInventarisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'per_page' => ['integer', 'min:1', 'max:50']
        ]);

        $perPage = $validated['per_page'] ?? 10;

        $data = BarangInventaris::latest()->paginate($perPage);

        return response()->json(['data' => $data], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user = Auth::user();

            $validated = $request->validate([
                'kode_jenis_barang' => ['required', 'exists:jenis_barang,kode_jenis_barang'],
                'vendor_id' => ['required', 'exists:vendor_barang,id'],
                'nama_barang' => ['required', 'string', 'max:255'],
                'tgl_diterima' => ['required', 'date'],
                'tgl_entry' => ['required', 'date'],
                'kondisi_barang' => ['required', 'in:1,2,3,4'],
                'no_entry' => ['required', 'integer'],
            ]);

            $validated['kode_barang'] = GenerateID::generateId(BarangInventaris::class, 'INV' . date('Y') . date('m'), 5, 'kode_barang');
            $validated['status_dipinjam'] = '0';
            $validated['user_id'] = $user->id;

            $data = BarangInventaris::create($validated);

            return response()->json(['data' => $data], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BarangInventaris $barangInventaris)
    {
        $validated = $request->validate([
            'kode_jenis_barang' => ['nullable', 'exists:jenis_barang,kode_jenis_barang'],
            'vendor_id' => ['nullable', 'exists:vendor_barang,id'],
            'nama_barang' => ['nullable', 'string', 'max:255'],
            'tgl_diterima' => ['nullable', 'date'],
            'tgl_entry' => ['nullable', 'date'],
            'kondisi_barang' => ['nullable', 'in:1,2,3,4'],
            'status_dipinjam' => ['nullable', 'in:0,1'],
            'no_entry' => ['nullable', 'integer'],
        ]);

        $barangInventaris->update($validated);

        return response()->json(['data' => $barangInventaris], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BarangInventaris $barangInventaris)
    {
        $barangInventaris->delete();

        return response()->json('', 204);
    }
}
