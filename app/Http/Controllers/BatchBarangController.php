<?php

namespace App\Http\Controllers;

use App\Models\BatchBarang;
use Illuminate\Http\Request;

class BatchBarangController extends Controller
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

        $data = BatchBarang::latest()->paginate($perPage);

        return response()->json(['data' => $data], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendor_id' => ['required', 'exists:vendor,id'],
            'tgl_diterima' => ['required', 'date'],
            'keterangan' => ['required', 'string', 'max:255']
        ]);
        
        $data = BatchBarang::create($validated);
        
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
    public function update(Request $request, BatchBarang $batchBarang)
    {
        $validated = $request->validate([
            'vendor_id' => ['sometimes', 'exists:vendor,id'],
            'tgl_diterima' => ['sometimes', 'date'],
            'keterangan' => ['sometimes', 'string', 'max:255']
        ]);

        $batchBarang->update($validated);

        return response()->json(['data' => $batchBarang], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BatchBarang $batchBarang)
    {
        $batchBarang->delete();

        return response()->json('', 204);
    }
}
