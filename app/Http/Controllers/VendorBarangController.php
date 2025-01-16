<?php

namespace App\Http\Controllers;

use App\Helpers\GenerateID;
use App\Models\VendorBarang;
use Exception;
use Illuminate\Http\Request;

class VendorBarangController extends Controller
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

        $data = VendorBarang::latest()->paginate($perPage);

        return response()->json(['data' => $data], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_vendor' => ['required', 'string', 'max:255']
            ]);

            $validated['id'] = GenerateID::generateId(VendorBarang::class, 'VB', 5, 'id');

            $data = VendorBarang::create($validated);

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
    public function update(Request $request, VendorBarang $vendorBarang)
    {
        $validated = $request->validate([
            'nama_vendor' => ['nullable', 'string', 'max:255']
        ]);

        $vendorBarang->update($validated);

        return response()->json(['data' => $vendorBarang], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VendorBarang $vendorBarang)
    {
        $vendorBarang->delete();

        return response()->json('', 204);
    }
}
