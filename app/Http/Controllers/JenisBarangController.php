<?php

namespace App\Http\Controllers;

use App\Models\JenisBarang;
use Illuminate\Http\Request;

class JenisBarangController extends Controller
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

        $data = JenisBarang::latest()->paginate($perPage);

        return response()->json(['data' => $data], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_barang' => ['required', 'string', 'max:255']
        ]);

        $validated['kode_jenis_barang'] = $this->generateId();

        $data = JenisBarang::create($validated);

        return response()->json(['data' => $data], 201);
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
    public function update(Request $request, JenisBarang $jenisBarang)
    {
        $validated = $request->validate([
            'jenis_barang' => ['sometimes', 'string', 'max:255']
        ]);

        $jenisBarang->update($validated);

        return response()->json(['data' => $jenisBarang], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisBarang $jenisBarang)
    {
        $jenisBarang->delete();

        return response()->json('', 204);
    }
}
