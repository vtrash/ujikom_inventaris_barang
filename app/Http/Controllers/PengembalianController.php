<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Auth;
use DB;
use Exception;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, Pengembalian $pengembalian)
    {
        $validated = $request->validate([
            'kondisi_barang_kembali' => ['required', 'in:1,2,3,4']
        ]);

        if ($pengembalian->status_pengembalian) {
            return response()->json(['error' => 'Pengembalian sudah selesai'], 405);
        }

        $validated['user_id'] = Auth::user()->id;
        $validated['tgl_kembali'] = now();
        $validated['status_pengembalian'] = '1';

        DB::beginTransaction();

        try {
            $pengembalian->update($validated);
    
            $peminjaman = Peminjaman::find($pengembalian->detail_peminjaman->peminjaman_id);
    
            $isCompleted = $peminjaman->detail_peminjaman->every(function ($detail) {
                return $detail->pengembalian && $detail->pengembalian->status_pengembalian == 1;
            });
    
            if ($isCompleted) {
                $peminjaman->update([
                    'status_pengembalian' => '1',
                ]);
            }
    
            DB::commit();

            return response()->json($pengembalian, 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Gagal mengubah status pengembalian: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
