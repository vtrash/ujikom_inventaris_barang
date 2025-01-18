<?php

namespace App\Http\Controllers;

use App\Models\BarangInventaris;
use Auth;
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
        $user = Auth::user();

        $validated = $request->validate([
            'kode_jenis_barang' => ['required', 'exists:jenis_barang,kode_jenis_barang'],
            'batch_barang_id' => ['required', 'exists:batch_barang,id'],
            'nama_barang' => ['required', 'string', 'max:255'],
            'tgl_entry' => ['required', 'date'],
            'kondisi_barang' => ['required', 'in:1,2,3,4'],
        ]);

        $validated['kode_barang'] = BarangInventaris::generateId();
        $validated['user_id'] = $user->id;
        $validated['status_dipinjam'] = '0';

        $data = BarangInventaris::create($validated);

        return response()->json(['data' => $data], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(BarangInventaris $barangInventaris)
    {
        return response()->json(['data' => $barangInventaris], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BarangInventaris $barangInventaris)
    {
        $validated = $request->validate([
            'kode_jenis_barang' => ['sometimes', 'exists:jenis_barang,kode_jenis_barang'],
            'batch_barang_id' => ['sometimes', 'exists:batch_barang,id'],
            'nama_barang' => ['sometimes', 'string', 'max:255'],
            'kondisi_barang' => ['sometimes', 'in:1,2,3,4'],
            'status_dipinjam' => ['sometimes', 'in:0,1'],
        ]);

        $barangInventaris->update($validated);

        return response()->json(['data' => $barangInventaris], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BarangInventaris $barangInventaris)
    {
        if (empty($barangInventaris->detail_peminjaman)) {
            $barangInventaris->forceDelete();
            return response()->json('', 204);
        }

        $isBorrowed = $barangInventaris->detail_peminjaman
            ->contains(fn ($detail_peminjaman) => !$detail_peminjaman->status_pengembalian);

        if ($isBorrowed) {
            return response()->json(['error' => 'Barang masih dipinjam.'], 409);
        }

        $barangInventaris->delete();
        return response()->json('', 204);
    }
}
