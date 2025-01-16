<?php

namespace App\Http\Controllers;

use App\Helpers\GenerateID;
use App\Models\Kelas;
use Exception;
use Illuminate\Http\Request;

class KelasController extends Controller
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

        $data = Kelas::latest()->paginate($perPage);

        return response()->json(['data' => $data], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'kelas' => ['required', 'string', 'max:255']
            ]);

            $validated['id'] = GenerateID::generateId(Kelas::class, 'K', 5, 'id');

            $data = Kelas::create($validated);

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
    public function update(Request $request, Kelas $kelas)
    {
        $validated = $request->validate([
            'kelas' => ['nullable', 'string', 'max:255']
        ]);

        $kelas->update($validated);

        return response()->json(['data' => $kelas], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelas $kelas)
    {
        $kelas->delete();

        return response()->json('', 204);
    }
}
