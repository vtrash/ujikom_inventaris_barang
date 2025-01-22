<?php

namespace App\Http\Controllers;

use App\Models\BarangInventaris;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Siswa;
use Auth;
use DB;
use Exception;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
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

        $data = Peminjaman::latest()->paginate($perPage);

        return response()->json(['data' => $data], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis_siswa' => ['required', 'string', 'max:255'],
            'tgl_pengembalian' => ['sometimes', 'date', 'after_or_equal:today'],
            'kode_barang' => ['required', 'array'],
            'kode_barang.*' => ['required', 'exists:barang_inventaris,kode_barang'],
        ]);

        $isBorrowing = Siswa::find($validated['nis_siswa'])->peminjaman()
            ->where('status_pengembalian', '0')
            ->exists();

        if ($isBorrowing) {
            return response()->json(['error' => 'Siswa belum menyelesaikan peminjaman sebelumnya.'], 409);
        }

        $isBorrowed = BarangInventaris::whereIn('kode_barang', $validated['kode_barang'])
            ->where('status_dipinjam', 1)
            ->exists();

        if ($isBorrowed) {
            return response()->json(['error' => 'Terdapat barang yang masih dipinjam.'], 409);
        }
        
        DB::beginTransaction();
        
        try {
            $validated['id'] = Peminjaman::generateId();
            $validated['user_id'] = Auth::user()->id;
            $validated['tgl_peminjaman'] = date('Y-m-d 00:00:00', strtotime('today'));
            $validated['tgl_pengembalian'] = date('Y-m-d 23:59:59', strtotime($validated['tgl_pengembalian']));
            $validated['status_pengembalian'] = '0';
            
            $peminjaman = Peminjaman::create($validated);
            
            $totalItems = count($validated['kode_barang']);

            $detailPeminjamanIds = DetailPeminjaman::generateId($peminjaman->id, $totalItems);
            $pengembalianIds = Pengembalian::generateId($totalItems);

            foreach ($validated['kode_barang'] as $index => $kodeBarang) {

                $detailPeminjamanDatas[] = [
                    'id' => $detailPeminjamanIds[$index],
                    'peminjaman_id' => $peminjaman->id,
                    'kode_barang' => $kodeBarang
                ];

                $pengembalianDatas[] = [
                    'id' => $pengembalianIds[$index],
                    'detail_peminjaman_id' => $detailPeminjamanIds[$index],
                    'user_id' => null,
                    'tgl_kembali' => null,
                    'kondisi_barang_kembali' => null,
                    'status_pengembalian' => '0',
                ];
            }

            DetailPeminjaman::insert($detailPeminjamanDatas);
            Pengembalian::insert($pengembalianDatas);

            BarangInventaris::whereIn('kode_barang', $validated['kode_barang'])
                ->update(['status_dipinjam' => 1]);
    
            DB::commit();
    
            return response()->json(['data' => $peminjaman->load('detail_peminjaman')], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Terjadi kesalahan membuat data peminjaman: ' . $e->getMessage()], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Peminjaman $peminjaman)
    {
        return response()->json(['data' => $peminjaman->load('detail_peminjaman.pengembalian')], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        //should I implement it? for what?

        // $isCompleted = $peminjaman->status_pengembalian;

        // if ($isCompleted) {
        //     return response()->json(['error' => 'Peminjaman sudah selesai.'], 405);
        // }

        // return response()->json(['data' => $peminjaman], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        $siswa->delete();

        return response()->json('', 204);
    }
}
